<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\VolunteerOpportunity;
use App\Models\User;
use App\Models\VolunteerProfile;
use App\Models\Organization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Stats
        $stats = [
            'total_volunteers' => User::where('user_type', 'Volunteer')->count(),
            'total_opportunities' => VolunteerOpportunity::where('status', 'Active')->count(),
            'total_hours' => \DB::table('volunteer_activities')->where('status', 'Verified')->sum('hours_worked'),
            'total_organizations' => Organization::where('verification_status', 'Verified')->count(),
        ];

        // Latest posts (5 most recent)
        $latestPosts = Post::with(['user.organization', 'user.volunteerProfile'])
            ->published()
            ->latest('published_at')
            ->take(8)
            ->get();

        // Featured/Pinned post
        $featuredPost = Post::published()
            ->pinned()
            ->latest('published_at')
            ->first();

        // Trending posts (most viewed in last 7 days)
        $trendingPosts = Post::published()
            ->where('published_at', '>=', now()->subDays(7))
            ->orderBy('views_count', 'desc')
            ->take(5)
            ->get();

        // Featured opportunities
        $featuredOpportunities = VolunteerOpportunity::with('organization')
            ->where('status', 'Active')
            ->orderBy('application_count', 'desc')
            ->take(6)
            ->get();

        // Impact stats
        $impactStats = [
            'lives_touched' => '10K+',
            'projects_completed' => '500+',
            'communities_served' => '63',
        ];
        $topVolunteers = VolunteerProfile::with('user')
        ->orderByDesc('total_volunteer_hours') // Xếp theo giờ làm
        ->take(3)
        ->get();
        return view('pages.home', compact(
            'stats',
            'latestPosts',
            'featuredPost',
            'trendingPosts',
            'featuredOpportunities',
            'impactStats',
            'topVolunteers'
        ));
    }
}