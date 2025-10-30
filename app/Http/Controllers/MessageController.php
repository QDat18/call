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
            
        if (!$participant) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $page = $request->get('page', 1);
        $perPage = 50;
        
        $messages = Message::where('conversation_id', $conversationId)
            ->where('is_deleted', false)
            ->with(['sender'])
            ->orderBy('sent_at', 'desc')
            ->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'messages' => $messages->items(),
            'pagination' => [
                'current_page' => $messages->currentPage(),
                'last_page' => $messages->lastPage(),
                'per_page' => $messages->perPage(),
                'total' => $messages->total()
            ]
        ]);
    }

    /**
     * Gửi message - ✅ HOÀN CHỈNH VỚI PUSHER
     */
    public function send(Request $request, $conversationId)
    {
        $request->validate([
            'content' => 'required|string|max:5000',
            'message_type' => 'nullable|in:text,image,file,video',
        ]);
        
        try {
            $conversation = Conversation::findOrFail($conversationId);
            
            // Kiểm tra quyền
            $isParticipant = $conversation->participants()
                ->where('user_id', auth()->id())
                ->where('is_active', true)
                ->exists();
            
            if (!$isParticipant) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not a participant'
                ], 403);
            }
            
            // ✅ Tạo message
            $message = Message::create([
                'conversation_id' => $conversationId,
                'sender_id' => auth()->id(),
                'message_type' => $request->message_type ?? 'text',
                'content' => $request->content,
            ]);
            
            // Update conversation
            $conversation->update(['last_message_at' => now()]);
            
            // Update unread count cho người khác
            $conversation->participants()
                ->where('user_id', '!=', auth()->id())
                ->increment('unread_count');
            
            // Load sender để broadcast
            $message->load('sender');
            
            // ✅ LOG
            Log::info('💬 Message sent', [
                'message_id' => $message->message_id,
                'sender_id' => auth()->id(),
                'conversation_id' => $conversationId,
                'content' => substr($message->content, 0, 50),
            ]);
            
            // ✅ BROADCAST với Pusher
            try {
                broadcast(new MessageSent($message))->toOthers();
                Log::info('✅ Broadcast successful');
            } catch (\Exception $e) {
                Log::error('❌ Broadcast failed: ' . $e->getMessage());
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully',
                'data' => $message
            ], 200);
            
        } catch (\Exception $e) {
            Log::error('❌ Send message error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
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
    public function typing(Request $request, $conversationId)
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
            'is_typing' => 'required|boolean'
        ]);
        
        // ✅ Broadcast typing event
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
}