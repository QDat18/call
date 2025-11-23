<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\ClearAnalyticsCache;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use ClearAnalyticsCache;
    
    protected $table = 'users';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'phone',
        'date_of_birth',
        'gender',
        'city',
        'district',
        'address',
        'user_type',
        'avatar_url',
        'is_verified',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'date',
        'is_verified' => 'boolean',
        'is_active' => 'boolean',
        'last_login_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ============================================
    // EXISTING RELATIONSHIPS
    // ============================================

    public function volunteerProfile(): HasOne
    {
        return $this->hasOne(VolunteerProfile::class, 'user_id', 'user_id');
    }

    /**
     * Alias for volunteerProfile to fix "Call to undefined method" error
     * This allows usages like User::with('volunteer') or $user->volunteer
     */
    public function volunteer(): HasOne
    {
        return $this->hasOne(VolunteerProfile::class, 'user_id', 'user_id');
    }

    public function organization(): HasOne
    {
        return $this->hasOne(Organization::class, 'user_id', 'user_id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'volunteer_id', 'user_id');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(VolunteerActivity::class, 'volunteer_id', 'user_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'reviewer_id', 'user_id');
    }

    public function sentReviews(): HasMany
    {
        return $this->hasMany(Review::class, 'reviewer_id', 'user_id');
    }

    public function receivedReviews(): HasMany
    {
        return $this->hasMany(Review::class, 'reviewee_id', 'user_id');
    }

    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class, 'created_by', 'user_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id', 'user_id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'user_id', 'user_id');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class, 'user_id', 'user_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    public function postLikes()
    {
        return $this->hasMany(PostLike::class, 'user_id');
    }

    public function postComments()
    {
        return $this->hasMany(PostComment::class, 'user_id');
    }

    public function postBookmarks()
    {
        return $this->hasMany(PostBookmark::class, 'user_id');
    }

    public function postReports()
    {
        return $this->hasMany(PostReport::class, 'reporter_id');
    }

    // ============================================
    // 🆕 CONNECTIONS RELATIONSHIPS (FRIENDS)
    // ============================================

    /**
     * Get connections where this user is the initiator
     */
    public function connections(): HasMany
    {
        return $this->hasMany(Connection::class, 'user_id', 'user_id');
    }

    /**
     * Get connections where this user is the friend
     */
    public function friendOf(): HasMany
    {
        return $this->hasMany(Connection::class, 'friend_id', 'user_id');
    }

    /**
     * Get all accepted friends (both directions)
     */
    public function friends()
    {
        // Get connections where I am user_id
        $connectionsAsUser = Connection::where('user_id', $this->user_id)
            ->where('status', 'accepted')
            ->with('friend')
            ->get()
            ->pluck('friend');

        // Get connections where I am friend_id
        $connectionsAsFriend = Connection::where('friend_id', $this->user_id)
            ->where('status', 'accepted')
            ->with('user')
            ->get()
            ->pluck('user');

        // Merge both collections
        return $connectionsAsUser->merge($connectionsAsFriend);
    }

    /**
     * Check if this user is friends with another user
     */
    public function isFriendWith($userId): bool
    {
        return Connection::where(function($q) use ($userId) {
                $q->where('user_id', $this->user_id)
                  ->where('friend_id', $userId);
            })
            ->orWhere(function($q) use ($userId) {
                $q->where('user_id', $userId)
                  ->where('friend_id', $this->user_id);
            })
            ->where('status', 'accepted')
            ->exists();
    }

    /**
     * Get connection status with another user
     */
    public function getConnectionStatus($userId): string
    {
        $connection = Connection::where(function($q) use ($userId) {
                $q->where('user_id', $this->user_id)
                  ->where('friend_id', $userId);
            })
            ->orWhere(function($q) use ($userId) {
                $q->where('user_id', $userId)
                  ->where('friend_id', $this->user_id);
            })
            ->first();

        return $connection ? $connection->status : 'none';
    }

    /**
     * Send friend request to another user
     */
    public function sendFriendRequest($userId)
    {
        // Check if connection already exists
        $exists = Connection::where(function($q) use ($userId) {
                $q->where('user_id', $this->user_id)
                  ->where('friend_id', $userId);
            })
            ->orWhere(function($q) use ($userId) {
                $q->where('user_id', $userId)
                  ->where('friend_id', $this->user_id);
            })
            ->exists();

        if ($exists) {
            return false;
        }

        return Connection::create([
            'user_id' => $this->user_id,
            'friend_id' => $userId,
            'status' => 'pending',
            'action_user_id' => $this->user_id,
            'requested_at' => now(),
        ]);
    }

    /**
     * Get pending friend requests received by this user
     */
    public function pendingFriendRequests()
    {
        return Connection::where('friend_id', $this->user_id)
            ->where('status', 'pending')
            ->with('user')
            ->get();
    }

    /**
     * Get pending friend requests sent by this user
     */
    public function sentFriendRequests()
    {
        return Connection::where('user_id', $this->user_id)
            ->where('status', 'pending')
            ->with('friend')
            ->get();
    }

    /**
     * Count accepted friends
     */
    public function friendsCount(): int
    {
        $asUser = Connection::where('user_id', $this->user_id)
            ->where('status', 'accepted')
            ->count();

        $asFriend = Connection::where('friend_id', $this->user_id)
            ->where('status', 'accepted')
            ->count();

        return $asUser + $asFriend;
    }

    // ============================================
    // 🆕 VIDEO CALLS RELATIONSHIPS
    // ============================================

    /**
     * Get video calls initiated by this user
     */
    public function videoCalls(): HasMany
    {
        return $this->hasMany(VideoCall::class, 'initiated_by', 'user_id');
    }

    /**
     * Get all video calls (initiated or received)
     */
    public function allVideoCalls()
    {
        return VideoCall::whereHas('conversation.participants', function($q) {
            $q->where('user_id', $this->user_id);
        })->orderBy('created_at', 'desc');
    }

    /**
     * Get recent video calls (last 7 days)
     */
    public function recentVideoCalls($days = 7)
    {
        return $this->allVideoCalls()
            ->where('created_at', '>=', now()->subDays($days))
            ->get();
    }

    /**
     * Get missed calls count
     */
    public function missedCallsCount(): int
    {
        return VideoCall::whereHas('conversation.participants', function($q) {
                $q->where('user_id', $this->user_id);
            })
            ->where('call_status', 'missed')
            ->where('initiated_by', '!=', $this->user_id)
            ->count();
    }

    /**
     * Get total call duration (in seconds)
     */
    public function totalCallDuration(): int
    {
        return VideoCall::whereHas('conversation.participants', function($q) {
                $q->where('user_id', $this->user_id);
            })
            ->where('call_status', 'ended')
            ->sum('duration');
    }

    /**
     * Get formatted total call duration
     */
    public function formattedTotalCallDuration(): string
    {
        $seconds = $this->totalCallDuration();
        
        if ($seconds < 3600) {
            $minutes = floor($seconds / 60);
            return $minutes . 'm';
        }
        
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        return $hours . 'h ' . $minutes . 'm';
    }

    // ============================================
    // EXISTING METHODS
    // ============================================

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeVolunteers($query)
    {
        return $query->where('user_type', 'Volunteer');
    }

    public function scopeOrganizations($query)
    {
        return $query->where('user_type', 'Organization');
    }

    public function scopeAdmins($query)
    {
        return $query->where('user_type', 'Admin');
    }

    public function isVolunteer(): bool
    {
        return $this->user_type == 'Volunteer';
    }

    public function isOrganization(): bool
    {
        return $this->user_type == 'Organization';
    }

    public function isAdmin(): bool
    {
        return $this->user_type == 'Admin';
    }

    public function markAsLoggedIn()
    {
        $this->update(['last_login_at' => now()]);
    }

    public function verify(): void
    {
        $this->update(['is_verified' => true]);
    }

    public function deactivate(): void
    {
        $this->update(['is_active' => false]);
    }

    public function activate(): void
    {
        $this->update(['is_active' => true]);
    }
}