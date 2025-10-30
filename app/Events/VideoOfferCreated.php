<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow; // dùng broadcast ngay lập tức
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VideoOfferCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * 🧩 Các thuộc tính của sự kiện
     */
    public int $call_id;
    public array $offer;
    public int $from_user_id;
    public int $to_user_id;
    public string $call_type;

    /**
     * 🚀 Khởi tạo event
     */
    public function __construct(
        int $call_id,
        array $offer,
        int $from_user_id,
        int $to_user_id,
        string $call_type = 'video' // mặc định video
    ) {
        $this->call_id = $call_id;
        $this->offer = $offer;
        $this->from_user_id = $from_user_id;
        $this->to_user_id = $to_user_id;
        $this->call_type = $call_type;
    }

    /**
     * 📡 Kênh broadcast (gửi cho người nhận cuộc gọi)
     */
    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('video-call.' . $this->to_user_id);
    }

    /**
     * 🏷️ Tên sự kiện khi broadcast qua Pusher/Echo
     */
    public function broadcastAs(): string
    {
        return 'offer.created';
    }

    /**
     * 📦 Dữ liệu gửi tới client
     */
    public function broadcastWith(): array
    {
        return [
            'call_id' => $this->call_id,
            'call_type' => $this->call_type,
            'offer' => $this->offer,
            'from_user_id' => $this->from_user_id,
        ];
    }
}
