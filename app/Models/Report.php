<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $primaryKey = 'report_id';
    protected $fillable = ['user_id', 'target_id', 'target_type', 'reason', 'description', 'status', 'resolution'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Quan hệ đa hình (Polymorphic) để lấy bài viết hoặc đối tượng bị báo cáo
    public function target()
    {
        return $this->morphTo();
    }
}
