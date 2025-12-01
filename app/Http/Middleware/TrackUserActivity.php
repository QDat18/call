<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class TrackUserActivity
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        
        // Cập nhật hoạt động nếu user đã đăng nhập
        if (Auth::check() && $this->shouldTrack($request)) {
            $user = Auth::user();
            
            // Cập nhật last_activity_at trong database
            $user->update(['last_activity_at' => now()]);
            
            // Cập nhật cache presence
            $cacheKey = 'user-online-' . $user->user_id;
            Cache::put($cacheKey, true, now()->addMinutes(5));
        }
        
        return $response;
    }
    
    private function shouldTrack(Request $request): bool
    {
        // Loại trừ các route không cần track
        $excludedPaths = [
            'api/',
            'broadcasting/',
            'horizon/',
            'telescope/',
            'storage/',
            'vendor/',
            '_debugbar/',
        ];
        
        $currentPath = $request->path();
        
        foreach ($excludedPaths as $path) {
            if (str_starts_with($currentPath, $path)) {
                return false;
            }
        }
        
        // Chỉ track GET requests và không phải AJAX
        return $request->method() === 'GET' && !$request->ajax();
    }
}