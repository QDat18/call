<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Organization;
use App\Models\VolunteerOpportunity;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Str;
use Illuminate\Support\Facades\Storage;
use App\Mail\VolunteerContactMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class OrganizationController extends Controller
{
    /**
     * Display a listing of organizations (public)
     */
    public function index(Request $request)
    {
        $query = Organization::with(['user', 'opportunities'])
            ->withCount(['opportunities as active_opportunities_count' => function ($query) {
                $query->where('status', 'Active');
            }])
            ->where('verification_status', 'Verified');

        // Search filter
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
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
            'pending_applications' => \App\Models\Application::whereHas('opportunity', function ($q) use ($organization) {
                $q->where('org_id', $organization->org_id);
            })->where('status', 'Pending')->count(),
        ];

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
            'certificates.*' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
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
            // 1. Tạo slug tên tổ chức (Dùng chung cho cả Avatar và Certificates)
            $orgNameSlug = \Illuminate\Support\Str::slug($organization->organization_name);

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                // Delete old avatar if exists
                if ($user->avatar_url && Storage::disk('public')->exists($user->avatar_url)) {
                    Storage::disk('public')->delete($user->avatar_url);
                }

                // Lấy file từ request
                $file = $request->file('avatar');

                // Lấy đuôi file (jpg, png...)
                $extension = $file->getClientOriginalExtension();

                // Tạo tên file hoàn chỉnh: ten-to-chuc-avatar-timestamp.jpg
                $fileName = $orgNameSlug . '-avatar-' . time() . '.' . $extension;

                // Lưu file dùng storeAs
                $avatarPath = $file->storeAs('avatars/organizations', $fileName, 'public');

                // Update user avatar_url
                $user->update([
                    'avatar_url' => $avatarPath
                ]);
            }

            // Handle Certificates Upload
            $currentCertificates = $organization->certificates ?? [];

            if ($request->hasFile('certificates')) {
                foreach ($request->file('certificates') as $index => $file) {
                    // Lấy đuôi file
                    $extension = $file->getClientOriginalExtension();

                    // Tạo tên file: ten-to-chuc-cert-{index}-{timestamp}.jpg
                    // Thêm $index để tránh trùng tên khi upload nhiều ảnh cùng lúc
                    $fileName = $orgNameSlug . '-cert-' . ($index + 1) . '-' . time() . '.' . $extension;

                    // Lưu file dùng storeAs
                    $path = $file->storeAs('certificates/' . $organization->org_id, $fileName, 'public');

                    $currentCertificates[] = $path;
                }
            }

            // Update organization data
            $organization->update(array_merge(
                $request->only([
                    'organization_name',
                    'organization_type',
                    'description',
                    'mission_statement',
                    'website',
                    'contact_person',
                    'registration_number',
                    'founded_year'
                ]),
                ['certificates' => $currentCertificates]
            ));

            return response()->json([
                'success' => true,
                'message' => 'Organization updated successfully',
                'avatar_url' => $user->avatar_url ? Storage::url($user->avatar_url) : null,
                'certificates' => $currentCertificates
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update organization: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete certificate
     */
    public function deleteCertificate(Request $request)
    {
        $user = Auth::user();
        if (!$user->isOrganization()) abort(403);

        $organization = $user->organization;
        $pathToDelete = $request->input('path');

        $certificates = $organization->certificates ?? [];

        // Tìm và xóa khỏi mảng
        if (($key = array_search($pathToDelete, $certificates)) !== false) {
            unset($certificates[$key]);

            // Xóa file vật lý
            if (Storage::disk('public')->exists($pathToDelete)) {
                Storage::disk('public')->delete($pathToDelete);
            }

            // Cập nhật lại DB (re-index array để tránh lỗi JSON object thay vì array)
            $organization->update(['certificates' => array_values($certificates)]);

            return response()->json(['success' => true, 'message' => 'Certificate deleted']);
        }

        return response()->json(['success' => false, 'message' => 'File not found'], 404);
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

        $orgId = $organization->org_id;

        // 1. Calculate Statistics (Sửa lỗi Undefined variable $stats)
        $stats = [
            'total' => \App\Models\User::whereHas('applications.opportunity', function ($q) use ($orgId) {
                $q->where('org_id', $orgId);
            })->count(),

            'active' => \App\Models\Application::whereHas('opportunity', function ($q) use ($orgId) {
                $q->where('org_id', $orgId);
            })->where('status', 'Accepted')->distinct('volunteer_id')->count(),

            'total_hours' => \App\Models\VolunteerActivity::where('org_id', $orgId)
                ->where('status', 'Verified')
                ->sum('hours_worked'),

            'avg_rating' => \App\Models\VolunteerProfile::whereHas('user.applications.opportunity', function ($q) use ($orgId) {
                $q->where('org_id', $orgId);
            })->avg('volunteer_rating') ?? 0,
        ];

        // 2. Get Opportunities list for Filter (Thêm biến cho dropdown filter)
        $opportunities = $organization->opportunities()->select('opportunity_id', 'title')->get();

        // 3. Get Volunteers List with Filters
        $query = \App\Models\User::whereHas('applications.opportunity', function ($q) use ($orgId) {
            $q->where('org_id', $orgId);
        })->with(['volunteerProfile', 'applications' => function ($q) use ($orgId) {
            // Eager load applications specific to this org to count them
            $q->whereHas('opportunity', fn($sub) => $sub->where('org_id', $orgId));
        }]);

        // Filter by Search
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->search . '%')
                    ->orWhere('last_name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by Opportunity
        if ($request->has('opportunity') && $request->opportunity) {
            $query->whereHas('applications', function ($q) use ($request) {
                $q->where('opportunity_id', $request->opportunity);
            });
        }

        // Filter by Status (Active/Completed)
        if ($request->has('status') && $request->status) {
            if ($request->status === 'active') {
                $query->whereHas('applications', function ($q) use ($orgId) {
                    $q->whereHas('opportunity', fn($o) => $o->where('org_id', $orgId))
                        ->whereIn('status', ['Accepted', 'Pending']);
                });
            } elseif ($request->status === 'completed') {
                // Giả sử completed là những người đã hoàn thành activity hoặc opportunity đóng
                $query->whereHas('applications', function ($q) use ($orgId) {
                    $q->whereHas('opportunity', fn($o) => $o->where('org_id', $orgId)->where('status', 'Completed'));
                });
            }
        }

        $volunteers = $query->paginate(12);

        // Append attributes manually for the view loop to avoid N+1 queries on calculations
        $volunteers->getCollection()->transform(function ($volunteer) {
            $volunteer->opportunities_count = $volunteer->applications->count();
            return $volunteer;
        });

        return view('organization.volunteers.index', compact('organization', 'volunteers', 'stats', 'opportunities'));
    }

    /**
     * Export Volunteers to Excel (.xlsx)
     */
    public function exportVolunteers(Request $request)
    {
        $user = Auth::user();
        if (!$user->isOrganization()) abort(403);

        $organization = $user->organization;
        $orgId = $organization->org_id;
        $type = $request->query('type', 'all'); // 'all' hoặc 'top100'

        // === 1. QUERY DỮ LIỆU (Giữ nguyên logic lọc cũ) ===
        $query = \App\Models\User::whereHas('applications.opportunity', function ($q) use ($orgId) {
            $q->where('org_id', $orgId);
        })->with(['volunteerProfile']);

        // Apply Filters
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->search . '%')
                    ->orWhere('last_name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('opportunity') && $request->opportunity) {
            $query->whereHas('applications', function ($q) use ($request) {
                $q->where('opportunity_id', $request->opportunity);
            });
        }

        if ($request->has('status') && $request->status === 'active') {
            $query->whereHas('applications', function ($q) use ($orgId) {
                $q->whereHas('opportunity', fn($o) => $o->where('org_id', $orgId))
                    ->whereIn('status', ['Accepted', 'Pending']);
            });
        }

        // Xử lý Top 100
        if ($type === 'top100') {
            $query->limit(100);
        }

        $volunteers = $query->get();

        // === 2. TẠO FILE EXCEL ===
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set tên sheet
        $sheet->setTitle('Volunteers List');

        // -- HEADER --
        $headers = ['ID', 'Full Name', 'Email', 'Phone', 'Hours Worked', 'Rating', 'Skills', 'Join Date'];
        $sheet->fromArray($headers, NULL, 'A1');

        // Style cho Header (Nền xanh, chữ trắng, in đậm)
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '059669']], // Màu xanh của Org
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ];
        $sheet->getStyle('A1:H1')->applyFromArray($headerStyle);

        // -- DATA --
        $row = 2;
        foreach ($volunteers as $volunteer) {
            // Xử lý Skills (Array/String to String)
            $skills = $volunteer->volunteerProfile->skills ?? [];
            if (is_string($skills)) $skills = explode(',', $skills);
            $skillsStr = is_array($skills) ? implode(', ', $skills) : '';

            // Ghi dữ liệu từng dòng
            $sheet->setCellValue('A' . $row, $volunteer->user_id);
            $sheet->setCellValue('B' . $row, $volunteer->first_name . ' ' . $volunteer->last_name);
            $sheet->setCellValue('C' . $row, $volunteer->email);
            $sheet->setCellValue('D' . $row, $volunteer->phone ?? 'N/A');
            $sheet->setCellValue('E' . $row, $volunteer->volunteerProfile->total_volunteer_hours ?? 0);
            $sheet->setCellValue('F' . $row, $volunteer->volunteerProfile->volunteer_rating ?? 0);
            $sheet->setCellValue('G' . $row, $skillsStr);
            $sheet->setCellValue('H' . $row, $volunteer->created_at->format('Y-m-d'));

            $row++;
        }

        // -- AUTO SIZE COLUMNS --
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // === 3. XUẤT FILE DOWNLOAD ===
        $fileName = "volunteers_export_" . ($type == 'top100' ? 'top100_' : 'all_') . date('Y-m-d_H-i') . ".xlsx";

        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    /**
     * Show volunteer profile detail
     */
    public function showVolunteer($id)
    {
        $user = Auth::user();
        if (!$user->isOrganization()) abort(403);

        $organization = $user->organization;

        // 1. Tìm Volunteer (User)
        // Dùng findOrFail để nếu không thấy sẽ báo 404 thay vì lỗi code
        $volunteer = \App\Models\User::with('volunteerProfile')->findOrFail($id);

        // 2. Bảo mật: Kiểm tra xem Volunteer này có từng nộp đơn vào Org này chưa?
        // Nếu muốn cho xem public thì bỏ đoạn này, nhưng nên check để bảo mật thông tin
        $hasInteraction = \App\Models\Application::where('volunteer_id', $id)
            ->whereHas('opportunity', function ($q) use ($organization) {
                $q->where('org_id', $organization->org_id);
            })->exists();

        if (!$hasInteraction) {
            return redirect()->route('organization.volunteers.index')
                ->with('error', 'This volunteer is not associated with your organization.');
        }

        // 3. Lấy lịch sử Applications của Volunteer này tại Org
        $applications = \App\Models\Application::where('volunteer_id', $id)
            ->whereHas('opportunity', function ($q) use ($organization) {
                $q->where('org_id', $organization->org_id);
            })
            ->with('opportunity')
            ->orderBy('created_at', 'desc')
            ->get();

        // 4. Lấy lịch sử Activities (Giờ làm) của Volunteer này tại Org
        $activities = \App\Models\VolunteerActivity::where('volunteer_id', $id)
            ->where('org_id', $organization->org_id)
            ->with('opportunity')
            ->orderBy('activity_date', 'desc')
            ->get();

        return view('organization.volunteers.show', compact('volunteer', 'organization', 'applications', 'activities'));
    }

    /**
     * Send Email to Volunteer
     */
    public function contactVolunteer(Request $request)
    {
        $user = Auth::user();
        if (!$user->isOrganization()) abort(403);

        $validator = Validator::make($request->all(), [
            'volunteer_id' => 'required|exists:users,user_id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        try {
            $volunteer = \App\Models\User::findOrFail($request->volunteer_id);

            // Gửi email
            Mail::to($volunteer->email)->send(new VolunteerContactMail(
                $request->only(['subject', 'message']),
                $user->organization->organization_name
            ));

            return response()->json(['success' => true, 'message' => 'Email sent successfully to ' . $volunteer->first_name]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to send email: ' . $e->getMessage()], 500);
        }
    }
}
