<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\ConversationParticipant;
use App\Models\Message;
use App\Models\User;
use App\Models\VolunteerOpportunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConversationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Danh sách conversations
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Conversation::whereHas('participants', function ($q) use ($user) {
            $q->where('user_id', $user->user_id)
              ->where('is_active', true);
        })
        ->with(['participants.user', 'opportunity', 'creator', 'lastMessage']);

        if ($request->filled('type')) {
            $query->where('conversation_type', $request->type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhereHas('participants.user', function ($subQ) use ($search) {
                      $subQ->where('first_name', 'like', "%$search%")
                           ->orWhere('last_name', 'like', "%$search%");
                  });
            });
        }

        $query->where('is_active', true);

        $conversations = $query->orderBy('last_message_at', 'desc')->paginate(20);

        $unreadCount = ConversationParticipant::where('user_id', $user->user_id)
            ->where('is_active', true)
            ->sum('unread_count');

        return view('conversations.index', compact('conversations', 'unreadCount'));
    }

    // Hiển thị chi tiết conversation
    public function show($id)
    {
        $user = Auth::user();

        $conversation = Conversation::with([
            'participants.user.volunteerProfile',
            'participants.user.organization',
            'opportunity',
            'creator',
            'messages.sender'
        ])->findOrFail($id);

        $participant = $conversation->participants()
            ->where('user_id', $user->user_id)
            ->where('is_active', true)
            ->first();

        if (!$participant) {
            abort(403, 'Bạn không có quyền xem conversation này');
        }

        $otherParticipant = $conversation->participants()
            ->where('user_id', '!=', $user->user_id)
            ->first();

        $otherUser = $otherParticipant ? $otherParticipant->user : null;

        $messages = $conversation->messages()
            ->with('sender')
            ->orderBy('sent_at', 'asc')
            ->paginate(50);

        $this->markAsRead($conversation, $user);

        return view('conversations.show', compact('conversation', 'messages', 'participant', 'otherUser'));
    }

    // Tạo conversation mới
    public function create(Request $request)
    {
        $type = $request->get('type', 'direct');
        $opportunityId = $request->get('opportunity_id');
        $userId = $request->get('user_id');
        $user = Auth::user();

        $connections = \App\Models\Connection::where('status', 'accepted')
            ->where(function ($q) use ($user) {
                $q->where('user_id', $user->user_id)
                  ->orWhere('friend_id', $user->user_id);
            })
            ->with(['user', 'friend'])
            ->get();

        $opportunity = $opportunityId ? VolunteerOpportunity::with('organization')->find($opportunityId) : null;
        $recipient = $userId ? User::find($userId) : null;

        return view('conversations.create', compact('type', 'opportunity', 'recipient', 'connections'));
    }

    // Lưu conversation mới
    public function store(Request $request)
    {
        $user = Auth::user();
        $otherUserId = $request->input('participant_ids.0');

        if (!$otherUserId) {
            return redirect()->back()->with('error', 'Participant ID is required');
        }

        $validated = $request->validate([
            'conversation_type' => 'required|in:direct,group,opportunity_chat',
            'title' => 'nullable|string|max:100',
            'opportunity_id' => 'nullable|exists:volunteer_opportunities,opportunity_id',
            'participant_ids' => 'required|array|min:1',
            'participant_ids.*' => 'exists:users,user_id',
            'initial_message' => 'nullable|string|max:1000'
        ]);

        if ($validated['conversation_type'] === 'direct' && count($validated['participant_ids']) !== 1) {
            return back()->with('error', 'Direct chat chỉ có 2 người!');
        }

        if ($validated['conversation_type'] === 'group' && count($validated['participant_ids']) > 20) {
            return back()->with('error', 'Group chat tối đa 20 người!');
        }

        if ($validated['conversation_type'] === 'direct') {
            $existingConversation = Conversation::where('conversation_type', 'direct')
                ->where('is_active', true)
                ->whereHas('participants', function ($q) use ($user) {
                    $q->where('user_id', $user->user_id);
                })
                ->whereHas('participants', function ($q) use ($otherUserId) {
                    $q->where('user_id', $otherUserId);
                })
                ->first();

            if ($existingConversation) {
                return redirect()->route('conversations.show', $existingConversation->conversation_id)
                    ->with('info', 'Conversation đã tồn tại!');
            }
        }

        DB::beginTransaction();
        try {
            $conversation = Conversation::create([
                'conversation_type' => $validated['conversation_type'],
                'title' => $validated['title'] ?? $this->generateConversationTitle($validated, $user),
                'created_by' => $user->user_id,
                'opportunity_id' => $validated['opportunity_id'] ?? null,
                'last_message_at' => now(),
                'is_active' => true
            ]);

            ConversationParticipant::create([
                'conversation_id' => $conversation->conversation_id,
                'user_id' => $user->user_id,
                'joined_at' => now(),
                'is_active' => true
            ]);

            foreach ($validated['participant_ids'] as $participantId) {
                if ($participantId != $user->user_id) {
                    ConversationParticipant::create([
                        'conversation_id' => $conversation->conversation_id,
                        'user_id' => $participantId,
                        'joined_at' => now(),
                        'is_active' => true
                    ]);

                    $this->sendConversationInviteNotification($conversation, $participantId);
                }
            }

            if (!empty($validated['initial_message'])) {
                Message::create([
                    'conversation_id' => $conversation->conversation_id,
                    'sender_id' => $user->user_id,
                    'message_type' => 'text',
                    'content' => $validated['initial_message'],
                    'sent_at' => now()
                ]);

                ConversationParticipant::where('conversation_id', $conversation->conversation_id)
                    ->where('user_id', '!=', $user->user_id)
                    ->increment('unread_count');
            }

            DB::commit();
            return redirect()->route('conversations.show', $conversation->conversation_id)
                ->with('success', 'Đã tạo conversation thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    // Cập nhật conversation
    public function update(Request $request, $id)
    {
        $conversation = Conversation::findOrFail($id);
        $user = Auth::user();

        if ($conversation->created_by != $user->user_id && $user->user_type !== 'Admin') {
            abort(403, 'Bạn không có quyền chỉnh sửa conversation này');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:100'
        ]);

        $conversation->update($validated);

        return back()->with('success', 'Đã cập nhật conversation!');
    }

    // Thêm participants
    public function addParticipants(Request $request, $id)
    {
        $conversation = Conversation::findOrFail($id);
        $user = Auth::user();

        $isParticipant = $conversation->participants()
            ->where('user_id', $user->user_id)
            ->where('is_active', true)
            ->exists();

        if (!$isParticipant) {
            abort(403, 'Bạn không có quyền thêm người vào conversation này');
        }

        if ($conversation->conversation_type === 'direct') {
            return back()->with('error', 'Không thể thêm người vào direct chat!');
        }

        $validated = $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,user_id'
        ]);

        $currentCount = $conversation->participants()->where('is_active', true)->count();
        if ($currentCount + count($validated['user_ids']) > 20) {
            return back()->with('error', 'Group chat tối đa 20 người!');
        }

        DB::beginTransaction();
        try {
            foreach ($validated['user_ids'] as $userId) {
                $existing = ConversationParticipant::where('conversation_id', $id)
                    ->where('user_id', $userId)
                    ->first();

                if ($existing) {
                    if (!$existing->is_active) {
                        $existing->update(['is_active' => true, 'joined_at' => now()]);
                    }
                } else {
                    ConversationParticipant::create([
                        'conversation_id' => $id,
                        'user_id' => $userId,
                        'joined_at' => now(),
                        'is_active' => true
                    ]);
                }

                $this->sendConversationInviteNotification($conversation, $userId);

                $addedUser = User::find($userId);
                Message::create([
                    'conversation_id' => $id,
                    'sender_id' => $user->user_id,
                    'message_type' => 'text',
                    'content' => ($addedUser ? $addedUser->first_name : 'Người dùng') . ' đã được thêm vào nhóm',
                    'sent_at' => now()
                ]);
            }

            DB::commit();
            return back()->with('success', 'Đã thêm thành viên vào conversation!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    // Rời conversation
    public function leave($id)
    {
        $conversation = Conversation::findOrFail($id);
        $user = Auth::user();

        if ($conversation->conversation_type === 'direct') {
            return back()->with('error', 'Không thể rời khỏi direct chat! Hãy archive thay thế.');
        }

        $participant = ConversationParticipant::where('conversation_id', $id)
            ->where('user_id', $user->user_id)
            ->first();

        if (!$participant) {
            return back()->with('error', 'Bạn không phải thành viên của conversation này!');
        }

        DB::beginTransaction();
        try {
            $participant->update(['is_active' => false]);

            Message::create([
                'conversation_id' => $id,
                'sender_id' => $user->user_id,
                'message_type' => 'text',
                'content' => $user->first_name . ' đã rời khỏi nhóm',
                'sent_at' => now()
            ]);

            $activeCount = ConversationParticipant::where('conversation_id', $id)
                ->where('is_active', true)
                ->count();

            if ($activeCount === 0) {
                $conversation->update(['is_active' => false]);
            }

            DB::commit();
            return redirect()->route('conversations.index')
                ->with('success', 'Đã rời khỏi conversation!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    // Archive
    public function archive($id)
    {
        $user = Auth::user();
        $participant = ConversationParticipant::where('conversation_id', $id)
            ->where('user_id', $user->user_id)
            ->firstOrFail();

        $participant->update(['is_active' => false]);

        return back()->with('success', 'Đã archive conversation!');
    }

    // Unarchive
    public function unarchive($id)
    {
        $user = Auth::user();
        $participant = ConversationParticipant::where('conversation_id', $id)
            ->where('user_id', $user->user_id)
            ->firstOrFail();

        $participant->update(['is_active' => true]);

        return back()->with('success', 'Đã khôi phục conversation!');
    }

    // Xóa conversation
    public function destroy($id)
    {
        $conversation = Conversation::findOrFail($id);
        $user = Auth::user();

        if ($conversation->created_by != $user->user_id && $user->user_type !== 'Admin') {
            abort(403, 'Bạn không có quyền xóa conversation này');
        }

        DB::beginTransaction();
        try {
            Message::where('conversation_id', $id)->update(['is_deleted' => true]);
            $conversation->update(['is_active' => false]);
            ConversationParticipant::where('conversation_id', $id)->update(['is_active' => false]);

            DB::commit();
            return redirect()->route('conversations.index')
                ->with('success', 'Đã xóa conversation!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    // Helper: Mark messages as read
    private function markAsRead($conversation, $user)
    {
        $participant = ConversationParticipant::where('conversation_id', $conversation->conversation_id)
            ->where('user_id', $user->user_id)
            ->first();

        if ($participant && $participant->unread_count > 0) {
            $participant->update([
                'unread_count' => 0,
                'last_read_at' => now()
            ]);
        }
    }

    // Helper: Generate conversation title
    private function generateConversationTitle($validated, $user)
    {
        if ($validated['conversation_type'] === 'direct') {
            $otherUser = User::find($validated['participant_ids'][0]);
            return $otherUser ? 'Chat với ' . $otherUser->first_name . ' ' . $otherUser->last_name : 'Direct Chat';
        }

        if ($validated['conversation_type'] === 'opportunity_chat' && isset($validated['opportunity_id'])) {
            $opportunity = VolunteerOpportunity::find($validated['opportunity_id']);
            return $opportunity ? 'Chat: ' . $opportunity->title : 'Opportunity Chat';
        }

        return 'Group Chat - ' . now()->format('d/m/Y');
    }

    // Helper: Send notification
    private function sendConversationInviteNotification($conversation, $userId)
    {
        DB::table('notifications')->insert([
            'user_id' => $userId,
            'notification_type' => 'Message',
            'title' => 'Bạn được thêm vào conversation mới',
            'content' => $conversation->title,
            'related_id' => $conversation->conversation_id,
            'related_type' => 'conversation',
            'action_url' => route('conversations.show', $conversation->conversation_id),
            'created_at' => now()
        ]);
    }
}
