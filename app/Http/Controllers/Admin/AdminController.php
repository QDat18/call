<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Organization;
use App\Models\VolunteerOpportunity;
use App\Models\Application;
use App\Models\Category;
use App\Models\VolunteerActivity;
use App\Models\Review;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Support\Facades\Mail; // <--- QUAN TRỌNG: Phải có dòng này
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth', 'role:Admin']);
    // }
    /**
     * Display admin dashboard
     */
    public function dashboard()
    {
        // 1. Statistics Cards (Dữ liệu thực từ DB)
        $stats = [
            'total_users'           => User::count(),
            'new_users_this_month'  => User::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count(),

            'total_orgs'            => Organization::count(),
            'pending_verifications' => Organization::where('verification_status', 'Pending')->count(),

            'active_opportunities'  => VolunteerOpportunity::where('status', 'Active')->count(),
            'upcoming'              => VolunteerOpportunity::where('status', 'Active')->where('start_date', '>', now())->count(),

            'total_applications'    => Application::count(),
            'pending_applications'  => Application::where('status', 'Pending')->count(),

            // Thống kê thêm cho phần Email Management
            'total_volunteers'      => User::where('user_type', 'Volunteer')->count(),
            'active_users'          => User::where('is_active', true)->count(),
            'total_posts'          => Post::count(),
            'pending_posts'        => Post::where('status', 'Pending')->count(),
        ];

        // 2. Recent Users (5 người dùng mới nhất)
        $recentUsers = User::latest()->take(5)->get();

        // 3. Pending Organizations (5 tổ chức chờ duyệt mới nhất)
        $pendingOrgs = Organization::where('verification_status', 'Pending')
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        // 4. Chart Data (Biểu đồ tăng trưởng User & Trạng thái đơn)
        $chartData = [
            'userGrowth' => [
                'labels' => collect(range(6, 0))->map(function ($days) {
                    return now()->subDays($days)->format('D, M d');
                })->values()->toArray(),
                'data' => collect(range(6, 0))->map(function ($days) {
                    return User::whereDate('created_at', now()->subDays($days))->count();
                })->values()->toArray(),
            ],
            'applicationStatus' => [
                Application::where('status', 'Pending')->count(),
                Application::where('status', 'Accepted')->count(),
                Application::where('status', 'Rejected')->count(),
                Application::where('status', 'Under Review')->count(),
            ],
        ];

        // 5. Recent Activities (Kết hợp từ nhiều nguồn: User mới, Org mới, Opportunity mới)
        // Lấy 5 hoạt động mới nhất từ 3 bảng khác nhau
        $newUsers = User::select('created_at', 'first_name', 'last_name')
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($user) {
                return [
                    'description' => "New user registered: {$user->first_name} {$user->last_name}",
                    'time'        => $user->created_at, // Giữ nguyên object Carbon để sort sau
                    'time_diff'   => $user->created_at->diffForHumans(),
                    'icon'        => 'user-plus',
                    'color'       => 'blue'
                ];
            });

        $verifiedOrgs = Organization::where('verification_status', 'Verified')
            ->select('updated_at', 'organization_name')
            ->latest('updated_at')
            ->take(3)
            ->get()
            ->map(function ($org) {
                return [
                    'description' => "Organization verified: {$org->organization_name}",
                    'time'        => $org->updated_at,
                    'time_diff'   => $org->updated_at->diffForHumans(),
                    'icon'        => 'check-circle',
                    'color'       => 'green'
                ];
            });

        $newOpps = VolunteerOpportunity::select('created_at', 'title')
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($opp) {
                return [
                    'description' => "New opportunity: " . \Str::limit($opp->title, 20),
                    'time'        => $opp->created_at,
                    'time_diff'   => $opp->created_at->diffForHumans(),
                    'icon'        => 'clipboard-list',
                    'color'       => 'purple'
                ];
            });

        // Gộp và sắp xếp theo thời gian mới nhất
        $recentActivities = $newUsers->concat($verifiedOrgs)->concat($newOpps)
            ->sortByDesc('time')
            ->take(6) // Lấy 6 hoạt động mới nhất
            ->values(); // Reset key

        return view('admin.dashboard', compact('stats', 'recentUsers', 'pendingOrgs', 'chartData', 'recentActivities'));
    }

    /**
     * Display users list
     */
    /**
     * Display users list
     */
    public function users(Request $request)
    {
        // Eager loading để tối ưu query, tránh N+1 khi hiển thị list
        $query = User::with(['volunteerProfile', 'organization']);

        // Search nâng cao: Tìm cả trong số điện thoại và email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    // Mở rộng tìm kiếm theo tên tổ chức nếu cần
                    ->orWhereHas('organization', function ($subQ) use ($search) {
                        $subQ->where('organization_name', 'LIKE', "%{$search}%");
                    });
            });
        }

        // Filter logic giữ nguyên...
        if ($request->filled('user_type')) {
            $query->where('user_type', $request->user_type);
        }
        if ($request->filled('status')) {
            $isActive = $request->status === 'active';
            $query->where('is_active', $isActive);
        }

        // Sort mặc định là mới nhất
        $sortField = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');

        // Bảo vệ sort field để tránh SQL Injection
        if (in_array($sortField, ['first_name', 'email', 'created_at', 'user_type'])) {
            $query->orderBy($sortField, $sortOrder);
        } else {
            $query->latest();
        }

        $users = $query->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show create user form
     */
    public function createUser()
    {
        return view('admin.users.create');
    }

    /**
     * Store new user
     */
    public function storeUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:50',
            'last_name'  => 'required|string|max:50',
            'email'      => 'required|email|unique:users,email',
            'phone'      => 'nullable|string|max:15|unique:users,phone', // Phone có thể null
            'user_type'  => 'required|in:Volunteer,Organization,Admin',
            'city'       => 'required|string',
            'password'   => 'required|string|min:8',
            'avatar'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            // Nếu là AJAX request
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $avatarUrl = null;
            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $avatarName = time() . '_' . uniqid() . '.' . $avatar->getClientOriginalExtension();
                $avatar->storeAs('public/avatars', $avatarName); // Dùng Storage chuẩn
                $avatarUrl = 'avatars/' . $avatarName;
            }

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'email'      => $request->email,
                'phone'      => $request->phone,
                'user_type'  => $request->user_type,
                'city'       => $request->city,
                'password'   => Hash::make($request->password),
                'avatar_url' => $avatarUrl,
                'is_active'  => true,
                'is_verified' => true, // Admin tạo thì auto verify
            ]);

            // Create related profile
            if ($request->user_type === 'Volunteer') {
                \App\Models\VolunteerProfile::create(['user_id' => $user->user_id]);
            } elseif ($request->user_type === 'Organization') {
                \App\Models\Organization::create([
                    'user_id' => $user->user_id,
                    'organization_name' => $request->organization_name ?? ($user->first_name . ' ' . $user->last_name),
                    'verification_status' => 'Verified', // Admin tạo thì verified luôn
                ]);
            }

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'User created successfully']);
            }
            return redirect()->route('admin.users.index')->with('success', 'User created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', 'Failed: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Export users to CSV
     */
    public function exportUsers(Request $request)
    {
        // --- PHẦN 1: LỌC DỮ LIỆU (Giống hệt logic hiển thị danh sách) ---
        $query = User::query();

        // Lọc theo ID đã chọn (nếu có)
        if ($request->filled('user_ids')) {
            $ids = explode(',', $request->user_ids);
            $query->whereIn('user_id', $ids);
        }
        // Nếu không chọn ID, áp dụng bộ lọc tìm kiếm
        else {
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'LIKE', "%{$search}%")
                        ->orWhere('last_name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%")
                        ->orWhere('phone', 'LIKE', "%{$search}%");
                });
            }
            if ($request->filled('user_type')) {
                $query->where('user_type', $request->user_type);
            }
            if ($request->filled('status')) {
                $isActive = $request->status === 'active';
                $query->where('is_active', $isActive);
            }
        }

        $users = $query->latest()->get();

        // --- PHẦN 2: TẠO FILE EXCEL ---
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Users List');

        // 1. Tạo Tiêu đề Cột (Header)
        $headers = ['ID', 'Full Name', 'Email', 'Phone', 'Role', 'Status', 'Joined Date'];
        $sheet->fromArray($headers, NULL, 'A1');

        // 2. Style cho Header (Nền xanh, chữ trắng, in đậm)
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4F46E5']], // Indigo-600
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ];
        $sheet->getStyle('A1:G1')->applyFromArray($headerStyle);
        $sheet->getRowDimension(1)->setRowHeight(25); // Chiều cao dòng header

        // 3. Đổ dữ liệu
        $row = 2;
        foreach ($users as $user) {
            $sheet->setCellValue('A' . $row, $user->user_id);
            $sheet->setCellValue('B' . $row, $user->first_name . ' ' . $user->last_name);
            $sheet->setCellValue('C' . $row, $user->email);
            $sheet->setCellValue('D' . $row, $user->phone ?? 'N/A');
            $sheet->setCellValue('E' . $row, $user->user_type);
            $sheet->setCellValue('F' . $row, $user->is_active ? 'Active' : 'Inactive');
            $sheet->setCellValue('G' . $row, $user->created_at->format('d/m/Y'));

            // Tô màu đỏ cho user Inactive
            if (!$user->is_active) {
                $sheet->getStyle('F' . $row)->getFont()->getColor()->setARGB('FFFF0000');
            }

            $row++;
        }

        // 4. Auto-size các cột cho đẹp
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // 5. Xuất file
        $fileName = 'users_export_' . date('Y-m-d_H-i') . '.xlsx';
        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    /**
     * Show user details
     */
    public function showUser($id)
    {
        $user = User::with(['volunteerProfile', 'organization', 'applications', 'reviews'])
            ->findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show edit user form
     */
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update user
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email,' . $id . ',user_id',
            'phone' => 'required|string|max:15|unique:users,phone,' . $id . ',user_id',
            'user_type' => 'required|in:Volunteer,Organization,Admin',
            'city' => 'required|string',
            'password' => 'nullable|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            $data = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'user_type' => $request->user_type,
                'city' => $request->city,
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            return response()->json([
                'success' => true,
                'message' => 'User updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user'
            ], 500);
        }
    }

    /**
     * Delete user
     */
    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);

            // Prevent deleting current admin
            if ($user->user_id === auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot delete your own account'
                ], 403);
            }

            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete user'
            ], 500);
        }
    }
    public function deactivateUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->user_id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot deactivate your own account'
            ], 403);
        }

        $user->update(['is_active' => false]);

        return response()->json([
            'success' => true,
            'message' => 'User deactivated successfully'
        ]);
    }
    /**
     * Suspend user
     */
    public function suspendUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->user_id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot suspend your own account'
            ], 403);
        }

        $user->update(['is_active' => false]);

        return response()->json([
            'success' => true,
            'message' => 'User suspended successfully'
        ]);
    }

    /**
     * Activate user
     */
    public function activateUser($id)
    {
        $user = User::findOrFail($id);

        $user->update(['is_active' => true]);

        return response()->json([
            'success' => true,
            'message' => 'User activated successfully'
        ]);
    }

    /**
     * Bulk actions on users
     */
    public function userBulkAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'action' => 'required|in:activate,deactivate,delete',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,user_id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            $userIds = $request->user_ids;

            // Prevent bulk action on current admin
            if (in_array(auth()->id(), $userIds)) {
                $userIds = array_diff($userIds, [auth()->id()]);
            }

            switch ($request->action) {
                case 'activate':
                    User::whereIn('user_id', $userIds)->update(['is_active' => true]);
                    $message = 'Users activated successfully';
                    break;

                case 'deactivate':
                    User::whereIn('user_id', $userIds)->update(['is_active' => false]);
                    $message = 'Users deactivated successfully';
                    break;

                case 'delete':
                    User::whereIn('user_id', $userIds)->delete();
                    $message = 'Users deleted successfully';
                    break;
            }

            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Bulk action failed'
            ], 500);
        }
    }
    /**
     * Display organizations list
     */
    public function organizations(Request $request)
    {
        $query = Organization::with('user');

        // Search
        if ($request->filled('search')) {
            $query->where('organization_name', 'LIKE', "%{$request->search}%");
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('verification_status', $request->status);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('organization_type', $request->type);
        }

        $organizations = $query->latest()->paginate(15);

        // Statistics
        $stats = [
            'total' => Organization::count(),
            'verified' => Organization::where('verification_status', 'Verified')->count(),
            'pending' => Organization::where('verification_status', 'Pending')->count(),
            'rejected' => Organization::where('verification_status', 'Rejected')->count(),
        ];

        return view('admin.organizations.index', compact('organizations', 'stats'));
    }

    /**
     * Show organization details
     */
    public function ShowOrganization($id)
    {
        $organization = Organization::with(['user', 'opportunities'])
            ->findOrFail($id);

        // Trả về view thay vì JSON
        return view('admin.organizations.show', compact('organization'));
    }

    /**
     * Approve organization
     */
    public function organizationsApprove($id)
    {
        $org = Organization::findOrFail($id);
        $org->update(['verification_status' => 'Verified']);

        // Create notification for organization
        \App\Models\Notification::create([
            'user_id' => $org->user_id,
            'notification_type' => 'System',
            'title' => 'Organization Verified',
            'content' => 'Congratulations! Your organization has been verified and you can now post opportunities.',
            'priority' => 'high',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Organization approved successfully'
        ]);
    }

    /**
     * Reject organization
     */
    public function organizationsReject($id)
    {
        $org = Organization::findOrFail($id);
        $org->update(['verification_status' => 'Rejected']);

        // Create notification
        \App\Models\Notification::create([
            'user_id' => $org->user_id,
            'notification_type' => 'System',
            'title' => 'Organization Verification Rejected',
            'content' => 'Your organization verification has been rejected. Please contact support for more information.',
            'priority' => 'high',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Organization rejected'
        ]);
    }

    /**
     * Delete organization
     */
    public function organizationsDestroy($id)
    {
        try {
            $org = Organization::findOrFail($id);
            $org->delete();

            return response()->json([
                'success' => true,
                'message' => 'Organization deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete organization'
            ], 500);
        }
    }

    /**
     * Export organizations
     */
    /**
     * Export organizations
     */
    public function organizationsExport(Request $request)
    {
        $query = Organization::with('user');

        // 1. Ưu tiên export theo IDs đã chọn
        if ($request->filled('org_ids')) {
            $ids = is_array($request->org_ids)
                ? $request->org_ids
                : explode(',', $request->org_ids);
            $query->whereIn('org_id', $ids);
        }
        // 2. Nếu không có IDs, áp dụng filters từ trang index
        else {
            if ($request->filled('search')) {
                $query->where('organization_name', 'LIKE', "%{$request->search}%");
            }
            if ($request->filled('status')) {
                $query->where('verification_status', $request->status);
            }
            if ($request->filled('type')) {
                $query->where('organization_type', $request->type);
            }
        }

        $organizations = $query->get();

        // Tạo file Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Organizations List');

        // Header
        $headers = ['ID', 'Name', 'Type', 'Status', 'Email', 'Phone', 'Founded', 'Opportunities', 'Rating', 'Created At'];
        $sheet->fromArray($headers, NULL, 'A1');

        // Style Header
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4F46E5']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ];
        $sheet->getStyle('A1:J1')->applyFromArray($headerStyle);

        // Data
        $row = 2;
        foreach ($organizations as $org) {
            $sheet->setCellValue('A' . $row, $org->org_id);
            $sheet->setCellValue('B' . $row, $org->organization_name);
            $sheet->setCellValue('C' . $row, $org->organization_type);
            $sheet->setCellValue('D' . $row, $org->verification_status);
            $sheet->setCellValue('E' . $row, $org->user->email ?? 'N/A');
            $sheet->setCellValue('F' . $row, $org->user->phone ?? 'N/A');
            $sheet->setCellValue('G' . $row, $org->founded_year);
            $sheet->setCellValue('H' . $row, $org->total_opportunities);
            $sheet->setCellValue('I' . $row, $org->rating);
            $sheet->setCellValue('J' . $row, $org->created_at->format('Y-m-d'));
            $row++;
        }

        // Auto Size Columns
        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Export file
        $filename = 'organizations_export_' . date('Y-m-d_H-i') . '.xlsx';
        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
    // Add to AdminController
    // public function showExportOptions(Request $request)
    // {
    //     // Nhận danh sách ID đã chọn từ trang Index (nếu có) để truyền sang View
    //     $orgIds = $request->query('org_ids');

    //     return view('admin.organizations.export', compact('orgIds'));
    // }
    /**
     * Display opportunities list
     */
    // Trong AdminController.php

    public function opportunities(Request $request)
    {
        $query = VolunteerOpportunity::with(['organization.user', 'category']);

        // --- Giữ nguyên Logic Lọc Cũ ---
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('location', 'LIKE', "%{$search}%");
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->filled('organization')) {
            $query->whereHas('organization', function ($q) use ($request) {
                $q->where('organization_name', 'LIKE', "%{$request->organization}%");
            });
        }
        // ---------------------------------

        $opportunities = $query->latest()->paginate(15);

        // [THÊM MỚI] Xử lý trả về AJAX JSON
        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.opportunities.partials.table', compact('opportunities'))->render(),
                'pagination' => $opportunities->links()->toHtml()
            ]);
        }

        // Các phần thống kê giữ nguyên
        $stats = [
            'total' => VolunteerOpportunity::count(),
            'active' => VolunteerOpportunity::where('status', 'Active')->count(),
            'paused' => VolunteerOpportunity::where('status', 'Paused')->count(),
            'completed' => VolunteerOpportunity::where('status', 'Completed')->count(),
            'cancelled' => VolunteerOpportunity::where('status', 'Cancelled')->count(),
        ];
        $categories = Category::where('is_active', true)->get();

        return view('admin.opportunities.index', compact('opportunities', 'stats', 'categories'));
    }
    /**
     * Show opportunity details
     */
    public function showOpportunity(Request $request, $id)
    {
        // Eager load sâu hơn để lấy ảnh avatar của organization user nếu cần
        $opportunity = VolunteerOpportunity::with(['organization.user', 'category'])
            ->findOrFail($id);

        if ($request->wantsJson() || $request->ajax()) {
            // [NÂNG CẤP] Format sẵn dữ liệu để JS không cần xử lý logic phức tạp
            $data = $opportunity->toArray();
            $data['formatted_start_date'] = $opportunity->start_date ? $opportunity->start_date->format('d/m/Y') : 'N/A';
            $data['formatted_end_date'] = $opportunity->end_date ? $opportunity->end_date->format('d/m/Y') : 'Vô thời hạn';
            $data['org_name'] = $opportunity->organization->organization_name ?? 'N/A';
            $data['org_avatar'] = $opportunity->organization->user->avatar_url ?? null;
            $data['category_info'] = $opportunity->category ? [
                'name' => $opportunity->category->category_name,
                'color' => $opportunity->category->color,
                'icon' => $opportunity->category->icon
            ] : null;

            return response()->json([
                'success' => true,
                'opportunity' => $data
            ]);
        }

        return view('admin.opportunities.show', compact('opportunity'));
    }
    /**
     * Update opportunity status
     */
    public function opportunitiesUpdateStatus(Request $request, $id)
    {
        $opportunity = VolunteerOpportunity::findOrFail($id);

        // Validate dữ liệu đầu vào
        $request->validate([
            'status' => 'required|in:Active,Paused,Completed,Cancelled'
        ]);

        $opportunity->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Trạng thái đã được cập nhật thành công.',
            'new_status' => $request->status // Trả về status mới để JS cập nhật giao diện
        ]);
    }

    /**
     * Delete opportunity
     */
    public function deleteOpportunity($id)
    {
        try {
            $opportunity = VolunteerOpportunity::findOrFail($id);
            $opportunity->delete();

            return response()->json([
                'success' => true,
                'message' => 'Đã xóa cơ hội thành công.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export opportunities
     */
    public function exportView()
    {
        $categories = Category::all(); // Lấy danh mục để fill vào select box
        return view('admin.opportunities.export', compact('categories'));
    }

    // 2. Hàm xử lý Download (Thay thế hàm opportunitiesExport cũ hoặc sửa lại)
    public function processExport(Request $request)
    {
        // 1. Lọc dữ liệu (Giữ nguyên logic lọc của bạn)
        $query = VolunteerOpportunity::with(['organization', 'category']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Lấy dữ liệu
        $opportunities = $query->get();

        // 2. TẠO FILE EXCEL (.xlsx)
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Opportunities List');

        // -- Header Columns --
        $headers = [
            'ID',
            'Title',
            'Organization',
            'Category',
            'Status',
            'Needed',
            'Registered',
            'Location',
            'Created At'
        ];
        $sheet->fromArray($headers, NULL, 'A1');

        // -- Style Header (Màu nền xanh, chữ trắng, đậm) --
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4F46E5']], // Indigo-600
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ];
        $sheet->getStyle('A1:I1')->applyFromArray($headerStyle);
        $sheet->getRowDimension(1)->setRowHeight(25); // Chiều cao dòng header

        // -- Fill Data --
        $row = 2;
        foreach ($opportunities as $opp) {
            $sheet->setCellValue('A' . $row, $opp->opportunity_id);
            $sheet->setCellValue('B' . $row, $opp->title);
            $sheet->setCellValue('C' . $row, $opp->organization->organization_name ?? 'N/A');
            $sheet->setCellValue('D' . $row, $opp->category->category_name ?? 'N/A');
            $sheet->setCellValue('E' . $row, $opp->status);
            $sheet->setCellValue('F' . $row, $opp->volunteers_needed);
            $sheet->setCellValue('G' . $row, $opp->volunteers_registered);
            $sheet->setCellValue('H' . $row, $opp->location);
            $sheet->setCellValue('I' . $row, $opp->created_at->format('d/m/Y'));

            // Tô màu trạng thái (Optional)
            if ($opp->status == 'Cancelled') {
                $sheet->getStyle('A' . $row . ':I' . $row)->getFont()->getColor()->setARGB('FFEF4444'); // Red text
            }

            $row++;
        }

        // -- Auto Size Columns --
        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // -- Xuất file --
        $filename = 'opportunities_export_' . date('Y-m-d_H-i') . '.xlsx';
        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
    /**
     * Display applications list
     */
    /**
     * Display applications list for admin
     */
    public function index(Request $request)
    {
        $query = Application::with(['volunteer', 'opportunity.organization']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('volunteer', function ($q) use ($search) {
                $q->where('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by organization
        if ($request->filled('organization')) {
            $query->whereHas('opportunity.organization', function ($q) use ($request) {
                $q->where('organization_name', 'LIKE', "%{$request->organization}%");
            });
        }

        // Filter by date range
        if ($request->filled('date_range')) {
            switch ($request->date_range) {
                case 'today':
                    $query->whereDate('applied_date', today());
                    break;
                case 'week':
                    $query->whereBetween('applied_date', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('applied_date', now()->month)
                        ->whereYear('applied_date', now()->year);
                    break;
            }
        }

        $applications = $query->latest('applied_date')->paginate(15);

        // Statistics
        $stats = [
            'total' => Application::count(),
            'pending' => Application::where('status', 'Pending')->count(),
            'under_review' => Application::where('status', 'Under Review')->count(),
            'accepted' => Application::where('status', 'Accepted')->count(),
            'rejected' => Application::where('status', 'Rejected')->count(),
        ];

        return view('admin.applications.index', compact('applications', 'stats'));
    }

    /**
     * Show application details for admin
     */
    public function showApplication($id)
    {
        $application = Application::with([
            'volunteer.volunteerProfile',
            'opportunity.organization.user',
            'opportunity.category'
        ])->findOrFail($id);

        return view('admin.applications.show', compact('application'));
    }

    /**
     * Export applications
     */
    /**
     * Export applications to CSV with detailed information
     */
    /**
     * Export applications to Excel (.xlsx)
     */
    public function exportApplications(Request $request)
    {
        // 1. Lọc dữ liệu (Giữ nguyên logic cũ)
        $query = Application::with(['volunteer.volunteerProfile', 'opportunity.organization']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('volunteer', function ($q) use ($search) {
                $q->where('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('organization')) {
            $query->whereHas('opportunity.organization', function ($q) use ($request) {
                $q->where('organization_name', 'LIKE', "%{$request->organization}%");
            });
        }

        if ($request->filled('date_range')) {
            switch ($request->date_range) {
                case 'today':
                    $query->whereDate('applied_date', today());
                    break;
                case 'week':
                    $query->whereBetween('applied_date', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('applied_date', now()->month)
                        ->whereYear('applied_date', now()->year);
                    break;
            }
        }

        $applications = $query->orderBy('applied_date', 'desc')->get();

        // 2. TẠO FILE EXCEL
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Applications List');

        // -- Header Columns --
        $headers = [
            'ID',
            'Volunteer Name',
            'Email',
            'Phone',
            'Age',
            'Rating',
            'Opportunity',
            'Organization',
            'Status',
            'Applied Date',
            'Reviewed Date',
            'Pending Days'
        ];
        $sheet->fromArray($headers, NULL, 'A1');

        // -- Style Header (Nền tím, chữ trắng, đậm) --
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '6D28D9']], // Purple-700
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ];
        $sheet->getStyle('A1:L1')->applyFromArray($headerStyle);
        $sheet->getRowDimension(1)->setRowHeight(30);

        // -- Fill Data --
        $row = 2;
        foreach ($applications as $app) {
            $volunteer = $app->volunteer;
            $profile = $volunteer->volunteerProfile;

            // Tính số ngày chờ
            $daysPending = $app->status === 'Pending' ?
                $app->applied_date->diffInDays(now()) : ($app->reviewed_date ? $app->applied_date->diffInDays($app->reviewed_date) : 0);

            $sheet->setCellValue('A' . $row, $app->application_id);
            $sheet->setCellValue('B' . $row, $volunteer->first_name . ' ' . $volunteer->last_name);
            $sheet->setCellValue('C' . $row, $volunteer->email);
            $sheet->setCellValue('D' . $row, $volunteer->phone ?? 'N/A');
            $sheet->setCellValue('E' . $row, $volunteer->date_of_birth ? \Carbon\Carbon::parse($volunteer->date_of_birth)->age : 'N/A');
            $sheet->setCellValue('F' . $row, $profile ? number_format($profile->volunteer_rating, 1) : '0.0');
            $sheet->setCellValue('G' . $row, $app->opportunity->title);
            $sheet->setCellValue('H' . $row, $app->opportunity->organization->organization_name);
            $sheet->setCellValue('I' . $row, $app->status);
            $sheet->setCellValue('J' . $row, $app->applied_date->format('d/m/Y H:i'));
            $sheet->setCellValue('K' . $row, $app->reviewed_date ? $app->reviewed_date->format('d/m/Y') : '');
            $sheet->setCellValue('L' . $row, $daysPending);

            // Tô màu trạng thái
            $statusColor = match ($app->status) {
                'Accepted' => 'DCFCE7', // Green-100
                'Rejected' => 'FEE2E2', // Red-100
                'Pending' => 'FEF9C3',  // Yellow-100
                default => 'F3F4F6'     // Gray-100
            };
            $sheet->getStyle('I' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($statusColor);

            // Căn giữa các cột ngắn
            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('E' . $row . ':F' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('I' . $row . ':L' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $row++;
        }

        // -- Auto Size Columns --
        foreach (range('A', 'L') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // -- Xuất file --
        $filename = 'applications_export_' . date('Y-m-d_H-i') . '.xlsx';
        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
    /**
     * Display categories list
     */
    public function categories()
    {
        $categories = Category::withCount('opportunities')
            ->orderBy('display_order')
            ->get();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Store category
     */
    public function categoriesStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|string|max:50|unique:categories,category_name',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
            'color' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        Category::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Category created successfully'
        ]);
    }
    /**
     * Show edit category form
     */
    public function categoriesEdit($id)
    {
        $category = Category::findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $category
        ]);
    }

    /**
     * Update category
     */
    public function categoriesUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|string|max:50|unique:categories,category_name,' . $id . ',category_id',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
            'color' => 'nullable|string',
            'display_order' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $category = Category::findOrFail($id);
        $category->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully'
        ]);
    }

    /**
     * Delete category
     */
    public function categoriesDestroy($id)
    {
        try {
            $category = Category::findOrFail($id);

            // Check if category has opportunities
            if ($category->opportunities()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete category with existing opportunities'
                ], 400);
            }

            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete category'
            ], 500);
        }
    }

    /**
     * Toggle category active status
     */
    public function categoriesToggle($id)
    {
        $category = Category::findOrFail($id);
        $category->is_active = !$category->is_active;
        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Category status updated',
            'is_active' => $category->is_active
        ]);
    }
    /**
     * Display activities list
     */
    public function activities()
    {
        $activities = VolunteerActivity::with(['volunteer', 'opportunity', 'organization'])
            ->latest()
            ->paginate(15);

        return view('admin.activities.index', compact('activities'));
    }


    /**
     * Show activity details
     */
    public function showActivity($id)
    {
        $activity = VolunteerActivity::with([
            'volunteer.volunteerProfile',
            'opportunity.organization',
            'verifiedBy'
        ])->findOrFail($id);

        return view('admin.activities.show', compact('activity'));
    }

    /**
     * Display disputed activities
     */
    public function disputedActivities()
    {
        $activities = VolunteerActivity::with(['volunteer', 'opportunity', 'organization'])
            ->where('status', 'Disputed')
            ->latest()
            ->paginate(15);

        return view('admin.activities.disputes', compact('activities'));
    }

    /**
     * Resolve activity dispute
     */
    public function resolveDispute(Request $request, $id)
    {
        $activity = VolunteerActivity::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'resolution' => 'required|in:approve,reject',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            DB::beginTransaction();

            if ($request->resolution === 'approve') {
                $activity->update([
                    'status' => 'Verified',
                    'verified_by' => Auth::id(),
                    'verified_date' => now(),
                    'impact_notes' => $request->admin_notes,
                ]);

                // Update volunteer total hours
                $activity->volunteer->volunteerProfile->increment('total_volunteer_hours', $activity->hours_worked);

                $message = 'Activity approved and hours verified';
            } else {
                $activity->update([
                    'status' => 'Rejected',
                    'impact_notes' => $request->admin_notes,
                ]);

                $message = 'Activity rejected';
            }

            // Create notification for volunteer
            Notification::create([
                'user_id' => $activity->volunteer_id,
                'notification_type' => 'System',
                'title' => 'Activity Dispute Resolved',
                'content' => "Your disputed activity has been {$request->resolution}d by admin.",
                'related_id' => $activity->activity_id,
                'related_type' => 'activity',
                'priority' => 'high',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to resolve dispute'
            ], 500);
        }
    }

    /**
     * Display all reviews
     */
    public function allReviews()
    {
        $reviews = Review::with(['reviewer', 'reviewee', 'opportunity'])
            ->latest()
            ->paginate(15);

        $stats = [
            'total' => Review::count(),
            'pending' => Review::where('is_approved', false)->count(),
            'approved' => Review::where('is_approved', true)->count(),
            'average_rating' => Review::where('is_approved', true)->avg('rating'),
        ];

        return view('admin.reviews.all', compact('reviews', 'stats'));
    }
    /**
     * Display reviews list
     */
    public function reviews()
    {
        $reviews = Review::with(['reviewer', 'reviewee', 'opportunity'])
            ->latest()
            ->paginate(15);

        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Display analytics
     */
    public function analytics()
    {
        $analytics = [
            'total_volunteer_hours' => VolunteerActivity::where('status', 'Verified')->sum('hours_worked'),
            'average_rating' => Review::where('is_approved', true)->avg('rating'),
            'conversion_rate' => Application::where('status', 'Accepted')->count() / max(Application::count(), 1) * 100,
        ];

        return view('admin.analytics', compact('analytics'));
    }

    /**
     * Display reports
     */
    public function reports()
    {
        return view('admin.reports.index');
    }

    /**
     * Generate report
     */
    public function reportsGenerate(Request $request)
    {
        $type = $request->type;
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        // Generate report based on type
        // Implementation depends on requirements

        return response()->json([
            'success' => true,
            'message' => 'Report generated successfully'
        ]);
    }

    /**
     * Display settings
     */
    public function settings()
    {
        // Lấy toàn bộ settings từ DB và chuyển thành mảng [key => value]
        $settings = DB::table('settings')->pluck('value', 'key')->toArray();

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update settings
     */
    public function updateSettings(Request $request)
    {
        // Danh sách các key hợp lệ
        $validKeys = [
            'site_name',
            'contact_email',
            'site_description',
            'email_notifications',
            'mail_from_name',
            'mail_from_address',
            'allow_registration',
            'require_email_verification',
            'maintenance_mode',
            'maintenance_message'
        ];

        $data = $request->only($validKeys);

        // Xử lý checkbox (nếu không check thì không gửi lên, cần set false)
        $checkboxes = ['email_notifications', 'allow_registration', 'require_email_verification', 'maintenance_mode'];
        foreach ($checkboxes as $key) {
            $data[$key] = $request->has($key) ? '1' : '0';
        }

        // Lưu vào DB
        foreach ($data as $key => $value) {
            DB::table('settings')->updateOrInsert(
                ['key' => $key],
                ['value' => $value, 'updated_at' => now()]
            );

            // [QUAN TRỌNG] Xóa Cache của key này để hệ thống load lại giá trị mới
            \Illuminate\Support\Facades\Cache::forget('setting_' . $key);
        }

        // Cập nhật file .env nếu cần (Nâng cao - cẩn thận quyền ghi file)
        // ...

        // Kiểm tra chế độ bảo trì
        if ($data['maintenance_mode'] == '1') {
            // Có thể gọi Artisan::call('down');
        } else {
            // Artisan::call('up');
        }

        return redirect()->back()->with('success', 'System settings updated successfully.');
    }

    public function downloadUserTemplate()
    {
        $filename = 'users_import_template.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            // Header columns required for import
            fputcsv($file, ['first_name', 'last_name', 'email', 'phone', 'user_type', 'city', 'password']);
            // Example row
            fputcsv($file, ['John', 'Doe', 'john@example.com', '0123456789', 'Volunteer', 'Hanoi', 'password123']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function importUsers(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx',
        ]);

        $file = $request->file('file');
        $handle = fopen($file->getPathname(), 'r');

        // Bỏ qua dòng header
        fgetcsv($handle);

        $imported = 0;
        $errors = [];
        $rowNumber = 1;

        DB::beginTransaction();
        try {
            while (($data = fgetcsv($handle)) !== false) {
                $rowNumber++;

                // Giả sử thứ tự cột: first_name, last_name, email, phone, user_type, city, password
                if (count($data) < 7) {
                    $errors[] = "Row $rowNumber: Invalid format";
                    continue;
                }

                $email = $data[2];

                // Bỏ qua nếu email đã tồn tại (nếu checkbox skip_duplicates được chọn)
                if ($request->has('skip_duplicates') && User::where('email', $email)->exists()) {
                    continue;
                }

                try {
                    $user = User::create([
                        'first_name' => $data[0],
                        'last_name'  => $data[1],
                        'email'      => $email,
                        'phone'      => $data[3] ?: null,
                        'user_type'  => in_array($data[4], ['Volunteer', 'Organization']) ? $data[4] : 'Volunteer',
                        'city'       => $data[5],
                        'password'   => Hash::make($data[6]),
                        'is_active'  => true,
                        'is_verified' => true,
                    ]);

                    // Tạo profile tương ứng
                    if ($user->user_type === 'Volunteer') {
                        \App\Models\VolunteerProfile::create(['user_id' => $user->user_id]);
                    } elseif ($user->user_type === 'Organization') {
                        \App\Models\Organization::create([
                            'user_id' => $user->user_id,
                            'organization_name' => $user->first_name . ' ' . $user->last_name,
                            'verification_status' => 'Verified'
                        ]);
                    }

                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = "Row $rowNumber: " . $e->getMessage();
                }
            }

            DB::commit();
            fclose($handle);

            if (count($errors) > 0) {
                return response()->json([
                    'success' => true, // Vẫn trả về true để reload, nhưng kèm cảnh báo
                    'message' => "Imported $imported users with some errors.",
                    'errors' => $errors
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => "Successfully imported $imported users."
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            fclose($handle);
            return response()->json([
                'success' => false,
                'message' => 'Import failed: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * API: Get opportunities by category
     */
    public function getCategoryOpportunities($id)
    {
        $opportunities = VolunteerOpportunity::where('category_id', $id)
            ->with('organization') // Eager load để lấy tên tổ chức
            ->select('opportunity_id', 'title', 'org_id', 'status', 'created_at')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $opportunities
        ]);
    }
    public function pendingActivities(Request $request)
    {
        $query = VolunteerActivity::with(['volunteer', 'opportunity', 'organization'])
            ->where('status', 'Pending');

        // Filter logic (Search, Org, Date...) giống như file pending.blade.php cần
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('volunteer', function ($q) use ($search) {
                $q->where('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('org_id')) {
            $query->where('org_id', $request->org_id);
        }

        $activities = $query->latest()->paginate(20);

        // Lấy danh sách organization để fill vào dropdown filter
        $organizations = \App\Models\Organization::select('org_id', 'organization_name')->get();

        return view('admin.activities.pending', compact('activities', 'organizations'));
    }
}
