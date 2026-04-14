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
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class VolunteerOpportunityController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display listing of opportunities
     */
    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $sortBy = $request->get('sort', 'latest');
        $search = $request->get('q') ?: $request->get('search');
        $categoryId = $request->get('category');
        $locationFilter = $request->get('location');
        $timeCommitment = $request->get('time_commitment');
        $experience = $request->get('experience');

        // Cache Key based on page and filters (avoiding full request serialization)
        $cacheKey = 'opportunities_html_p' . $page . '_s' . $sortBy . '_c' . $categoryId . '_l' . md5($locationFilter . $search);

        return Cache::tags(['opportunities'])->remember($cacheKey, 60, function () use ($request, $sortBy, $search, $categoryId, $locationFilter, $timeCommitment, $experience) {
            $query = VolunteerOpportunity::query()
                ->select([
                    'opportunity_id', 'org_id', 'category_id', 'title',
                    'location', 'volunteers_needed', 'volunteers_registered',
                    'application_deadline', 'created_at', 'required_skills',
                    'application_count'
                ])
                ->with([
                    'organization:org_id,organization_name',
                    'category:category_id,category_name,color,icon'
                ])
                ->where('volunteer_opportunities.status', 'Active');

            // Search logic (Full-Text)
            if (!empty($search)) {
                $query->leftJoin('organizations', 'volunteer_opportunities.org_id', '=', 'organizations.org_id')
                    ->where(function ($sub) use ($search) {
                        $sub->whereFullText(['volunteer_opportunities.title', 'volunteer_opportunities.description'], $search)
                            ->orWhereFullText('organizations.organization_name', $search);
                    });
            }

            // Category Filter
            if ($categoryId) {
                $query->where('volunteer_opportunities.category_id', $categoryId);
            }

            // Location Filter (Full-Text)
            if ($locationFilter) {
                // Check if location matches what we indexed
                $query->whereFullText('volunteer_opportunities.location', $locationFilter);
            }

            // Other filters
            if ($timeCommitment) {
                $query->where('volunteer_opportunities.time_commitment', $timeCommitment);
            }

            if ($experience) {
                $query->where('volunteer_opportunities.experience_needed', $experience);
            }

            // Sort logic
            switch ($sortBy) {
                case 'popular':
                    $query->orderBy('volunteer_opportunities.application_count', 'desc');
                    break;
                case 'urgent':
                    $query->orderBy('volunteer_opportunities.application_deadline', 'asc');
                    break;
                case 'oldest':
                    $query->orderBy('volunteer_opportunities.created_at', 'asc');
                    break;
                default: // latest
                    $query->orderBy('volunteer_opportunities.created_at', 'desc');
            }

            // Use simplePaginate to avoid COUNT(*)
            $opportunities = $query->simplePaginate(9);

            // Move logic from Blade to Controller: pre-process skills and logic using through()
            $opportunities->through(function ($opportunity) {
                $skills = $opportunity->required_skills ?: [];
                $opportunity->processed_skills = array_slice(array_filter($skills, function ($v) {
                    return !empty(trim($v));
                }), 0, 2);
                $opportunity->remaining_skills_count = count($skills) > 2 ? count($skills) - 2 : 0;
                
                // Pre-calculate percentage for Blade
                $opportunity->registration_percentage = $opportunity->volunteers_needed > 0
                    ? ($opportunity->volunteers_registered / $opportunity->volunteers_needed) * 100
                    : 0;
                
                return $opportunity;
            });

            $categories = Category::all(['category_id', 'category_name']);

            if ($request->ajax()) {
                return view('opportunities.partials.list', compact('opportunities'))->render();
            }

            return view('opportunities.index', compact('opportunities', 'categories'))->render();
        });
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
            Cache::tags(['opportunities'])->flush();

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
            Cache::tags(['opportunities'])->flush();

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
            Cache::tags(['opportunities'])->flush();

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
