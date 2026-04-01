<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Fortify\Features;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login page.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('auth/login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // $user = $request->validateCredentials();

        $email = $request->input('email');
        $user = User::where('email', $email)->first();

        // 1. KIỂM TRA: Nếu tài khoản đã bị khóa (is_active = 0) -> Chặn luôn
        if ($user && !$user->is_active) {
            throw ValidationException::withMessages([
                'email' => 'Tài khoản của bạn đã bị vô hiệu hóa do nhập sai quá nhiều lần. Vui lòng liên hệ Admin.',
            ]);
        }

        // Key định danh để đếm lỗi (login_fail_ + UserID)
        $limiterKey = $user ? 'login_fail_' . $user->id : null;

        try {
            // 2. THỬ ĐĂNG NHẬP (Hàm này sẽ ném lỗi nếu sai pass)
            $user = $request->validateCredentials();

            // === NẾU ĐĂNG NHẬP THÀNH CÔNG ===
            // Xóa bộ đếm lỗi cũ nếu có
            if ($limiterKey) {
                RateLimiter::clear($limiterKey);
            }
        } catch (ValidationException $e) {
            // === NẾU ĐĂNG NHẬP THẤT BẠI (Sai mật khẩu) ===
            if ($user && $limiterKey) {
                // Tăng bộ đếm lỗi
                RateLimiter::hit($limiterKey);

                // Kiểm tra nếu sai quá 7 lần -> KHÓA TÀI KHOẢN
                if (RateLimiter::attempts($limiterKey) >= 7) {
                    $user->update(['is_active' => false]);

                    // Reset bộ đếm để lần sau vào check ngay điều kiện số 1 (is_active)
                    RateLimiter::clear($limiterKey);
                }
            }

            // Ném lại lỗi ra ngoài để hiển thị "Mật khẩu không đúng"
            throw $e;
        }
        if (Features::enabled(Features::twoFactorAuthentication()) && $user->hasEnabledTwoFactorAuthentication()) {
            $request->session()->put([
                'login.id' => $user->getKey(),
                'login.remember' => $request->boolean('remember'),
            ]);

            return to_route('two-factor.login');
        }

        Auth::login($user, $request->boolean('remember'));

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
