{{-- resources/views/volunteer/profile/profile.blade.php --}}
@extends('layouts.app')

@section('title', 'Hồ Sơ Tình Nguyện - ' . $profile->user->first_name)

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        @keyframes gradient-shift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        @keyframes pulse-ring {
            0% {
                transform: scale(0.95);
                opacity: 1;
            }

            50% {
                transform: scale(1.05);
                opacity: 0.7;
            }

            100% {
                transform: scale(0.95);
                opacity: 1;
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }

            100% {
                background-position: 1000px 0;
            }
        }

        @keyframes bounce-in {
            0% {
                transform: scale(0.8);
                opacity: 0;
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes slide-up {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .gradient-purple {
            background: linear-gradient(135deg, #8b5cf6, #6b46c1);
        }

        .gradient-bg {
            background: linear-gradient(-45deg, #667eea, #764ba2, #f093fb, #4facfe);
            background-size: 400% 400%;
            animation: gradient-shift 15s ease infinite;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(139, 92, 246, 0.2);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            animation: slide-up 0.6s ease-out;
        }

        .card-hover:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 50px -12px rgba(139, 92, 246, 0.25);
        }

        .avatar-container {
            position: relative;
            animation: float 4s ease-in-out infinite;
        }

        .avatar-ring {
            position: absolute;
            inset: -8px;
            border-radius: 50%;
            background: linear-gradient(45deg, #8b5cf6, #ec4899, #8b5cf6);
            background-size: 200% 200%;
            animation: gradient-shift 3s ease infinite, pulse-ring 2s ease-in-out infinite;
            z-index: 0;
        }

        .stats-card {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .stats-card:hover::before {
            opacity: 1;
            animation: shimmer 2s infinite;
        }

        .stats-card:hover {
            transform: scale(1.05) rotate(2deg);
        }

        .badge-bronze {
            background: linear-gradient(135deg, #fef3c7, #fbbf24);
            color: #92400e;
            box-shadow: 0 4px 15px rgba(251, 191, 36, 0.3);
        }

        .badge-silver {
            background: linear-gradient(135deg, #f3f4f6, #d1d5db);
            color: #374151;
            box-shadow: 0 4px 15px rgba(209, 213, 219, 0.3);
        }

        .badge-gold {
            background: linear-gradient(135deg, #fef3c7, #f59e0b);
            color: #92400e;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);
        }

        .badge-star {
            background: linear-gradient(135deg, #fffbeb, #fbbf24);
            color: #78350f;
            box-shadow: 0 4px 15px rgba(251, 191, 36, 0.3);
        }

        .badge-item {
            transition: all 0.3s ease;
            animation: bounce-in 0.6s ease;
        }

        .badge-item:hover {
            transform: translateX(10px) scale(1.05);
        }

        .nav-tab {
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-tab::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%) scaleX(0);
            width: 80%;
            height: 3px;
            background: linear-gradient(90deg, #8b5cf6, #ec4899);
            border-radius: 2px;
            transition: transform 0.3s ease;
        }

        .nav-tab:hover::after {
            transform: translateX(-50%) scaleX(1);
        }

        .nav-tab.active {
            background: linear-gradient(135deg, #8b5cf6, #6366f1);
            box-shadow: 0 10px 30px -5px rgba(139, 92, 246, 0.5);
        }

        .skill-tag,
        .interest-tag {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .skill-tag::before,
        .interest-tag::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            transform: translate(-50%, -50%);
            transition: width 0.5s, height 0.5s;
        }

        .skill-tag:hover::before,
        .interest-tag:hover::before {
            width: 200px;
            height: 200px;
        }

        .skill-tag:hover,
        .interest-tag:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(139, 92, 246, 0.4);
        }

        .section-icon {
            transition: all 0.3s ease;
        }

        .card-hover:hover .section-icon {
            transform: rotate(360deg) scale(1.1);
        }

        .info-box {
            position: relative;
            overflow: hidden;
        }

        .info-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(139, 92, 246, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .info-box:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: linear-gradient(135deg, #8b5cf6, #6366f1);
            box-shadow: 0 10px 30px -5px rgba(139, 92, 246, 0.4);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-primary:hover::before {
            width: 400px;
            height: 400px;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px -5px rgba(139, 92, 246, 0.6);
        }

        .btn-secondary {
            background: white;
            border: 3px solid #8b5cf6;
            color: #8b5cf6;
            box-shadow: 0 4px 15px rgba(139, 92, 246, 0.15);
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #f5f3ff, #ede9fe);
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(139, 92, 246, 0.3);
            border-color: #6366f1;
        }

        .quote-block {
            position: relative;
            padding-left: 30px;
        }

        .quote-block::before {
            content: '"';
            position: absolute;
            left: 0;
            top: -20px;
            font-size: 80px;
            color: #8b5cf6;
            opacity: 0.2;
            font-family: Georgia, serif;
        }

        .stat-number {
            background: linear-gradient(135deg, #ffffff, rgba(255, 255, 255, 0.8));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .nav-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 40px -10px rgba(139, 92, 246, 0.3);
        }

        /* Stagger animation for cards */
        .card-hover:nth-child(1) {
            animation-delay: 0s;
        }

        .card-hover:nth-child(2) {
            animation-delay: 0.1s;
        }

        .card-hover:nth-child(3) {
            animation-delay: 0.2s;
        }

        .card-hover:nth-child(4) {
            animation-delay: 0.3s;
        }

        .card-hover:nth-child(5) {
            animation-delay: 0.4s;
        }

        .card-hover:nth-child(6) {
            animation-delay: 0.5s;
        }

        /* Achievement icon animations */
        @keyframes trophy-bounce {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            25% {
                transform: translateY(-10px) rotate(-5deg);
            }

            75% {
                transform: translateY(-10px) rotate(5deg);
            }
        }

        .achievement-icon {
            animation: trophy-bounce 2s ease-in-out infinite;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card-hover:hover {
                transform: translateY(-4px);
            }

            .avatar-container {
                animation: float 5s ease-in-out infinite;
            }
        }

        /* Loading shimmer effect */
        @keyframes loading-shimmer {
            0% {
                background-position: -200% center;
            }

            100% {
                background-position: 200% center;
            }
        }

        .shimmer-bg {
            background: linear-gradient(90deg,
                    rgba(255, 255, 255, 0) 0%,
                    rgba(255, 255, 255, 0.3) 50%,
                    rgba(255, 255, 255, 0) 100%);
            background-size: 200% 100%;
            animation: loading-shimmer 2s infinite;
        }
    </style>
@endpush

@section('content')
    <div class="min-h-screen gradient-bg py-12 px-4">
        <div class="max-w-6xl mx-auto">

            <!-- Navigation Tabs -->
            <div class="flex justify-center mb-12">
                <div class="nav-container rounded-full p-2 flex flex-wrap justify-center gap-2">
                    <a href="{{ route('volunteer.dashboard') }}"
                        class="nav-tab px-6 md:px-8 py-3 md:py-4 rounded-full font-bold text-gray-700 hover:bg-purple-100 transition flex items-center gap-2 md:gap-3">
                        <i class="fas fa-home"></i> <span class="hidden sm:inline">Dashboard</span>
                    </a>
                    <a href="{{ route('volunteer.profile.profile') }}"
                        class="nav-tab active px-6 md:px-8 py-3 md:py-4 rounded-full text-white font-bold flex items-center gap-2 md:gap-3">
                        <i class="fas fa-user-tie"></i> <span class="hidden sm:inline">Hồ Sơ</span>
                    </a>
                    <a href="{{ route('volunteer.profile.edit') }}"
                        class="nav-tab px-6 md:px-8 py-3 md:py-4 rounded-full font-bold text-gray-700 hover:bg-purple-100 transition flex items-center gap-2 md:gap-3">
                        <i class="fas fa-edit"></i> <span class="hidden sm:inline">Chỉnh Sửa</span>
                    </a>
                </div>
            </div>

            <div class="grid lg:grid-cols-3 gap-8">

                <!-- Left: Avatar + Info + Stats -->
                <div class="lg:col-span-1 space-y-8">
                    <div class="glass-card rounded-3xl shadow-2xl p-8 text-center card-hover">
                        <div class="avatar-container inline-block">
                            <div class="avatar-ring"></div>
                            <img src="{{ $profile->user->avatar_url
        ? asset('storage/' . $profile->user->avatar_url)
        : 'https://ui-avatars.com/api/?name=' . urlencode($profile->user->first_name . ' ' . $profile->user->last_name) . '&background=8b5cf6&color=fff&size=256' }}"
                                class="relative z-10 w-40 h-40 md:w-48 md:h-48 rounded-full mx-auto object-cover border-8 border-white shadow-2xl"
                                alt="Ảnh đại diện của {{ $profile->user->first_name }} {{ $profile->user->last_name }}">
                            {{-- Thêm alt text cho SEO --}}
                        </div>

                        <h1
                            class="text-2xl md:text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600 mt-6">
                            {{ $profile->user->first_name }} {{ $profile->user->last_name }}
                        </h1>
                        <p class="text-lg md:text-xl text-gray-600 mt-2 font-semibold">Tình Nguyện Viên</p>

                        @if($profile->preferred_location)
                            <div
                                class="mt-3 inline-flex items-center gap-2 px-4 py-2 bg-purple-50 rounded-full text-purple-700">
                                <i class="fas fa-map-marker-alt"></i>
                                <span class="text-sm font-medium">{{ $profile->preferred_location }}</span>
                            </div>
                        @endif

                        <!-- Stats -->
                        <div class="grid grid-cols-2 gap-4 mt-8">
                            <div
                                class="stats-card bg-gradient-to-br from-purple-500 to-purple-700 text-white rounded-2xl p-6 shadow-lg">
                                <div class="stat-number text-3xl md:text-4xl font-bold">{{ $stats['total_hours'] }}</div>
                                <div class="text-xs md:text-sm mt-1 font-semibold">Giờ TNV</div>
                            </div>
                            <div
                                class="stats-card bg-gradient-to-br from-yellow-500 to-orange-600 text-white rounded-2xl p-6 shadow-lg">
                                <div class="stat-number text-3xl md:text-4xl font-bold">
                                    {{ number_format($stats['rating'], 1) }}</div>
                                <div class="text-xs md:text-sm flex items-center justify-center gap-1 mt-1 font-semibold">
                                    <i class="fas fa-star"></i> Đánh giá
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 space-y-3">
                            <div
                                class="info-box bg-gradient-to-r from-green-50 to-emerald-50 text-green-800 px-6 py-3 rounded-xl font-bold shadow-md border-2 border-green-200">
                                {{ $stats['accepted_applications'] }} / {{ $stats['applications'] }} Đơn chấp nhận
                            </div>
                            <div
                                class="info-box bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-800 px-6 py-3 rounded-xl font-bold shadow-md border-2 border-blue-200">
                                {{ $stats['completed_activities'] }} Hoạt động hoàn thành
                            </div>
                        </div>
                    </div>

                    <!-- Achievements -->
                    @if(count($achievements) > 0)
                        <div class="glass-card rounded-3xl shadow-2xl p-8 card-hover">
                            <h3
                                class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-yellow-600 to-orange-600 mb-6 text-center flex items-center justify-center gap-3">
                                <i class="fas fa-trophy achievement-icon text-yellow-500"></i>
                                <span>Thành Tựu</span>
                            </h3>
                            <div class="space-y-4">
                                @foreach($achievements as $ach)
                                                <div class="badge-item flex items-center gap-4 p-4 rounded-2xl {{ 
                                                            $ach['color'] == 'bronze' ? 'badge-bronze' :
                                    ($ach['color'] == 'silver' ? 'badge-silver' :
                                        ($ach['color'] == 'gold' ? 'badge-gold' : 'badge-star')) 
                                                        }}">
                                                    <i class="{{ $ach['icon'] }} text-2xl md:text-3xl"></i>
                                                    <div class="flex-1">
                                                        <div class="font-bold text-sm md:text-base">{{ $ach['name'] }}</div>
                                                        <div class="text-xs md:text-sm opacity-90">{{ $ach['description'] }}</div>
                                                    </div>
                                                </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right: Detailed Info -->
                <div class="lg:col-span-2 space-y-8">

                    <!-- Bio -->
                    @if($profile->bio)
                        <div class="glass-card rounded-3xl shadow-2xl p-8 md:p-10 card-hover">
                            <h3 class="text-xl md:text-2xl font-bold text-purple-800 mb-6 flex items-center gap-3">
                                <i class="fas fa-quote-left section-icon text-purple-500"></i> Giới Thiệu
                            </h3>
                            <div
                                class="quote-block bg-gradient-to-br from-purple-50 to-pink-50 p-6 md:p-8 rounded-2xl border-l-4 border-purple-600 shadow-inner">
                                <p class="text-gray-700 leading-relaxed text-base md:text-lg">
                                    {{ $profile->bio }}
                                </p>
                            </div>
                        </div>
                    @endif

                    <!-- Info Grid -->
                    <div class="grid md:grid-cols-2 gap-8">
                        <!-- Occupation & Education -->
                        <div class="glass-card rounded-3xl shadow-2xl p-6 md:p-8 card-hover">
                            <div class="flex items-center gap-4 mb-6">
                                <div
                                    class="section-icon w-12 h-12 md:w-14 md:h-14 bg-gradient-to-br from-purple-500 to-purple-700 rounded-2xl flex items-center justify-center text-white text-xl md:text-2xl shadow-lg">
                                    <i class="fas fa-briefcase"></i>
                                </div>
                                <h3 class="text-lg md:text-xl font-bold text-purple-800">Nghề Nghiệp</h3>
                            </div>
                            <p class="text-base md:text-lg font-semibold text-gray-700">
                                {{ $profile->occupation ?? 'Chưa cập nhật' }}</p>
                            @if($profile->education_level)
                                <div class="mt-4 p-3 bg-purple-50 rounded-xl border border-purple-200">
                                    <p class="text-sm text-purple-700 flex items-center gap-2">
                                        <i class="fas fa-graduation-cap"></i>
                                        <span>{{ $profile->education_level }}</span>
                                        @if($profile->university)
                                            <span class="text-gray-500">- {{ $profile->university }}</span>
                                        @endif
                                    </p>
                                </div>
                            @endif
                        </div>

                        <!-- Availability & Transport -->
                        <div class="glass-card rounded-3xl shadow-2xl p-6 md:p-8 card-hover">
                            <div class="flex items-center gap-4 mb-6">
                                <div
                                    class="section-icon w-12 h-12 md:w-14 md:h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center text-white text-xl md:text-2xl shadow-lg">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <h3 class="text-lg md:text-xl font-bold text-blue-800">Thời Gian</h3>
                            </div>
                            <div
                                class="inline-block px-5 py-3 rounded-full bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 font-bold shadow-md">
                                {{ $profile->availability ?? 'Chưa cập nhật' }}
                            </div>
                            @if($profile->transportation)
                                <div class="mt-4 p-3 bg-blue-50 rounded-xl border border-blue-200">
                                    <p class="text-sm text-blue-700 flex items-center gap-2">
                                        <i class="fas fa-car"></i> {{ $profile->transportation }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Skills -->
                    @if($profile->skills)
                        <div class="glass-card rounded-3xl shadow-2xl p-8 md:p-10 card-hover">
                            <div class="flex items-center gap-4 mb-6">
                                <div
                                    class="section-icon w-12 h-12 md:w-14 md:h-14 bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl flex items-center justify-center text-white text-xl md:text-2xl shadow-lg">
                                    <i class="fas fa-tools"></i>
                                </div>
                                <h3 class="text-lg md:text-xl font-bold text-orange-800">Kỹ Năng</h3>
                            </div>
                            <div class="flex flex-wrap gap-3">
                                @foreach(explode(',', $profile->skills) as $skill)
                                    <span
                                        class="skill-tag px-4 md:px-5 py-2 md:py-3 rounded-full bg-gradient-to-r from-orange-100 to-red-100 text-orange-800 font-bold text-xs md:text-sm shadow-md border-2 border-orange-200">
                                        {{ trim($skill) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Interests -->
                    @if($profile->interests)
                        <div class="glass-card rounded-3xl shadow-2xl p-8 md:p-10 card-hover">
                            <div class="flex items-center gap-4 mb-6">
                                <div
                                    class="section-icon w-12 h-12 md:w-14 md:h-14 bg-gradient-to-br from-pink-500 to-rose-600 rounded-2xl flex items-center justify-center text-white text-xl md:text-2xl shadow-lg">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <h3 class="text-lg md:text-xl font-bold text-pink-800">Sở Thích Tình Nguyện</h3>
                            </div>
                            <div class="flex flex-wrap gap-3">
                                @foreach(explode(',', $profile->interests) as $interest)
                                    <span
                                        class="interest-tag px-4 md:px-5 py-2 md:py-3 rounded-full bg-gradient-to-r from-pink-100 to-rose-100 text-pink-800 font-bold text-xs md:text-sm shadow-md border-2 border-pink-200">
                                        {{ trim($interest) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Experience -->
                    @if($profile->volunteer_experience)
                        <div class="glass-card rounded-3xl shadow-2xl p-8 md:p-10 card-hover">
                            <div class="flex items-center gap-4 mb-6">
                                <div
                                    class="section-icon w-12 h-12 md:w-14 md:h-14 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center text-white text-xl md:text-2xl shadow-lg">
                                    <i class="fas fa-hands-helping"></i>
                                </div>
                                <h3 class="text-lg md:text-xl font-bold text-emerald-800">Kinh Nghiệm Tình Nguyện</h3>
                            </div>
                            <div
                                class="bg-gradient-to-br from-emerald-50 to-teal-50 p-6 md:p-8 rounded-2xl border-l-4 border-emerald-500 shadow-inner">
                                <p class="text-gray-700 leading-relaxed text-base md:text-lg">
                                    {{ $profile->volunteer_experience }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex flex-col md:flex-row justify-center gap-4 md:gap-6 mt-12">
                        <a href="{{ route('volunteer.profile.edit') }}"
                            class="btn-primary text-white px-8 md:px-10 py-4 md:py-5 rounded-2xl font-bold text-lg md:text-xl transform transition duration-300 flex items-center justify-center gap-3 relative z-10">
                            <i class="fas fa-edit"></i> Chỉnh Sửa Hồ Sơ
                        </a>
                        <a href="{{ route('volunteer.dashboard') }}"
                            class="btn-secondary px-8 md:px-10 py-4 md:py-5 rounded-2xl font-bold text-lg md:text-xl transition transform duration-300 flex items-center justify-center gap-3">
                            <i class="fas fa-home"></i> Về Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection