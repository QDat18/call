<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Connection extends Model
{
    protected $primaryKey = 'connection_id';

    protected $fillable = [
        'user_id',
        'friend_id',
        'status',
        'action_user_id',
        'requested_at',
        'accepted_at',
        'blocked_at',
    ];

    protected $casts = [
        'requested_at' => 'datetime',
        'accepted_at' => 'datetime',
        'blocked_at' => 'datetime',
    ];

    /**
     * Get the user who owns the connection
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Get the friend in the connection
     */
    public function friend(): BelongsTo
    {
        return $this->belongsTo(User::class, 'friend_id', 'user_id');
    }

    /**
     * Get the user who performed the last action
     */
    public function actionUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'action_user_id', 'user_id');
    }

    /**
     * Scope to get accepted connections
     */
    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    /**
     * Scope to get pending connections
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope to get blocked connections
     */
    public function scopeBlocked($query)
    {
        return $query->where('status', 'blocked');
    }

    /**
     * Check if connection is accepted
     */
    public function isAccepted(): bool
    {
        return $this->status === 'accepted';
    }

    /**
     * Check if connection is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if connection is blocked
     */
    public function isBlocked(): bool
    {
        return $this->status === 'blocked';
    }

    /**
     * Accept the connection
     */
    public function accept(): bool
    {
        $this->status = 'accepted';
        $this->accepted_at = now();
        $this->action_user_id = auth()->id();
        return $this->save();
    }

    /**
     * Block the connection
     */
    public function block(): bool
    {
        $this->status = 'blocked';
        $this->blocked_at = now();
        $this->action_user_id = auth()->id();
        return $this->save();
    }

    /**
     * Unblock the connection
     */
    public function unblock(): bool
    {
        $this->status = 'pending';
        $this->blocked_at = null;
        $this->action_user_id = auth()->id();
        return $this->save();
    }
}