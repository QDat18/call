<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VolunteerOpportunity;
use App\Models\Application;
use App\Models\VolunteerActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isOrganization()) {
            return $this->organizationDashboard();
        } else {
            return $this->volunteerDashboard();
        }
    }

    public function volunteerDashboard()
    {
        $user = Auth::user();
        $profile = $user->volunteerProfile;

        // 1. Thống kê
        $stats = [
            'total_hours' => $profile->total_volunteer_hours ?? 0,
            'rating' => $profile->volunteer_rating ?? 0,
            'applications' => $user->applications()->count(),
            'accepted_applications' => $user->applications()->where('status', 'Accepted')->count(),
            'pending_applications' => $user->applications()->whereIn('status', ['Pending', 'Under Review'])->count(),
            'completed_activities' => $user->activities()->where('status', 'Verified')->count(),
        ];

        // 2. Danh sách phụ
        $recentApplications = $user->applications()
            ->with(['opportunity.organization'])
            ->latest()
            ->take(5)
            ->get();

        $upcomingActivities = $user->applications()
            ->where('status', 'Accepted')
            ->whereHas('opportunity', function ($q) {
                $q->where('status', 'Active')
                    ->where('start_date', '>=', now());
            })
            ->with(['opportunity'])
            ->take(5)
            ->get();

        $activityHistory = $user->activities()
            ->where('status', 'Verified')
            ->with(['opportunity', 'organization'])
            ->latest()
            ->take(10)
            ->get();

        // 3. Gợi ý cơ hội (Logic thông minh giữ nguyên)
        $recommendations = VolunteerOpportunity::with(['organization', 'category'])
            ->where('status', 'Active')
            ->where('application_deadline', '>', now())
            ->whereRaw('(volunteers_needed - volunteers_registered) > 0')
            ->where(function ($query) use ($user, $profile) {
                $query->when($user->city, function ($q) use ($user) {
                    $q->orWhere('location', 'LIKE', "%{$user->city}%");
                });
                if ($profile?->skills) {
                    $skills = collect(explode(',', $profile->skills ?? ''))->map('trim')->filter();
                    foreach ($skills as $skill) {
                        $query->orWhere('required_skills', 'LIKE', "%{$skill}%");
                    }
                }
                if ($profile?->interests) {
                    $interestNames = collect(explode(',', $profile->interests ?? ''))->map('trim')->filter();
                    $categoryIds = \App\Models\Category::whereIn('category_name', $interestNames)->pluck('category_id');
                    if ($categoryIds->isNotEmpty()) {
                        $query->orWhereIn('category_id', $categoryIds);
                    }
                }
            })
            ->get()
            ->map(function ($opp) use ($user, $profile) {
                $score = 30;
                if ($user->city && str_contains(strtolower($opp->location), strtolower($user->city))) $score += 15;
                $opp->match_score = min(98, $score);
                return $opp;
            })
            ->sortByDesc('match_score')
            ->take(6);

        // 4. Biểu đồ Hoạt động (Line Chart)
        $chartLabels = [];
        $chartValues = [];
        $activityData = $user->activities()
            ->select(
                DB::raw("DATE_FORMAT(activity_date, '%Y-%m') as month"),
                DB::raw("SUM(hours_worked) as total_hours")
            )
            ->where('activity_date', '>=', now()->subMonths(6))
            ->where('status', 'Verified')
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->get();

        foreach ($activityData as $data) {
            $chartLabels[] = \Carbon\Carbon::createFromFormat('Y-m', $data->month)->format('M Y');
            $chartValues[] = (float) $data->total_hours;
        }

        // 5. Biểu đồ Lĩnh vực (Donut Chart) - SỬA LẠI LOGIC TẠI ĐÂY
        // Thay vì lấy Favorite, ta lấy từ Applications đã được Accepted
        $fieldData = \App\Models\Application::where('applications.volunteer_id', $user->user_id)
            ->where('applications.status', 'Accepted') // Chỉ tính đơn đã tham gia
            ->join('volunteer_opportunities', 'applications.opportunity_id', '=', 'volunteer_opportunities.opportunity_id')
            ->join('categories', 'volunteer_opportunities.category_id', '=', 'categories.category_id')
            ->select('categories.category_name', DB::raw('count(*) as total'))
            ->groupBy('categories.category_name')
            ->orderByDesc('total')
            ->get();

        // Nếu không có dữ liệu, trả về mảng rỗng để View hiển thị "Chưa có dữ liệu"
        // (Bỏ đoạn code tự động lấy dữ liệu toàn hệ thống gây hiểu lầm)
        $fieldLabels = $fieldData->pluck('category_name')->toArray();
        $fieldValues = $fieldData->pluck('total')->toArray();

        // 6. Thành tựu
        $achievements = [];
        if (($stats['total_hours'] ?? 0) >= 10) $achievements[] = ['icon' => '🥉', 'title' => 'Đồng (10+ giờ)'];
        if (($stats['total_hours'] ?? 0) >= 50) $achievements[] = ['icon' => '🥈', 'title' => 'Bạc (50+ giờ)'];
        if (($stats['accepted_applications'] ?? 0) >= 5) $achievements[] = ['icon' => '🔥', 'title' => 'Năng nổ'];
        if (empty($achievements)) {
            $achievements[] = ['icon' => '🌱', 'title' => 'Người mới'];
        }

        return view('volunteer.dashboard', compact(
            'user',
            'stats',
            'recentApplications',
            'upcomingActivities',
            'activityHistory',
            'recommendations',
            'achievements',
            'chartLabels',
            'chartValues',
            'fieldLabels',
            'fieldValues'
        ));
    }
    public function organizationDashboard()
    {
        $user = Auth::user();
        $organization = $user->organization;

        if (!$organization) {
            return redirect()->route('organization.profile.edit');
        }

        $orgId = $organization->org_id;

        // 1. Thống kê cơ bản (Statistics Cards)
        $stats = [
            'active_opportunities' => $organization->opportunities()->where('status', 'Active')->count(),
            'total_opportunities' => $organization->opportunities()->count(),

            'pending_applications' => Application::whereHas('opportunity', function ($q) use ($orgId) {
                $q->where('org_id', $orgId);
            })->where('status', 'Pending')->count(),

            // Đếm số tình nguyện viên duy nhất đã được chấp nhận
            'volunteer_count' => Application::whereHas('opportunity', function ($q) use ($orgId) {
                $q->where('org_id', $orgId);
            })->where('status', 'Accepted')->distinct('volunteer_id')->count(),

            'rating' => $organization->rating ?? 0,
        ];

        // 2. Danh sách cơ hội gần đây (Recent Opportunities)
        $recentOpportunities = $organization->opportunities()
            ->withCount('applications') // Đếm số lượng đơn
            ->latest()
            ->take(5)
            ->get();

        // 3. Danh sách đơn chờ duyệt (Pending Applications List)
        $pendingApplications = Application::whereHas('opportunity', function ($q) use ($orgId) {
            $q->where('org_id', $orgId);
        })
            ->where('status', 'Pending')
            ->with(['volunteer', 'opportunity']) // Eager load để tránh N+1 query
            ->orderBy('applied_date', 'desc')
            ->take(10)
            ->get();

        // 4. Dữ liệu biểu đồ (Activity Chart - 7 ngày qua)
        $dates = collect(range(6, 0))->map(function ($i) {
            return now()->subDays($i)->format('Y-m-d');
        });

        $chartLabels = $dates->map(fn($date) => \Carbon\Carbon::parse($date)->format('D')); // Mon, Tue...

        // Dữ liệu: Số đơn ứng tuyển theo ngày
        $applicationsData = $dates->map(function ($date) use ($orgId) {
            return Application::whereHas('opportunity', function ($q) use ($orgId) {
                $q->where('org_id', $orgId);
            })->whereDate('applied_date', $date)->count();
        });

        // Dữ liệu: Số hoạt động mới (Activities) theo ngày
        $activitiesData = $dates->map(function ($date) use ($orgId) {
            return \App\Models\VolunteerActivity::where('org_id', $orgId)
                ->whereDate('created_at', $date)
                ->count();
        });

        $chartData = [
            'labels' => $chartLabels,
            'applications' => $applicationsData,
            'activities' => $activitiesData
        ];

        return view('organization.dashboard', compact(
            'organization',
            'stats',
            'recentOpportunities',
            'pendingApplications',
            'chartData'
        ));
    }

    public function statistics()
    {
        $user = Auth::user();

        if ($user->isVolunteer()) {
            $profile = $user->volunteerProfile;
            return response()->json([
                'user_type' => 'volunteer',
                'total_hours' => $profile->total_volunteer_hours ?? 0,
                'rating' => $profile->volunteer_rating ?? 0,
                'applications' => $user->applications()->count(),
                'accepted_applications' => $user->applications()->where('status', 'Accepted')->count(),
                'completed_activities' => $user->volunteerActivities()->where('status', 'Verified')->count(),
            ]);
        } elseif ($user->isOrganization()) {
            $organization = $user->organization;
            return response()->json([
                'user_type' => 'organization',
                'total_opportunities' => $organization->total_opportunities,
                'active_opportunities' => $organization->opportunities()->where('status', 'Active')->count(),
                'volunteer_count' => $organization->volunteer_count,
                'rating' => $organization->rating,
                'pending_applications' => Application::whereHas('opportunity', function ($q) use ($organization) {
                    $q->where('org_id', $organization->org_id);
                })->where('status', 'Pending')->count(),
            ]);
        }
        return response()->json([
            'error' => 'Invalid user type'
        ], 400);
    }

    public function activityFeed()
    {
        $user = Auth::user();
        $activities = [];

        if ($user->isVolunteer()) {
            // Get volunteer activities
            $recentActivities = $user->volunteerActivities()
                ->where('status', 'Verified')
                ->with(['opportunity', 'organization'])
                ->latest()
                ->take(10)
                ->get();

            foreach ($recentActivities as $activity) {
                $activities[] = [
                    'type' => 'activity',
                    'title' => 'Volunteered at ' . $activity->opportunity->title,
                    'description' => $activity->hours_worked . ' hours with ' . $activity->organization->organization_name,
                    'date' => $activity->activity_date,
                    'icon' => 'fa-calendar-check',
                    'color' => 'green'
                ];
            }

            // Get recent applications
            $recentApplications = $user->applications()
                ->with(['opportunity'])
                ->latest()
                ->take(5)
                ->get();

            foreach ($recentApplications as $app) {
                $activities[] = [
                    'type' => 'application',
                    'title' => 'Applied to ' . $app->opportunity->title,
                    'description' => 'Status: ' . $app->status,
                    'date' => $app->applied_date,
                    'icon' => 'fa-file-alt',
                    'color' => $app->status == 'Accepted' ? 'green' : ($app->status == 'Pending' ? 'yellow' : 'red')
                ];
            }
        } elseif ($user->isOrganization()) {
            $organization = $user->organization;

            // Get recent opportunities
            $recentOpportunities = $organization->opportunities()
                ->latest()
                ->take(5)
                ->get();

            foreach ($recentOpportunities as $opp) {
                $activities[] = [
                    'type' => 'opportunity',
                    'title' => 'Posted: ' . $opp->title,
                    'description' => $opp->application_count . ' applications received',
                    'date' => $opp->created_at,
                    'icon' => 'fa-clipboard-list',
                    'color' => 'blue'
                ];
            }

            // Get recent applications
            $recentApplications = Application::whereHas('opportunity', function ($q) use ($organization) {
                $q->where('org_id', $organization->org_id);
            })
                ->with(['volunteer', 'opportunity'])
                ->latest()
                ->take(10)
                ->get();

            foreach ($recentApplications as $app) {
                $activities[] = [
                    'type' => 'application',
                    'title' => 'New application from ' . $app->volunteer->first_name,
                    'description' => 'For: ' . $app->opportunity->title,
                    'date' => $app->applied_date,
                    'icon' => 'fa-user-plus',
                    'color' => 'purple'
                ];
            }
        }

        // Sort by date
        usort($activities, function ($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });

        return response()->json(array_slice($activities, 0, 15));
    }

    public function quickStats()
    {
        $user = Auth::user();

        if ($user->isVolunteer()) {
            $profile = $user->volunteerProfile;

            return response()->json([
                'cards' => [
                    [
                        'title' => 'Total Hours',
                        'value' => $profile->total_volunteer_hours ?? 0,
                        'icon' => 'fa-clock',
                        'color' => 'blue'
                    ],
                    [
                        'title' => 'Rating',
                        'value' => number_format($profile->volunteer_rating ?? 0, 1),
                        'icon' => 'fa-star',
                        'color' => 'yellow'
                    ],
                    [
                        'title' => 'Applications',
                        'value' => $user->applications()->count(),
                        'icon' => 'fa-file-alt',
                        'color' => 'purple'
                    ],
                    [
                        'title' => 'Completed',
                        'value' => $user->volunteerActivities()->where('status', 'Verified')->count(),
                        'icon' => 'fa-check-circle',
                        'color' => 'green'
                    ]
                ]
            ]);
        } elseif ($user->isOrganization()) {
            $organization = $user->organization;

            return response()->json([
                'cards' => [
                    [
                        'title' => 'Opportunities',
                        'value' => $organization->total_opportunities,
                        'icon' => 'fa-clipboard-list',
                        'color' => 'blue'
                    ],
                    [
                        'title' => 'Volunteers',
                        'value' => $organization->volunteer_count,
                        'icon' => 'fa-users',
                        'color' => 'green'
                    ],
                    [
                        'title' => 'Applications',
                        'value' => Application::whereHas('opportunity', function ($q) use ($organization) {
                            $q->where('org_id', $organization->org_id);
                        })->where('status', 'Pending')->count(),
                        'icon' => 'fa-inbox',
                        'color' => 'yellow'
                    ],
                    [
                        'title' => 'Rating',
                        'value' => number_format($organization->rating, 1),
                        'icon' => 'fa-star',
                        'color' => 'purple'
                    ]
                ]
            ]);
        }

        return response()->json(['error' => 'Invalid user type'], 400);
    }
}
