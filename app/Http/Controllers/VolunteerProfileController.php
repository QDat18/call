<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\VolunteerProfile;
use App\Mail\OTPVerificationEmail;
use Illuminate\Validation\Rule;

class VolunteerProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        if (!$user->isVolunteer()) {
            abort(403, 'Only volunteers can access this page!');
        }

        // Tạo profile nếu chưa có
        $profile = $user->volunteerProfile ?? VolunteerProfile::create(['user_id' => $user->user_id]);

        // THỐNG KÊ
        $stats = [
            'total_hours' => $profile->total_volunteer_hours ?? 0,
            'rating' => $profile->volunteer_rating ?? 0,
            'applications' => $user->applications()->count(),
            'accepted_applications' => $user->applications()->where('status', 'Accepted')->count(),
            'completed_activities' => $user->activities()->where('status', 'Verified')->count(),
            'reviews_count' => $user->receivedReviews()->where('is_approved', true)->count(),
        ];

        // THÀNH TỰU
        $achievements = [];
        $hours = $profile->total_volunteer_hours ?? 0;
        $rating = $profile->volunteer_rating ?? 0;

        if ($hours >= 10) {
            $achievements[] = ['name' => 'Bronze Volunteer', 'description' => '10 giờ tình nguyện', 'icon' => 'fas fa-medal', 'color' => 'bronze'];
        }
        if ($hours >= 50) {
            $achievements[] = ['name' => 'Silver Volunteer', 'description' => '50 giờ tình nguyện', 'icon' => 'fas fa-medal', 'color' => 'silver'];
        }
        if ($hours >= 100) {
            $achievements[] = ['name' => 'Gold Volunteer', 'description' => '100 giờ tình nguyện', 'icon' => 'fas fa-medal', 'color' => 'gold'];
        }
        if ($rating >= 4.5) {
            $achievements[] = ['name' => 'Top Rated', 'description' => 'Đánh giá 4.5+', 'icon' => 'fas fa-star', 'color' => 'yellow'];
        }

        return view('volunteer.profile.profile', compact('profile', 'stats', 'achievements'));
    }

    public function edit()
    {
        $user = Auth::user();
        if (!$user->isVolunteer()) {
            abort(403, 'Only volunteers can access this page!');
        }

        $profile = $user->volunteerProfile ?? VolunteerProfile::create(['user_id' => $user->user_id]);
        return view('volunteer.profile.edit-profile', compact('profile'));
    }

