<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Nếu chế độ bảo trì đang TẮT -> Cho qua luôn
        if (get_setting('maintenance_mode') !== '1') {
            return $next($request);
        }

        // 2. Những Route ĐƯỢC PHÉP truy cập khi bảo trì (Whitelist)
        // Bao gồm: trang login, xử lý login, logout, và các route admin
        $excludedRoutes = [
            'login',           // Route hiển thị form login
            'login/*',         // Các xử lý login
            'logout',          // Route logout
            'admin/*',         // Các route admin (để admin còn vào mà tắt bảo trì)
            'api/*',           // (Tùy chọn) Nếu muốn API vẫn chạy
            'emergency-unlock-maintenance',
        ];

        foreach ($excludedRoutes as $route) {
            if ($request->is($route)) {
                return $next($request);
            }
        }

        // 3. Nếu là Admin đã đăng nhập -> Cho qua
        if (auth()->check() && auth()->user()->user_type === 'Admin') {
            return $next($request);
        }

        // 4. Các trường hợp còn lại -> Chặn và báo lỗi 503
        abort(503, get_setting('maintenance_message', 'Hệ thống đang bảo trì. Vui lòng quay lại sau.'));
    }
}