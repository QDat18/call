<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationCampaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_user_id', 'title', 'description', 'banner_image_url', 
        'target_amount', 'current_amount', 'end_date', 'status', 'is_pinned'
    ];
    
    protected $casts = [
        'end_date' => 'datetime',
        'is_pinned' => 'boolean',
    ];

    // Quan hệ: Chiến dịch này thuộc về Admin nào
    public function adminUser()
    {
        return $this->belongsTo(User::class, 'admin_user_id', 'user_id');
    }

    // Quan hệ: Lấy tất cả các khoản quyên góp
    public function donations()
    {
        return $this->hasMany(Donation::class, 'campaign_id', 'id');
    }
}