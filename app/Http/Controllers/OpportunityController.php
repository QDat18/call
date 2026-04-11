<?php

namespace App\Http\Controllers;

use App\Models\VolunteerOpportunity;
use App\Models\Category;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendNotificationJob;

class OpportunityController extends Controller
{
    /**
     * Display a listing of opportunities for the organization
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            abort(403, 'Only organizations can access this page');
        }

        $query = $user->organization->opportunities();

        // Search
        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $opportunities = $query->latest()->paginate(10);

        // Statistics
        $stats = [
            'total' => $user->organization->opportunities()->count(),
            'active' => $user->organization->opportunities()->where('status', 'Active')->count(),
            'applications' => DB::table('applications')
                ->join('volunteer_opportunities', 'applications.opportunity_id', '=', 'volunteer_opportunities.opportunity_id')
                ->where('volunteer_opportunities.org_id', $user->organization->org_id)
                ->count(),
            'completed' => $user->organization->opportunities()->where('status', 'Completed')->count(),
        ];

        return view('organization.opportunities.index', compact('opportunities', 'stats'));
    }

    /**
     * Show the form for creating a new opportunity
     */
    public function create()
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            abort(403, 'Only organizations can access this page');
        }

        // Check if organization can create more opportunities
        $activeOpportunities = $user->organization->opportunities()->where('status', 'Active')->count();
        
        if ($activeOpportunities >= 5) {
            return redirect()->route('organization.opportunities.index')
                ->with('error', 'You have reached the maximum limit of 5 active opportunities. Please pause or complete existing ones.');
        }

        $categories = Category::where('is_active', true)->orderBy('display_order')->get();
        
        return view('organization.opportunities.create', compact('categories'));
    }

    /**
     * Store a newly created opportunity
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            return response()->json([
                'success' => false,
                'message' => 'Only organizations can create opportunities'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:200',
            'category_id' => 'required|exists:categories,category_id',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'location' => 'required|string|max:200',
            'start_date' => 'nullable|date|after_or_equal:' . date('Y-m-d', strtotime('+3 days')),
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'time_commitment' => 'nullable|in:1-2 hours,3-5 hours,6-8 hours,Full day,Multiple days',
            'schedule_type' => 'nullable|in:One-time,Weekly,Monthly,Flexible',
            'volunteers_needed' => 'required|integer|min:1',
            'min_age' => 'nullable|integer|min:16',
            'required_skills' => 'nullable|string',
            'experience_needed' => 'nullable|in:No experience,Some experience,Experienced',
            'application_deadline' => 'nullable|date|after_or_equal:today',
        ], [
            'start_date.after_or_equal' => 'Start date must be at least 3 days from today',
            'end_date.after_or_equal' => 'End date must be after or equal to start date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $organization = $user->organization;

            // Check active opportunities limit
            $activeCount = $organization->opportunities()->where('status', 'Active')->count();
            if ($activeCount >= 5) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have reached the maximum limit of 5 active opportunities'
                ], 400);
            }

            $opportunity = VolunteerOpportunity::create([
                'org_id' => $organization->org_id,
                'category_id' => $request->category_id,
                'title' => $request->title,
                'description' => $request->description,
                'requirements' => $request->requirements,
                'benefits' => $request->benefits,
                'location' => $request->location,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'time_commitment' => $request->time_commitment ?? '1-2 hours',
                'schedule_type' => $request->schedule_type ?? 'Flexible',
                'volunteers_needed' => $request->volunteers_needed,
                'min_age' => $request->min_age ?? 16,
                'required_skills' => $request->required_skills,
                'experience_needed' => $request->experience_needed ?? 'No experience',
                'application_deadline' => $request->application_deadline,
                'status' => 'Active',
            ]);

            // Update organization's total opportunities count
            $organization->increment('total_opportunities');

            return response()->json([
                'success' => true,
                'message' => 'Opportunity created successfully',
                'redirect' => route('organization.opportunities.show', $opportunity->opportunity_id)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create opportunity: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified opportunity
     */
    public function show($id)
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            abort(403, 'Only organizations can access this page');
        }

        $opportunity = $user->organization->opportunities()->findOrFail($id);
        
        // Get recent applications
        $recentApplications = $opportunity->applications()
            ->with('volunteer')
            ->latest()
            ->take(5)
            ->get();

        return view('organization.opportunities.show', compact('opportunity', 'recentApplications'));
    }

    /**
     * Show the form for editing the specified opportunity
     */
    public function edit($id)
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            abort(403, 'Only organizations can access this page');
        }

        $opportunity = $user->organization->opportunities()->findOrFail($id);
        $categories = Category::where('is_active', true)->orderBy('display_order')->get();

        return view('organization.opportunities.edit', compact('opportunity', 'categories'));
    }

    /**
     * Update the specified opportunity
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            return response()->json([
                'success' => false,
                'message' => 'Only organizations can update opportunities'
            ], 403);
        }

        $opportunity = $user->organization->opportunities()->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:200',
            'category_id' => 'required|exists:categories,category_id',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'location' => 'required|string|max:200',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'time_commitment' => 'nullable|in:1-2 hours,3-5 hours,6-8 hours,Full day,Multiple days',
            'schedule_type' => 'nullable|in:One-time,Weekly,Monthly,Flexible',
            'volunteers_needed' => 'required|integer|min:' . $opportunity->volunteers_registered,
            'min_age' => 'nullable|integer|min:16',
            'required_skills' => 'nullable|string',
            'experience_needed' => 'nullable|in:No experience,Some experience,Experienced',
            'application_deadline' => 'nullable|date',
            'status' => 'required|in:Active,Paused,Completed,Cancelled',
        ], [
            'volunteers_needed.min' => 'Cannot set volunteers needed below current registered count (' . $opportunity->volunteers_registered . ')',
            'end_date.after_or_equal' => 'End date must be after or equal to start date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $opportunity->update([
                'category_id' => $request->category_id,
                'title' => $request->title,
                'description' => $request->description,
                'requirements' => $request->requirements,
                'benefits' => $request->benefits,
                'location' => $request->location,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'time_commitment' => $request->time_commitment,
                'schedule_type' => $request->schedule_type,
                'volunteers_needed' => $request->volunteers_needed,
                'min_age' => $request->min_age,
                'required_skills' => $request->required_skills,
                'experience_needed' => $request->experience_needed,
                'application_deadline' => $request->application_deadline,
                'status' => $request->status,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Opportunity updated successfully',
                'redirect' => route('organization.opportunities.show', $opportunity->opportunity_id)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update opportunity: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified opportunity
     */
    public function destroy($id)
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            return response()->json([
                'success' => false,
                'message' => 'Only organizations can delete opportunities'
            ], 403);
        }

        try {
            $opportunity = $user->organization->opportunities()->findOrFail($id);

            // Check if there are registered volunteers
            if ($opportunity->volunteers_registered > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete opportunity with registered volunteers. Please contact them first.'
                ], 400);
            }

            $opportunity->delete();

            // Decrement organization's total opportunities count
            $user->organization->decrement('total_opportunities');

            return redirect()->route('organization.opportunities.index')
                ->with('success', 'Opportunity deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete opportunity');
        }
    }

    /**
     * Pause an opportunity
     */
    public function pause($id)
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        try {
            $opportunity = $user->organization->opportunities()->findOrFail($id);

            if ($opportunity->status !== 'Active') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only active opportunities can be paused'
                ], 400);
            }

            $opportunity->update(['status' => 'Paused']);

            // Notify all accepted volunteers
            $volunteerIds = $opportunity->applications()
                ->where('status', 'Accepted')
                ->pluck('volunteer_id')
                ->toArray();

            if (!empty($volunteerIds)) {
                SendNotificationJob::dispatch($volunteerIds, [
                    'type' => 'Opportunity',
                    'title' => 'Hoạt động đã tạm dừng',
                    'content' => "Hoạt động \"{$opportunity->title}\" đã bị tạm dừng bởi tổ chức.",
                    'related_id' => $opportunity->opportunity_id,
                    'related_type' => 'opportunity',
                    'action_url' => route('opportunities.show', $opportunity->opportunity_id),
                    'priority' => 'high'
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Opportunity paused successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to pause opportunity'
            ], 500);
        }
    }

    /**
     * Activate an opportunity
     */
    public function activate($id)
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        try {
            $opportunity = $user->organization->opportunities()->findOrFail($id);

            if ($opportunity->status !== 'Paused') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only paused opportunities can be activated'
                ], 400);
            }

            // Check active opportunities limit
            $activeCount = $user->organization->opportunities()->where('status', 'Active')->count();
            if ($activeCount >= 5) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have reached the maximum limit of 5 active opportunities'
                ], 400);
            }

            $opportunity->update(['status' => 'Active']);

            // Notify all accepted volunteers
            $volunteerIds = $opportunity->applications()
                ->where('status', 'Accepted')
                ->pluck('volunteer_id')
                ->toArray();

            if (!empty($volunteerIds)) {
                SendNotificationJob::dispatch($volunteerIds, [
                    'type' => 'Opportunity',
                    'title' => 'Hoạt động đã hoạt động trở lại',
                    'content' => "Hoạt động \"{$opportunity->title}\" đã được mở lại.",
                    'related_id' => $opportunity->opportunity_id,
                    'related_type' => 'opportunity',
                    'action_url' => route('opportunities.show', $opportunity->opportunity_id),
                    'priority' => 'high'
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Opportunity activated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to activate opportunity'
            ], 500);
        }
    }

    /**
     * Complete an opportunity
     */
    public function complete($id)
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        try {
            $opportunity = $user->organization->opportunities()->findOrFail($id);

            $opportunity->update(['status' => 'Completed']);

            // Notify all accepted volunteers
            $volunteerIds = $opportunity->applications()
                ->where('status', 'Accepted')
                ->pluck('volunteer_id')
                ->toArray();

            if (!empty($volunteerIds)) {
                SendNotificationJob::dispatch($volunteerIds, [
                    'type' => 'Opportunity',
                    'title' => 'Hoạt động đã hoàn thành',
                    'content' => "Chúc mừng! Hoạt động \"{$opportunity->title}\" đã hoàn thành tốt đẹp.",
                    'related_id' => $opportunity->opportunity_id,
                    'related_type' => 'opportunity',
                    'action_url' => route('opportunities.show', $opportunity->opportunity_id),
                    'priority' => 'medium'
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Opportunity marked as completed'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to complete opportunity'
            ], 500);
        }
    }

    /**
     * Cancel an opportunity
     */
    public function cancel($id)
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        try {
            $opportunity = $user->organization->opportunities()->findOrFail($id);

            $opportunity->update(['status' => 'Cancelled']);

            // Notify all registered volunteers
            $volunteerIds = $opportunity->applications()
                ->whereIn('status', ['Pending', 'Accepted'])
                ->pluck('volunteer_id')
                ->toArray();

            if (!empty($volunteerIds)) {
                SendNotificationJob::dispatch($volunteerIds, [
                    'type' => 'Opportunity',
                    'title' => 'Hoạt động đã bị hủy',
                    'content' => "Rất tiếc, hoạt động \"{$opportunity->title}\" đã bị hủy bỏ bởi ban tổ chức.",
                    'related_id' => $opportunity->opportunity_id,
                    'related_type' => 'opportunity',
                    'priority' => 'high'
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Opportunity cancelled successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel opportunity'
            ], 500);
        }
    }
    public function organizationsList(Request $request)
    {
        $query = Organization::query()
            ->where('verification_status', 'Verified')
            ->withCount([
                'opportunities as active_opportunities_count' => function($q) {
                    $q->where('status', 'Active');
                }
            ])
            ->with('user');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('organization_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('organization_type', $request->type);
        }

        // Sort
        $sortBy = $request->get('sort', 'rating');
        switch($sortBy) {
            case 'newest':
                $query->latest();
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            case 'volunteers':
                $query->orderBy('volunteer_count', 'desc');
                break;
            case 'opportunities':
                $query->orderBy('total_opportunities', 'desc');
                break;
            default:
                $query->orderBy('rating', 'desc');
        }

        $organizations = $query->paginate(12);

        // Get organization types for filter
        $organizationTypes = Organization::distinct()
            ->pluck('organization_type')
            ->filter()
            ->toArray();

        return view('organizations.index', compact('organizations', 'organizationTypes'));
    }

    /**
     * Display organization detail page (public)
     */
    public function organizationDetail($id)
    {
        $organization = Organization::with(['user'])
            ->withCount([
                'opportunities as active_opportunities_count' => function($q) {
                    $q->where('status', 'Active');
                }
            ])
            ->findOrFail($id);

        // Get recent opportunities (public can see)
        $recentOpportunities = $organization->opportunities()
            ->where('status', 'Active')
            ->with('category')
            ->latest()
            ->take(6)
            ->get();

        // Get statistics
        $stats = [
            'total_opportunities' => $organization->total_opportunities,
            'active_opportunities' => $organization->active_opportunities_count,
            'volunteer_count' => $organization->volunteer_count,
            'rating' => $organization->rating,
        ];

        return view('organizations.show', compact('organization', 'recentOpportunities', 'stats'));
    }
}