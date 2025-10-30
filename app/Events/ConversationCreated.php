<?php

namespace App\Events;

use App\Models\Conversation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class ConversationCreated implements ShouldBroadcast
{
    use SerializesModels;

    public $conversation;

    public function __construct(Conversation $conversation)
    {
        $this->conversation = $conversation->load('participants.user');
    }

    public function broadcastOn()
    {
        return new Channel('conversations');
    }

    public function broadcastWith()
    {
        return ['conversation' => $this->conversation];
    }
}
