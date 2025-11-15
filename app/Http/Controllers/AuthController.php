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
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
            'email.required' => 'Email address is required',
            'email.email' => 'Please enter a valid email address',
            'email.unique' => 'This email is already registered',
            'phone.required' => 'Phone number is required',
            'phone.unique' => 'This phone number is already registered',
            'date_of_birth.required' => 'Date of birth is required',
            'date_of_birth.before' => 'You must be at least 16 years old to register',
            'gender.required' => 'Please select your gender',
            'city.required' => 'Please select your city',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters',
            'password.confirmed' => 'Password confirmation does not match',
            'terms.accepted' => 'You must agree to the terms and conditions',
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
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'city' => $request->city,
                'district' => $request->district,
                'address' => $request->address,
                'user_type' => 'Volunteer',
                'is_active' => true,
                'is_verified' => false,
            ]);

            // Create volunteer profile
            VolunteerProfile::create([
                'user_id' => $user->user_id,
                'total_volunteer_hours' => 0,
                'volunteer_rating' => 0.00,
            ]);

            DB::commit();

            // Auto login
            Auth::login($user);

            // Update last login
            $user->update(['last_login_at' => now()]);

            // return redirect() -> route('home')
            //     ->with('success', 'Welcome to VolunteerConnect! Your account has been created.')
            //     ->with('show_profile_toast', true);

            return redirect()->route('volunteer.profile.edit')
                ->with('success', 'Chào mừng bạn! Vui lòng hoàn thiện hồ sơ và xác thực tài khoản.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Registration failed. Please try again.')
                ->withInput();
        }
    }

    /**
     * Register a new organization
     */
    public function registerOrganization(Request $request)
    {
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
            'first_name.required' => 'Representative first name is required',
            'last_name.required' => 'Representative last name is required',
            'email.required' => 'Official email address is required',
            'email.unique' => 'This email is already registered',
            'phone.required' => 'Phone number is required',
            'phone.unique' => 'This phone number is already registered',
            'city.required' => 'Please select your city',
            'district.required' => 'District is required',
            'address.required' => 'Full address is required',
            'organization_name.required' => 'Organization name is required',
            'organization_type.required' => 'Please select organization type',
            'description.required' => 'Organization description is required',
            'description.max' => 'Description cannot exceed 500 characters',
            'registration_number.required' => 'Registration number is required',
            'founded_year.required' => 'Founded year is required',
            'founded_year.max' => 'Founded year cannot be in the future',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters',
            'password.confirmed' => 'Password confirmation does not match',
            'terms.accepted' => 'You must agree to the terms and conditions',
            'verify_info.accepted' => 'You must confirm the accuracy of the information',
            'registration_document.required' => 'Please upload authentication documents',
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
            ]);

            $logoPath = null;
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('logos', 'public');
            }
            $documentPath = null;
            if ($request->hasFile('registration_document')) {
                $documentPath = $request->file('registration_document')->store('documents', 'public');
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

            // Create notification for admin (if notification system exists)
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

            // Auto login
            // Auth::login($user);

            // // Update last login
            // $user->update(['last_login_at' => now()]);

            return redirect()->route('login')
                ->with('success', 'Đăng ký thành công! Tài khoản của bạn đang chờ quản trị viên xét duyệt.');

            // return redirect()->route('home')
            //     ->with('success', 'Welcome to VolunteerConnect! Your organization has been registered. Please submit verification documents to get verified badge.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Registration failed. Please try again.')
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
            'email.required' => 'Email address is required',
            'email.email' => 'Please enter a valid email address',
            'password.required' => 'Password is required',
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
                ->with('error', 'No account found with this email address.')
                ->withInput($request->only('email', 'remember'));
        }

        if (!$user->is_active) {
            return redirect()->back()
                ->with('error', 'Your account has been deactivated. Please contact support.')
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
            // Update last login
            $user->update(['last_login_at' => now()]);

            // Redirect based on user type
            $redirectRoute = match ($user->user_type) {
                'Admin' => route('admin.dashboard'),
                'Organization' => route('organization.dashboard'),
                'Volunteer' => route('volunteer.dashboard'),
                default => route('home'),
            };

            return redirect()->intended($redirectRoute)
                ->with('success', 'Welcome back, ' . $user->first_name . '!');
        }

        return redirect()->back()
            ->with('error', 'Invalid email or password.')
            ->withInput($request->only('email', 'remember'));
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'You have been logged out successfully.');
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
            'email.required' => 'Email address is required',
            'email.email' => 'Please enter a valid email address',
            'email.exists' => 'We could not find an account with this email address',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'We have emailed your password reset link!')
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Show reset password form
     */
    public function showResetPasswordForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    /**
     * Handle password reset
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ], [
            'email.required' => 'Email address is required',
            'email.email' => 'Please enter a valid email address',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters',
            'password.confirmed' => 'Password confirmation does not match',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Your password has been reset successfully!')
            : back()->withErrors(['email' => [__($status)]]);
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
                ->with('error', 'Unable to connect to Google. Please try again later.');
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
                        ->with('error', 'Your account has been deactivated. Please contact support.');
                }

                Auth::login($user);
                $user->update(['last_login_at' => now()]);

                $redirectRoute = match ($user->user_type) {
                    'Admin' => route('admin.dashboard'),
                    'Organization' => route('organization.dashboard'),
                    'Volunteer' => route('volunteer.dashboard'),
                    default => route('home'),
                };

                return redirect()->intended($redirectRoute)
                    ->with('success', 'Welcome back, ' . $user->first_name . '!');
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
                    'password' => Hash::make(Str::random(16)), // Random password
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'user_type' => 'Volunteer',
                    'is_active' => true,
                    'is_verified' => true, // Auto verify OAuth users
                    'avatar_url' => $googleUser->avatar,
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
                $user->update(['last_login_at' => now()]);

                return redirect()->route('volunteer.profile.edit')
                    ->with('success', 'Chào mừng bạn! Vui lòng hoàn thiện hồ sơ và xác thực tài khoản.');
            } catch (Exception $e) {
                DB::rollBack();
                return redirect()->route('login')
                    ->with('error', 'Failed to create account. Please try again.');
            }
        } catch (Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Failed to authenticate with Google. Please try again.');
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
                ->with('error', 'Unable to connect to Facebook. Please try again later.');
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
                        ->with('error', 'Your account has been deactivated. Please contact support.');
                }

                Auth::login($user);
                $user->update(['last_login_at' => now()]);

                $redirectRoute = match ($user->user_type) {
                    'Admin' => route('admin.dashboard'),
                    'Organization' => route('organization.dashboard'),
                    'Volunteer' => route('volunteer.dashboard'),
                    default => route('home'),
                };

                return redirect()->intended($redirectRoute)
                    ->with('success', 'Welcome back, ' . $user->first_name . '!');
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
                    'password' => Hash::make(Str::random(16)), // Random password
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'user_type' => 'Volunteer',
                    'is_active' => true,
                    'is_verified' => true, // Auto verify OAuth users
                    'avatar_url' => $facebookUser->avatar,
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
                $user->update(['last_login_at' => now()]);

                return redirect()->route('home')
                    ->with('success', 'Welcome to VolunteerConnect! Your account has been created successfully.');
            } catch (Exception $e) {
                DB::rollBack();
                return redirect()->route('login')
                    ->with('error', 'Failed to create account. Please try again.');
            }
        } catch (Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Failed to authenticate with Facebook. Please try again.');
        }
    }
}
