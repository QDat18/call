<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Application;
use App\Models\VolunteerActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VolunteerController extends Controller
{
    /**
     * Display list of volunteers for organization
     */
    public function organizationIndex(Request $request)
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            abort(403, 'Only organizations can access this page');
        }

        $organization = $user->organization;

        // Get volunteers who have applied (with accepted status)
        $query = User::where('user_type', 'Volunteer')
            ->whereHas('applications', function ($q) use ($organization) {
                $q->whereHas('opportunity', function ($oq) use ($organization) {
                    $oq->where('org_id', $organization->org_id);
                })
                    ->where('status', 'Accepted');
            })
            ->with(['volunteerProfile', 'applications' => function ($q) use ($organization) {
                $q->whereHas('opportunity', function ($oq) use ($organization) {
                    $oq->where('org_id', $organization->org_id);
                });
            }]);

        // Search
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', "%{$request->search}%")
                    ->orWhere('last_name', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        // Filter by opportunity
        if ($request->opportunity) {
            $query->whereHas('applications', function ($q) use ($request) {
                $q->where('opportunity_id', $request->opportunity)
                    ->where('status', 'Accepted');
            });
        }

        // Filter by status
        if ($request->status == 'active') {
            $query->whereHas('applications', function ($q) use ($organization) {
                $q->whereHas('opportunity', function ($oq) use ($organization) {
                    $oq->where('org_id', $organization->org_id)
                        ->where('status', 'Active');
                })
                    ->where('status', 'Accepted');
            });
        } elseif ($request->status == 'completed') {
            $query->whereHas('applications', function ($q) use ($organization) {
                $q->whereHas('opportunity', function ($oq) use ($organization) {
                    $oq->where('org_id', $organization->org_id)
                        ->where('status', 'Completed');
                })
                    ->where('status', 'Accepted');
            });
        }

        // Add opportunities count
        $query->withCount(['applications as opportunities_count' => function ($q) use ($organization) {
            $q->whereHas('opportunity', function ($oq) use ($organization) {
                $oq->where('org_id', $organization->org_id);
            })
                ->where('status', 'Accepted');
        }]);

        $volunteers = $query->paginate(15);

        // Get organization's opportunities for filter
        $opportunities = $organization->opportunities()->get();

        // Statistics
        $stats = [
            'total' => User::where('user_type', 'Volunteer')
                ->whereHas('applications', function ($q) use ($organization) {
                    $q->whereHas('opportunity', function ($oq) use ($organization) {
                        $oq->where('org_id', $organization->org_id);
                    })
                        ->where('status', 'Accepted');
                })
                ->count(),
            'active' => User::where('user_type', 'Volunteer')
                ->whereHas('applications', function ($q) use ($organization) {
                    $q->whereHas('opportunity', function ($oq) use ($organization) {
                        $oq->where('org_id', $organization->org_id)
                            ->where('status', 'Active');
                    })
                        ->where('status', 'Accepted');
                })
                ->count(),
            'total_hours' => VolunteerActivity::where('org_id', $organization->org_id)
                ->where('status', 'Verified')
                ->sum('hours_worked'),
            'avg_rating' => DB::table('volunteer_profiles')
                ->join('users', 'volunteer_profiles.user_id', '=', 'users.user_id')
                ->join('applications', 'users.user_id', '=', 'applications.volunteer_id')
                ->join('volunteer_opportunities', 'applications.opportunity_id', '=', 'volunteer_opportunities.opportunity_id')
                ->where('volunteer_opportunities.org_id', $organization->org_id)
                ->where('applications.status', 'Accepted')
                ->avg('volunteer_profiles.volunteer_rating') ?? 0,
        ];

        return view('organization.volunteers.index', compact('volunteers', 'opportunities', 'stats'));
    }

    /**
     * Show volunteer profile
     */
    public function show($id)
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            abort(403, 'Only organizations can access this page');
        }

        $organization = $user->organization;

        // Get volunteer
        $volunteer = User::where('user_type', 'Volunteer')
            ->where('user_id', $id)
            ->with('volunteerProfile')
            ->firstOrFail();

        // Check if this volunteer has relationship with organization
        $hasRelationship = Application::where('volunteer_id', $volunteer->user_id)
            ->whereHas('opportunity', function ($q) use ($organization) {
                $q->where('org_id', $organization->org_id);
            })
            ->exists();

        if (!$hasRelationship) {
            abort(403, 'This volunteer has not applied to any of your opportunities');
        }

        // Get applications to this organization
        $applications = Application::where('volunteer_id', $volunteer->user_id)
            ->whereHas('opportunity', function ($q) use ($organization) {
                $q->where('org_id', $organization->org_id);
            })
            ->with('opportunity')
            ->latest('applied_date')
            ->get();

        // Get activities with this organization
        $activities = VolunteerActivity::where('volunteer_id', $volunteer->user_id)
            ->where('org_id', $organization->org_id)
            ->with('opportunity')
            ->latest('activity_date')
            ->get();

        return view('organization.volunteers.show', compact('volunteer', 'applications', 'activities'));
    }

    /**
     * Search volunteers (for assigning to opportunities)
     */
    public function search(Request $request)
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $search = $request->input('query', '');

        $volunteers = User::where('user_type', 'Volunteer')
            ->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->with('volunteerProfile')
            ->limit(10)
            ->get()
            ->map(function ($volunteer) {
                return [
                    'id' => $volunteer->user_id,
                    'name' => $volunteer->full_name,
                    'email' => $volunteer->email,
                    'avatar' => $volunteer->avatar_url,
                    'occupation' => $volunteer->volunteerProfile->occupation ?? null,
                    'rating' => $volunteer->volunteerProfile->volunteer_rating ?? 0,
                ];
            });

        return response()->json([
            'success' => true,
            'volunteers' => $volunteers
        ]);
    }

    /**
     * Get volunteer statistics
     */
    public function statistics($id)
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $organization = $user->organization;

        $volunteer = User::where('user_type', 'Volunteer')
            ->where('user_id', $id)
            ->firstOrFail();

        // Get statistics for this volunteer with this organization
        $stats = [
            'total_applications' => Application::where('volunteer_id', $volunteer->user_id)
                ->whereHas('opportunity', function ($q) use ($organization) {
                    $q->where('org_id', $organization->org_id);
                })
                ->count(),
            'accepted_applications' => Application::where('volunteer_id', $volunteer->user_id)
                ->whereHas('opportunity', function ($q) use ($organization) {
                    $q->where('org_id', $organization->org_id);
                })
                ->where('status', 'Accepted')
                ->count(),
            'total_hours' => VolunteerActivity::where('volunteer_id', $volunteer->user_id)
                ->where('org_id', $organization->org_id)
                ->where('status', 'Verified')
                ->sum('hours_worked'),
            'activities_count' => VolunteerActivity::where('volunteer_id', $volunteer->user_id)
                ->where('org_id', $organization->org_id)
                ->count(),
        ];

        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }

    /**
     * Export volunteers list to CSV
     */
    public function export()
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            abort(403, 'Unauthorized');
        }

        $organization = $user->organization;

        $volunteers = User::where('user_type', 'Volunteer')
            ->whereHas('applications', function ($q) use ($organization) {
                $q->whereHas('opportunity', function ($oq) use ($organization) {
                    $oq->where('org_id', $organization->org_id);
                })
                    ->where('status', 'Accepted');
            })
            ->with('volunteerProfile')
            ->get();

        $filename = 'volunteers_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($volunteers, $organization) {
            $file = fopen('php://output', 'w');

            // CSV headers
            fputcsv($file, [
                'ID',
                'Name',
                'Email',
                'Phone',
                'City',
                'Occupation',
                'Education',
                'Rating',
                'Total Hours',
                'Opportunities'
            ]);

            foreach ($volunteers as $volunteer) {
                // Get hours for this organization
                $hours = VolunteerActivity::where('volunteer_id', $volunteer->user_id)
                    ->where('org_id', $organization->org_id)
                    ->where('status', 'Verified')
                    ->sum('hours_worked');

                // Get opportunities count
                $opportunities = Application::where('volunteer_id', $volunteer->user_id)
                    ->whereHas('opportunity', function ($q) use ($organization) {
                        $q->where('org_id', $organization->org_id);
                    })
                    ->where('status', 'Accepted')
                    ->count();

                fputcsv($file, [
                    $volunteer->user_id,
                    $volunteer->full_name,
                    $volunteer->email,
                    $volunteer->phone,
                    $volunteer->city,
                    $volunteer->volunteerProfile->occupation ?? '',
                    $volunteer->volunteerProfile->education_level ?? '',
                    $volunteer->volunteerProfile->volunteer_rating ?? 0,
                    $hours,
                    $opportunities
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function remove(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->isOrganization()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        try {
            $organization = $user->organization;

            // XÓA HẲN bản ghi trong bảng applications
            // Điều này sẽ xóa mọi liên kết giữa Volunteer này và các cơ hội của Tổ chức bạn
            $deletedCount = \App\Models\Application::where('volunteer_id', $id)
                ->whereHas('opportunity', function ($q) use ($organization) {
                    $q->where('org_id', $organization->org_id);
                })
                // Bạn có thể bỏ dòng where status này nếu muốn xóa sạch bất kể trạng thái
                // ->where('status', 'Accepted') 
                ->delete(); // <--- DÙNG HÀM DELETE THAY VÌ UPDATE

            if ($deletedCount > 0) {
                return response()->json([
                    'success' => true,
                    'message' => 'Đã xóa hoàn toàn volunteer khỏi dữ liệu của tổ chức.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Volunteer này không còn trong danh sách của bạn.'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
