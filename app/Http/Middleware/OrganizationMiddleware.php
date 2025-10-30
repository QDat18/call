<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizationMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để tiếp tục');
        }

        // Check if user is Organization
        if (Auth::user()->user_type !== 'Organization') {
            abort(403, 'Chỉ tổ chức mới có quyền truy cập trang này');
        }

        // IMPORTANT: Allow access to profile and verification pages even if not verified
        $allowedRoutes = [
            'organization.profile.show',
            'organization.profile.edit',
            'organization.profile.update',
            'organization.verification.request',
            'organization.verification.submit',
            'organization.verification.documents',
            'organization.dashboard', // Also allow dashboard
        ];

        // If accessing allowed routes, let them through
        if (in_array($request->route()->getName(), $allowedRoutes)) {
            return $next($request);
        }

        // For other routes, check verification status
        $organization = Auth::user()->organization;
        
        if ($organization && $organization->verification_status !== 'Verified') {
            // Only show warning message, don't block access
            // This allows unverified organizations to still use basic features
            if (!session()->has('verification_warning_shown')) {
                session()->flash('warning', 'Tài khoản tổ chức của bạn đang chờ xác minh. Vui lòng hoàn tất xác minh để mở khóa đầy đủ tính năng.');
                session(['verification_warning_shown' => true]);
            }
        }

        return $next($request);
    }
}