public function update(Request $request)
    {
        $user = Auth::user();

        // 1. Validation (Chỉ validate các trường có trong form)
        $validatedData = $request->validate([
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'occupation' => 'nullable|string|max:100',
            'education_level' => 'nullable|string',
            'bio' => 'nullable|string|max:2000',
            'skills' => 'nullable|string',
            'interests' => 'nullable|string',
        ]);

        try {
            // 2. Cập nhật Model USER (Chỉ avatar)
            if ($request->hasFile('avatar')) {
                // (Thêm logic xóa ảnh cũ nếu cần)
                $path = $request->file('avatar')->store('avatars', 'public');
                $user->avatar_url = $path;
                $user->save();
            }

            // 3. Cập nhật Model VOLUNTEERPROFILE
            // Sử dụng updateOrCreate để tự động tạo profile nếu nó chưa tồn tại
            VolunteerProfile::updateOrCreate(
                ['user_id' => $user->user_id], // Điều kiện tìm
                [ // Dữ liệu để cập nhật hoặc tạo mới
                    'occupation' => $validatedData['occupation'] ?? null,
                    'education_level' => $validatedData['education_level'] ?? null,
                    'bio' => $validatedData['bio'] ?? null,
                    'skills' => $validatedData['skills'] ?? null,
                    'interests' => $validatedData['interests'] ?? null,
                ]
            );

            // 4. Trả về JSON thành công
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật hồ sơ thành công!'
            ]);

        } catch (\Exception $e) {
            // 5. Trả về JSON lỗi
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi máy chủ: ' . $e->getMessage()
            ], 500); // Gửi mã 500
        }
    }

    public function updateSkills(Request $request)
    {
        $user = Auth::user();

        if (!$user->isVolunteer()) {
            return response()->json([
                'success' => false,
                'message' => 'Only volunteers can update skills'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'skills' => 'required|array',
            'skills.*' => 'string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $profile = $user->volunteerProfile;
        $profile->update([
            'skills' => implode(',', $request->skills)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Skills updated successfully'
        ]);
    }
    public function updateInterests(Request $request)
    {
        $user = Auth::user();

        if (!$user->isVolunteer()) {
            return response()->json([
                'success' => false,
                'message' => 'Only volunteers can update interests'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'interests' => 'required|array',
            'interests.*' => 'string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $profile = $user->volunteerProfile;
        $profile->update([
            'interests' => implode(',', $request->interests)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Interests updated successfully'
        ]);
    }

    /**
     * Update availability
     */
    public function updateAvailability(Request $request)
    {
        $user = Auth::user();

        if (!$user->isVolunteer()) {
            return response()->json([
                'success' => false,
                'message' => 'Only volunteers can update availability'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'availability' => 'required|in:Weekdays,Weekends,Flexible,Full-time',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $profile = $user->volunteerProfile;
        $profile->update([
            'availability' => $request->availability
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Availability updated successfully'
        ]);
    }

    /**
     * Get volunteer statistics
     */
    public function statistics()
    {
        $user = Auth::user();

        if (!$user->isVolunteer()) {
            return response()->json([
                'success' => false,
                'message' => 'Only volunteers can view statistics'
            ], 403);
        }

        $profile = $user->volunteerProfile;

        $stats = [
            'total_hours' => $profile->total_volunteer_hours,
            'rating' => $profile->volunteer_rating,
            'applications' => $user->applications()->count(),
            'accepted_applications' => $user->applications()->where('status', 'Accepted')->count(),
            'completed_activities' => $user->volunteerActivities()->where('status', 'Verified')->count(),
            'reviews_count' => $user->reviewsReceived()->where('is_approved', true)->count(),
        ];

        return response()->json($stats);
    }

    /**
     * Get volunteer achievements
     */
    public function achievements()
    {
        $user = Auth::user();

        if (!$user->isVolunteer()) {
            return response()->json([
                'success' => false,
                'message' => 'Only volunteers can view achievements'
            ], 403);
        }

        $profile = $user->volunteerProfile;
        $achievements = [];

        // Bronze Badge - 10 hours
        if ($profile->total_volunteer_hours >= 10) {
            $achievements[] = [
                'name' => 'Bronze Volunteer',
                'description' => 'Completed 10 volunteer hours',
                'icon' => 'fas fa-medal',
                'color' => 'bronze'
            ];
        }

        // Silver Badge - 50 hours
        if ($profile->total_volunteer_hours >= 50) {
            $achievements[] = [
                'name' => 'Silver Volunteer',
                'description' => 'Completed 50 volunteer hours',
                'icon' => 'fas fa-medal',
                'color' => 'silver'
            ];
        }

        // Gold Badge - 100 hours
        if ($profile->total_volunteer_hours >= 100) {
            $achievements[] = [
                'name' => 'Gold Volunteer',
                'description' => 'Completed 100 volunteer hours',
                'icon' => 'fas fa-medal',
                'color' => 'gold'
            ];
        }

        // Top Rated
        if ($profile->volunteer_rating >= 4.5) {
            $achievements[] = [
                'name' => 'Top Rated Volunteer',
                'description' => 'Maintained 4.5+ rating',
                'icon' => 'fas fa-star',
                'color' => 'yellow'
            ];
        }

        return response()->json([
            'success' => true,
            'achievements' => $achievements,
            'total_hours' => $profile->total_volunteer_hours,
            'rating' => $profile->volunteer_rating
        ]);
    }

    public function sendVerificationOtp(Request $request)
    {
        $user = Auth::user();

        if ($user->is_verified) {
            return back()->with('error', 'Tài khoản của bạn đã được xác thực.');
        }

        try {
            $otp = rand(100000, 999999);

            // Lưu OTP và thời gian hết hạn vào session
            Session::put('verification_otp', $otp);
            Session::put('otp_expires_at', now()->addMinutes(10));

            // Gửi email (sử dụng Mailable bạn đã cung cấp)
            Mail::to($user->email)->send(new OTPVerificationEmail($user, $otp));

            // Chuyển hướng đến trang nhập OTP
            return redirect()->route('volunteer.profile.showOtp')
                ->with('success', 'Một mã OTP đã được gửi đến email ' . $user->email);
        } catch (\Exception $e) {
            return back()->with('error', 'Không thể gửi email OTP. Vui lòng thử lại.');
        }
    }

    /**
     * Hiển thị form nhập OTP
     */
    public function showOtpForm()
    {
        if (Auth::user()->is_verified) {
            return redirect()->route('volunteer.profile.edit')->with('info', 'Tài khoản đã được xác thực.');
        }
        if (!Session::has('verification_otp')) {
            return redirect()->route('volunteer.profile.edit')->with('error', 'Chưa có mã OTP. Vui lòng yêu cầu mã mới.');
        }

        // Bạn cần tạo view này ở Bước 5
        return view('volunteer.profile.verify-otp');
    }

    /**
     * Xác thực mã OTP
     */
    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|numeric|digits:6']);

        $sessionOtp = Session::get('verification_otp');
        $expiresAt = Session::get('otp_expires_at');

        if (!$sessionOtp || !$expiresAt) {
            return back()->with('error', 'OTP không tồn tại hoặc đã hết hạn. Vui lòng yêu cầu mã mới.');
        }

        if (now()->greaterThan($expiresAt)) {
            // Hủy session
            Session::forget(['verification_otp', 'otp_expires_at']);
            return back()->with('error', 'OTP đã hết hạn. Vui lòng yêu cầu mã mới.');
        }

        if ($request->otp != $sessionOtp) {
            return back()->with('error', 'Mã OTP không chính xác. Vui lòng thử lại.');
        }

        // Xác thực thành công
        $user = Auth::user();
        $user->is_verified = true;
        // $user->email_verified_at = now(); // Cập nhật luôn trường này
        $user->save();

        // Xóa OTP khỏi session
        Session::forget(['verification_otp', 'otp_expires_at']);

        // Chuyển về trang edit với tick xanh
        return redirect()->route('volunteer.profile.edit')
            ->with('success', 'Xác thực tài khoản thành công!');
    }
}
