<?php
namespace App\Jobs;
use App\Models\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userIds;
    protected $data;
    public function __construct($userIds, array $data)
    {
        $this->userIds = is_array($userIds) ? $userIds : [$userIds];
        $this->data = $data;
    }
    public function handle(): void
    {
        try {
            $notifications = [];
            $now = now();

            foreach ($this->userIds as $userId) {
                $notifications[] = [
                    'user_id' => $userId,
                    'notification_type' => $this->data['type'] ?? 'General',
                    'title' => $this->data['title'],
                    'content' => $this->data['content'],
                    'related_id' => $this->data['related_id'] ?? null,
                    'related_type' => $this->data['related_type'] ?? null,
                    'action_url' => $this->data['action_url'] ?? null,
                    'priority' => $this->data['priority'] ?? 'medium',
                    'is_read' => false,
                    'created_at' => $now,
                ];
            }
            Notification::insert($notifications);
        } catch (\Exception $e) {
            Log::error('Failed to send notifications: ' . $e->getMessage());
            throw $e;
        }
    }
}
