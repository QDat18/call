<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class CacheResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  int  $ttl  Time to live in seconds
     * @return mixed
     */
    public function handle(Request $request, Closure $next, int $ttl = 60)
    {
        // Only cache GET requests
        if ($request->method() !== 'GET') {
            return $next($request);
        }

        // Avoid caching for logged-in users to ensure personal data (favorites, etc.) is correct
        // Unless it's an AJAX request for a partial list (which we can cache safely)
        if (Auth::check() && !$request->ajax()) {
            return $next($request);
        }

        // Generate a cache key based on the URL and query parameters
        $url = $request->fullUrl();
        $cacheKey = 'page_cache_' . md5($url . ($request->ajax() ? '_ajax' : ''));

        // If we have a cached response, return it
        // We use tags if supported by the driver (Redis supports it)
        $cachedResponse = Cache::tags(['page_cache', 'opportunities'])->get($cacheKey);

        if ($cachedResponse) {
            return response($cachedResponse)
                ->header('X-Cache', 'HIT')
                ->header('Content-Type', $request->ajax() ? 'text/html' : 'text/html; charset=UTF-8');
        }

        // Get the response
        $response = $next($request);

        // Cache the response content if it's successful
        if ($response->isSuccessful()) {
            Cache::tags(['page_cache', 'opportunities'])->put($cacheKey, $response->getContent(), $ttl);
            $response->header('X-Cache', 'MISS');
        }

        return $response;
    }
}
