<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail; // Import Mail
use App\Mail\OrganizationApproved;     // Import Mail Class
use App\Mail\OrganizationRejected;     // Import Mail Class

class OrganizationVerificationController extends Controller
{
    // ... (giữ nguyên phần index và construct) ...
    public function index(Request $request)
    {
        $query = Organization::with('user');

        $status = $request->get('status', 'Pending');
        $query->where('verification_status', $status);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('organization_name', 'LIKE', "%{$search}%");
        }

        $organizations = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.organizations.verification', compact('organizations', 'status'));
    }

    public function show($id)
    {
        $organization = Organization::with('user')->findOrFail($id);
        $stats = [
            'total_opportunities' => $organization->opportunities()->count(),
            'active_opportunities' => $organization->opportunities()->where('status', 'Active')->count(),
            'total_volunteers' => $organization->total_volunteers,
            'total_hours_received' => $organization->total_hours,
        ];
        return view('admin.organizations.show', compact('organization', 'stats'));
    }

    public function approve(Request $request, $id)
    {
        $organization = Organization::with('user')->findOrFail($id);

        $organization->verification_status = 'Verified';
        $organization->save();

        if ($organization->user) {
            $organization->user->is_verified = true;
            $organization->user->save();

            // Gửi mail
            if ($organization->user->email) {
                try {
                    Mail::to($organization->user->email)->send(new OrganizationApproved($organization));
                } catch (\Exception $e) {
                }
            }
        }

        $message = 'Organization approved successfully.';

        // Nếu là Ajax/Fetch (từ trang show), trả về JSON
        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        // Nếu là Form thường, redirect
        return redirect()->back()->with('success', $message);
    }

    public function reject(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'rejection_reason' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $organization = Organization::with('user')->findOrFail($id);

        $organization->verification_status = 'Rejected';
        $organization->rejection_reason = $request->rejection_reason;
        $organization->save();

        if ($organization->user && $organization->user->email) {
            try {
                Mail::to($organization->user->email)->send(new OrganizationRejected($organization, $request->rejection_reason));
            } catch (\Exception $e) {
            }
        }

        $message = 'Organization rejected successfully.';

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        return redirect()->back()->with('success', $message);
    }

    public function destroy(Request $request, $id)
    {
        try {
            $organization = Organization::findOrFail($id);

            // Xóa tổ chức (Cascade sẽ tự xóa các quan hệ nếu bạn đã cài đặt trong migration)
            $organization->delete();

            $message = 'Organization deleted successfully.';

            if ($request->wantsJson()) {
                return response()->json(['success' => true, 'message' => $message]);
            }

            return redirect()->route('admin.organizations.index')->with('success', $message);
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Failed to delete: ' . $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', 'Failed to delete organization.');
        }
    }


    public function requestDocuments(Request $request, $id)
    {
        // ... (Giữ nguyên logic request documents) ...
        $validator = Validator::make($request->all(), [
            'document_request' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $organization = Organization::findOrFail($id);

        // Có thể thêm gửi mail yêu cầu tài liệu ở đây tương tự như trên

        return redirect()->back()->with('success', 'Document request has been sent to the organization.');
    }
}
