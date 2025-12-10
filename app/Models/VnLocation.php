<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VnLocation extends Model
{
    protected $table = 'vn_locations';
    
    // Vì bảng này không có cột created_at/updated_at
    public $timestamps = false; 

    protected $fillable = [
        'name', 'full_name', 'full_path', 'code', 'level', 'parent_code'
    ];

    // Quan hệ lấy danh sách con (Ví dụ: Tỉnh lấy danh sách Xã)
    public function children()
    {
        return $this->hasMany(VnLocation::class, 'parent_code', 'code');
    }

    // Quan hệ lấy cha (Ví dụ: Xã lấy Tỉnh)
    public function parent()
    {
        return $this->belongsTo(VnLocation::class, 'parent_code', 'code');
    }
}