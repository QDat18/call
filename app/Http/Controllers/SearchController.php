<?php

namespace App\Http\Controllers;

use App\Models\VolunteerOpportunity;
use App\Models\Organization;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    /**
     * Main search page
     */
    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)
            ->orderBy('display_order')
            ->get();

        // Get trending opportunities
        $trendingOpportunities = VolunteerOpportunity::with(['organization', 'category'])
            ->where('status', 'Active')
            ->orderBy('view_count', 'desc')
            ->orderBy('application_count', 'desc')
            ->limit(6)
            ->get();

        // Get search statistics
        $stats = [
            'total_opportunities' => VolunteerOpportunity::where('status', 'Active')->count(),
            'total_organizations' => Organization::where('verification_status', 'Verified')->count(),
            'total_categories' => Category::where('is_active', true)->count(),
            'total_locations' => VolunteerOpportunity::where('status', 'Active')->distinct('location')->count(),
        ];

        return view('search.index', compact('categories', 'trendingOpportunities', 'stats'));
    }

    /**
     * General search (simple search from home page)
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        // If no query and no filters, redirect to search index
        if (!$query && !$request->hasAny(['category', 'location', 'time_commitment'])) {
            return redirect()->route('search.index');
        }

        // Build opportunities query
        $opportunities = $this->buildSearchQuery($request)->paginate(12)->withQueryString();
        
        $categories = Category::where('is_active', true)
            ->orderBy('display_order')
            ->get();

        return view('search.results', compact('opportunities', 'categories'));
    }

    /**
     * Advanced search page
     */
    public function advancedSearch(Request $request)
    {
        $categories = Category::where('is_active', true)
            ->orderBy('display_order')
            ->get();

        // If search parameters exist, perform search
        if ($request->hasAny(['q', 'category', 'location', 'time_commitment', 'schedule_type', 'experience_needed', 'skills', 'start_date_from', 'start_date_to', 'opportunity_type', 'age_group'])) {
            $opportunities = $this->buildSearchQuery($request)->paginate(12)->withQueryString();
            
            return view('search.advanced', compact('opportunities', 'categories'));
        }

        // Show empty search form
        return view('search.advanced', compact('categories'));
    }

    /**
     * Build search query based on filters
     */
    private function buildSearchQuery(Request $request)
    {
        $query = VolunteerOpportunity::with(['organization.user', 'category'])
            ->where('status', 'Active');

        // Keyword search
        if ($request->filled('q')) {
            $searchTerm = $request->q;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('description', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('location', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('required_skills', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhereHas('organization', function($orgQuery) use ($searchTerm) {
                      $orgQuery->where('organization_name', 'LIKE', '%' . $searchTerm . '%');
                  });
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Location filter
        if ($request->filled('location')) {
            $query->where('location', 'LIKE', '%' . $request->location . '%');
        }

        // Time commitment filter
        if ($request->filled('time_commitment')) {
            $query->where('time_commitment', $request->time_commitment);
        }

        // Schedule type filter
        if ($request->filled('schedule_type')) {
            $query->where('schedule_type', $request->schedule_type);
        }

        // Experience level filter
        if ($request->filled('experience_needed')) {
            $query->where('experience_needed', $request->experience_needed);
        }

        // Skills filter
        if ($request->filled('skills')) {
            $skills = is_array($request->skills) ? $request->skills : [$request->skills];
            $query->where(function($q) use ($skills) {
                foreach ($skills as $skill) {
                    $q->orWhere('required_skills', 'LIKE', '%' . $skill . '%');
                }
            });
        }

        // Opportunity type filter
        if ($request->filled('opportunity_type')) {
            $query->whereIn('opportunity_type', $request->opportunity_type);
        }

        // Age group filter
        if ($request->filled('age_group')) {
            $query->where('suitable_age_group', $request->age_group);
        }

        // Date range filter
        if ($request->filled('start_date_from')) {
            $query->where('start_date', '>=', $request->start_date_from);
        }

        if ($request->filled('start_date_to')) {
            $query->where('start_date', '<=', $request->start_date_to);
        }

        // Status filter (default to Active only)
        if ($request->filled('status')) {
            $query->whereIn('status', $request->status);
        }

        // Per page setting
        $perPage = $request->get('per_page', 12);

        // Sorting
        switch ($request->get('sort', 'latest')) {
            case 'popular':
                $query->orderBy('view_count', 'desc');
                break;
            case 'deadline':
                $query->orderBy('application_deadline', 'asc');
                break;
            case 'nearest':
                $query->orderBy('start_date', 'asc');
                break;
            case 'most_applied':
                $query->orderBy('application_count', 'desc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        return $query;
    }

    /**
     * Search suggestions for autocomplete (API endpoint)
     */
    public function suggestions(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        // Search in opportunities
        $opportunities = VolunteerOpportunity::where('status', 'Active')
            ->where(function($q) use ($query) {
                $q->where('title', 'LIKE', '%' . $query . '%')
                  ->orWhere('description', 'LIKE', '%' . $query . '%');
            })
            ->select('title', 'opportunity_id')
            ->limit(5)
            ->get()
            ->map(function($opp) {
                return [
                    'type' => 'opportunity',
                    'title' => $opp->title,
                    'url' => route('opportunities.show', $opp->opportunity_id)
                ];
            });

        // Search in organizations
        $organizations = Organization::where('verification_status', 'Verified')
            ->where('organization_name', 'LIKE', '%' . $query . '%')
            ->select('organization_name', 'org_id')
            ->limit(3)
            ->get()
            ->map(function($org) {
                return [
                    'type' => 'organization',
                    'title' => $org->organization_name,
                    'url' => route('organizations.show', $org->org_id)
                ];
            });

        // Search in categories
        $categories = Category::where('is_active', true)
            ->where('category_name', 'LIKE', '%' . $query . '%')
            ->select('category_name', 'category_id')
            ->limit(3)
            ->get()
            ->map(function($cat) {
                return [
                    'type' => 'category',
                    'title' => $cat->category_name,
                    'url' => route('search.by.category', $cat->category_id)
                ];
            });

        $suggestions = $opportunities->concat($organizations)->concat($categories);

        return response()->json($suggestions);
    }

    /**
     * Search by category
     */
    public function searchByCategory($id)
    {
        $category = Category::findOrFail($id);
        
        $opportunities = VolunteerOpportunity::with(['organization.user', 'category'])
            ->where('category_id', $id)
            ->where('status', 'Active')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $categories = Category::where('is_active', true)
            ->orderBy('display_order')
            ->get();

        return view('search.results', compact('opportunities', 'categories', 'category'));
    }

    /**
     * Get popular searches
     */
    public function popularSearches()
    {
        // Get most searched keywords from recent searches
        // For now, return predefined popular searches
        $popularSearches = [
            ['keyword' => 'giáo dục', 'count' => 245],
            ['keyword' => 'môi trường', 'count' => 189],
            ['keyword' => 'trẻ em', 'count' => 156],
            ['keyword' => 'y tế', 'count' => 134],
            ['keyword' => 'người cao tuổi', 'count' => 98],
            ['keyword' => 'dạy học', 'count' => 87],
            ['keyword' => 'từ thiện', 'count' => 76],
            ['keyword' => 'cộng đồng', 'count' => 65],
        ];

        return response()->json($popularSearches);
    }

    /**
     * Get trending opportunities
     */
    public function trendingOpportunities()
    {
        $trending = VolunteerOpportunity::with(['organization', 'category'])
            ->where('status', 'Active')
            ->orderBy('view_count', 'desc')
            ->orderBy('application_count', 'desc')
            ->limit(10)
            ->get()
            ->map(function($opp) {
                return [
                    'id' => $opp->opportunity_id,
                    'title' => $opp->title,
                    'organization' => $opp->organization->organization_name,
                    'category' => $opp->category->category_name ?? 'General',
                    'location' => $opp->location,
                    'view_count' => $opp->view_count,
                    'application_count' => $opp->application_count,
                    'url' => route('opportunities.show', $opp->opportunity_id)
                ];
            });

        return response()->json($trending);
    }

    /**
     * Location-based search
     */
    public function searchByLocation(Request $request)
    {
        $latitude = $request->get('lat');
        $longitude = $request->get('lng');
        $radius = $request->get('radius', 10); // km

        if (!$latitude || !$longitude) {
            return response()->json(['error' => 'Location required'], 400);
        }

        // Haversine formula for distance calculation
        $opportunities = VolunteerOpportunity::select('*')
            ->selectRaw(
                '( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance',
                [$latitude, $longitude, $latitude]
            )
            ->where('status', 'Active')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->having('distance', '<', $radius)
            ->orderBy('distance')
            ->limit(20)
            ->with(['organization', 'category'])
            ->get();

        return response()->json($opportunities);
    }

    /**
     * Filter opportunities by multiple criteria (API)
     */
    public function filterOpportunities(Request $request)
    {
        $opportunities = $this->buildSearchQuery($request)
            ->limit(50)
            ->get();

        return response()->json([
            'total' => $opportunities->count(),
            'opportunities' => $opportunities
        ]);
    }

    /**
     * Get search statistics
     */
    public function searchStatistics()
    {
        $stats = [
            'total_opportunities' => VolunteerOpportunity::where('status', 'Active')->count(),
            'total_organizations' => Organization::where('verification_status', 'Verified')->count(),
            'total_categories' => Category::where('is_active', true)->count(),
            'locations' => VolunteerOpportunity::where('status', 'Active')
                ->select('location', DB::raw('COUNT(*) as count'))
                ->groupBy('location')
                ->orderBy('count', 'desc')
                ->limit(10)
                ->get(),
            'popular_categories' => Category::withCount(['opportunities' => function($q) {
                $q->where('status', 'Active');
            }])
                ->where('is_active', true)
                ->orderBy('opportunities_count', 'desc')
                ->limit(8)
                ->get()
        ];

        return response()->json($stats);
    }

    /**
     * Save search query (for analytics)
     */
    public function saveSearch(Request $request)
    {
        // Log search for analytics
        // This can be stored in a separate searches table
        // For now, just return success
        
        return response()->json(['success' => true]);
    }

    /**
     * Quick search (used in header search bar)
     */
    public function quickSearch(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([
                'opportunities' => [],
                'organizations' => []
            ]);
        }

        $opportunities = VolunteerOpportunity::with(['organization', 'category'])
            ->where('status', 'Active')
            ->where(function($q) use ($query) {
                $q->where('title', 'LIKE', '%' . $query . '%')
                  ->orWhere('description', 'LIKE', '%' . $query . '%')
                  ->orWhere('location', 'LIKE', '%' . $query . '%');
            })
            ->limit(5)
            ->get();

        $organizations = Organization::where('verification_status', 'Verified')
            ->where('organization_name', 'LIKE', '%' . $query . '%')
            ->limit(3)
            ->get();

        return response()->json([
            'opportunities' => $opportunities,
            'organizations' => $organizations
        ]);
    }
}