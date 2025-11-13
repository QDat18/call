<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoCall extends Model
{
    protected $primaryKey = 'call_id';
    
    protected $fillable = [
        'conversation_id',
        'initiated_by',
        'call_type',
        'call_status',
        'room_id',
        'started_at',
        'ended_at',
        'duration'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'duration' => 'integer'
    ];

    // ✅ Relationships
    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'conversation_id');
    }

    public function initiator()
    {
        return $this->belongsTo(User::class, 'initiated_by');
    }

    // ✅ SỬA: Scope tìm calls của user qua conversation_participants
    public function scopeForUser($query, $userId = null)
    {
        $userId = $userId ?? auth()->id();
        
        return $query->whereHas('conversation.participants', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        });
    }

    // ✅ Helper: Lấy user bên kia cuộc gọi
    public function getOtherParticipantAttribute()
    {
        $currentUserId = auth()->id();
        
        return $this->conversation->participants()
            ->where('user_id', '!=', $currentUserId)
            ->first()
            ?->user;
    }
}