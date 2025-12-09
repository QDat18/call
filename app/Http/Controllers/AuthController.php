<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VolunteerProfile;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationEmail;
use Exception;

class AuthController extends Controller
{
    /**
     * Show main registration page (choose account type)
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Show volunteer registration form
     */
    public function showVolunteerRegisterForm()
    {
        return view('auth.register-volunteer');
    }

    /**
     * Show organization registration form
     */
    public function showOrganizationRegisterForm()
    {
        return view('auth.register-organization');
    }

    /**
     * Register a new volunteer
     */
    public function registerVolunteer(Request $request)
    {
        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser) {
            if ($existingUser->user_type === 'Organization') {
                return redirect()->back()->withInput()->withErrors([
                    'email' => 'Email này đã được đăng ký tài khoản Tổ chức. Vui lòng sử dụng email khác hoặc đăng nhập.'
                ]);
            }
            if ($existingUser->user_type === 'Admin') {
                return redirect()->back()->withInput()->withErrors([
                    'email' => 'Email này đã được đăng ký tài khoản Quản trị viên.'
                ]);
            }
        }

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:15|unique:users',
            'date_of_birth' => 'required|date|before:-16 years',
            'gender' => 'required|in:Male,Female,Other',
            'city' => 'required|string|max:50',
            'district' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'terms' => 'required|accepted',
        ], [
            'first_name.required' => 'Họ là bắt buộc',
            'last_name.required' => 'Tên là bắt buộc',
            'email.required' => 'Email là bắt buộc',
            'email.email' => 'Vui lòng nhập địa chỉ email hợp lệ',
            'email.unique' => 'Email này đã được đăng ký',
            'phone.required' => 'Số điện thoại là bắt buộc',
            'phone.unique' => 'Số điện thoại này đã được đăng ký',
            'date_of_birth.required' => 'Ngày sinh là bắt buộc',
            'date_of_birth.before' => 'Bạn phải ít nhất 16 tuổi để đăng ký',
            'gender.required' => 'Vui lòng chọn giới tính',
            'city.required' => 'Vui lòng chọn thành phố',
            'password.required' => 'Mật khẩu là bắt buộc',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
            'terms.accepted' => 'Bạn phải đồng ý với điều khoản và điều kiện',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        try {
            // 1. Tạo Verification Token
            $verificationToken = Str::random(64);

            // 2. Create user (Thêm verification_token vào mảng create)
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'city' => $request->city,
                'district' => $request->district,
                'address' => $request->address,
                'user_type' => 'Volunteer',
                'is_active' => true,
                'is_verified' => false, // Mặc định là chưa xác thực
                'verification_token' => $verificationToken, // Lưu token
                'last_activity_at' => now(),
            ]);

            VolunteerProfile::create([
                'user_id' => $user->user_id,
                'total_volunteer_hours' => 0,
                'volunteer_rating' => 0.00,
            ]);

            // 3. Gửi Email xác thực
            try {
                Mail::to($user->email)->send(new VerificationEmail($user, $verificationToken));
            } catch (\Exception $e) {
                \Log::error('Lỗi gửi mail xác thực: ' . $e->getMessage());
                // Không rollback DB nếu lỗi gửi mail, chỉ log lại để admin biết
            }

            DB::commit();

            // 4. Auto login
            Auth::login($user);

            $user->update([
                'last_login_at' => now(),
                'last_activity_at' => now()
            ]);

            // 5. Redirect kèm thông báo check mail
            return redirect()->route('volunteer.profile.edit')
                ->with('warning', 'Đăng ký thành công! Vui lòng kiểm tra email để xác thực tài khoản của bạn.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Đăng ký thất bại. Vui lòng thử lại: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function verifyEmail($token)
    {
        $user = User::where('verification_token', $token)->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Liên kết xác thực không hợp lệ.');
        }

        $user->email_verified_at = now();
        $user->is_verified = true;
        $user->verification_token = null;
        $user->save();

        if (!Auth::check()) {
            Auth::login($user);
        }
        return redirect()->route('home')->with('success', 'Tài khoản của bạn đã được xác thực thành công!');
    }

    public function resendVerificationEmail(Request $request)
    {
        $user = Auth::user();

        if ($user->email_verified_at) {
            return back()->with('info', 'Tài khoản của bạn đã được xác thực rồi.');
        }

        $token = Str::random(64);
        $user->verification_token = $token;
        $user->save();
        try {
            Mail::to($user->email)->send(new VerificationEmail($user, $token));
            return back()->with('success', 'Đã gửi lại email xác thực. Vui lòng kiểm tra hộp thư.');
        } catch (\Exception $e) {
            \Log::error('Lỗi gửi mail xác thực: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Không thể gửi email xác thực. Vui lòng thử lại sau.');
        }
    }

    /**
     * Register a new organization
     */
    public function registerOrganization(Request $request)
    {
        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser) {
            if ($existingUser->user_type === 'Volunteer') {
                return redirect()->back()->withInput()->withErrors([
                    'email' => 'Email này đã được đăng ký tài khoản Tình nguyện viên. Vui lòng sử dụng email khác hoặc đăng nhập.'
                ]);
            }
            if ($existingUser->user_type === 'Admin') {
                return redirect()->back()->withInput()->withErrors([
                    'email' => 'Email này đã được đăng ký tài khoản Quản trị viên.'
                ]);
            }
        }

        $validator = Validator::make($request->all(), [
            // User information
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:15|unique:users',
            'city' => 'required|string|max:50',
            'district' => 'required|string|max:50',
            'address' => 'required|string',

            // Organization information
            'organization_name' => 'required|string|max:150',
            'organization_type' => 'required|in:NGO,NPO,Charity,School,Hospital,Community Group',
            'description' => 'required|string|max:500',
            'mission_statement' => 'nullable|string',
            'registration_number' => 'required|string|max:50',
            'website' => 'nullable|url|max:100',
            'contact_person' => 'nullable|string|max:100',
            'founded_year' => 'required|integer|min:1900|max:' . date('Y'),
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'registration_document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',

            // Terms
            'terms' => 'required|accepted',
            'verify_info' => 'required|accepted',
        ], [
            'first_name.required' => 'Họ người đại diện là bắt buộc',
            'last_name.required' => 'Tên người đại diện là bắt buộc',
            'email.required' => 'Email chính thức là bắt buộc',
            'email.unique' => 'Email này đã được đăng ký',
            'phone.required' => 'Số điện thoại là bắt buộc',
            'phone.unique' => 'Số điện thoại này đã được đăng ký',
            'city.required' => 'Vui lòng chọn thành phố',
            'district.required' => 'Quận/huyện là bắt buộc',
            'address.required' => 'Địa chỉ đầy đủ là bắt buộc',
            'organization_name.required' => 'Tên tổ chức là bắt buộc',
            'organization_type.required' => 'Vui lòng chọn loại tổ chức',
            'description.required' => 'Mô tả tổ chức là bắt buộc',
            'description.max' => 'Mô tả không được vượt quá 500 ký tự',
            'registration_number.required' => 'Mã số đăng ký là bắt buộc',
            'founded_year.required' => 'Năm thành lập là bắt buộc',
            'founded_year.max' => 'Năm thành lập không thể ở tương lai',
            'password.required' => 'Mật khẩu là bắt buộc',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
            'terms.accepted' => 'Bạn phải đồng ý với điều khoản và điều kiện',
            'verify_info.accepted' => 'Bạn phải xác nhận tính chính xác của thông tin',
            'registration_document.required' => 'Vui lòng tải lên tài liệu xác thực',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        try {
            // Create user
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'city' => $request->city,
                'district' => $request->district,
                'address' => $request->address,
                'user_type' => 'Organization',
                'is_active' => true,
                'is_verified' => false,
                'last_activity_at' => now(), // THÊM: Cập nhật last_activity_at khi đăng ký
            ]);

            $logoPath = null;
            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $safeName = Str::slug($request->organization_name);
                $fileName = $safeName . '_logo.' . $file->getClientOriginalExtension();
                $logoPath = $file->storeAs('logos', $fileName, 'public');
            }

            $documentPath = null;
            if ($request->hasFile('registration_document')) {
                $file = $request->file('registration_document');
                $safeName = Str::slug($request->organization_name);
                $fileName = $safeName . '_xacthuc.' . $file->getClientOriginalExtension();
                $documentPath = $file->storeAs('documents', $fileName, 'public');
            }

            // Create organization
            Organization::create([
                'user_id' => $user->user_id,
                'organization_name' => $request->organization_name,
                'organization_type' => $request->organization_type,
                'description' => $request->description,
                'mission_statement' => $request->mission_statement,
                'website' => $request->website,
                'contact_person' => $request->contact_person,
                'registration_number' => $request->registration_number,
                'verification_status' => 'Pending',
                'founded_year' => $request->founded_year,
                'volunteer_count' => 0,
                'rating' => 0.00,
                'total_opportunities' => 0,
            ]);

            // Create notification for admin
            try {
                \App\Models\Notification::create([
                    'user_id' => 1, // Admin user ID
                    'notification_type' => 'System',
                    'title' => 'New Organization Registration',
                    'content' => $request->organization_name . ' has registered and needs verification',
                    'related_type' => 'user',
                    'related_id' => $user->user_id,
                    'priority' => 'high',
                ]);
            } catch (\Exception $e) {
                // Notification creation failed, but continue
            }

            DB::commit();

            return redirect()->route('login')
                ->with('success', 'Đăng ký thành công! Tài khoản của bạn đang chờ quản trị viên xét duyệt.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Đăng ký thất bại. Vui lòng thử lại.')
                ->withInput();
        }
    }

    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email là bắt buộc',
            'email.email' => 'Vui lòng nhập địa chỉ email hợp lệ',
            'password.required' => 'Mật khẩu là bắt buộc',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->only('email', 'remember'));
        }

        // Check if user exists
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()
                ->with('error', 'Không tìm thấy tài khoản với email này.')
                ->withInput($request->only('email', 'remember'));
        }

        if (!$user->is_active) {
            return redirect()->back()
                ->with('error', 'Tài khoản của bạn đã bị vô hiệu hóa. Vui lòng liên hệ hỗ trợ.')
                ->withInput($request->only('email', 'remember'));
        }

        // Attempt login
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {

            if ($user->user_type == 'Organization') {
                $organization = $user->organization;
                if ($organization && $organization->verification_status == 'Pending') {
                    Auth::logout();
                    return redirect()->back()
                        ->with('error', 'Tài khoản của bạn đang chờ xét duyệt. Vui lòng thử lại sau.')
                        ->withInput($request->only('email', 'remember'));
                }
                if ($organization && $organization->verification_status == 'Rejected') {
                    Auth::logout();
                    return redirect()->back()
                        ->with('error', 'Tài khoản của bạn đã bị từ chối. Vui lòng liên hệ hỗ trợ')
                        ->withInput($request->only('email', 'remember'));
                }
            }

            $request->session()->regenerate();

            // SỬA: Update last login và last activity
            $user->update([
                'last_login_at' => now(),
                'last_activity_at' => now() // THÊM: Cập nhật last_activity_at khi login
            ]);

            // Redirect based on user type
            $redirectRoute = match ($user->user_type) {
                'Admin' => route('admin.dashboard'),
                'Organization' => route('organization.dashboard'),
                'Volunteer' => route('volunteer.dashboard'),
                default => route('home'),
            };

            return redirect()->intended($redirectRoute)
                ->with('success', 'Chào mừng trở lại, ' . $user->first_name . '!');
        }

        return redirect()->back()
            ->with('error', 'Email hoặc mật khẩu không đúng.')
            ->withInput($request->only('email', 'remember'));
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        // THÊM: Cập nhật last_activity_at trước khi logout
        if (Auth::check()) {
            Auth::user()->update(['last_activity_at' => now()]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Bạn đã đăng xuất thành công.');
    }

    /**
     * Show forgot password form
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send password reset link
     */
    public function sendResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Email là bắt buộc',
            'email.email' => 'Vui lòng nhập địa chỉ email hợp lệ',
            'email.exists' => 'Không tìm thấy tài khoản với email này',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return back()->withErrors(['email' => 'Không tìm thấy tài khoản với email này.']);
            }

            // Generate reset token
            $token = Str::random(60);

            // Save token to user
            $user->update([
                'reset_password_token' => $token,
                'reset_password_token_expires_at' => now()->addHours(1)
            ]);

            \Log::info("Attempting to send reset email to: " . $user->email);

            // GỬI EMAIL THẬT - SỬ DỤNG ResetPasswordEmail
            Mail::to($user->email)->send(new \App\Mail\ResetPasswordEmail($user, $token));

            \Log::info("Reset email sent successfully to: " . $user->email);

            return back()->with('status', 'Chúng tôi đã gửi liên kết đặt lại mật khẩu đến email của bạn!');
        } catch (\Exception $e) {
            \Log::error('Password reset error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return back()->withErrors(['email' => 'Có lỗi xảy ra khi gửi email. Vui lòng thử lại sau.']);
        }
    }
    /**
     * Show reset password form
     */
    public function showResetPasswordForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email // Lấy email từ query string để điền sẵn vào form
        ]);
    }

    /**
     * Handle password reset
     */
    public function resetPassword(Request $request)
    {
        // 1. Validate
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        // 2. Tìm user khớp email và token
        $user = User::where('email', $request->email)
            ->where('reset_password_token', $request->token)
            ->first();

        // 3. Kiểm tra user và thời hạn token
        if (!$user) {
            return back()->withErrors(['email' => 'Email hoặc mã xác thực không không chính xác.']);
        }

        if ($user->reset_password_token_expires_at && $user->reset_password_token_expires_at < now()) {
            return back()->withErrors(['email' => 'Liên kết đặt lại mật khẩu đã hết hạn.']);
        }

        // 4. Đổi mật khẩu thành công
        $user->forceFill([
            'password' => Hash::make($request->password),
            'reset_password_token' => null, // Xóa token sau khi dùng
            'reset_password_token_expires_at' => null,
        ])->save();

        return redirect()->route('login')->with('success', 'Mật khẩu đã được đặt lại thành công! Vui lòng đăng nhập.');
    }

    /**
     * Redirect to Google OAuth
     */
    public function redirectToGoogle()
    {
        try {
            return Socialite::driver('google')->redirect();
        } catch (Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Không thể kết nối với Google. Vui lòng thử lại sau.');
        }
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Check if user exists
            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                // User exists, login
                if (!$user->is_active) {
                    return redirect()->route('login')
                        ->with('error', 'Tài khoản của bạn đã bị vô hiệu hóa. Vui lòng liên hệ hỗ trợ.');
                }

                Auth::login($user);

                // SỬA: Update last login và last activity
                $user->update([
                    'last_login_at' => now(),
                    'last_activity_at' => now() // THÊM: Cập nhật last_activity_at khi login
                ]);

                $redirectRoute = match ($user->user_type) {
                    'Admin' => route('admin.dashboard'),
                    'Organization' => route('organization.dashboard'),
                    'Volunteer' => route('volunteer.dashboard'),
                    default => route('home'),
                };

                return redirect()->intended($redirectRoute)
                    ->with('success', 'Chào mừng trở lại, ' . $user->first_name . '!');
            }

            // New user - create account as Volunteer
            DB::beginTransaction();

            try {
                // Split name into first and last name
                $nameParts = explode(' ', $googleUser->name, 2);
                $firstName = $nameParts[0];
                $lastName = $nameParts[1] ?? '';

                $user = User::create([
                    'email' => $googleUser->email,
                    'password' => Hash::make(Str::random(16)),
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'user_type' => 'Volunteer',
                    'is_active' => true,
                    'is_verified' => true,
                    'avatar_url' => $googleUser->avatar,
                    'last_activity_at' => now(), // THÊM: Cập nhật last_activity_at khi đăng ký
                ]);

                // Create volunteer profile
                VolunteerProfile::create([
                    'user_id' => $user->user_id,
                    'total_volunteer_hours' => 0,
                    'volunteer_rating' => 0.00,
                ]);

                DB::commit();

                // Login
                Auth::login($user);

                // SỬA: Update last login và last activity
                $user->update([
                    'last_login_at' => now(),
                    'last_activity_at' => now() // THÊM: Cập nhật last_activity_at khi login
                ]);

                return redirect()->route('volunteer.profile.edit')
                    ->with('success', 'Chào mừng bạn! Vui lòng hoàn thiện hồ sơ và xác thực tài khoản.');
            } catch (Exception $e) {
                DB::rollBack();
                return redirect()->route('login')
                    ->with('error', 'Tạo tài khoản thất bại. Vui lòng thử lại.');
            }
        } catch (Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Xác thực với Google thất bại. Vui lòng thử lại.');
        }
    }

    /**
     * Redirect to Facebook OAuth
     */
    public function redirectToFacebook()
    {
        try {
            return Socialite::driver('facebook')->redirect();
        } catch (Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Không thể kết nối với Facebook. Vui lòng thử lại sau.');
        }
    }

    /**
     * Handle Facebook OAuth callback
     */
    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();

            // Check if user exists
            $user = User::where('email', $facebookUser->email)->first();

            if ($user) {
                // User exists, login
                if (!$user->is_active) {
                    return redirect()->route('login')
                        ->with('error', 'Tài khoản của bạn đã bị vô hiệu hóa. Vui lòng liên hệ hỗ trợ.');
                }

                Auth::login($user);

                // SỬA: Update last login và last activity
                $user->update([
                    'last_login_at' => now(),
                    'last_activity_at' => now() // THÊM: Cập nhật last_activity_at khi login
                ]);

                $redirectRoute = match ($user->user_type) {
                    'Admin' => route('admin.dashboard'),
                    'Organization' => route('organization.dashboard'),
                    'Volunteer' => route('volunteer.dashboard'),
                    default => route('home'),
                };

                return redirect()->intended($redirectRoute)
                    ->with('success', 'Chào mừng trở lại, ' . $user->first_name . '!');
            }

            // New user - create account as Volunteer
            DB::beginTransaction();

            try {
                // Split name into first and last name
                $nameParts = explode(' ', $facebookUser->name, 2);
                $firstName = $nameParts[0];
                $lastName = $nameParts[1] ?? '';

                $user = User::create([
                    'email' => $facebookUser->email,
                    'password' => Hash::make(Str::random(16)),
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'user_type' => 'Volunteer',
                    'is_active' => true,
                    'is_verified' => true,
                    'avatar_url' => $facebookUser->avatar,
                    'last_activity_at' => now(), // THÊM: Cập nhật last_activity_at khi đăng ký
                ]);

                // Create volunteer profile
                VolunteerProfile::create([
                    'user_id' => $user->user_id,
                    'total_volunteer_hours' => 0,
                    'volunteer_rating' => 0.00,
                ]);

                DB::commit();

                // Login
                Auth::login($user);

                // SỬA: Update last login và last activity
                $user->update([
                    'last_login_at' => now(),
                    'last_activity_at' => now() // THÊM: Cập nhật last_activity_at khi login
                ]);

                return redirect()->route('home')
                    ->with('success', 'Chào mừng đến với VolunteerConnect! Tài khoản của bạn đã được tạo thành công.');
            } catch (Exception $e) {
                DB::rollBack();
                return redirect()->route('login')
                    ->with('error', 'Tạo tài khoản thất bại. Vui lòng thử lại.');
            }
        } catch (Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Xác thực với Facebook thất bại. Vui lòng thử lại.');
        }
    }
}
