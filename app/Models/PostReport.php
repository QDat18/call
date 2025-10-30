<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostReport extends Model
{
    protected $primaryKey = 'report_id';

    protected $fillable = [
        'post_id',
        'reporter_id',  
        'reason',
        'description',
        'status',
        'reviewed_by',
        'admin_notes',
        'reviewed_at'
    ];

    protected $casts = [
        'reviewed_at' => 'datetime'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}