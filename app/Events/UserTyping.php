<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserTyping implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $conversationId;
    public $userId;
    public $userName;
    public $isTyping;

    public function __construct($conversationId, $userId, $userName, $isTyping = true)
    {
        $this->conversationId = $conversationId;
        $this->userId = $userId;
        $this->userName = $userName;
        $this->isTyping = $isTyping;
    }

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('conversation.' . $this->conversationId);
    }

    public function broadcastAs(): string
    {
        return 'user.typing';
    }

    public function broadcastWith(): array
    {
        return [
            'user_id' => $this->userId,
            'user_name' => $this->userName,
            'is_typing' => $this->isTyping,
        ];
    }
}