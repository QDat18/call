<?php
namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class FriendRequestSent implements ShouldBroadcast
{
    public $connection;
    
    public function __construct($connection)
    {
        $this->connection = $connection->load('user');
    }
    
    public function broadcastOn()
    {
        return new PrivateChannel('user.' . $this->connection->friend_id);
    }
    
    public function broadcastAs()
    {
        return 'friend.request.sent';
    }
}