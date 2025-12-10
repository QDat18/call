{{-- resources/views/volunteer/profile/profile.blade.php --}}
@extends('layouts.volunteer')

@section('title', 'Hồ Sơ Của Tôi')

@section('content')
    <div class="h-60 bg-gradient-to-r from-purple-600 via-indigo-600 to-blue-600 relative">
        <div class="absolute inset-0 bg-black/10"></div>

        <div class="absolute top-6 right-6">
            <a href="{{ route('volunteer.profile.edit') }}"
                class="bg-white/20 backdrop-blur-md text-white border border-white/30 px-4 py-2 rounded-lg hover:bg-white hover:text-purple-700 transition font-medium flex items-center gap-2 shadow-sm">
                <i class="fas fa-pen"></i> <span class="hidden sm:inline">Chỉnh sửa</span>
            </a>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-24 relative z-10 pb-12">

        @if(!Auth::user()->email_verified_at)
            <div
                class="mb-6 bg-yellow-50 border border-yellow-200 rounded-xl p-4 flex flex-col sm:flex-row items-center justify-between shadow-lg gap-4">
                <div class="flex items-center gap-3">
                    <i class="fas fa-exclamation-triangle text-yellow-600 text-xl"></i>
                    <div>
                        <span class="text-yellow-800 font-bold block sm:inline">Tài khoản chưa xác thực email.</span>
                        <span class="text-yellow-700 text-sm block sm:inline">Vui lòng xác thực để sử dụng đầy đủ tính
                            năng.</span>
                    </div>
                </div>
                <form method="POST" action="{{ route('email.resend') }}">
                    @csrf
                    <button
                        class="whitespace-nowrap text-white bg-yellow-600 hover:bg-yellow-700 px-4 py-2 rounded-lg text-sm font-bold transition shadow-md">
                        Gửi lại Email
                    </button>
                </form>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 sticky top-24">
                    <div class="p-8 text-center border-b border-gray-100">
                        <div class="relative inline-block">
                            <img src="{{ $profile->user->avatar_url ? asset('storage/' . $profile->user->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($profile->user->last_name . ' ' . $profile->user->first_name) . '&background=8b5cf6&color=fff&size=200' }}"
                                alt="Avatar" class="w-40 h-40 rounded-full border-4 border-white shadow-2xl object-cover">

                            {{-- Badge xác thực --}}
                            @if($profile->user->email_verified_at)
                                <div class="absolute bottom-2 right-2 bg-green-500 text-white w-8 h-8 rounded-full flex items-center justify-center border-2 border-white shadow-md"
                                    title="Đã xác thực">
                                    <i class="fas fa-check text-sm"></i>
                                </div>
                            @else
                                <div class="absolute bottom-2 right-2 bg-yellow-500 text-white w-8 h-8 rounded-full flex items-center justify-center border-2 border-white shadow-md"
                                    title="Chưa xác thực">
                                    <i class="fas fa-exclamation text-sm"></i>
                                </div>
                            @endif
                        </div>

                        <h1 class="mt-4 text-2xl font-bold text-gray-900">{{ $profile->user->last_name }}
                            {{ $profile->user->first_name }}
                        </h1>
                        <p class="text-purple-600 font-medium">{{ $profile->occupation ?? 'Tình nguyện viên' }}</p>

                        @if($profile->preferred_location)
                            <p class="mt-2 text-gray-500 text-sm flex items-center justify-center gap-1">
                                <i class="fas fa-map-marker-alt"></i> {{ $profile->preferred_location }}
                            </p>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 divide-x divide-gray-100 bg-gray-50">
                        <div class="p-6 text-center group hover:bg-purple-50 transition cursor-default">
                            <span
                                class="block text-3xl font-extrabold text-gray-800 group-hover:text-purple-600 transition">{{ $stats['total_hours'] ?? 0 }}</span>
                            <span class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Giờ đóng góp</span>
                        </div>
                        <div class="p-6 text-center group hover:bg-yellow-50 transition cursor-default">
                            <span
                                class="block text-3xl font-extrabold text-gray-800 group-hover:text-yellow-600 transition flex items-center justify-center gap-1">
                                {{ number_format($stats['rating'] ?? 0, 1) }} <i
                                    class="fas fa-star text-sm text-yellow-400"></i>
                            </span>
                            <span class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Đánh giá</span>
                        </div>
                    </div>

                    <div class="p-8 space-y-6">
                        <div>
                            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-3">Liên hệ</h3>
                            <ul class="space-y-3 text-sm text-gray-600">
                                <li class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <span class="truncate"
                                        title="{{ $profile->user->email }}">{{ $profile->user->email }}</span>
                                </li>
                                @if($profile->user->phone)
                                    <li class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500">
                                            <i class="fas fa-phone"></i>
                                        </div>
                                        <span>{{ $profile->user->phone }}</span>
                                    </li>
                                @endif
                            </ul>
                        </div>

                        @if(isset($achievements) && count($achievements) > 0)
                            <div>
                                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-3">Huy hiệu</h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($achievements as $ach)
                                        <div class="bg-yellow-50 border border-yellow-100 text-yellow-800 px-3 py-1.5 rounded-lg text-sm flex items-center gap-2 cursor-help"
                                            title="{{ $ach['description'] ?? '' }}">
                                            <span>{!! $ach['icon'] ?? '<i class="fas fa-medal"></i>' !!}</span>
                                            <span class="font-semibold">{{ $ach['title'] ?? $ach['name'] }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-8">

                <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <i class="fas fa-user-circle text-purple-600"></i> Giới thiệu
                    </h2>
                    @if($profile->bio)
                        <p class="text-gray-600 leading-relaxed text-lg whitespace-pre-line">{{ $profile->bio }}</p>
                    @else
                        <div class="text-center py-8 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                            <p class="text-gray-500 mb-4">Bạn chưa có lời giới thiệu nào.</p>
                            <a href="{{ route('volunteer.profile.edit') }}"
                                class="text-purple-600 font-bold hover:underline">Thêm giới thiệu ngay</a>
                        </div>
                    @endif
                </div>

                <div class="grid md:grid-cols-2 gap-8">

                    <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100 h-full">
                        <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <i class="fas fa-tools text-orange-500"></i> Kỹ năng
                        </h2>
                        @php
                            // Giải mã JSON từ DB
                            $skillsArr = $profile->skills ?? [];
                        @endphp

                        @if(!empty($skillsArr) && is_array($skillsArr) && count($skillsArr) > 0)
                            <div class="flex flex-wrap gap-2">
                                @foreach($skillsArr as $skill)
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 rounded-full bg-orange-50 text-orange-700 font-medium text-sm border border-orange-100 shadow-sm">
                                        {{ $skill }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-6 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                                <p class="text-gray-400 italic text-sm">Chưa cập nhật kỹ năng</p>
                            </div>
                        @endif
                    </div>

                    <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100 h-full">
                        <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <i class="fas fa-heart text-pink-500"></i> Quan tâm
                        </h2>
                        @php
                            // Giải mã JSON từ DB
                            $interestsArr = $profile->interests ?? [];
                        @endphp

                        @if(!empty($interestsArr) && is_array($interestsArr) && count($interestsArr) > 0)
                            <div class="flex flex-wrap gap-2">
                                @foreach($interestsArr as $interest)
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 rounded-full bg-pink-50 text-pink-700 font-medium text-sm border border-pink-100 shadow-sm">
                                        {{ $interest }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-6 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                                <p class="text-gray-400 italic text-sm">Chưa cập nhật sở thích</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                    <h2 class="text-xl font-bold text-gray-900 p-8 pb-4 flex items-center gap-2">
                        <i class="fas fa-info-circle text-blue-600"></i> Thông tin bổ sung
                    </h2>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <tbody class="divide-y divide-gray-100">
                                <tr class="hover:bg-gray-50 transition">
                                    <th class="px-8 py-4 text-gray-500 font-medium w-1/3 whitespace-nowrap">Trình độ học vấn
                                    </th>
                                    <td class="px-8 py-4 text-gray-800 font-semibold">
                                        {{ $profile->education_level ?? '---' }}
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition">
                                    <th class="px-8 py-4 text-gray-500 font-medium">Trường học</th>
                                    <td class="px-8 py-4 text-gray-800 font-semibold">
                                        {{ $profile->university ?? '---' }}
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition">
                                    <th class="px-8 py-4 text-gray-500 font-medium">Phương tiện</th>
                                    <td class="px-8 py-4 text-gray-800 font-semibold">
                                        @if($profile->transportation)
                                            @php
                                                // Định nghĩa icon và tên hiển thị tiếng Việt
                                                $transMap = [
                                                    'Motorbike' => [
                                                        'icon' => 'fa-motorcycle',
                                                        'label' => 'Xe máy'
                                                    ],
                                                    'Car' => [
                                                        'icon' => 'fa-car',
                                                        'label' => 'Ô tô'
                                                    ],
                                                    'Public Transport' => [
                                                        'icon' => 'fa-bus',
                                                        'label' => 'Phương tiện công cộng'
                                                    ],
                                                    'Walking' => [
                                                        'icon' => 'fa-walking',
                                                        'label' => 'Đi bộ'
                                                    ],
                                                ];

                                                // Lấy thông tin dựa trên giá trị trong DB, nếu không khớp thì dùng mặc định
                                                $currentTrans = $transMap[$profile->transportation] ?? [
                                                    'icon' => 'fa-route',
                                                    'label' => $profile->transportation
                                                ];
                                            @endphp

                                            <span class="inline-flex items-center gap-2">
                                                {{-- Hiển thị Icon động --}}
                                                <i class="fas {{ $currentTrans['icon'] }} text-gray-400"></i>

                                                {{-- Hiển thị Tên tiếng Việt --}}
                                                {{ $currentTrans['label'] }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 italic">---</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition">
                                    <th class="px-8 py-4 text-gray-500 font-medium">Thời gian rảnh</th>
                                    <td class="px-8 py-4 text-gray-800 font-semibold">
                                        @if($profile->availability)
                                            <span
                                                class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs uppercase font-bold">
                                                {{ $profile->availability }}
                                            </span>
                                        @else
                                            ---
                                        @endif
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition">
                                    <th class="px-8 py-4 text-gray-500 font-medium">Kinh nghiệm</th>
                                    <td class="px-8 py-4 text-gray-800 font-semibold">
                                        {{ $profile->volunteer_experience ?? 'Chưa cập nhật' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection