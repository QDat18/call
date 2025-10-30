<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConversationParticipant extends Model
{
    use HasFactory;

    protected $table = 'conversation_participants';
    protected $primaryKey = 'participant_id';
    public $timestamps = false;

    protected $fillable = [
        'conversation_id',
        'user_id',
        'joined_at',
        'last_read_at',
        'unread_count',
        'is_active',
    ];

    protected $casts = [
        'joined_at' => 'datetime',
        'last_read_at' => 'datetime',
        'unread_count' => 'integer',
        'is_active' => 'boolean',
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'conversation_id', 'conversation_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function markAsRead()
    {
        $this->update([
            'last_read_at' => now(),
            'unread_count' => 0,
        ]);
    }

    public function incrementUnreadCount()
    {
        $this->increment('unread_count');
    }
}