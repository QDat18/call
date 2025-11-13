<?php
// app/Events/CallEnded.php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CallEnded implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $callId;
    public $duration;
    public $endedBy;

    public function __construct($callId, $duration, $endedBy)
    {
        $this->callId = $callId;
        $this->duration = $duration;
        $this->endedBy = $endedBy;
    }

    public function broadcastOn()
    {
        return new Channel('call.' . $this->callId);
    }

    public function broadcastAs()
    {
        return 'call.ended';
    }
}