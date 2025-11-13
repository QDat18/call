<?php

namespace App\Http\Controllers;

use App\Events\CallInvitation;
use App\Jobs\CheckMissedCall;
use App\Models\VideoCall;
use App\Models\ConversationParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Services\AgoraTokenBuilder;
use App\Events\CallEnded;

class VideoCallController extends Controller
{
    /**
     * Display video calls history
     */
    public function index()
    {
        $calls = VideoCall::forUser()->orderByDesc('created_at')->paginate(20);
        
        // Calculate stats
        $totalCalls = VideoCall::forUser()->count();
        $completedCalls = VideoCall::forUser()->where('call_status', 'ended')->count();
        $missedCalls = VideoCall::forUser()->where('call_status', 'missed')->count();
        $totalDuration = VideoCall::forUser()->where('call_status', 'ended')->sum('duration');
        $totalDurationFormatted = gmdate('H\h i\m', $totalDuration);
        
        return view('video-calls.index', compact(
            'calls', 
            'totalCalls', 
            'completedCalls', 
            'missedCalls', 
            'totalDurationFormatted'
        ));
    }
    public function status($call_id)
    {
        $call = VideoCall::findOrFail($call_id);
    
        return response()->json([
            'call_id' => $call->call_id,
            'status' => $call->call_status,
            'duration' => $call->duration,
            'ended_at' => $call->ended_at?->toDateTimeString(),
        ]);
    }
    /**
     * Initiate a new video/audio call
     */
    public function initiate(Request $request)
    {
        try {
            $request->validate([
                'conversation_id' => 'required|exists:conversations,conversation_id',
                'call_type' => 'required|in:audio,video',
            ]);

            $userId = Auth::id();
            $conversationId = $request->conversation_id;

            Log::info('📞 Video call initiate request', [
                'user_id' => $userId,
                'conversation_id' => $conversationId,
                'call_type' => $request->call_type
            ]);

            // Check permission
            if (!ConversationParticipant::where('conversation_id', $conversationId)
                ->where('user_id', $userId)
                ->exists()) {
                Log::warning('❌ Unauthorized call attempt', [
                    'user_id' => $userId,
                    'conversation_id' => $conversationId
                ]);
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            // ✅ AUTO-END existing calls (fix "Call in progress" error)
            $existing = VideoCall::where('conversation_id', $conversationId)
                ->whereIn('call_status', ['ringing', 'active'])
                ->first();
                
            if ($existing) {
                Log::warning('⚠️ Found existing call, ending it automatically', [
                    'existing_call_id' => $existing->call_id,
                    'status' => $existing->call_status
                ]);
                
                $duration = $existing->started_at 
                    ? now()->diffInSeconds($existing->started_at) 
                    : 0;
                    
                $existing->update([
                    'call_status' => 'ended',
                    'ended_at' => now(),
                    'duration' => $duration
                ]);
            }

            // Create new call with Agora room ID
            $roomId = 'agora_' . Str::random(16);
            
            $call = VideoCall::create([
                'conversation_id' => $conversationId,
                'initiated_by' => $userId,
                'call_type' => $request->call_type,
                'call_status' => 'ringing',
                'room_id' => $roomId,
            ]);

            // Get receiver
            $receiverId = ConversationParticipant::where('conversation_id', $conversationId)
                ->where('user_id', '!=', $userId)
                ->value('user_id');

            if (!$receiverId) {
                Log::error('❌ Receiver not found', [
                    'conversation_id' => $conversationId,
                    'caller_id' => $userId
                ]);
                return response()->json(['error' => 'Receiver not found'], 404);
            }

            $user = Auth::user();
            $callerName = $user->first_name . ' ' . $user->last_name;

            // Broadcast invitation to receiver
            broadcast(new CallInvitation(
                $call->call_id, 
                $roomId, 
                [
                    'id' => $userId,
                    'name' => $callerName,
                    'receiverId' => $receiverId
                ], 
                $request->call_type
            ));

            // Queue missed call check (after 60 seconds)
            CheckMissedCall::dispatch($call->call_id)->delay(now()->addSeconds(60));

            Log::info('✅ Video call created successfully', [
                'call_id' => $call->call_id,
                'room_id' => $roomId,
                'caller_id' => $userId,
                'receiver_id' => $receiverId
            ]);

            return response()->json([
                'success' => true,
                'call_id' => $call->call_id, 
                'room_id' => $roomId
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('❌ Validation error', ['errors' => $e->errors()]);
            return response()->json([
                'error' => 'Validation failed',
                'message' => $e->getMessage(),
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('❌ Video call initiate error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'Failed to initiate call',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate Agora RTC Token
     * ✅ Fixed: Always returns appId even in testing mode
     */
    public function token(Request $request)
{
    $request->validate([
        'channel' => 'required|string',
    ]);

    try {
        $appId = (string) config('services.agora.app_id');
        $appCertificate = config('services.agora.certificate');
        $channelName = $request->channel;
        $uid = Auth::id() ?? rand(1, 999999);
        $expire = config('services.agora.token_expire', 3600);

        \Log::info('🎫 Token request received', [
            'channel' => $channelName,
            'has_app_id' => !empty($appId),
            'has_certificate' => !empty($appCertificate),
        ]);
        $expire = (int) $expire;
        // ✅ Gọi đúng class builder
        $token = \App\Services\AgoraTokenBuilder::generateToken(
            $appId,
            $appCertificate,
            $channelName,
            $uid,
            $expire
        );

        return response()->json([
            'success' => true,
            'app_id' => $appId,
            'channel' => $channelName,
            'uid' => $uid,
            'token' => $token,
            'expires_at' => now()->addSeconds($expire)->toDateTimeString()
        ]);
    } catch (\Throwable $e) {
        \Log::error('🚨 Token generation failed', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
        return response()->json([
            'error' => 'Failed to generate token',
            'message' => $e->getMessage(),
        ], 500);
    }
}
    /**
     * Accept incoming call
     */
    public function accept(Request $request)
    {
        $request->validate(['call_id' => 'required|exists:video_calls,call_id']);

        $call = VideoCall::findOrFail($request->call_id);
        
        Log::info('✅ Call accepted', [
            'call_id' => $call->call_id,
            'user_id' => Auth::id()
        ]);
        
        $call->update([
            'call_status' => 'active',
            'started_at' => now()
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Decline incoming call
     */
    public function decline(Request $request)
    {
        $request->validate(['call_id' => 'required|exists:video_calls,call_id']);

        $call = VideoCall::findOrFail($request->call_id);
        
        Log::info('❌ Call declined', [
            'call_id' => $call->call_id,
            'user_id' => Auth::id()
        ]);
        
        $call->update([
            'call_status' => 'declined',
            'ended_at' => now(),
            'duration' => 0
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * End active call
     */
    public function end(Request $request)
{
    $request->validate(['call_id' => 'required|exists:video_calls,call_id']);

    $call = VideoCall::findOrFail($request->call_id);
    $duration = $call->started_at ? now()->diffInSeconds($call->started_at) : 0;
    
    Log::info('📞 Call ended', [
        'call_id' => $call->call_id,
        'duration' => $duration,
        'user_id' => Auth::id()
    ]);
    
    $call->update([
        'call_status' => 'ended',
        'ended_at' => now(),
        'duration' => $duration
    ]);

    // ✅ Broadcast để notify cả 2 bên
    broadcast(new CallEnded(
        $call->call_id,
        $duration,
        Auth::id()
    ))->toOthers();

    return response()->json([
        'success' => true,
        'duration' => $duration
    ]);
}
    /**
     * Show video call room
     */
    public function room($call_id)
    {
        $call = VideoCall::with(['conversation.participants.user', 'initiator'])
            ->findOrFail($call_id);
            
        $isInitiator = $call->initiated_by === Auth::id();
        
        // Get the other participant
        $participant = $call->conversation->participants()
            ->where('user_id', '!=', Auth::id())
            ->first()?->user;

        if (!$participant) {
            Log::error('❌ Participant not found', [
                'call_id' => $call_id,
                'user_id' => Auth::id()
            ]);
            abort(404, 'Participant not found');
        }

        $receiverId = $participant->user_id;

        Log::info('📺 Showing call room', [
            'call_id' => $call->call_id,
            'room_id' => $call->room_id,
            'user_id' => Auth::id(),
            'participant_id' => $receiverId
        ]);

        return view('video-calls.room', [
            'callId' => $call->call_id,
            'roomId' => $call->room_id,
            'callType' => $call->call_type,
            'conversationId' => $call->conversation_id,
            'participant' => $participant,
            'receiverId' => $receiverId,
            'isInitiator' => $isInitiator,
            'startedAt' => $call->started_at?->timestamp ?? null,
        ]);
    }

    /**
     * Show call ended screen
     */
    public function ended($call_id)
{
    $call = VideoCall::with(['initiator', 'conversation.participants.user'])
        ->findOrFail($call_id);
        
    // ✅ Tìm otherUser từ conversation participants
    $otherUser = $call->conversation->participants()
        ->where('user_id', '!=', auth()->id())
        ->first()
        ?->user;

    // ✅ Fallback: Nếu không tìm thấy, dùng initiator (nếu không phải mình)
    if (!$otherUser) {
        $otherUser = $call->initiator->user_id !== auth()->id() 
            ? $call->initiator 
            : null;
    }

    // ✅ Kiểm tra null
    if (!$otherUser) {
        Log::error('❌ Other user not found for ended call', [
            'call_id' => $call_id,
            'initiated_by' => $call->initiated_by,
            'current_user' => auth()->id()
        ]);
        abort(404, 'Participant not found');
    }

    Log::info('📞 Call ended screen', [
        'call_id' => $call_id,
        'duration' => $call->duration,
        'status' => $call->call_status,
        'other_user' => $otherUser->user_id
    ]);

    return view('video-calls.ended', compact('call', 'otherUser'));
}

    /**
     * Alias for room()
     */
    public function showRoom($callId)
    {
        return $this->room($callId);
    }

    /**
     * Join call (for receivers)
     */
    public function join($callId)
    {
        $call = VideoCall::with(['conversation.participants.user'])->findOrFail($callId);
        
        // Check if user is participant
        $isParticipant = $call->conversation->participants()
            ->where('user_id', Auth::id())
            ->exists();

        if (!$isParticipant) {
            Log::warning('❌ Unauthorized join attempt', [
                'call_id' => $callId,
                'user_id' => Auth::id()
            ]);
            abort(403, 'You are not a participant in this call');
        }

        // Update call status to active if it's ringing
        if ($call->call_status === 'ringing') {
            $call->update([
                'call_status' => 'active',
                'started_at' => now()
            ]);
            Log::info('✅ Call status updated to active', ['call_id' => $callId]);
        }

        return redirect()->route('video-calls.room', $callId);
    }

    /**
     * Get recent calls
     */
    public function recent()
    {
        $recentCalls = VideoCall::forUser()
            ->with(['initiator', 'conversation.participants.user'])
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return response()->json($recentCalls);
    }
}