<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id', 'user_id', 'amount', 'message', 'status', 'vnp_TransactionNo'
    ];

    // Quan hệ: Khoản quyên góp này thuộc về chiến dịch nào
    public function campaign()
    {
        return $this->belongsTo(DonationCampaign::class, 'campaign_id', 'id');
    }

    // Quan hệ: Khoản quyên góp này của ai
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}