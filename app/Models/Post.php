<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\PostMedia;

class Post extends Model
{
    protected $primaryKey = 'post_id';

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'image_url',
        'post_type',
        'status',
        'admin_notes',
        'likes_count',
        'comments_count',
        'shares_count',
        'views_count',
        'is_pinned',
        'allow_comments',
        'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_pinned' => 'boolean',
        'allow_comments' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function organization()
    {
        return $this->user->user_type === 'Organization'
            ? $this->user->organization
            : null;
    }

    public function likes()
    {
        return $this->hasMany(PostLike::class, 'post_id');
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class, 'post_id')
            ->whereNull('parent_id');
    }

    public function reports()
    {
        return $this->hasMany(PostReport::class, 'post_id');
    }

    public function bookmarks()
    {
        return $this->hasMany(PostBookmark::class, 'post_id');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    public function scopeByUserType($query, $type)
    {
        return $query->whereHas('user', function ($q) use ($type) {
            $q->where('user_type', $type);
        });
    }

    // Methods
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    public function isLikedByUser($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }

    public function isBookmarkedByUser($userId)
    {
        return $this->bookmarks()->where('user_id', $userId)->exists();
    }

    public function canEdit($userId)
    {
        return $this->user_id === $userId;
    }

    public function getUserDisplayName()
    {
        if ($this->user->user_type === 'Organization') {
            return $this->user->organization->organization_name ?? $this->user->first_name . ' ' . $this->user->last_name;
        }
        return $this->user->first_name . ' ' . $this->user->last_name;
    }

    // public function getUserAvatar()
    // {
    //     if ($this->user->user_type === 'Organization' && $this->user->organization) {
    //         return $this->user->organization->user->avatar_url ?? $this->user->avatar_url ?? '/images/default-org.png';
    //     }
    //     return $this->user->avatar_url ?? '/images/default-avatar.png';
    // }

    public function getUserAvatar()
    {
        if (!$this->user) {
            return 'https://ui-avatars.com/api/?name=Unknown&background=random&color=fff';
        }

        // 1. Nếu user có avatar trong DB
        if ($this->user->avatar_url) {
            return asset('storage/' . $this->user->avatar_url);
        }

        // 2. Fallback: Dùng UI Avatars với tên hiển thị
        $name = $this->getUserDisplayName();
        return 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=random&color=fff';
    }

    public function getUserBadge()
    {
        switch ($this->user->user_type) {
            case 'Organization':
                return '<span class="px-2 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-xs rounded-full">Organization</span>';
            case 'Admin':
                return '<span class="px-2 py-1 bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 text-xs rounded-full">Admin</span>';
            case 'Volunteer':
                return '<span class="px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs rounded-full">Volunteer</span>';
            default:
                return '';
        }
    }

    public function getTypeColor()
    {
        $colors = [
            'general' => 'gray',
            'announcement' => 'blue',
            'success_story' => 'yellow',
            'event' => 'purple',
            'impact_update' => 'green',
            'question' => 'indigo',
        ];

        return $colors[$this->post_type] ?? 'gray';
    }

    public function getTypeIcon()
    {
        $icons = [
            'general' => 'fas fa-comments',
            'announcement' => 'fas fa-bullhorn',
            'success_story' => 'fas fa-star',
            'event' => 'fas fa-calendar',
            'impact_update' => 'fas fa-chart-line',
            'question' => 'fas fa-question-circle',
        ];

        return $icons[$this->post_type] ?? 'fas fa-comments';
    }

    public function getTypeLabel()
    {
        $labels = [
            'general' => 'General',
            'announcement' => 'Announcement',
            'success_story' => 'Success Story',
            'event' => 'Event',
            'impact_update' => 'Impact Update',
            'question' => 'Question',
        ];

        return $labels[$this->post_type] ?? 'General';
    }

    public function getExcerpt($length = 150)
    {
        return Str::limit($this->content, $length);
    }

    public function hasImage()
    {
        return !empty($this->image_url);
    }
    public function media()
    {
        return $this->hasMany(PostMedia::class, 'post_id');
    }

    public function getReadingTime()
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $minutes = ceil($wordCount / 200);
        return max(1, $minutes);
    }
}
