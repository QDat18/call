<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Organization;
use App\Models\VolunteerOpportunity;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class OrganizationController extends Controller
{
    /**
     * Display a listing of organizations (public)
     */
    public function index(Request $request)
    {
        $query = Organization::with(['user', 'opportunities'])
                    ->withCount(['opportunities as active_opportunities_count' => function($query) {
                        $query->where('status', 'Active');
                    }])
                    ->where('verification_status', 'Verified');

        // Search filter
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('organization_name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Type filter
        if ($request->has('type') && $request->type) {
            $query->where('organization_type', $request->type);
        }

        // Sort
        $sort = $request->get('sort', 'rating');
        switch ($sort) {
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'volunteers':
                $query->orderBy('volunteer_count', 'desc');
                break;
            case 'opportunities':
                $query->orderBy('active_opportunities_count', 'desc');
                break;
            default:
                $query->orderBy('rating', 'desc');
        }

        $organizations = $query->paginate(12);
        $organizationTypes = ['NGO', 'NPO', 'Charity', 'School', 'Hospital', 'Community Group'];

        return view('organizations.index', compact('organizations', 'organizationTypes'));
    }

    /**
     * Display organization details (public)
     */
    public function show($id)
    {
        $organization = Organization::with(['user', 'opportunities.category'])
                            ->findOrFail($id);

        // Recent opportunities
        $recentOpportunities = $organization->opportunities()
            ->where('status', 'Active')
            ->with('category')
            ->latest()
            ->take(5)
            ->get();

        // Statistics
        $stats = [
            'total_opportunities' => $organization->total_opportunities,
            'active_opportunities' => $organization->opportunities()->where('status', 'Active')->count(),
            'volunteer_count' => $organization->volunteer_count,
            'rating' => $organization->rating,
        ];

        return view('organizations.show', compact('organization', 'recentOpportunities', 'stats'));
    }

    /**
     * Display organization profile (for organization owner)
     */
    public function profile()
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            abort(403, 'Only organizations can access this page');
        }

        $organization = $user->organization;
        
        if (!$organization) {
            abort(404, 'Organization not found');
        }

        // Statistics for dashboard
        $stats = [
            'total_opportunities' => $organization->total_opportunities,
            'active_opportunities' => $organization->opportunities()->where('status', 'Active')->count(),
            'volunteer_count' => $organization->volunteer_count,
            'rating' => $organization->rating,
            'pending_applications' => \App\Models\Application::whereHas('opportunity', function($q) use ($organization) {
                $q->where('org_id', $organization->org_id);
            })->where('status', 'Pending')->count(),
        ];

        // Recent opportunities
        $recentOpportunities = $organization->opportunities()
            ->latest()
            ->take(5)
            ->get();

        // Pending applications
        $pendingApplications = \App\Models\Application::whereHas('opportunity', function($q) use ($organization) {
            $q->where('org_id', $organization->org_id);
        })
        ->where('status', 'Pending')
        ->with(['volunteer.user', 'opportunity'])
        ->latest()
        ->take(10)
        ->get();

        return view('organization.profile.show', compact('organization', 'stats', 'recentOpportunities', 'pendingApplications'));
    }

    /**
     * Show edit form for organization
     */
    public function edit()
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            abort(403, 'Only organizations can access this page');
        }

        $organization = $user->organization;
        
        if (!$organization) {
            abort(404, 'Organization not found');
        }

        return view('organization.profile.edit', compact('organization'));
    }

    /**
     * Update organization profile
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            return response()->json([
                'success' => false,
                'message' => 'Only organizations can update profile'
            ], 403);
        }

        $organization = $user->organization;
        
        if (!$organization) {
            return response()->json([
                'success' => false,
                'message' => 'Organization not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'organization_name' => 'required|string|max:150',
            'organization_type' => 'required|in:NGO,NPO,Charity,School,Hospital,Community Group',
            'description' => 'nullable|string|max:1000',
            'mission_statement' => 'nullable|string',
            'website' => 'nullable|url|max:100',
            'contact_person' => 'nullable|string|max:100',
            'registration_number' => 'nullable|string|max:50',
            'founded_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'avatar.image' => 'Logo must be an image',
            'avatar.mimes' => 'Logo must be JPG, PNG, or GIF',
            'avatar.max' => 'Logo size must not exceed 2MB',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                // Delete old avatar if exists
                if ($user->avatar_url && Storage::disk('public')->exists($user->avatar_url)) {
                    Storage::disk('public')->delete($user->avatar_url);
                }

                // Store new avatar
                $avatarPath = $request->file('avatar')->store('avatars/organizations', 'public');

                // Update user avatar_url
                $user->update([
                    'avatar_url' => $avatarPath
                ]);
            }

            // Update organization data
            $organization->update($request->only([
                'organization_name',
                'organization_type',
                'description',
                'mission_statement',
                'website',
                'contact_person',
                'registration_number',
                'founded_year'
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Organization updated successfully',
                'avatar_url' => $user->avatar_url ? Storage::url($user->avatar_url) : null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update organization: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show verification request page
     */
    public function showVerification()
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            abort(403, 'Only organizations can access this page');
        }

        $organization = $user->organization;
        
        if (!$organization) {
            abort(404, 'Organization not found');
        }

        return view('organization.verification', compact('organization'));
    }

    /**
     * Submit verification request
     */
    public function submitVerification(Request $request)
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            return response()->json([
                'success' => false,
                'message' => 'Only organizations can request verification'
            ], 403);
        }

        $organization = $user->organization;
        
        if (!$organization) {
            return response()->json([
                'success' => false,
                'message' => 'Organization not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'documents' => 'required|array|min:1|max:5',
            'documents.*' => 'file|mimes:pdf,jpg,jpeg,png|max:5120',
            'business_email' => 'required|email',
            'phone' => 'required|string',
            'additional_info' => 'nullable|string',
            'terms' => 'required|accepted',
        ], [
            'documents.required' => 'Please upload at least one document',
            'documents.*.mimes' => 'Documents must be PDF, JPG, or PNG',
            'documents.*.max' => 'Each document must not exceed 5MB',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            if ($organization->verification_status === 'Verified') {
                return response()->json([
                    'success' => false,
                    'message' => 'Organization is already verified'
                ], 400);
            }

            if ($organization->verification_status === 'Pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Verification request is already pending'
                ], 400);
            }

            // Upload documents
            $uploadedFiles = [];

            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $file) {
                    $path = $file->store('verification-documents/' . $organization->org_id, 'public');
                    $uploadedFiles[] = $path;
                }
            }

            // Update organization status
            $organization->update([
                'verification_status' => 'Pending'
            ]);

            // Create notification for admin
            try {
                \App\Models\Notification::create([
                    'user_id' => 1, // Admin user_id
                    'notification_type' => 'System',
                    'title' => 'New Verification Request',
                    'content' => $organization->organization_name . ' has submitted verification documents',
                    'related_id' => $organization->org_id,
                    'related_type' => 'organization',
                    'priority' => 'high',
                ]);
            } catch (\Exception $e) {
                // Continue even if notification fails
            }

            return response()->json([
                'success' => true,
                'message' => 'Verification request submitted successfully. Our team will review within 3-5 business days.',
                'files' => $uploadedFiles
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit verification request: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get organization statistics (API)
     */
    public function statistics()
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            return response()->json([
                'success' => false,
                'message' => 'Only organizations can view statistics'
            ], 403);
        }

        $organization = $user->organization;
        
        if (!$organization) {
            return response()->json([
                'success' => false,
                'message' => 'Organization not found'
            ], 404);
        }

        $stats = [
            'total_opportunities' => $organization->total_opportunities,
            'active_opportunities' => $organization->opportunities()->where('status', 'Active')->count(),
            'volunteer_count' => $organization->volunteer_count,
            'rating' => $organization->rating,
            'pending_applications' => $organization->opportunities()
                ->join('applications', 'volunteer_opportunities.opportunity_id', '=', 'applications.opportunity_id')
                ->where('applications.status', 'Pending')
                ->count(),
            'total_applications' => $organization->opportunities()
                ->join('applications', 'volunteer_opportunities.opportunity_id', '=', 'applications.opportunity_id')
                ->count(),
        ];

        return response()->json($stats);
    }

    /**
     * Display organization analytics
     */
    public function analytics()
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            abort(403, 'Only organizations can access analytics');
        }

        $organization = $user->organization;
        
        if (!$organization) {
            abort(404, 'Organization not found');
        }

        return view('organization.analytics.index', compact('organization'));
    }

    /**
     * Get organization volunteers
     */
    public function volunteers(Request $request)
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            abort(403, 'Only organizations can access volunteers');
        }

        $organization = $user->organization;
        
        if (!$organization) {
            abort(404, 'Organization not found');
        }

        // Get volunteers who have applied to this organization's opportunities
        $query = \App\Models\User::whereHas('volunteer.applications.opportunity', function($q) use ($organization) {
            $q->where('org_id', $organization->org_id);
        })->with('volunteer');

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $volunteers = $query->paginate(15);

        return view('organization.volunteers.index', compact('organization', 'volunteers'));
    }
}