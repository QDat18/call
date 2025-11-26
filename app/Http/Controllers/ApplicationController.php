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
     * Show the form for creating a new application
     */

    public function myApplications(Request $request)
    {
        $applications = Auth::user()->applications()
            ->with('opportunity.organization')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest('applied_date')
            ->paginate(10);

        return view('volunteer.applications.index', compact('applications'));
    }

    // 2. Form ứng tuyển
    public function create($opportunityId)
    {
        // Tìm Opportunity và kiểm tra tồn tại
        $opportunity = VolunteerOpportunity::with('organization')->findOrFail($opportunityId);

        // Validate 1: Cơ hội phải đang Active
        if ($opportunity->status !== 'Active') {
            return redirect()->route('opportunities.show', $opportunity->opportunity_id)
                ->with('error', 'Cơ hội này hiện không nhận đơn ứng tuyển.');
        }

        // Validate 2: Kiểm tra hạn chót (Deadline)
        if ($opportunity->application_deadline && now()->gt($opportunity->application_deadline)) {
            return redirect()->route('opportunities.show', $opportunity->opportunity_id)
                ->with('error', 'Đã hết hạn nộp đơn ứng tuyển.');
        }

        // Validate 3: Kiểm tra đã ứng tuyển chưa
        $exists = Application::where('volunteer_id', Auth::id())
            ->where('opportunity_id', $opportunity->opportunity_id)
            ->whereIn('status', ['Pending', 'Accepted', 'Under Review']) // Nếu đã rút đơn hoặc bị từ chối thì có thể cho nộp lại (tuỳ logic)
            ->exists();

        if ($exists) {
            return redirect()->route('opportunities.show', $opportunity->opportunity_id)
                ->with('warning', 'Bạn đã ứng tuyển cơ hội này rồi!');
        }

        return view('volunteer.applications.create', compact('opportunity'));
    }

    // 3. Lưu đơn
    public function store(Request $request)
    {
        $request->validate([
            'opportunity_id'       => 'required|exists:volunteer_opportunities,opportunity_id',
            'motivation_letter'    => 'required|string|max:3000',
            'relevant_experience'  => 'required|string|max:3000',
            'availability_note'    => 'nullable|string|max:2000',
        ]);

        // Bắt đầu transaction để đảm bảo tính toàn vẹn dữ liệu
        try {
            DB::beginTransaction();

            // Tạo Application
            $application = Application::create([
                'volunteer_id'        => Auth::id(),
                'opportunity_id'      => $request->opportunity_id,
                'motivation_letter'   => $request->motivation_letter,
                'relevant_experience' => $request->relevant_experience,
                'availability_note'   => $request->availability_note,
                'status'              => 'Pending',
                'applied_date'        => now(),
            ]);

            // --- PHẦN QUAN TRỌNG: GỬI THÔNG BÁO CHO TỔ CHỨC ---

            // 1. Lấy thông tin Opportunity và Organization
            $opportunity = VolunteerOpportunity::with('organization')->find($request->opportunity_id);

            // 2. Tìm User ID của chủ sở hữu Organization (vì notification gửi theo user_id)
            if ($opportunity && $opportunity->organization) {
                $orgOwnerId = $opportunity->organization->user_id;
                $volunteerName = Auth::user()->first_name . ' ' . Auth::user()->last_name;

                Notification::create([
                    'user_id'           => $orgOwnerId, // Gửi cho chủ tổ chức
                    'notification_type' => 'Application',
                    'title'             => 'Đơn ứng tuyển mới 📝',
                    'content'           => "$volunteerName đã ứng tuyển vào cơ hội: {$opportunity->title}",
                    'related_id'        => $application->application_id,
                    'related_type'      => 'application', // Để click vào xem chi tiết
                    'is_read'           => false,
                    'priority'          => 'medium',
                    'created_at'        => now(),
                ]);
            }

            DB::commit();

            return redirect()->route('volunteer.applications.my')
                ->with('success', 'Ứng tuyển thành công! Tổ chức sẽ sớm xem xét hồ sơ của bạn.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra khi gửi đơn: ' . $e->getMessage())->withInput();
        }
    }

    // 4. Xem chi tiết đơn
    public function show(Application $application)
    {
        // Bảo mật: chỉ cho xem đơn của chính mình
        if ($application->volunteer_id !== Auth::id()) {
            abort(404); // hoặc 403
        }

        // Load quan hệ để tránh N+1
        $application->load('opportunity.organization');

        return view('volunteer.applications.show', compact('application'));
    }

    // 5. Rút đơn
    public function withdraw(Application $application)
    {
        if ($application->volunteer_id !== Auth::id() || $application->status !== 'Pending') {
            return back()->with('error', 'Không thể rút đơn này!');
        }

        $application->update(['status' => 'Withdrawn']);

        return back()->with('success', 'Đã rút đơn thành công!');
    }

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
     * Update application status
     */
    public function updateStatus(Request $request, $id)
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

            $validator = Validator::make($request->all(), [
                'status' => 'required|in:Accepted,Rejected,Under Review',
                'notes' => 'nullable|string|max:1000',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ], 422);
            }

            $application->update([
                'status' => $request->status,
                'organization_notes' => $request->notes,
                'reviewed_date' => now(),
            ]);

            // Notify volunteer
            Notification::create([
                'user_id' => $application->volunteer_id,
                'notification_type' => 'Application',
                'title' => 'Application ' . $request->status,
                'content' => 'Your application to "' . $application->opportunity->title . '" has been ' . strtolower($request->status),
                'related_id' => $application->application_id,
                'related_type' => 'application',
                'priority' => 'high',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status'
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

        try {
            $application = Application::findOrFail($id);

            // Check ownership
            if ($application->opportunity->org_id !== $user->organization->org_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            $validator = Validator::make($request->all(), [
                'interview_datetime' => 'required|date|after:now',
                'notes' => 'nullable|string|max:1000',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ], 422);
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
