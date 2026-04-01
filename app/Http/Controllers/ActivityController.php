<?php

namespace App\Http\Controllers;

use App\Models\VolunteerActivity;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\VolunteerProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\VolunteerOpportunity;

class ActivityController extends Controller
{
    /**
     * Display activities for organization
     */
    public function organizationIndex(Request $request)
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            abort(403, 'Only organizations can access this page');
        }

        $organization = $user->organization;

        // Base query
        $query = VolunteerActivity::where('org_id', $organization->org_id)
            ->with(['volunteer', 'opportunity']);

        // Search by volunteer name
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

        // Filter by date
        if ($request->date_from) {
            $query->whereDate('activity_date', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('activity_date', '<=', $request->date_to);
        }

        $activities = $query->latest('activity_date')->paginate(15);

        // Get organization's opportunities for filter
        $opportunities = $organization->opportunities()->where('status', '!=', 'Cancelled')->get();
        $volunteers = User::whereHas('applications', function ($q) use ($organization) {
            $q->whereHas('opportunity', function ($oq) use ($organization) {
                $oq->where('org_id', $organization->org_id);
            })->where('status', 'Accepted');
        })->select('user_id', 'first_name', 'last_name', 'email')->get();
        // Statistics
        $stats = [
            'total_hours' => VolunteerActivity::where('org_id', $organization->org_id)
                ->where('status', 'Verified')
                ->sum('hours_worked'),
            'pending' => VolunteerActivity::where('org_id', $organization->org_id)
                ->where('status', 'Pending')
                ->count(),
            'verified' => VolunteerActivity::where('org_id', $organization->org_id)
                ->where('status', 'Verified')
                ->count(),
            'disputed' => VolunteerActivity::where('org_id', $organization->org_id)
                ->where('status', 'Disputed')
                ->count(),
        ];

        return view('organization.activities.index', compact('activities', 'opportunities', 'stats', 'volunteers'));
    }


    public function logHours(Request $request)
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'volunteer_id' => 'required|exists:users,user_id',
            'opportunity_id' => 'required|exists:volunteer_opportunities,opportunity_id',
            'activity_date' => 'required|date|before_or_equal:today',
            'hours_worked' => 'required|numeric|min:0.5|max:24',
            'description' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            DB::beginTransaction();
            $organization = $user->organization;

            // 1. Kiểm tra Opportunity có thuộc về Org này không
            $opportunity = \App\Models\VolunteerOpportunity::where('opportunity_id', $request->opportunity_id)
                ->where('org_id', $organization->org_id)
                ->firstOrFail();

            // 2. Kiểm tra xem Volunteer này có Application Accepted cho Opportunity này không (Optional - tùy policy của bạn)
            // Nếu muốn chặt chẽ:
            $hasApplication = \App\Models\Application::where('volunteer_id', $request->volunteer_id)
                ->where('opportunity_id', $request->opportunity_id)
                ->where('status', 'Accepted')
                ->exists();

            if (!$hasApplication) {
                return response()->json([
                    'success' => false,
                    'message' => 'This volunteer is not an accepted participant for this opportunity.'
                ], 400);
            }

            // 3. Tạo Activity với status = Verified (Vì Org tự tạo)
            $activity = VolunteerActivity::create([
                'volunteer_id' => $request->volunteer_id,
                'opportunity_id' => $request->opportunity_id,
                'org_id' => $organization->org_id,
                'activity_date' => $request->activity_date,
                'hours_worked' => $request->hours_worked,
                'activity_description' => $request->description ?? 'Logged by Organization',
                'status' => 'Verified', // Auto verified
                'verified_by' => $user->user_id,
                'verified_date' => now(),
            ]);

            // 4. Cộng dồn giờ cho Volunteer
            $volunteerProfile = VolunteerProfile::where('user_id', $request->volunteer_id)->first();
            if ($volunteerProfile) {
                $volunteerProfile->increment('total_volunteer_hours', $request->hours_worked);
            }

            // 5. Gửi thông báo cho Volunteer
            Notification::create([
                'user_id' => $request->volunteer_id,
                'notification_type' => 'System',
                'title' => 'New Hours Logged 🕒',
                'content' => "Organization {$organization->organization_name} logged {$request->hours_worked} hours for you regarding '{$opportunity->title}'.",
                'related_id' => $activity->activity_id,
                'related_type' => 'activity',
                'priority' => 'medium',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Hours logged and verified successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Show activity details
     */
    public function show($id)
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            abort(403, 'Only organizations can access this page');
        }

        $activity = VolunteerActivity::with(['volunteer.volunteerProfile', 'opportunity', 'verifiedBy'])
            ->findOrFail($id);

        // Check if activity belongs to this organization
        if ($activity->org_id !== $user->organization->org_id) {
            abort(403, 'Unauthorized access to this activity');
        }

        return view('organization.activities.show', compact('activity'));
    }

    /**
     * Verify activity
     */
    public function verify(Request $request, $id)
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

            $activity = VolunteerActivity::findOrFail($id);

            // Check ownership
            if ($activity->org_id !== $user->organization->org_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            if ($activity->status !== 'Pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only pending activities can be verified'
                ], 400);
            }

            // Verify activity
            $activity->update([
                'status' => 'Verified',
                'verified_by' => $user->user_id,
                'verified_date' => now(),
                'impact_notes' => $request->input('notes'),
            ]);

            // Update volunteer's total hours
            $volunteerProfile = $activity->volunteer->volunteerProfile;
            if ($volunteerProfile) {
                $volunteerProfile->increment('total_volunteer_hours', $activity->hours_worked);
            }

            // Notify volunteer
            Notification::create([
                'user_id' => $activity->volunteer_id,
                'notification_type' => 'System',
                'title' => 'Activity Verified ✅',
                'content' => 'Your ' . $activity->hours_worked . ' hours for "' . $activity->opportunity->title . '" have been verified',
                'related_id' => $activity->activity_id,
                'related_type' => 'activity',
                'priority' => 'medium',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Activity verified successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to verify activity: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Dispute activity
     */
    public function dispute(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'reason' => 'required|string|min:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            $activity = VolunteerActivity::findOrFail($id);

            // Check ownership
            if ($activity->org_id !== $user->organization->org_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            if ($activity->status !== 'Pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only pending activities can be disputed'
                ], 400);
            }

            // Dispute activity
            $activity->update([
                'status' => 'Disputed',
                'verified_by' => $user->user_id,
                'verified_date' => now(),
                'impact_notes' => 'Disputed: ' . $request->input('reason'),
            ]);

            // Notify volunteer
            Notification::create([
                'user_id' => $activity->volunteer_id,
                'notification_type' => 'System',
                'title' => 'Activity Disputed ⚠️',
                'content' => 'Your activity for "' . $activity->opportunity->title . '" has been disputed. Reason: ' . $request->input('reason'),
                'related_id' => $activity->activity_id,
                'related_type' => 'activity',
                'priority' => 'high',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Activity disputed'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to dispute activity'
            ], 500);
        }
    }

    /**
     * Bulk verify activities
     */
    public function bulkVerify(Request $request)
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'activity_ids' => 'required|array',
            'activity_ids.*' => 'exists:volunteer_activities,activity_id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $organization = $user->organization;

            // Get activities that belong to this organization
            $activities = VolunteerActivity::whereIn('activity_id', $request->activity_ids)
                ->where('org_id', $organization->org_id)
                ->where('status', 'Pending')
                ->get();

            foreach ($activities as $activity) {
                $activity->update([
                    'status' => 'Verified',
                    'verified_by' => $user->user_id,
                    'verified_date' => now(),
                ]);

                // Update volunteer's total hours
                $volunteerProfile = $activity->volunteer->volunteerProfile;
                if ($volunteerProfile) {
                    $volunteerProfile->increment('total_volunteer_hours', $activity->hours_worked);
                }

                // Notify volunteer
                Notification::create([
                    'user_id' => $activity->volunteer_id,
                    'notification_type' => 'System',
                    'title' => 'Activity Verified',
                    'content' => 'Your activity hours have been verified',
                    'related_id' => $activity->activity_id,
                    'related_type' => 'activity',
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => count($activities) . ' activity(ies) verified successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to verify activities'
            ], 500);
        }
    }

    /**
     * Export activities to CSV
     */
    public function export(Request $request)
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            abort(403, 'Unauthorized');
        }

        $organization = $user->organization;

        $query = VolunteerActivity::where('org_id', $organization->org_id)
            ->with(['volunteer', 'opportunity']);

        // Apply filters
        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->date_from) {
            $query->whereDate('activity_date', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('activity_date', '<=', $request->date_to);
        }

        $activities = $query->get();

        $filename = 'activities_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($activities) {
            $file = fopen('php://output', 'w');

            // CSV headers
            fputcsv($file, [
                'ID',
                'Volunteer Name',
                'Email',
                'Opportunity',
                'Date',
                'Hours',
                'Status',
                'Verified By',
                'Verified Date'
            ]);

            foreach ($activities as $activity) {
                fputcsv($file, [
                    $activity->activity_id,
                    $activity->volunteer->full_name,
                    $activity->volunteer->email,
                    $activity->opportunity->title,
                    $activity->activity_date->format('Y-m-d'),
                    $activity->hours_worked,
                    $activity->status,
                    $activity->verifiedBy ? $activity->verifiedBy->full_name : '',
                    $activity->verified_date ? $activity->verified_date->format('Y-m-d H:i') : '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $headers = ['Volunteer Email', 'Opportunity ID', 'Date (YYYY-MM-DD)', 'Hours', 'Description'];
        $sheet->fromArray($headers, NULL, 'A1');

        // Style Header
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);
        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Dữ liệu mẫu (Example row)
        $sheet->setCellValue('A2', 'volunteer@example.com');
        $sheet->setCellValue('B2', '123');
        $sheet->setCellValue('C2', date('Y-m-d'));
        $sheet->setCellValue('D2', '4.5');
        $sheet->setCellValue('E2', 'Support event logistics');

        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, 'log_hours_template.xlsx');
    }

    /**
     * Xử lý Import file Excel
     */
    public function import(Request $request)
    {
        $user = Auth::user();
        if (!$user->isOrganization()) abort(403);

        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:5120',
        ]);

        $file = $request->file('file');
        $organization = $user->organization;

        try {
            $spreadsheet = IOFactory::load($file->getPathname());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            $successCount = 0;
            $errors = [];

            DB::beginTransaction();

            foreach ($rows as $index => $row) {
                if ($index === 0) continue; // Bỏ qua dòng Header

                // Giả sử thứ tự cột: 0:Email, 1:OppID, 2:Date, 3:Hours, 4:Desc
                $email = trim($row[0] ?? '');
                $oppId = trim($row[1] ?? '');
                $date = trim($row[2] ?? '');
                $hours = floatval($row[3] ?? 0);
                $desc = trim($row[4] ?? 'Logged via Excel Import');

                if (empty($email) || empty($oppId)) continue; // Bỏ dòng trống

                // 1. Tìm Volunteer
                $volunteer = User::where('email', $email)->where('user_type', 'Volunteer')->first();
                if (!$volunteer) {
                    $errors[] = "Row " . ($index + 1) . ": Volunteer email '$email' not found.";
                    continue;
                }

                // 2. Kiểm tra Opportunity (Phải thuộc về Org này)
                $opportunity = VolunteerOpportunity::where('opportunity_id', $oppId)
                    ->where('org_id', $organization->org_id)
                    ->first();

                if (!$opportunity) {
                    $errors[] = "Row " . ($index + 1) . ": Opportunity ID '$oppId' invalid or not yours.";
                    continue;
                }

                // 3. Tạo Activity
                $activity = VolunteerActivity::create([
                    'volunteer_id' => $volunteer->user_id,
                    'opportunity_id' => $opportunity->opportunity_id,
                    'org_id' => $organization->org_id,
                    'activity_date' => date('Y-m-d', strtotime($date)),
                    'hours_worked' => $hours,
                    'activity_description' => $desc,
                    'status' => 'Verified', // Auto verified
                    'verified_by' => $user->user_id,
                    'verified_date' => now(),
                ]);

                // 4. Cộng giờ
                $profile = VolunteerProfile::where('user_id', $volunteer->user_id)->first();
                if ($profile) {
                    $profile->increment('total_volunteer_hours', $hours);
                }

                // 5. Notify
                Notification::create([
                    'user_id' => $volunteer->user_id,
                    'notification_type' => 'System',
                    'title' => 'Hours Logged (Bulk Import)',
                    'content' => "Organization {$organization->organization_name} logged $hours hours via bulk import.",
                    'related_id' => $activity->activity_id,
                    'related_type' => 'activity',
                ]);

                $successCount++;
            }

            DB::commit();

            if (count($errors) > 0) {
                return response()->json([
                    'success' => true, // Vẫn trả true để reload, nhưng hiện warning
                    'message' => "Imported $successCount rows. Errors: " . implode(' | ', array_slice($errors, 0, 3)) . (count($errors) > 3 ? '...' : ''),
                    'warning' => true
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => "Successfully imported $successCount activities."
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Import failed: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Get activity statistics
     */
    public function statistics(Request $request)
    {
        $user = Auth::user();

        if (!$user->isOrganization()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $organization = $user->organization;

        // Get date range
        $startDate = $request->input('start_date', now()->subDays(30));
        $endDate = $request->input('end_date', now());

        $stats = [
            'total_hours' => VolunteerActivity::where('org_id', $organization->org_id)
                ->where('status', 'Verified')
                ->whereBetween('activity_date', [$startDate, $endDate])
                ->sum('hours_worked'),
            'total_activities' => VolunteerActivity::where('org_id', $organization->org_id)
                ->whereBetween('activity_date', [$startDate, $endDate])
                ->count(),
            'unique_volunteers' => VolunteerActivity::where('org_id', $organization->org_id)
                ->whereBetween('activity_date', [$startDate, $endDate])
                ->distinct('volunteer_id')
                ->count('volunteer_id'),
            'pending_verification' => VolunteerActivity::where('org_id', $organization->org_id)
                ->where('status', 'Pending')
                ->count(),
            'hours_by_month' => VolunteerActivity::where('org_id', $organization->org_id)
                ->where('status', 'Verified')
                ->whereBetween('activity_date', [$startDate, $endDate])
                ->selectRaw('MONTH(activity_date) as month, SUM(hours_worked) as total_hours')
                ->groupBy('month')
                ->get(),
        ];

        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }
}
