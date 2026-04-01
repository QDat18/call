<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class FriendRequestSent implements ShouldBroadcast
{
    use SerializesModels;

    // ĐỔI TÊN BIẾN: Tránh dùng $connection vì trùng từ khóa của Laravel Queue
    public $friendRequest; 
    
    public function __construct($connectionModel)
    {
        // Gán vào biến mới
        $this->friendRequest = $connectionModel->load('user');
    }
    
    public function broadcastOn()
    {
        // Sử dụng biến mới
        return new PrivateChannel('user.' . $this->friendRequest->friend_id);
    }
    
    public function broadcastAs()
    {
        return 'friend.request.sent';
    }

    /**
     * Định dạng dữ liệu trả về cho Frontend (JS)
     * Tại đây ta map lại key thành 'connection' để Frontend không bị lỗi code cũ
     */
    public function broadcastWith()
    {
        return [
            'connection' => $this->friendRequest
        ];
    }
}