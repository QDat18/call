<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostBookmark extends Model
{
    protected $primaryKey = 'bookmark_id';
    
    protected $fillable = [
        'post_id',
        'user_id',
        'notes'
    ];

    // Relationships
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Scopes
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Methods
    public static function toggle($postId, $userId)
    {
        $bookmark = self::where('post_id', $postId)
            ->where('user_id', $userId)
            ->first();

        if ($bookmark) {
            $bookmark->delete();
            return ['bookmarked' => false, 'message' => 'Bookmark removed'];
        } else {
            self::create([
                'post_id' => $postId,
                'user_id' => $userId
            ]);
            return ['bookmarked' => true, 'message' => 'Post bookmarked'];
        }
    }

    public static function isBookmarked($postId, $userId)
    {
        return self::where('post_id', $postId)
            ->where('user_id', $userId)
            ->exists();
    }
}