@extends('layouts.app')

@section('title', 'Hồ Sơ Của Tôi - Volunteer Connect')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 pb-12">

        {{-- COVER & HEADER (Consistent with Public Profile) --}}
        <div class="bg-white dark:bg-gray-800 shadow-sm mb-8">
            <div class="h-48 bg-gradient-to-r from-blue-600 to-indigo-700 relative">
                <div class="absolute inset-0 bg-black/10"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="relative -mt-16 pb-6 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex flex-col md:flex-row items-end gap-6">
                        {{-- Avatar --}}
                        <div class="relative group">
                            <div class="p-1.5 bg-white dark:bg-gray-800 rounded-full">
                                <img src="{{ $user->avatar_url ? asset('storage/' . $user->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($user->first_name . ' ' . $user->last_name) }}"
                                    class="w-32 h-32 md:w-40 md:h-40 rounded-full object-cover border-4 border-white dark:border-gray-800 shadow-lg">
                            </div>
                            <a href="{{ route('user.edit-profile') }}"
                                class="absolute bottom-2 right-2 bg-gray-800 text-white p-2 rounded-full shadow-md hover:bg-gray-700 transition"
                                title="Đổi ảnh đại diện">
                                <i class="fas fa-camera text-sm"></i>
                            </a>
                        </div>

                        {{-- Info --}}
                        <div class="flex-1 text-center md:text-left mb-2 w-full">
                            <div class="flex flex-col md:flex-row justify-between items-center">
                                <div>
                                    <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-1">
                                        {{ $user->full_name }}
                                    </h1>
                                    <p class="text-gray-500 dark:text-gray-400 font-medium mb-1">{{ $user->email }}</p>
                                    <div class="flex items-center justify-center md:justify-start gap-2 mt-2">
                                        <span
                                            class="px-3 py-1 bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300 rounded-full text-xs font-bold uppercase tracking-wide">
                                            {{ $user->user_type }}
                                        </span>
                                        @if($user->email_verified_at)
                                            <span
                                                class="px-2 py-1 text-green-600 dark:text-green-400 text-xs font-bold flex items-center gap-1">
                                                <i class="fas fa-check-circle"></i> Đã xác thực
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Edit Button --}}
                                <div class="mt-4 md:mt-0 flex gap-3">
                                    <a href="{{ route('user.public-profile', $user->user_id) }}"
                                        class="px-5 py-2.5 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-white rounded-xl font-semibold hover:bg-gray-50 transition">
                                        <i class="fas fa-eye mr-2"></i> Xem công khai
                                    </a>
                                    
                            @if (Auth::user()->user_type === 'Volunteer')
                                <a href="{{ route('volunteer.profile.edit') }}" 
                                   class="px-5 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-900 dark:text-white rounded-lg font-semibold transition flex items-center gap-2">
                                    <i class="fas fa-pen"></i> Chỉnh sửa trang cá nhân
                                </a>
                            @elseif (Auth::user()->user_type === 'Organization')
                                <a href="{{ route('organization.profile.edit') }}" 
                                   class="px-5 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-900 dark:text-white rounded-lg font-semibold transition flex items-center gap-2">
                                    <i class="fas fa-pen"></i> Chỉnh sửa trang cá nhân
                                </a>
                            @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- MAIN CONTENT --}}
                <div class="lg:col-span-2 space-y-8">

                    {{-- Personal Info Card --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 md:p-8">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                            <i class="far fa-id-card text-indigo-500"></i> Thông tin cá nhân
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Số điện thoại</label>
                                <p class="text-gray-800 dark:text-gray-200 font-medium">
                                    {{ $user->phone ?? 'Chưa cập nhật' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Giới tính</label>
                                <p class="text-gray-800 dark:text-gray-200 font-medium">
                                    {{ $user->gender ?? 'Chưa cập nhật' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Ngày sinh</label>
                                <p class="text-gray-800 dark:text-gray-200 font-medium">
                                    {{ $user->date_of_birth ? date('d/m/Y', strtotime($user->date_of_birth)) : 'Chưa cập nhật' }}
                                </p>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Địa chỉ</label>
                                <p class="text-gray-800 dark:text-gray-200 font-medium">
                                    {{ $user->address ? $user->address . ', ' : '' }}{{ $user->district ? $user->district . ', ' : '' }}{{ $user->city ?? 'Chưa cập nhật' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Volunteer / Org Specific Profile --}}
                    @if($user->isVolunteer() && $user->volunteerProfile)
                        <div
                            class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 md:p-8 relative overflow-hidden">
                            <div class="absolute top-0 right-0 p-4 opacity-10">
                                <i class="fas fa-hands-helping text-9xl text-indigo-500"></i>
                            </div>

                            <div class="flex justify-between items-center mb-6 relative z-10">
                                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Hồ sơ Tình nguyện viên</h2>
                                <a href="{{ route('volunteer.profile.profile') }}"
                                    class="text-sm font-bold text-indigo-600 hover:underline">Chi tiết <i
                                        class="fas fa-arrow-right"></i></a>
                            </div>

                            <div class="grid grid-cols-2 gap-6 relative z-10">
                                <div class="bg-indigo-50 dark:bg-indigo-900/20 p-4 rounded-xl text-center">
                                    <div class="text-2xl font-extrabold text-indigo-600 dark:text-indigo-400">
                                        {{ $user->volunteerProfile->total_volunteer_hours }}</div>
                                    <div class="text-xs font-bold text-gray-500 uppercase">Giờ đóng góp</div>
                                </div>
                                <div class="bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-xl text-center">
                                    <div
                                        class="text-2xl font-extrabold text-yellow-600 dark:text-yellow-400 flex justify-center items-center gap-1">
                                        {{ number_format($user->volunteerProfile->volunteer_rating, 1) }} <i
                                            class="fas fa-star text-sm"></i>
                                    </div>
                                    <div class="text-xs font-bold text-gray-500 uppercase">Đánh giá</div>
                                </div>
                            </div>

                            @if($user->volunteerProfile->skills)
                                <div class="mt-6 relative z-10">
                                    <label class="block text-xs font-bold text-gray-400 uppercase mb-3">Kỹ năng</label>
                                    <div class="flex flex-wrap gap-2">
                                        @php
                                            $badgeColors = [
                                                'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                                'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                                'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
                                                'bg-pink-100 text-pink-700 dark:bg-pink-900/30 dark:text-pink-400',
                                                'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                                                'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400',
                                                'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                                'bg-teal-100 text-teal-700 dark:bg-teal-900/30 dark:text-teal-400',
                                                'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400',
                                                'bg-cyan-100 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-400',
                                            ];
                                        @endphp

@php
    $rawSkills = $user->volunteerProfile->skills;
    
    // Nếu là chuỗi (VD: "PHP, Laravel, CSS") -> Dùng explode
    if (is_string($rawSkills)) {
        $skillsList = explode(',', $rawSkills);
    } 
    // Nếu đã là mảng (do Model $casts = ['skills' => 'array']) -> Dùng luôn
    elseif (is_array($rawSkills)) {
        $skillsList = $rawSkills;
    } 
    // Trường hợp null hoặc khác -> Mảng rỗng
    else {
        $skillsList = [];
    }
@endphp

@foreach($skillsList as $index => $skill)
    @php
        $colorClass = $badgeColors[$index % count($badgeColors)];
    @endphp
    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 {{ $colorClass }} rounded-full text-sm font-semibold shadow-sm hover:shadow-md transition-shadow">
        <i class="fas fa-check-circle text-xs"></i>
        {{-- Trim khoảng trắng thừa và strip_tags để an toàn --}}
        <span>{{ trim(strip_tags($skill)) }}</span>
    </span>
@endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                {{-- SIDEBAR --}}
                <div class="space-y-6">
                    {{-- Account Settings --}}
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                        <h3 class="font-bold text-gray-900 dark:text-white mb-4">Cài đặt tài khoản</h3>
                        <div class="space-y-2">
<form id="auth-reset-form" action="{{ route('user.send-reset-link') }}" method="POST" class="hidden">
    @csrf
</form>

{{-- Nút bấm --}}
<a href="#" 
   onclick="event.preventDefault(); if(confirm('Hệ thống sẽ gửi email đặt lại mật khẩu đến {{ $user->email }}. Bạn có muốn tiếp tục?')) document.getElementById('auth-reset-form').submit();"
   class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition group">
    <div class="flex items-center gap-3">
        <div class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center group-hover:bg-indigo-100 dark:group-hover:bg-indigo-900 transition">
            <i class="fas fa-key text-gray-500 group-hover:text-indigo-600 text-sm"></i>
        </div>
        <span class="text-sm font-medium text-gray-700 dark:text-gray-200">Đổi mật khẩu</span>
    </div>
    <i class="fas fa-chevron-right text-xs text-gray-400"></i>
</a>

                            <a href="{{ route('notifications.index') }}"
                                class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition group">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center group-hover:bg-blue-100 dark:group-hover:bg-blue-900 transition">
                                        <i class="fas fa-bell text-gray-500 group-hover:text-blue-600 text-sm"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-200">Cài đặt thông
                                        báo</span>
                                </div>
                                <i class="fas fa-chevron-right text-xs text-gray-400"></i>
                            </a>

                            <button onclick="document.getElementById('deactivate-modal').classList.remove('hidden')"
                                class="w-full flex items-center justify-between p-3 rounded-xl hover:bg-red-50 dark:hover:bg-red-900/20 transition group mt-4 border border-transparent hover:border-red-100">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full bg-red-50 dark:bg-red-900/30 flex items-center justify-center">
                                        <i class="fas fa-user-slash text-red-500 text-sm"></i>
                                    </div>
                                    <span class="text-sm font-medium text-red-600">Vô hiệu hóa tài khoản</span>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Deactivate Modal (Giữ nguyên logic cũ, chỉ style lại chút) --}}
    <div id="deactivate-modal"
        class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl max-w-md w-full p-6 shadow-2xl transform transition-all scale-100">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Vô hiệu hóa tài khoản?</h3>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">
                    Hành động này sẽ ẩn hồ sơ của bạn khỏi cộng đồng. Bạn có thể kích hoạt lại bất cứ lúc nào bằng cách đăng
                    nhập.
                </p>
            </div>

            <form action="{{ route('user.deactivate') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mật khẩu xác
                            nhận</label>
                        <input type="password" name="password" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Lý do (Tùy
                            chọn)</label>
                        <textarea name="reason" rows="2"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:text-white"></textarea>
                    </div>
                </div>

                <div class="flex gap-3 mt-6">
                    <button type="button" onclick="document.getElementById('deactivate-modal').classList.add('hidden')"
                        class="flex-1 px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-bold rounded-lg hover:bg-gray-200 transition">Hủy</button>
                    <button type="submit"
                        class="flex-1 px-4 py-2 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700 transition shadow-lg shadow-red-200 dark:shadow-none">Xác
                        nhận</button>
                </div>
            </form>
        </div>
    </div>
@endsection