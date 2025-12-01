{{-- resources/views/volunteer/profile/profile.blade.php --}}
@extends('layouts.volunteer')

@section('title', 'Hồ Sơ Tình Nguyện - ' . $profile->user->first_name)

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
    .gradient-purple { background: linear-gradient(135deg, #8b5cf6, #6b46c1); }
    .card-hover { @apply transition transform hover:-translate-y-2 hover:shadow-2xl; }
    .badge-bronze { @apply text-orange-700 bg-orange-100; }
    .badge-silver { @apply text-gray-600 bg-gray-200; }
    .badge-gold { @apply text-yellow-600 bg-yellow-100; }
    .badge-star { @apply text-yellow-500 bg-yellow-50; }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-pink-50 to-indigo-50 py-12 px-4">
    <div class="max-w-6xl mx-auto">

        <!-- Navigation Tabs -->
        <div class="flex justify-center mb-12">
            <div class="bg-white rounded-full shadow-2xl p-2 flex space-x-2">
                <a href="{{ route('volunteer.dashboard') }}" 
                   class="px-8 py-4 rounded-full font-bold text-gray-700 hover:bg-purple-100 transition flex items-center gap-3">
                    <i class="fas fa-home"></i> Dashboard
                </a>
                <a href="{{ route('volunteer.profile.profile') }}" 
                   class="px-8 py-4 rounded-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold shadow-lg flex items-center gap-3">
                    <i class="fas fa-user-tie"></i> Hồ Sơ
                </a>
                <a href="{{ route('volunteer.profile.edit') }}" 
                   class="px-8 py-4 rounded-full font-bold text-gray-700 hover:bg-purple-100 transition flex items-center gap-3">
                    <i class="fas fa-edit"></i> Chỉnh Sửa
                </a>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">

            <!-- Left: Avatar + Info + Stats -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl shadow-2xl p-8 text-center border border-purple-100 card-hover">
                    <img src="{{ $profile->user->avatar_url 
                        ? asset('storage/'.$profile->user->avatar_url) 
                        : 'https://ui-avatars.com/api/?name='.urlencode($profile->user->first_name.' '.$profile->user->last_name).'&background=8b5cf6&color=fff&size=256' }}" 
                         class="w-48 h-48 rounded-full mx-auto object-cover border-8 border-white shadow-2xl ring-4 ring-purple-200">

                    <h1 class="text-3xl font-bold text-purple-800 mt-6">
                        {{ $profile->user->first_name }} {{ $profile->user->last_name }}
                    </h1>
                    <p class="text-xl text-gray-600 mt-2">Tình Nguyện Viên</p>

                    @if($profile->preferred_location)
                        <p class="text-sm text-gray-500 mt-2">
                            <i class="fas fa-map-marker-alt"></i> {{ $profile->preferred_location }}
                        </p>
                    @endif

                    <!-- Stats -->
                    <div class="grid grid-cols-2 gap-4 mt-8">
                        <div class="bg-gradient-to-br from-purple-500 to-purple-700 text-white rounded-2xl p-6">
                            <div class="text-3xl font-bold">{{ $stats['total_hours'] }}</div>
                            <div class="text-sm">Giờ TNV</div>
                        </div>
                        <div class="bg-gradient-to-br from-yellow-500 to-orange-600 text-white rounded-2xl p-6">
                            <div class="text-3xl font-bold">{{ number_format($stats['rating'], 1) }}</div>
                            <div class="text-sm flex items-center justify-center gap-1">
                                <i class="fas fa-star"></i> Đánh giá
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 space-y-3">
                        <div class="bg-green-50 text-green-800 px-6 py-3 rounded-xl font-bold">
                            {{ $stats['accepted_applications'] }} / {{ $stats['applications'] }} Đơn chấp nhận
                        </div>
                        <div class="bg-blue-50 text-blue-800 px-6 py-3 rounded-xl font-bold">
                            {{ $stats['completed_activities'] }} Hoạt động hoàn thành
                        </div>
                    </div>
                </div>

                <!-- Achievements -->
                @if(count($achievements) > 0)
                    <div class="bg-white rounded-3xl shadow-2xl p-8 mt-8 border border-purple-100 card-hover">
                        <h3 class="text-2xl font-bold text-purple-800 mb-6 text-center">
                            <i class="fas fa-trophy text-yellow-500"></i> Thành Tựu
                        </h3>
                        <div class="space-y-4">
                            @foreach($achievements as $ach)
                                <div class="flex items-center gap-4 p-4 rounded-2xl {{ 
                                    $ach['color'] == 'bronze' ? 'badge-bronze' : 
                                    ($ach['color'] == 'silver' ? 'badge-silver' : 
                                    ($ach['color'] == 'gold' ? 'badge-gold' : 'badge-star')) 
                                }}">
                                    <i class="{{ $ach['icon'] }} text-3xl"></i>
                                    <div>
                                        <div class="font-bold">{{ $ach['name'] }}</div>
                                        <div class="text-sm">{{ $ach['description'] }}</div>
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
                    <div class="bg-white rounded-3xl shadow-2xl p-10 border border-purple-100 card-hover">
                        <h3 class="text-2xl font-bold text-purple-800 mb-6">
                            <i class="fas fa-quote-left text-purple-500"></i> Giới Thiệu
                        </h3>
                        <p class="text-gray-700 leading-relaxed text-lg bg-purple-50 p-8 rounded-2xl border-l-4 border-purple-600">
                            {{ $profile->bio }}
                        </p>
                    </div>
                @endif

                <!-- Info Grid -->
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Occupation & Education -->
                    <div class="bg-white rounded-3xl shadow-2xl p-8 border border-purple-100 card-hover">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-700 rounded-2xl flex items-center justify-center text-white text-2xl">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <h3 class="text-xl font-bold text-purple-800">Nghề Nghiệp</h3>
                        </div>
                        <p class="text-lg font-semibold text-gray-700">{{ $profile->occupation ?? 'Chưa cập nhật' }}</p>
                        @if($profile->education_level)
                            <p class="text-sm text-gray-600 mt-3">
                                <i class="fas fa-graduation-cap"></i> {{ $profile->education_level }}
                                @if($profile->university) - {{ $profile->university }} @endif
                            </p>
                        @endif
                    </div>

                    <!-- Availability & Transport -->
                    <div class="bg-white rounded-3xl shadow-2xl p-8 border border-purple-100 card-hover">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center text-white text-2xl">
                                <i class="fas fa-clock"></i>
                            </div>
                            <h3 class="text-xl font-bold text-blue-800">Thời Gian & Di Chuyển</h3>
                        </div>
                        <p class="text-lg font-semibold">
                            <span class="px-4 py-2 rounded-full bg-blue-100 text-blue-800">
                                {{ $profile->availability ?? 'Chưa cập nhật' }}
                            </span>
                        </p>
                        @if($profile->transportation)
                            <p class="text-sm text-gray-600 mt-3">
                                <i class="fas fa-car"></i> {{ $profile->transportation }}
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Skills -->
                @if($profile->skills)
                    <div class="bg-white rounded-3xl shadow-2xl p-10 border border-purple-100 card-hover">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl flex items-center justify-center text-white text-2xl">
                                <i class="fas fa-tools"></i>
                            </div>
                            <h3 class="text-xl font-bold text-orange-800">Kỹ Năng</h3>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            @foreach(explode(',', $profile->skills) as $skill)
                                <span class="px-5 py-3 rounded-full bg-orange-100 text-orange-800 font-bold text-sm shadow">
                                    {{ trim($skill) }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Interests -->
                @if($profile->interests)
                    <div class="bg-white rounded-3xl shadow-2xl p-10 border border-purple-100 card-hover">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 bg-gradient-to-br from-pink-500 to-rose-600 rounded-2xl flex items-center justify-center text-white text-2xl">
                                <i class="fas fa-heart"></i>
                            </div>
                            <h3 class="text-xl font-bold text-pink-800">Sở Thích Tình Nguyện</h3>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            @foreach(explode(',', $profile->interests) as $interest)
                                <span class="px-5 py-3 rounded-full bg-pink-100 text-pink-800 font-bold text-sm shadow">
                                    {{ trim($interest) }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Experience -->
                @if($profile->volunteer_experience)
                    <div class="bg-white rounded-3xl shadow-2xl p-10 border border-purple-100 card-hover">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center text-white text-2xl">
                                <i class="fas fa-hands-helping"></i>
                            </div>
                            <h3 class="text-xl font-bold text-emerald-800">Kinh Nghiệm Tình Nguyện</h3>
                        </div>
                        <div class="bg-emerald-50 p-8 rounded-2xl border-l-4 border-emerald-500">
                            <p class="text-gray-700 leading-relaxed text-lg">{{ $profile->volunteer_experience }}</p>
                        </div>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex justify-center gap-6 mt-12">
                    <a href="{{ route('volunteer.profile.edit') }}" 
                       class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-10 py-5 rounded-2xl font-bold text-xl shadow-2xl hover:shadow-purple-500/50 transform hover:scale-105 transition duration-300 flex items-center gap-4">
                        <i class="fas fa-edit"></i> Chỉnh Sửa Hồ Sơ
                    </a>
                    <a href="{{ route('volunteer.dashboard') }}" 
                       class="bg-white text-purple-700 px-10 py-5 rounded-2xl font-bold text-xl border-4 border-purple-600 hover:bg-purple-600 hover:text-white transition transform hover:scale-105 shadow-2xl flex items-center gap-4">
                        <i class="fas fa-home"></i> Về Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection