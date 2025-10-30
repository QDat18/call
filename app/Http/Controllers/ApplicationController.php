<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\VolunteerOpportunity;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    /**
     * Display applications for organization
     */
    public function organizationIndex(Request $request)
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            abort(403, 'Only organizations can access this page');
        }

        $organization = $user->organization;

        // Base query
        $query = Application::whereHas('opportunity', function ($q) use ($organization) {
            $q->where('org_id', $organization->org_id);
        })->with(['volunteer', 'opportunity']);

        // Search by volunteer name or email
        if ($request->search) {
            $query->whereHas('volunteer', function ($q) use ($request) {
                $q->where('first_name', 'like', "%{$request->search}%")
                  ->orWhere('last_name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Filter by opportunity
        if ($request->opportunity) {
            $query->where('opportunity_id', $request->opportunity);
        }

        $applications = $query->latest('applied_date')->paginate(15);

        // Get organization's opportunities for filter
        $opportunities = $organization->opportunities()
            ->where('status', 'Active')
            ->get();

        // Statistics
        $stats = [
            'total' => Application::whereHas('opportunity', function ($q) use ($organization) {
                $q->where('org_id', $organization->org_id);
            })->count(),
            'pending' => Application::whereHas('opportunity', function ($q) use ($organization) {
                $q->where('org_id', $organization->org_id);
            })->where('status', 'Pending')->count(),
            'under_review' => Application::whereHas('opportunity', function ($q) use ($organization) {
                $q->where('org_id', $organization->org_id);
            })->where('status', 'Under Review')->count(),
            'accepted' => Application::whereHas('opportunity', function ($q) use ($organization) {
                $q->where('org_id', $organization->org_id);
            })->where('status', 'Accepted')->count(),
            'rejected' => Application::whereHas('opportunity', function ($q) use ($organization) {
                $q->where('org_id', $organization->org_id);
            })->where('status', 'Rejected')->count(),
        ];

        return view('organization.applications.index', compact('applications', 'opportunities', 'stats'));
    }

    /**
     * Show application details
     */
    public function show($id)
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            abort(403, 'Only organizations can access this page');
        }

        $application = Application::with(['volunteer.volunteerProfile', 'opportunity'])
            ->findOrFail($id);

        // Check if application belongs to this organization
        if ($application->opportunity->org_id !== $user->organization->org_id) {
            abort(403, 'Unauthorized access to this application');
        }

        return view('organization.applications.show', compact('application'));
    }

    /**
     * Mark application as under review
     */
    public function review(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        try {
            $application = Application::findOrFail($id);

            // Check ownership
            if ($application->opportunity->org_id !== $user->organization->org_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            if ($application->status !== 'Pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only pending applications can be marked as under review'
                ], 400);
            }

            $application->update([
                'status' => 'Under Review',
                'reviewed_date' => now(),
            ]);

            // Notify volunteer
            Notification::create([
                'user_id' => $application->volunteer_id,
                'notification_type' => 'Application',
                'title' => 'Application Under Review',
                'content' => 'Your application for "' . $application->opportunity->title . '" is now under review',
                'related_id' => $application->application_id,
                'related_type' => 'application',
                'priority' => 'medium',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Application marked as under review'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update application'
            ], 500);
        }
    }

    /**
     * Accept application
     */
    public function accept(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        try {
            DB::beginTransaction();

            $application = Application::findOrFail($id);

            // Check ownership
            if ($application->opportunity->org_id !== $user->organization->org_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            // Check if opportunity has available spots
            if ($application->opportunity->volunteers_registered >= $application->opportunity->volunteers_needed) {
                return response()->json([
                    'success' => false,
                    'message' => 'No available spots for this opportunity'
                ], 400);
            }

            $notes = $request->input('notes');
            
            $application->update([
                'status' => 'Accepted',
                'reviewed_date' => now(),
                'organization_notes' => $notes,
            ]);

            // Increment volunteers registered
            $application->opportunity->increment('volunteers_registered');

            // Notify volunteer
            Notification::create([
                'user_id' => $application->volunteer_id,
                'notification_type' => 'Application',
                'title' => 'Application Accepted! 🎉',
                'content' => 'Congratulations! Your application for "' . $application->opportunity->title . '" has been accepted',
                'related_id' => $application->application_id,
                'related_type' => 'application',
                'priority' => 'high',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Application accepted successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to accept application: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reject application
     */
    public function reject(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'reason' => 'nullable|string|min:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            $application = Application::findOrFail($id);

            // Check ownership
            if ($application->opportunity->org_id !== $user->organization->org_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            $reason = $request->input('reason');
            
            $application->update([
                'status' => 'Rejected',
                'reviewed_date' => now(),
                'organization_notes' => $reason,
            ]);

            // Notify volunteer
            Notification::create([
                'user_id' => $application->volunteer_id,
                'notification_type' => 'Application',
                'title' => 'Application Update',
                'content' => 'Your application for "' . $application->opportunity->title . '" has been reviewed',
                'related_id' => $application->application_id,
                'related_type' => 'application',
                'priority' => 'medium',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Application rejected'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to reject application'
            ], 500);
        }
    }

    /**
     * Schedule interview
     */
    public function scheduleInterview(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'interview_datetime' => 'required|date|after:now',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            $application = Application::findOrFail($id);

            // Check ownership
            if ($application->opportunity->org_id !== $user->organization->org_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            $application->update([
                'status' => 'Under Review',
                'interview_scheduled' => $request->interview_datetime,
                'organization_notes' => $request->notes,
            ]);

            // Notify volunteer
            Notification::create([
                'user_id' => $application->volunteer_id,
                'notification_type' => 'Application',
                'title' => 'Interview Scheduled 📅',
                'content' => 'An interview has been scheduled for your application to "' . $application->opportunity->title . '" on ' . 
                            date('M d, Y H:i', strtotime($request->interview_datetime)),
                'related_id' => $application->application_id,
                'related_type' => 'application',
                'priority' => 'high',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Interview scheduled successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to schedule interview'
            ], 500);
        }
    }

    /**
     * Save notes for application
     */
    public function saveNotes(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        try {
            $application = Application::findOrFail($id);

            // Check ownership
            if ($application->opportunity->org_id !== $user->organization->org_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            $application->update([
                'organization_notes' => $request->input('notes')
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Notes saved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save notes'
            ], 500);
        }
    }
}