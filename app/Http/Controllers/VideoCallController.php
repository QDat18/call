<?php

namespace App\Http\Controllers;

use App\Models\VideoCall;
use App\Models\Conversation;
use App\Models\ConversationParticipant;
use App\Events\VideoOfferCreated;
use App\Events\VideoAnswerCreated;
use App\Events\IceCandidateReceived;
use App\Events\VideoCallDeclined;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VideoCallController extends Controller
{
    /**
     * Hiển thị lịch sử cuộc gọi
     */
    public function index()
    {
        $userId = Auth::id();
        $calls = VideoCall::forUser($userId)
            ->with(['conversation', 'initiator', 'recipient'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('video-calls.index', compact('calls'));
    }

    /**
     * Khởi tạo cuộc gọi (API) - CHỈ TẠO RECORD, CHƯA GỬI OFFER
     */
    public function initiate(Request $request)
{
    $request->validate([
        'conversation_id' => 'required|exists:conversations,conversation_id',
        'call_type' => 'required|in:audio,video',
    ]);

    $userId = Auth::id();
    $conversationId = $request->conversation_id;

    // 🔒 Kiểm tra quyền của user trong conversation
    $isParticipant = ConversationParticipant::where('conversation_id', $conversationId)
        ->where('user_id', $userId)
        ->exists();

    if (!$isParticipant) {
        return response()->json([
            'success' => false,
            'message' => 'Bạn không có quyền thực hiện cuộc gọi trong cuộc trò chuyện này.'
        ], 403);
    }

    // 🔍 Tìm cuộc gọi đang hoạt động hoặc đang đổ chuông
    $existingCall = VideoCall::where('conversation_id', $conversationId)
        ->whereIn('call_status', ['ringing', 'active'])
        ->first();

    if ($existingCall) {
        // ✅ Thay vì trả 409, tự động kết thúc cuộc gọi cũ
        Log::warning('⚠️ Existing call found, auto-ending before new call', [
            'old_call_id' => $existingCall->call_id,
            'conversation_id' => $conversationId,
        ]);

        $existingCall->update([
            'call_status' => 'ended',
            'ended_at' => now(),
        ]);
    }

    // 🎬 Tạo cuộc gọi mới với trạng thái "ringing"
    $call = VideoCall::create([
        'conversation_id' => $conversationId,
        'initiated_by' => $userId,
        'call_type' => $request->call_type,
        'call_status' => 'ringing',
        'room_id' => Str::uuid(),
    ]);

    Log::info('📞 Video call initiated', [
        'call_id' => $call->call_id,
        'user_id' => $userId,
        'type' => $request->call_type
    ]);

    return response()->json([
        'success' => true,
        'call_id' => $call->call_id,
        'room_id' => $call->room_id,
        'message' => 'Cuộc gọi đã được tạo thành công.'
    ]);
}

    /**
     * Gửi Offer - BROADCAST ĐẾN NGƯỜI NHẬN
     */
    public function sendOffer(Request $request)
    {
        $request->validate([
            'call_id' => 'required|exists:video_calls,call_id',
            'offer' => 'required|array',
            'offer.type' => 'required|in:offer',
            'offer.sdp' => 'required|string',
            'to_user_id' => 'required|exists:users,user_id',
        ]);

        $call = VideoCall::findOrFail($request->call_id);

        // Kiểm tra quyền gửi offer
        if ($call->initiated_by !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Không có quyền.'], 403);
        }

        // Kiểm tra đã có offer chưa
        if ($call->offer_sdp) {
            return response()->json([
                'success' => false,
                'message' => 'Offer đã được gửi.'
            ], 400);
        }

        // Lưu offer vào database
        $call->update([
            'offer_sdp' => json_encode($request->offer),
            'call_status' => 'ringing',
        ]);

        // Broadcast event đến người nhận
        broadcast(new VideoOfferCreated(
            $call->call_id,
            $request->offer,
            Auth::id(),
            $request->to_user_id
        ))->toOthers();

        Log::info('Offer sent', [
            'call_id' => $call->call_id,
            'from' => Auth::id(),
            'to' => $request->to_user_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Offer sent successfully.'
        ]);
    }

    /**
     * Lấy Offer SDP - Dùng khi người nhận accept
     */
    public function getOffer($call_id)
    {
        $call = VideoCall::findOrFail($call_id);

        if (!$call->offer_sdp) {
            return response()->json([
                'success' => false,
                'message' => 'No offer found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'offer' => json_decode($call->offer_sdp, true),
            'from_user_id' => $call->initiated_by,
        ]);
    }

    /**
     * Gửi Answer - Người nhận đã chấp nhận
     */
    public function answer(Request $request)
    {
        $request->validate([
            'call_id' => 'required|exists:video_calls,call_id',
            'answer' => 'required|array',
            'to_user_id' => 'required|exists:users,user_id',
        ]);

        $call = VideoCall::findOrFail($request->call_id);

        // Cập nhật status thành active
        $call->update([
            'answer_sdp' => json_encode($request->answer),
            'call_status' => 'active',
            'started_at' => now(),
        ]);

        // Broadcast answer đến người gọi
        broadcast(new VideoAnswerCreated(
            $call->call_id,
            $request->answer,
            Auth::id(),
            $request->to_user_id
        ))->toOthers();

        Log::info('Answer sent', [
            'call_id' => $call->call_id,
            'from' => Auth::id(),
            'to' => $request->to_user_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Answer sent successfully.'
        ]);
    }

    /**
     * Gửi ICE Candidate
     */
    public function ice(Request $request)
    {
        $request->validate([
            'call_id' => 'required|exists:video_calls,call_id',
            'candidate' => 'required',
            'to_user_id' => 'required|exists:users,user_id',
        ]);

        broadcast(new IceCandidateReceived(
            $request->call_id,
            $request->candidate,
            Auth::id(),
            $request->to_user_id
        ))->toOthers();

        return response()->json([
            'success' => true,
            'message' => 'ICE candidate sent.'
        ]);
    }

    /**
     * VÀO PHÒNG GỌI - KIỂM TRA NGHIÊM NGẶT
     */
    public function showRoom($call_id)
    {
        $call = VideoCall::with(['conversation.participants.user', 'initiator'])
            ->findOrFail($call_id);

        $userId = Auth::id();

        // Kiểm tra là participant
        $isParticipant = $call->conversation->participants()
            ->where('user_id', $userId)
            ->where('is_active', true)
            ->exists();

        if (!$isParticipant) {
            abort(403, 'You are not allowed to join this call.');
        }

        // KIỂM TRA TRẠNG THÁI CUỘC GỌI
        if (!in_array($call->call_status, ['ringing', 'active'])) {
            return redirect()->route('video-calls.ended', $call_id)
                ->with('error', 'This call has ended.');
        }

        $isInitiator = $call->initiated_by === $userId;

        // NGƯỜI GỌI: Phải đã gửi offer mới được vào room
        if ($isInitiator) {
            if (!$call->offer_sdp) {
                return redirect()->route('conversations.show', $call->conversation_id)
                    ->with('error', 'Please wait while connecting...');
            }
        } 
        // NGƯỜI NHẬN: Phải có offer từ người gọi
        else {
            if (!$call->offer_sdp) {
                return redirect()->route('conversations.show', $call->conversation_id)
                    ->with('error', 'Waiting for caller to connect...');
            }
        }

        $participant = $call->conversation->participants()
            ->where('user_id', '!=', $userId)
            ->first()?->user;

        return view('video-calls.room', [
            'callId' => $call->call_id,
            'callType' => $call->call_type,
            'participant' => $participant,
            'isInitiator' => $isInitiator,
            'conversationId' => $call->conversation_id,
            'startedAt' => $call->started_at ?? now()->timestamp * 1000,
        ]);
    }

    /**
     * Join call - Accept incoming call
     */
    public function join($call_id)
    {
        $call = VideoCall::findOrFail($call_id);
        $userId = Auth::id();

        // Kiểm tra quyền
        $isParticipant = $call->conversation->participants()
            ->where('user_id', $userId)
            ->exists();

        if (!$isParticipant) {
            return redirect()->route('dashboard')
                ->with('error', 'You are not allowed to join this call.');
        }

        // Redirect đến room
        return redirect()->route('video-calls.room', $call_id);
    }

    /**
     * Kết thúc cuộc gọi
     */
    public function end(Request $request)
    {
        $request->validate([
            'call_id' => 'required|exists:video_calls,call_id'
        ]);

        $call = VideoCall::findOrFail($request->call_id);
        
        // Calculate duration
        $duration = 0;
        if ($call->started_at) {
            $duration = now()->diffInSeconds($call->started_at);
        }

        $call->update([
            'call_status' => 'ended',
            'ended_at' => now(),
            'duration' => $duration,
        ]);

        Log::info('Call ended', [
            'call_id' => $call->call_id,
            'duration' => $duration
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Call ended.',
            'redirect' => route('video-calls.ended', $call->call_id)
        ]);
    }

    /**
     * Từ chối cuộc gọi
     */
    public function decline(Request $request)
    {
        $request->validate([
            'call_id' => 'required|exists:video_calls,call_id'
        ]);

        $call = VideoCall::findOrFail($request->call_id);

        $call->update([
            'call_status' => 'declined'
        ]);

        // Broadcast declined event
        broadcast(new VideoCallDeclined(
            $call->call_id,
            Auth::id(),
            $call->initiated_by,
            $request->reason ?? 'Call declined'
        ))->toOthers();

        Log::info('Call declined', [
            'call_id' => $call->call_id,
            'by' => Auth::id()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Call declined.'
        ]);
    }

    /**
     * Trang kết thúc cuộc gọi
     */
    public function ended($call_id)
    {
        $call = VideoCall::with(['initiator', 'conversation.participants.user'])
            ->findOrFail($call_id);

        return view('video-calls.ended', compact('call'));
    }

    /**
     * Get call details
     */
    public function show($call_id)
    {
        $call = VideoCall::with(['initiator', 'conversation.participants.user'])
            ->findOrFail($call_id);

        return response()->json([
            'success' => true,
            'call' => [
                'call_id' => $call->call_id,
                'call_type' => $call->call_type,
                'call_status' => $call->call_status,
                'initiator' => [
                    'user_id' => $call->initiator->user_id,
                    'name' => $call->initiator->first_name . ' ' . $call->initiator->last_name,
                    'avatar_url' => $call->initiator->avatar_url,
                ],
                'started_at' => $call->started_at,
                'ended_at' => $call->ended_at,
                'duration' => $call->duration,
            ]
        ]);
    }

    /**
     * Recent calls
     */
    public function recent()
    {
        $userId = Auth::id();
        
        $calls = VideoCall::forUser($userId)
            ->with(['initiator', 'conversation.participants.user'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'calls' => $calls
        ]);
    }
}