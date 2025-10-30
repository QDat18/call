<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VideoCallDeclined implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $callId;
    public $fromUserId;
    public $toUserId;
    public $reason;

    /**
     * Create a new event instance.
     */
    public function __construct($callId, $fromUserId, $toUserId, $reason = null)
    {
        $this->callId = $callId;
        $this->fromUserId = $fromUserId;
        $this->toUserId = $toUserId;
        $this->reason = $reason;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('video-call.' . $this->toUserId),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'video.declined';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'call_id' => $this->callId,
            'from_user_id' => $this->fromUserId,
            'reason' => $this->reason,
        ];
    }
}