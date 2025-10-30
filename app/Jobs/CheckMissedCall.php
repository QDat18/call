<?php

namespace App\Jobs;

use App\Models\VideoCall;
use App\Models\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class CheckMissedCall implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $callId;
    protected $timeoutSeconds;

    /**
     * Create a new job instance.
     */
    public function __construct($callId, $timeoutSeconds = 60)
    {
        $this->callId = $callId;
        $this->timeoutSeconds = $timeoutSeconds;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $call = VideoCall::find($this->callId);

        if (!$call) {
            return;
        }

        // Check if call is still in ringing or initiated status
        if (in_array($call->call_status, ['ringing', 'initiated'])) {
            // ✅ FIX: Correct way to calculate time difference
            $createdAt = Carbon::parse($call->created_at);
            $now = Carbon::now();
            
            // ✅ OLD (WRONG): $now->diffInSeconds($createdAt)
            // ✅ NEW (CORRECT): $createdAt->diffInSeconds($now)
            $elapsedSeconds = $createdAt->diffInSeconds($now);
            
            if ($elapsedSeconds >= $this->timeoutSeconds) {
                // Mark as missed
                $call->markAsMissed();

                // Notify the caller that the call was missed
                $this->notifyMissedCall($call);
            }
        }
    }

    /**
     * Notify participants about missed call.
     */
    protected function notifyMissedCall($call)
    {
        $conversation = $call->conversation;
        $initiator = $call->initiator;

        if (!$conversation || !$initiator) {
            return;
        }

        // Get other participants
        $participants = $conversation->participants()
            ->where('user_id', '!=', $call->initiated_by)
            ->where('is_active', true)
            ->get();

        foreach ($participants as $participant) {
            // ✅ FIX: Add null check for user relationship
            if (!$participant->user) {
                continue;
            }

            // Notify the caller (initiator)
            Notification::create([
                'user_id' => $call->initiated_by,
                'notification_type' => 'Video Call',
                'title' => 'Missed Call',
                'content' => "Your call to {$participant->user->first_name} {$participant->user->last_name} was not answered.",
                'related_id' => $call->call_id,
                'related_type' => 'call',
                'action_url' => route('video-calls.show', $call->call_id),
                'priority' => 'medium',
            ]);

            // Also notify the recipient
            Notification::create([
                'user_id' => $participant->user_id,
                'notification_type' => 'Video Call',
                'title' => 'Missed Call',
                'content' => "You missed a call from {$initiator->first_name} {$initiator->last_name}.",
                'related_id' => $call->call_id,
                'related_type' => 'call',
                'action_url' => route('conversations.show', $conversation->conversation_id),
                'priority' => 'medium',
            ]);
        }
    }
}