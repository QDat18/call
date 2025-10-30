<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class OrganizationController extends Controller
{
    /**
     * Display organization dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            abort(403, 'Only organizations can access dashboard');
        }

        $organization = $user->organization;

        // Recent opportunities
        $recentOpportunities = $organization->opportunities()
            ->latest()
            ->take(5)
            ->get();

        // Pending applications
        $pendingApplications = \App\Models\Application::whereHas('opportunity', function ($q) use ($organization) {
            $q->where('org_id', $organization->org_id);
        })
            ->where('status', 'Pending')
            ->with(['volunteer', 'opportunity'])
            ->latest()
            ->take(10)
            ->get();

        // Statistics
        $stats = [
            'total_opportunities' => $organization->total_opportunities,
            'active_opportunities' => $organization->opportunities()->where('status', 'Active')->count(),
            'volunteer_count' => $organization->volunteer_count,
            'rating' => $organization->rating,
            'pending_applications' => $pendingApplications->count(),
        ];

        return view('organization.dashboard', compact('organization', 'recentOpportunities', 'pendingApplications', 'stats'));
    }

    /**
     * Display organization profile
     */
    public function show()
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            abort(403, 'Only organizations can access this page');
        }

        $organization = $user->organization;

        return view('organization.profile.show', compact('organization'));
    }

    /**
     * Show edit form
     */
    public function edit()
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            abort(403, 'Only organizations can access this page');
        }

        $organization = $user->organization;

        return view('organization.profile.edit', compact('organization'));
    }

    /**
     * Update organization
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
            $organization = $user->organization;

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
                    'avatar_url' => Storage::url($avatarPath)
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
                'avatar_url' => $user->avatar_url
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
            $organization = $user->organization;

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
     * Upload verification documents
     */
    public function uploadDocuments(Request $request)
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            return response()->json([
                'success' => false,
                'message' => 'Only organizations can upload documents'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'documents' => 'required|array|max:5',
            'documents.*' => 'file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            $uploadedFiles = [];
            $organization = $user->organization;

            foreach ($request->file('documents') as $file) {
                $path = $file->store('organization-documents/' . $organization->org_id, 'public');
                $uploadedFiles[] = [
                    'path' => $path,
                    'name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'url' => Storage::url($path)
                ];
            }

            return response()->json([
                'success' => true,
                'message' => 'Documents uploaded successfully',
                'files' => $uploadedFiles
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload documents'
            ], 500);
        }
    }

    /**
     * Request verification
     */
    public function requestVerification(Request $request)
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            return response()->json([
                'success' => false,
                'message' => 'Only organizations can request verification'
            ], 403);
        }

        $organization = $user->organization;

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

        $organization->update([
            'verification_status' => 'Pending'
        ]);

        // Notify admin
        try {
            \App\Models\Notification::create([
                'user_id' => 1,
                'notification_type' => 'System',
                'title' => 'Verification Request',
                'content' => $organization->organization_name . ' has requested verification',
                'related_id' => $organization->org_id,
                'related_type' => 'organization',
                'priority' => 'high',
            ]);
        } catch (\Exception $e) {
            // Continue
        }

        return response()->json([
            'success' => true,
            'message' => 'Verification request submitted successfully'
        ]);
    }

    /**
     * Get organization statistics
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
     * Get organization analytics
     */
    public function analytics()
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            abort(403, 'Only organizations can access analytics');
        }

        $organization = $user->organization;

        return view('organization.analytics.index', compact('organization'));
    }
}