<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoCall extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $table = 'video_calls';
    protected $primaryKey = 'call_id';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'conversation_id',
        'initiated_by',
        'call_type',
        'call_status',
        'room_id',
        'started_at',
        'ended_at',
        'duration',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'created_at' => 'datetime',
        'duration' => 'integer',
    ];

    /**
     * Get the conversation associated with this call.
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'conversation_id', 'conversation_id');
    }

    /**
     * Get the user who initiated the call.
     */
    public function initiator()
    {
        return $this->belongsTo(User::class, 'initiated_by', 'user_id');
    }

    /**
     * Get all participants in this call through conversation participants.
     */
    public function participants()
    {
        return $this->hasManyThrough(
            User::class,
            ConversationParticipant::class,
            'conversation_id',
            'user_id',
            'conversation_id',
            'user_id'
        );
    }

    /**
     * Start the call.
     */
    public function start()
    {
        $this->update([
            'call_status' => 'active',
            'started_at' => now(),
        ]);
    }

    /**
     * End the call and calculate duration.
     */
    public function end()
    {
        $endTime = now();
        $duration = $this->started_at ? $this->started_at->diffInSeconds($endTime) : 0;

        $this->update([
            'call_status' => 'ended',
            'ended_at' => $endTime,
            'duration' => $duration,
        ]);
    }

    /**
     * Mark call as missed.
     */
    public function markAsMissed()
    {
        $this->update([
            'call_status' => 'missed',
        ]);
    }

    /**
     * Decline the call.
     */
    public function decline()
    {
        $this->update([
            'call_status' => 'declined',
        ]);
    }

    /**
     * Check if call is active.
     */
    public function isActive(): bool
    {
        return $this->call_status === 'active';
    }

    /**
     * Check if call is ringing.
     */
    public function isRinging(): bool
    {
        return $this->call_status === 'ringing';
    }

    /**
     * Get formatted duration.
     */
    public function getFormattedDurationAttribute(): string
    {
        if (!$this->duration) {
            return '0:00';
        }

        $hours = floor($this->duration / 3600);
        $minutes = floor(($this->duration % 3600) / 60);
        $seconds = $this->duration % 60;

        if ($hours > 0) {
            return sprintf('%d:%02d:%02d', $hours, $minutes, $seconds);
        }

        return sprintf('%d:%02d', $minutes, $seconds);
    }

    /**
     * Scope for active calls.
     */
    public function scopeActive($query)
    {
        return $query->where('call_status', 'active');
    }

    /**
     * Scope for ringing calls.
     */
    public function scopeRinging($query)
    {
        return $query->where('call_status', 'ringing');
    }

    /**
     * Scope for user's calls.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->whereHas('conversation.participants', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        });
    }

    /**
     * Scope for recent calls.
     */
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days))
                     ->orderBy('created_at', 'desc');
    }
}