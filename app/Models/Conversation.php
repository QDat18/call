<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $table = 'conversations';
    protected $primaryKey = 'conversation_id';
    const UPDATED_AT = null;

    protected $fillable = [
        'conversation_type',
        'title',
        'opportunity_id',
        'created_by',
        'last_message_at',
        'is_active',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
        'created_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }

    public function opportunity()
    {
        return $this->belongsTo(VolunteerOpportunity::class, 'opportunity_id', 'opportunity_id');
    }

    public function participants()
    {
        return $this->hasMany(ConversationParticipant::class, 'conversation_id', 'conversation_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'conversation_id', 'conversation_id');
    }

    public function videoCalls()
    {
        return $this->hasMany(VideoCall::class, 'conversation_id', 'conversation_id');
    }

    public function activeParticipants()
    {
        return $this->participants()->where('is_active', true);
    }

    public function getOtherParticipants($currentUserId)
    {
        return $this->participants()
                    ->where('user_id', '!=', $currentUserId)
                    ->where('is_active', true)
                    ->with('user')
                    ->get();
    }
    public function lastMessage()
        {
            return $this->hasOne(Message::class, 'conversation_id', 'conversation_id')
                ->latest('message_id');
        }
}