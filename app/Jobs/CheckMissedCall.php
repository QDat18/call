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

    public function __construct($callId, $timeoutSeconds = 60)
    {
        $this->callId = $callId;
        $this->timeoutSeconds = $timeoutSeconds;
    }

    public function handle(): void
    {
        $call = VideoCall::find($this->callId);

        if (!$call || !in_array($call->call_status, ['initiated', 'ringing'])) {
            return;
        }

        $elapsedSeconds = Carbon::parse($call->created_at)->diffInSeconds(Carbon::now());

        if ($elapsedSeconds >= $this->timeoutSeconds) {
            $call->markAsMissed();
            $this->notifyMissedCall($call);
        }
    }

    protected function notifyMissedCall($call)
    {
        $conversation = $call->conversation;
        $initiator = $call->initiator;

        if (!$conversation || !$initiator) {
            return;
        }

        $participants = $conversation->participants()
            ->where('user_id', '!=', $call->initiated_by)
            ->get();

        foreach ($participants as $participant) {
            if (!$participant->user) continue;

            // Notify caller
            Notification::create([
                'user_id' => $call->initiated_by,
                'notification_type' => 'missed_call',
                'title' => 'Missed Call',
                'content' => "Your call to {$participant->user->name} was missed.",
                'related_id' => $call->call_id,
            ]);

            // Notify recipient
            Notification::create([
                'user_id' => $participant->user_id,
                'notification_type' => 'missed_call',
                'title' => 'Missed Call',
                'content' => "You missed a call from {$initiator->name}.",
                'related_id' => $call->call_id,
            ]);
        }
    }
}