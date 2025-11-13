<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CallInvitation implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $callId;
    public $roomId;
    public $caller;
    public $callType;

    public function __construct($callId, $roomId, $caller, $callType)
    {
        $this->callId = $callId;
        $this->roomId = $roomId;
        $this->caller = $caller;
        $this->callType = $callType;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('user.' . $this->caller['receiverId']);
    }

    public function broadcastAs()
    {
        return 'call.invitation';
    }
}