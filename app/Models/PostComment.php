<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CommentLike;


class PostComment extends Model
{
    protected $primaryKey = 'comment_id';
    
    protected $fillable = [
        'post_id',
        'user_id',
        'content',
        'parent_id',
        'is_approved',
        'likes_count'
    ];

    protected $casts = [
        'is_approved' => 'boolean'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function parent()
    {
        return $this->belongsTo(PostComment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(PostComment::class, 'parent_id');
    }

    public function likes(){
        return $this->hasMany(CommentLike::class, 'comment_id');
    }

    public function isLikedByUser($userId){
        if(!$userId){
            return false;
        }
        return $this->likes()->where('user_id', $userId)->exists();
    }
}