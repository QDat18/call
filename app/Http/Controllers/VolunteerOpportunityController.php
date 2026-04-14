<?php

namespace App\Http\Controllers;

use App\Models\VolunteerOpportunity;
use App\Models\Category;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Services\VolunteerOpportunityService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class VolunteerOpportunityController extends Controller
{
    use AuthorizesRequests;

    protected $opportunityService;

    public function __construct(VolunteerOpportunityService $opportunityService)
    {
        $this->opportunityService = $opportunityService;
    }

    /**
     * Display listing of opportunities
     */
    public function index(Request $request)
    {
        $filters = [
            'page' => $request->get('page', 1),
            'sort' => $request->get('sort', 'latest'),
            'search' => $request->get('q') ?: $request->get('search'),
            'category' => $request->get('category'),
            'location' => $request->get('location'),
            'time_commitment' => $request->get('time_commitment'),
            'experience' => $request->get('experience'),
        ];

        $data = $this->opportunityService->getPaginatedOpportunities($filters);
        
        $opportunities = $data['opportunities'];
        $categories = $data['categories'];

        if ($request->ajax()) {
            return view('opportunities.partials.list', compact('opportunities'))->render();
        }

        return view('opportunities.index', compact('opportunities', 'categories'));
    }

    /**
     * Show opportunity details
     */
    public function show($id)
    {
        $opportunity = VolunteerOpportunity::with(['organization.user', 'category'])
            ->findOrFail($id);

        $opportunity->volunteers_registered = $opportunity->applications()
            ->where('status', 'Accepted')
            ->count();
        // Increment view count
        $opportunity->increment('view_count');

        // Get similar opportunities
        $similarOpportunities = VolunteerOpportunity::where('category_id', $opportunity->category_id)
            ->where('opportunity_id', '!=', $id)
            ->where('status', 'Active')
            ->take(3)
            ->get();

        // Check if user already applied
        $hasApplied = false;
        if (Auth::check() && Auth::user()->isVolunteer()) {
            $hasApplied = $opportunity->applications()
                ->where('volunteer_id', Auth::id())
                ->exists();
        }

        // Check if user favorited
        $isFavorited = false;
        if (Auth::check()) {
            $isFavorited = Auth::user()->favorites()
                ->where('opportunity_id', $id)
                ->exists();
        }
        $reviews = $opportunity->reviews()->latest()->take(10)->get();
        return view('opportunities.show', compact('opportunity', 'similarOpportunities', 'hasApplied', 'isFavorited', 'reviews'));
    }

    /**
     * Show create opportunity form (Organization only)
     */
    public function create()
    {
        $this->authorize('create', VolunteerOpportunity::class);

        $categories = Category::where('is_active', true)
            ->orderBy('display_order')
            ->get();

        return view('opportunities.create', compact('categories'));
    }

    /**
     * Store new opportunity
     */
    public function store(Request $request)
    {
        $this->authorize('create', VolunteerOpportunity::class);

        $user = Auth::user();
        $organization = $user->organization;

        // Check if organization is verified
        if (!$organization->isVerified()) {
            return redirect()->back()
                ->with('error', 'Your organization must be verified before posting opportunities.');
        }

        // Check maximum active opportunities limit
        $activeCount = $organization->opportunities()->where('status', 'Active')->count();
        if ($activeCount >= 5) {
            return redirect()->back()
                ->with('error', 'You have reached the maximum limit of 5 active opportunities.');
        }

        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,category_id',
            'title' => 'required|string|max:200',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'location' => 'required|string|max:200',
            'start_date' => 'required|date|after_or_equal:' . now()->addDays(3)->format('Y-m-d'),
            'end_date' => 'nullable|date|after:start_date',
            'time_commitment' => 'required|in:1-2 hours,3-5 hours,6-8 hours,Full day,Multiple days',
            'schedule_type' => 'required|in:One-time,Weekly,Monthly,Flexible',
            'volunteers_needed' => 'required|integer|min:1|max:100',
            'min_age' => 'required|integer|min:16|max:100',
            'required_skills' => 'nullable|string',
            'experience_needed' => 'required|in:No experience,Some experience,Experienced',
            'application_deadline' => 'required|date|after:today|before:start_date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
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
                'time_commitment' => $request->time_commitment,
                'schedule_type' => $request->schedule_type,
                'volunteers_needed' => $request->volunteers_needed,
                'min_age' => $request->min_age,
                'required_skills' => $request->required_skills,
                'experience_needed' => $request->experience_needed,
                'status' => 'Active',
                'application_deadline' => $request->application_deadline,
            ]);

            // Increment organization total opportunities count
            $organization->increment('total_opportunities');

            // Invalidate cache
            $this->opportunityService->clearCache();

            return redirect()->route('opportunities.show', $opportunity->opportunity_id)
                ->with('success', 'Opportunity posted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create opportunity. Please try again.')
                ->withInput();
        }
    }

    /**
     * Show edit opportunity form
     */
    public function edit($id)
    {
        $opportunity = VolunteerOpportunity::findOrFail($id);

        $this->authorize('update', $opportunity);

        $categories = Category::where('is_active', true)
            ->orderBy('display_order')
            ->get();

        return view('opportunities.edit', compact('opportunity', 'categories'));
    }

    /**
     * Update opportunity
     */
    public function update(Request $request, $id)
    {
        $opportunity = VolunteerOpportunity::findOrFail($id);

        $this->authorize('update', $opportunity);

        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,category_id',
            'title' => 'required|string|max:200',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'location' => 'required|string|max:200',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'time_commitment' => 'required|in:1-2 hours,3-5 hours,6-8 hours,Full day,Multiple days',
            'schedule_type' => 'required|in:One-time,Weekly,Monthly,Flexible',
            'volunteers_needed' => 'required|integer|min:1|max:100',
            'min_age' => 'required|integer|min:16|max:100',
            'required_skills' => 'nullable|string',
            'experience_needed' => 'required|in:No experience,Some experience,Experienced',
            'status' => 'required|in:Active,Paused,Completed,Cancelled',
            'application_deadline' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $opportunity->update($request->all());

            // Invalidate cache
            $this->opportunityService->clearCache();

            return redirect()->route('opportunities.show', $opportunity->opportunity_id)
                ->with('success', 'Opportunity updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update opportunity. Please try again.')
                ->withInput();
        }
    }

    /**
     * Delete opportunity
     */
    public function destroy($id)
    {
        $opportunity = VolunteerOpportunity::findOrFail($id);

        $this->authorize('delete', $opportunity);

        try {
            $opportunity->delete();

            // Invalidate cache
            $this->opportunityService->clearCache();

            return redirect()->route('opportunities.index')
                ->with('success', 'Opportunity deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete opportunity. Please try again.');
        }
    }

    /**
     * Get opportunities for organization dashboard
     */
    public function myOpportunities()
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            abort(403, 'Unauthorized action.');
        }

        $opportunities = $user->organization->opportunities()
            ->with('category')
            ->withCount('applications')
            ->latest()
            ->paginate(10);

        return view('opportunities.my-opportunities', compact('opportunities'));
    }

    /**
     * Change opportunity status
     */
    public function changeStatus(Request $request, $id)
    {
        $opportunity = VolunteerOpportunity::findOrFail($id);

        $this->authorize('update', $opportunity);

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:Active,Paused,Completed,Cancelled',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $opportunity->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
            'status' => $request->status
        ]);
    }

    /**
     * Get recommended opportunities for volunteer
     */
    public function recommendations()
    {
        if (!Auth::check() || !Auth::user()->isVolunteer()) {
            return redirect()->route('opportunities.index');
        }

        $user = Auth::user();
        $profile = $user->volunteerProfile;

        // Simple matching algorithm
        $opportunities = VolunteerOpportunity::with(['organization.user', 'category'])
            ->where('status', 'Active')
            ->where('application_deadline', '>', now())
            ->when($user->city, function ($query) use ($user) {
                $query->where('location', 'LIKE', "%{$user->city}%");
            })
            ->latest()
            ->take(12)
            ->get();

        return view('opportunities.recommendations', compact('opportunities'));
    }
}
