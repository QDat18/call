<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\VolunteerProfile;
use App\Mail\OTPVerificationEmail;
use Illuminate\Validation\Rule;
use App\Models\VolunteerOpportunity;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class VolunteerProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        if (!$user->isVolunteer()) {
            abort(403, 'Only volunteers can access this page!');
        }

        $profile = $user->volunteerProfile ?? VolunteerProfile::create(['user_id' => $user->user_id]);

        // Tự động cập nhật kỹ năng & sở thích
        $this->updateAutoSkillsAndInterests($user, $profile);

        // Thống kê
        $stats = [
            'total_hours' => $profile->total_volunteer_hours ?? 0,
            'rating' => $profile->volunteer_rating ?? 0,
            'applications' => $user->applications()->count(),
            'accepted_applications' => $user->applications()->where('status', 'Accepted')->count(),
            'completed_activities' => $user->activities()->where('status', 'Verified')->count(),
            'reviews_count' => $user->receivedReviews()->where('is_approved', true)->count(),
        ];

        // Thành tựu
        $achievements = [];
        $hours = $profile->total_volunteer_hours ?? 0;
        $rating = $profile->volunteer_rating ?? 0;

        if ($hours >= 10) $achievements[] = ['name' => 'Bronze Volunteer', 'description' => '10 giờ tình nguyện', 'icon' => 'fas fa-medal', 'color' => 'bronze'];
        if ($hours >= 50) $achievements[] = ['name' => 'Silver Volunteer', 'description' => '50 giờ tình nguyện', 'icon' => 'fas fa-medal', 'color' => 'silver'];
        if ($hours >= 100) $achievements[] = ['name' => 'Gold Volunteer', 'description' => '100 giờ tình nguyện', 'icon' => 'fas fa-medal', 'color' => 'gold'];
        if ($rating >= 4.5) $achievements[] = ['name' => 'Top Rated', 'description' => 'Đánh giá 4.5+', 'icon' => 'fas fa-star', 'color' => 'yellow'];

        return view('volunteer.profile.profile', compact('profile', 'stats', 'achievements'));
    }

    public function edit()
    {
        $user = Auth::user();
        if (!$user->isVolunteer()) {
            abort(403, 'Only volunteers can access this page!');
        }

        $profile = $user->volunteerProfile ?? VolunteerProfile::create(['user_id' => $user->user_id]);

        // TỰ ĐỘNG TÍNH KỸ NĂNG & SỞ THÍCH
        $autoSkills = VolunteerOpportunity::whereHas('favorites', function ($q) use ($user) {
            $q->where('user_id', $user->user_id);
        })
            ->orWhereHas('applications', function ($q) use ($user) {
                $q->where('volunteer_id', $user->user_id)
                    ->where('status', 'Accepted');
            })
            ->orWhereHas('volunteerActivities', function ($q) use ($user) {
                $q->where('volunteer_id', $user->user_id)
                    ->where('status', 'Verified');
            })
            ->get()
            ->pluck('skills_required')
            ->filter()
            ->flatMap(function ($skills) {
                return preg_split('/[,;]/', $skills);
            })
            ->map('trim')
            ->filter()
            ->unique()
            ->take(15)
            ->values();

        $autoInterests = Category::whereHas('opportunities', function ($q) use ($user) {
            $q->where(function ($sub) use ($user) {
                $sub->whereHas('favorites', fn($f) => $f->where('user_id', $user->user_id))
                    ->orWhereHas('applications', fn($a) => $a->where('volunteer_id', $user->user_id)->where('status', 'Accepted'))
                    ->orWhereHas('volunteerActivities', fn($va) => $va->where('volunteer_id', $user->user_id)->where('status', 'Verified'));
            });
        })
            ->select('categories.category_id')
            ->selectRaw('categories.category_name')
            ->selectRaw('categories.icon')
            ->selectRaw('categories.description')
            ->selectRaw('COUNT(*) as total_engagement')
            ->groupBy('categories.category_id', 'categories.category_name', 'categories.icon', 'categories.description')
            ->orderByDesc('total_engagement')
            ->limit(10)
            ->get();

        return view('volunteer.profile.edit-profile', compact('profile', 'autoSkills', 'autoInterests'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if (!$user->isVolunteer()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // 1. Validate
        $validator = Validator::make($request->all(), [
            'avatar' => 'nullable|image|max:2048',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'occupation' => 'nullable|string|max:100',
            'education_level' => 'nullable|string',
            'university' => 'nullable|string|max:150',
            'bio' => 'nullable|string|max:1000',
            'preferred_location' => 'nullable|string|max:100',
            'transportation' => 'nullable|string',
            'availability' => 'nullable|string',
            'volunteer_experience' => 'nullable|string',
            'skills' => 'nullable|string',   // Nhận chuỗi từ form
            'interests' => 'nullable|string' // Nhận chuỗi từ form
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        try {
            // 2. Avatar
            if ($request->hasFile('avatar')) {
                if ($user->avatar_url && Storage::disk('public')->exists($user->avatar_url)) {
                    Storage::disk('public')->delete($user->avatar_url);
                }
                $path = $request->file('avatar')->store('avatars/volunteers', 'public');
                $user->update(['avatar_url' => $path]);
            }

            $userData = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
            ];

            $user->update($userData);
            $profile = $user->volunteerProfile;
            $skillsJson = '[]'; // Mặc định là mảng rỗng JSON
            if ($request->skills) {
                $skillsArray = array_values(array_filter(array_map('trim', explode(',', $request->skills))));
                // $skillsJson = json_encode($skillsArray, JSON_UNESCAPED_UNICODE);
                $skillsJson = $skillsArray;
            }

            $interestsJson = '[]';
            if ($request->interests) {
                $interestsArray = array_values(array_filter(array_map('trim', explode(',', $request->interests))));
                // $interestsJson = json_encode($interestsArray, JSON_UNESCAPED_UNICODE);
                $interestsJson = $interestsArray;
            }

            if ($request->filled('city_name') && $request->filled('ward_name')) {
                $locationData = $request->ward_name . ', ' . $request->city_name;
            } elseif ($request->filled('city_name')) {
                $locationData = $request->city_name;
            }
            $profile->update([
                'occupation' => $request->occupation,
                'education_level' => $request->education_level,
                'university' => $request->university,
                'bio' => $request->bio,
                'preferred_location' => $locationData ?? $request->preferred_location,
                'transportation' => $request->transportation,
                'availability' => $request->availability,
                'volunteer_experience' => $request->volunteer_experience,

                // Lưu chuỗi JSON đã mã hóa thủ công
                'skills' => $skillsJson,
                'interests' => $interestsJson
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật thành công!',
                'avatar_url' => $user->avatar_url ? asset('storage/' . $user->avatar_url) : null
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
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
    private function updateAutoSkillsAndInterests($user, $profile)
    {
        // Nếu đã có dữ liệu (và không phải mảng rỗng) thì thôi
        // if (!empty($profile->skills) && $profile->skills !== '[]') return;
        if (!empty($profile->skills)) return;

        $autoSkills = VolunteerOpportunity::whereHas('favorites', fn($q) => $q->where('user_id', $user->user_id))
            ->get()->pluck('skills_required')
            ->flatMap(fn($s) => preg_split('/[,;]/', $s))
            ->map('trim')->filter()->unique()->values();

        $autoInterests = Category::limit(5)->pluck('category_name'); // Demo logic

        $updates = [];

        // SỬA: Dùng json_encode thay vì implode
        if (empty($profile->skills) || $profile->skills == '[]') {
            // $updates['skills'] = json_encode($autoSkills->toArray(), JSON_UNESCAPED_UNICODE);
            $updates['skills'] = $autoSkills->toArray();
        }

        if (empty($profile->interests) || $profile->interests == '[]') {
            $updates['interests'] = json_encode($autoInterests->toArray(), JSON_UNESCAPED_UNICODE);
        }

        if (!empty($updates)) {
            // Update trực tiếp để tránh lỗi Model Events
            DB::table('volunteer_profiles')
                ->where('profile_id', $profile->profile_id)
                ->update($updates);
        }
    }
}
