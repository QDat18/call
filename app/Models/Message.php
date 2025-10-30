<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $primaryKey = 'message_id';

    // ✅ Không dùng timestamps mặc định vì chỉ có sent_at
    public $timestamps = false;

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'message_type',
        'content',
        'attachment_url',
        'attachment_name',
        'is_deleted',
        'sent_at',
    ];

    protected $casts = [
        'is_deleted' => 'boolean',
        'sent_at' => 'datetime',
    ];

    // ✅ Auto-set sent_at khi tạo
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($message) {
            if (empty($message->sent_at)) {
                $message->sent_at = now();
            }
        });
    }

    // Relationships
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class, 'conversation_id', 'conversation_id');
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id', 'user_id');
    }

    // Accessors
    public function getDisplayContentAttribute(): string
    {
        return $this->is_deleted ? '[Message deleted]' : $this->content;
    }

    // Methods
    public function softDelete(): void
    {
        $this->update(['is_deleted' => true]);
    }

    public function hasAttachment(): bool
    {
        return !empty($this->attachment_url);
    }
}