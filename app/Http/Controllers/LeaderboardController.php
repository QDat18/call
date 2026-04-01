<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VolunteerProfile;
use App\Models\Organization;

class LeaderboardController extends Controller
{
    public function index()
    {
        // 1. Top Tình nguyện viên (Dựa trên số giờ làm và đánh giá)
        $topVolunteers = VolunteerProfile::with('user')
            ->whereHas('user', function($q) {
                $q->where('is_active', true);
            })
            ->orderByDesc('total_volunteer_hours') // Ưu tiên số giờ
            ->orderByDesc('volunteer_rating')      // Sau đó đến điểm đánh giá
            ->take(10)
            ->get();

        // 2. Top Tổ chức (Dựa trên đánh giá và số chiến dịch đã tạo)
        $topOrganizations = Organization::with(['user'])
            ->withCount('opportunities') // Đếm số cơ hội đã tạo
            ->where('verification_status', 'Verified')
            ->orderByDesc('rating')          // Ưu tiên điểm đánh giá
            ->orderByDesc('opportunities_count') // Sau đó đến sự năng nổ (nhiều job)
            ->take(10)
            ->get();

        return view('pages.leaderboard', compact('topVolunteers', 'topOrganizations'));
    }
}