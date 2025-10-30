<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VideoAnswerCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $callId;
    public $answer;
    public $fromUserId;
    public $toUserId;

    /**
     * Create a new event instance.
     */
    public function __construct($callId, $answer, $fromUserId, $toUserId)
    {
        $this->callId = $callId;
        $this->answer = $answer;
        $this->fromUserId = $fromUserId;
        $this->toUserId = $toUserId;
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
        return 'video.answer';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'call_id' => $this->callId,
            'answer' => $this->answer,
            'from_user_id' => $this->fromUserId,
        ];
    }
}