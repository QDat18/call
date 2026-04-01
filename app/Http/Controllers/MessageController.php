<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Conversation;
use App\Models\ConversationParticipant;
use App\Events\MessageSent;
use App\Events\UserTyping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Lấy danh sách messages
     */
    public function index(Request $request, $conversationId)
    {
        $user = Auth::user();

        $participant = ConversationParticipant::where('conversation_id', $conversationId)
            ->where('user_id', $user->user_id)
            ->where('is_active', true)
            ->first();

        if(!$participant) abort(403);

        $limit = $request->get('limit', 20);
        $beforeId = $request->get('before_id'); // Để load more khi scroll lên

        $query = Message::where('conversation_id', $conversationId)
            ->where('is_deleted', false)
            ->with('sender')
            ->orderBy('sent_at', 'desc'); // Lấy mới nhất trước

        if ($beforeId) {
            $query->where('message_id', '<', $beforeId);
        }

        $messages = $query->take($limit)->get()->reverse()->values(); // Đảo ngược lại để hiển thị tăng dần thời gian

        // Format dữ liệu giống MessageSent
        $formatted = $messages->map(function($msg) {
            return (new MessageSent($msg))->broadcastWith();
        });

        return response()->json(['success' => true, 'data' => $formatted]);
    }

    /**
     * Gửi message - ✅ HOÀN CHỈNH VỚI PUSHER
     */
    public function send(Request $request, $conversationId)
    {
        $request->validate([
            'content' => 'nullable|string|max:5000',
            'message_type' => 'required|in:text,image,file,video',
            'file' => 'required_if:message_type,image,file,video|file|max:10240' // 10MB
        ]);

        $user = Auth::user();
        $conversation = Conversation::findOrFail($conversationId);

        // Check quyền
        if (!$conversation->participants()->where('user_id', $user->user_id)->exists()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $messageData = [
            'conversation_id' => $conversationId,
            'sender_id' => $user->user_id,
            'message_type' => $request->message_type,
            'content' => $request->content ?? '',
        ];

        // Xử lý file nếu có
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('messages/' . $conversationId, 'public');
            $messageData['attachment_url'] = $path;
            $messageData['attachment_name'] = $file->getClientOriginalName();

            // Nếu là ảnh/file thì content có thể để trống hoặc tên file
            if (empty($messageData['content'])) {
                $messageData['content'] = ($request->message_type === 'image') ? 'Đã gửi một ảnh' : 'Đã gửi một tệp đính kèm';
            }
        }

        $message = Message::create($messageData);

        // Cập nhật conversation
        $conversation->update(['last_message_at' => now()]);

        // Tăng unread cho người khác
        $conversation->participants()
            ->where('user_id', '!=', $user->user_id)
            ->increment('unread_count');

        // Broadcast sự kiện
        try {
            broadcast(new MessageSent($message))->toOthers();
        } catch (\Exception $e) {
            Log::error("Broadcast error: " . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'data' => (new MessageSent($message))->broadcastWith() // Trả về format chuẩn ngay lập tức
        ]);
    }

    /**
     * Mark messages as read
     */
    public function markRead(Request $request, $conversationId)
    {
        $user = Auth::user();

        $participant = ConversationParticipant::where('conversation_id', $conversationId)
            ->where('user_id', $user->user_id)
            ->firstOrFail();

        $participant->update([
            'unread_count' => 0,
            'last_read_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Marked as read'
        ]);
    }

    /**
     * Upload attachment
     */
    public function uploadAttachment(Request $request, $conversationId)
    {
        $user = Auth::user();

        $participant = ConversationParticipant::where('conversation_id', $conversationId)
            ->where('user_id', $user->user_id)
            ->where('is_active', true)
            ->first();

        if (!$participant) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'file' => 'required|file|max:10240',
            'type' => 'required|in:image,file,video'
        ]);

        try {
            $file = $request->file('file');

            // Store file
            $path = $file->store('messages/' . $conversationId, 'public');
            $url = Storage::url($path);

            return response()->json([
                'success' => true,
                'url' => $url,
                'filename' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete message
     */
    public function destroy($conversationId, $messageId)
    {
        $user = Auth::user();

        $message = Message::where('conversation_id', $conversationId)
            ->where('message_id', $messageId)
            ->firstOrFail();

        if ($message->sender_id != $user->user_id && $user->user_type !== 'Admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $message->update(['is_deleted' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Message deleted'
        ]);
    }

    /**
     * Get latest messages
     */
    public function getLatest(Request $request, $conversationId)
    {
        $user = Auth::user();

        $participant = ConversationParticipant::where('conversation_id', $conversationId)
            ->where('user_id', $user->user_id)
            ->where('is_active', true)
            ->first();

        if (!$participant) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $afterId = $request->get('after_id', 0);

        $messages = Message::where('conversation_id', $conversationId)
            ->where('message_id', '>', $afterId)
            ->where('is_deleted', false)
            ->with(['sender'])
            ->orderBy('sent_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'messages' => $messages,
            'count' => $messages->count()
        ]);
    }

    /**
     * Search messages
     */
    public function search(Request $request, $conversationId)
    {
        $user = Auth::user();

        $participant = ConversationParticipant::where('conversation_id', $conversationId)
            ->where('user_id', $user->user_id)
            ->where('is_active', true)
            ->first();

        if (!$participant) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $query = $request->get('q', '');

        if (strlen($query) < 2) {
            return response()->json([
                'success' => false,
                'error' => 'Query must be at least 2 characters'
            ], 400);
        }

        $messages = Message::where('conversation_id', $conversationId)
            ->where('is_deleted', false)
            ->where('message_type', 'text')
            ->where('content', 'like', "%$query%")
            ->with(['sender'])
            ->orderBy('sent_at', 'desc')
            ->limit(50)
            ->get();

        return response()->json([
            'success' => true,
            'messages' => $messages,
            'count' => $messages->count()
        ]);
    }

    /**
     * Get unread count
     */
    public function getUnreadCount()
    {
        $user = Auth::user();

        $unreadCount = ConversationParticipant::where('user_id', $user->user_id)
            ->where('is_active', true)
            ->sum('unread_count');

        $conversations = ConversationParticipant::where('user_id', $user->user_id)
            ->where('is_active', true)
            ->where('unread_count', '>', 0)
            ->pluck('unread_count', 'conversation_id');

        return response()->json([
            'success' => true,
            'total_unread' => $unreadCount,
            'conversations' => $conversations
        ]);
    }

    /**
     * Typing indicator - ✅ BROADCAST VỚI PUSHER
     */
    /**
     * Typing indicator
     */
    public function typing(Request $request) // <--- XÓA $conversationId ở đây
    {
        // 1. Validate dữ liệu gửi lên
        $validated = $request->validate([
            'conversation_id' => 'required|exists:conversations,conversation_id', // Thêm validate ID
            'is_typing' => 'required|boolean'
        ]);

        $conversationId = $validated['conversation_id'];
        $user = Auth::user();

        // 2. Kiểm tra quyền (Optional nhưng nên có)
        $isParticipant = ConversationParticipant::where('conversation_id', $conversationId)
            ->where('user_id', $user->user_id)
            ->exists();

        if (!$isParticipant) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // 3. Xử lý Cache hoặc Broadcast
        // Cách dùng Cache (như bạn đã làm ở các bước trước)
        $key = "typing_{$conversationId}_{$user->user_id}";

        if ($validated['is_typing']) {
            \Illuminate\Support\Facades\Cache::put($key, true, 5); // Tồn tại 5 giây
        } else {
            \Illuminate\Support\Facades\Cache::forget($key);
        }

        // Nếu bạn dùng Pusher/Reverb (Broadcast)
        try {
            broadcast(new UserTyping(
                $conversationId,
                $user->user_id,
                $user->first_name,
                $validated['is_typing']
            ))->toOthers();
        } catch (\Exception $e) {
            Log::error('Typing broadcast failed: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'user_id' => $user->user_id,
            'is_typing' => $validated['is_typing']
        ]);
    }

    public function checkUpdates(Request $request, $conversationId)
    {
        // Lấy mốc thời gian client gửi lên (hoặc mặc định là 10 giây trước)
        $lastCheck = $request->get('last_check', now()->subSeconds(10));

        // Tìm các tin nhắn trong cuộc hội thoại này có updated_at mới hơn mốc thời gian
        $updatedMessages = Message::where('conversation_id', $conversationId)
            ->where('updated_at', '>', $lastCheck)
            ->get();
        $otherParticipants = ConversationParticipant::where('conversation_id', $conversationId)
            ->where('user_id', '!=', $user->user_id)
            ->pluck('user_id');

        $typingUsers = [];
        foreach ($otherParticipants as $otherId) {
            if (\Cache::has("typing_{$conversationId}_{$otherId}")) {
                $u = User::find($otherId);
                if ($u) $typingUsers[] = $u->first_name;
            }
        }
        return response()->json([
            'success' => true,
            'updates' => $updatedMessages,
            'typing_users' => $typingUsers,
            'server_time' => now()->toDateTimeString() // Trả về giờ server để đồng bộ lần sau
        ]);
    }
}
