<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    /**
     * @param Message $message
     */
    public function __construct(Message $message)
    {
        // Chỉ load sender nếu cần thiết
        $this->message = $message->loadMissing('sender');
    }

    /**
     * Kênh broadcast: private-conversation.{id}
     */
    public function broadcastOn(): Channel
    {
        return new PrivateChannel('conversation.' . $this->message->conversation_id);
    }

    /**
     * Tên event client sẽ lắng nghe
     */
    public function broadcastAs(): string
    {
        return 'message.sent';
    }

    /**
     * Dữ liệu gửi về client
     */
    public function broadcastWith(): array
    {
        $sender = $this->message->sender;

        return [
            'message_id'       => $this->message->message_id,
            'conversation_id'  => $this->message->conversation_id,
            'sender_id'        => $this->message->sender_id,
            'sender'           => [
                'first_name'   => $sender?->first_name ?? 'User',
                'last_name'    => $sender?->last_name,
                'full_name'    => trim(($sender?->first_name ?? '') . ' ' . ($sender?->last_name ?? '')) ?: 'User',
                'avatar_url'   => $sender?->avatar_url ?? asset('images/default-avatar.png'),
            ],
            'content'          => $this->message->content,
            'message_type'     => $this->message->message_type ?? 'text',
            'attachment_url'   => $this->message->attachment_url ? asset($this->message->attachment_url) : null,
            'attachment_name'  => $this->message->attachment_name,
            'sent_at'          => $this->message->sent_at?->toISOString(), // ISO 8601: "2025-04-05T10:20:30.000000Z"
        ];
    }
}