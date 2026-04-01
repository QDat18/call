@extends('layouts.app')

@section('title', 'Bảng Vàng Danh Dự')

@section('content')
    <style>
        @keyframes shine {
            0% {
                background-position: -200% center;
            }

            100% {
                background-position: 200% center;
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes glow-pulse {

            0%,
            100% {
                box-shadow: 0 0 20px rgba(251, 191, 36, 0.4), 0 0 40px rgba(251, 191, 36, 0.2);
            }

            50% {
                box-shadow: 0 0 40px rgba(251, 191, 36, 0.6), 0 0 80px rgba(251, 191, 36, 0.4);
            }
        }

        @keyframes sparkle {

            0%,
            100% {
                opacity: 0;
                transform: scale(0) rotate(0deg);
            }

            50% {
                opacity: 1;
                transform: scale(1) rotate(180deg);
            }
        }

        .shine-effect {
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            background-size: 200% 100%;
            animation: shine 3s infinite;
        }

        .golden-text {
            background: linear-gradient(135deg, #ffd700 0%, #ffed4e 25%, #ffd700 50%, #ffb700 75%, #ffd700 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            background-size: 200% auto;
            animation: shine 3s linear infinite;
        }

        .golden-border {
            border: 3px solid #ffd700;
            box-shadow: 0 0 30px rgba(255, 215, 0, 0.5), inset 0 0 20px rgba(255, 215, 0, 0.2);
        }

        .sparkle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: #ffd700;
            border-radius: 50%;
            animation: sparkle 2s infinite;
        }
    </style>

    <div
        class="min-h-screen bg-gradient-to-br from-amber-950 via-slate-900 to-yellow-950 relative overflow-hidden font-sans">
        {{-- Animated Background --}}
        <div class="absolute inset-0 opacity-30">
            <div
                class="absolute top-0 left-0 w-full h-full bg-[radial-gradient(circle_at_20%_20%,rgba(251,191,36,0.15),transparent_50%)]">
            </div>
            <div
                class="absolute top-0 right-0 w-full h-full bg-[radial-gradient(circle_at_80%_20%,rgba(217,119,6,0.15),transparent_50%)]">
            </div>
            <div
                class="absolute bottom-0 left-1/2 w-full h-full bg-[radial-gradient(circle_at_50%_80%,rgba(251,191,36,0.1),transparent_50%)]">
            </div>
        </div>

        {{-- Sparkle Effects --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            @for($i = 0; $i < 20; $i++)
                <div class="sparkle"
                    style="top: {{ rand(0, 100) }}%; left: {{ rand(0, 100) }}%; animation-delay: {{ $i * 0.3 }}s;"></div>
            @endfor
        </div>

        {{-- Grand Header --}}
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-16 text-center">
            {{-- Crown Icon --}}
            <div class="mb-6 inline-block" style="animation: float 3s ease-in-out infinite;">
                <div class="relative">
                    <i class="fas fa-crown text-8xl text-yellow-400 drop-shadow-[0_0_30px_rgba(251,191,36,0.8)]"></i>
                    <div class="absolute inset-0 shine-effect"></div>
                </div>
            </div>

            {{-- Badge --}}
            <div
                class="inline-flex items-center gap-2 py-2 px-6 rounded-full bg-gradient-to-r from-yellow-600/30 via-amber-500/30 to-yellow-600/30 border-2 border-yellow-500/50 backdrop-blur-sm mb-6">
                <i class="fas fa-award text-yellow-400 text-sm"></i>
                <span class="text-yellow-300 text-sm font-bold tracking-[0.3em] uppercase">Hall of Fame</span>
                <i class="fas fa-award text-yellow-400 text-sm"></i>
            </div>

            {{-- Main Title --}}
            <h1 class="text-6xl md:text-8xl font-black text-white tracking-tight mb-6 relative">
                <span class="block golden-text drop-shadow-[0_0_50px_rgba(251,191,36,0.5)]">
                    BẢNG VÀNG
                </span>
                <span class="block text-5xl md:text-7xl mt-2 golden-text">
                    VolunteerConnect
                </span>
            </h1>

            {{-- Subtitle --}}
            <p class="text-amber-200/90 text-xl md:text-2xl max-w-3xl mx-auto font-light tracking-wide">
                Vinh danh những cá nhân và tổ chức xuất sắc nhất
            </p>

            {{-- Decorative Line --}}
            <div class="flex items-center justify-center gap-4 mt-8">
                <div class="h-px w-20 bg-gradient-to-r from-transparent to-yellow-500"></div>
                <i class="fas fa-star text-yellow-400 text-xl"></i>
                <div class="h-px w-20 bg-gradient-to-l from-transparent to-yellow-500"></div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

                {{-- === TOP TÌNH NGUYỆN VIÊN === --}}
                <div class="flex flex-col">
                    {{-- Section Header --}}
                    <div class="relative mb-10">
                        <div
                            class="bg-gradient-to-r from-transparent via-blue-900/50 to-transparent p-6 rounded-2xl backdrop-blur-sm border border-blue-500/30">
                            <div class="flex items-center justify-center gap-4">
                                <div class="p-4 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 golden-border"
                                    style="animation: glow-pulse 2s infinite;">
                                    <i class="fas fa-user-astronaut text-3xl text-white"></i>
                                </div>
                                <div class="text-center">
                                    <h2 class="text-3xl font-black golden-text tracking-wide">TOP TÌNH NGUYỆN VIÊN</h2>
                                    <p class="text-amber-300/80 text-sm mt-1 tracking-widest uppercase">Xếp hạng theo giờ
                                        cống hiến</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- PODIUM TOP 3 --}}
                    <div class="relative mb-12">
                        <div class="grid grid-cols-3 gap-4 items-end h-80">
                            {{-- Hạng 2 - SILVER --}}
                            @if(isset($topVolunteers[1]))
                                                <div class="relative flex flex-col items-center group">
                                                    <div class="absolute -top-6 w-full text-center">
                                                        <i class="fas fa-medal text-4xl text-slate-300 drop-shadow-lg"></i>
                                                    </div>
                                                    <div class="relative mb-4 mt-8">
                                                        <div class="absolute inset-0 bg-slate-300 rounded-full blur-xl opacity-50"></div>
                                                        <img src="{{ !empty($topVolunteers[1]->user->avatar_url)
                                ? (\Illuminate\Support\Str::startsWith($topVolunteers[1]->user->avatar_url, ['http'])
                                    ? $topVolunteers[1]->user->avatar_url
                                    : asset('storage/' . $topVolunteers[1]->user->avatar_url))
                                : 'https://ui-avatars.com/api/?name=' . urlencode($topVolunteers[1]->user->first_name) . '&background=random' }}"
                                                            class="w-16 h-16 rounded-full object-cover border-4 border-slate-300 shadow-lg">
                                                        <div
                                                            class="absolute -bottom-3 left-1/2 -translate-x-1/2 bg-gradient-to-r from-slate-200 to-slate-400 text-slate-900 text-lg font-black px-4 py-1 rounded-full shadow-lg border-2 border-white">
                                                            2</div>
                                                    </div>
                                                    <div
                                                        class="w-full bg-gradient-to-b from-slate-400/20 to-slate-800/80 backdrop-blur-md rounded-t-3xl p-5 flex flex-col items-center justify-end h-36 border-t-4 border-slate-300 relative overflow-hidden">
                                                        <div class="absolute inset-0 shine-effect"></div>
                                                        <h3
                                                            class="relative text-white font-bold text-base truncate w-full text-center mb-2 drop-shadow-lg">
                                                            {{ $topVolunteers[1]->user->first_name }}</h3>
                                                        <div class="relative bg-slate-700/50 px-3 py-1 rounded-full backdrop-blur-sm">
                                                            <span
                                                                class="text-slate-200 text-sm font-bold">{{ $topVolunteers[1]->total_volunteer_hours }}
                                                                giờ</span>
                                                        </div>
                                                    </div>
                                                </div>
                            @endif

                            {{-- Hạng 1 - GOLD --}}
                            @if(isset($topVolunteers[0]))
                                <div class="relative flex flex-col items-center z-20 group transform scale-110">
                                    <div class="absolute -top-8 w-full text-center animate-bounce">
                                        <i
                                            class="fas fa-crown text-6xl golden-text drop-shadow-[0_0_30px_rgba(251,191,36,0.8)]"></i>
                                    </div>
                                    <div class="relative mb-4 mt-12">
                                        <div
                                            class="absolute inset-0 bg-yellow-400 rounded-full blur-2xl opacity-60 animate-pulse">
                                        </div>
                                        <img src="{{ $topVolunteers[0]->user->avatar_url ? asset('storage/' . $topVolunteers[0]->user->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($topVolunteers[0]->user->first_name) . '&background=random' }}"
                                            class="relative w-32 h-32 rounded-full object-cover golden-border group-hover:scale-110 transition-all duration-300"
                                            style="animation: glow-pulse 2s infinite;">
                                        <div
                                            class="absolute -bottom-4 left-1/2 -translate-x-1/2 bg-gradient-to-r from-yellow-400 via-amber-500 to-yellow-400 text-amber-950 text-2xl font-black px-6 py-2 rounded-full shadow-2xl border-4 border-yellow-300">
                                            1</div>
                                    </div>
                                    <div
                                        class="w-full bg-gradient-to-b from-yellow-500/30 via-amber-600/20 to-slate-800/80 backdrop-blur-md rounded-t-3xl p-6 flex flex-col items-center justify-end h-48 border-t-4 border-yellow-400 relative overflow-hidden">
                                        <div class="absolute inset-0 shine-effect"></div>
                                        <h3
                                            class="relative text-white font-black text-xl truncate w-full text-center mb-3 drop-shadow-lg">
                                            {{ $topVolunteers[0]->user->first_name }}</h3>
                                        <div
                                            class="relative bg-gradient-to-r from-yellow-600/50 to-amber-600/50 px-4 py-2 rounded-full backdrop-blur-sm border-2 border-yellow-400/50">
                                            <span
                                                class="golden-text text-lg font-black">{{ $topVolunteers[0]->total_volunteer_hours }}
                                                giờ</span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Hạng 3 - BRONZE --}}
                            @if(isset($topVolunteers[2]))
                                <div class="relative flex flex-col items-center group">
                                    <div class="absolute -top-6 w-full text-center">
                                        <i class="fas fa-medal text-4xl text-amber-700 drop-shadow-lg"></i>
                                    </div>
                                    <div class="relative mb-4 mt-8">
                                        <div class="absolute inset-0 bg-amber-700 rounded-full blur-xl opacity-50"></div>
                                        <img src="{{ $topVolunteers[2]->user->avatar_url ? asset('storage/' . $topVolunteers[2]->user->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($topVolunteers[2]->user->first_name) . '&background=random' }}"
                                            class="relative w-24 h-24 rounded-full object-cover border-4 border-amber-700 shadow-2xl group-hover:scale-110 transition-all duration-300">
                                        <div
                                            class="absolute -bottom-3 left-1/2 -translate-x-1/2 bg-gradient-to-r from-amber-600 to-amber-800 text-amber-100 text-lg font-black px-4 py-1 rounded-full shadow-lg border-2 border-amber-400">
                                            3</div>
                                    </div>
                                    <div
                                        class="w-full bg-gradient-to-b from-amber-700/20 to-slate-800/80 backdrop-blur-md rounded-t-3xl p-5 flex flex-col items-center justify-end h-28 border-t-4 border-amber-700 relative overflow-hidden">
                                        <div class="absolute inset-0 shine-effect"></div>
                                        <h3
                                            class="relative text-white font-bold text-base truncate w-full text-center mb-2 drop-shadow-lg">
                                            {{ $topVolunteers[2]->user->first_name }}</h3>
                                        <div class="relative bg-amber-900/50 px-3 py-1 rounded-full backdrop-blur-sm">
                                            <span
                                                class="text-amber-200 text-sm font-bold">{{ $topVolunteers[2]->total_volunteer_hours }}
                                                giờ</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- List 4-10 --}}
                    <div
                        class="bg-gradient-to-br from-slate-800/50 to-slate-900/50 rounded-3xl border-2 border-yellow-600/30 p-6 backdrop-blur-sm shadow-2xl">
                        <div class="space-y-3">
                            @foreach($topVolunteers->slice(3) as $index => $profile)
                                <div
                                    class="flex items-center p-4 rounded-xl bg-slate-800/40 hover:bg-gradient-to-r hover:from-yellow-900/20 hover:to-slate-800/40 transition-all duration-300 group border border-slate-700/50 hover:border-yellow-600/50">
                                    <div class="w-10 text-center">
                                        <span
                                            class="text-2xl font-black text-yellow-600/50 group-hover:text-yellow-400 transition">{{ $loop->iteration + 3 }}</span>
                                    </div>
                                    <img src="{{ $profile->user->avatar_url ? asset('storage/' . $profile->user->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($profile->user->first_name) . '&background=random' }}"
                                        class="w-12 h-12 rounded-full object-cover mx-4 border-2 border-slate-600 group-hover:border-yellow-500 transition-all">
                                    <div class="flex-grow">
                                        <a href="{{ route('user.public-profile', $profile->user_id) }}"
                                            class="text-slate-100 font-bold hover:text-yellow-300 transition block text-lg">
                                            {{ $profile->user->first_name }} {{ $profile->user->last_name }}
                                        </a>
                                    </div>
                                    <div class="bg-slate-700/50 px-4 py-2 rounded-full">
                                        <span class="text-amber-400 font-bold text-sm">{{ $profile->total_volunteer_hours }}
                                            giờ</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- === TOP TỔ CHỨC === --}}
                <div class="flex flex-col">
                    {{-- Section Header --}}
                    <div class="relative mb-10">
                        <div
                            class="bg-gradient-to-r from-transparent via-emerald-900/50 to-transparent p-6 rounded-2xl backdrop-blur-sm border border-emerald-500/30">
                            <div class="flex items-center justify-center gap-4">
                                <div class="p-4 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 golden-border"
                                    style="animation: glow-pulse 2s infinite 0.5s;">
                                    <i class="fas fa-building text-3xl text-white"></i>
                                </div>
                                <div class="text-center">
                                    <h2 class="text-3xl font-black golden-text tracking-wide">TOP TỔ CHỨC</h2>
                                    <p class="text-amber-300/80 text-sm mt-1 tracking-widest uppercase">Xếp hạng theo đóng
                                        góp</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- PODIUM TOP 3 --}}
                    <div class="relative mb-12">
                        <div class="grid grid-cols-3 gap-4 items-end h-80">
                            {{-- Hạng 2 - SILVER --}}
                            @if(isset($topOrganizations[1]))
                                <div class="relative flex flex-col items-center group">
                                    <div class="absolute -top-6 w-full text-center">
                                        <i class="fas fa-medal text-4xl text-slate-300 drop-shadow-lg"></i>
                                    </div>
                                    <div class="relative mb-4 mt-8">
                                        <div class="absolute inset-0 bg-slate-300 rounded-xl blur-xl opacity-50"></div>
                                        <img src="{{ $topOrganizations[1]->user->avatar_url ? asset('storage/' . $topOrganizations[1]->user->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($topOrganizations[1]->organization_name) . '&background=random' }}"
                                            class="relative w-24 h-24 rounded-xl object-cover border-4 border-slate-300 shadow-2xl group-hover:scale-110 transition-all duration-300">
                                        <div
                                            class="absolute -bottom-3 left-1/2 -translate-x-1/2 bg-gradient-to-r from-slate-200 to-slate-400 text-slate-900 text-lg font-black px-4 py-1 rounded-full shadow-lg border-2 border-white">
                                            2</div>
                                    </div>
                                    <div
                                        class="w-full bg-gradient-to-b from-slate-400/20 to-slate-800/80 backdrop-blur-md rounded-t-3xl p-5 flex flex-col items-center justify-end h-36 border-t-4 border-slate-300 relative overflow-hidden">
                                        <div class="absolute inset-0 shine-effect"></div>
                                        <h3
                                            class="relative text-white font-bold text-sm truncate w-full text-center mb-2 drop-shadow-lg">
                                            {{ $topOrganizations[1]->organization_name }}</h3>
                                        <div
                                            class="relative flex items-center gap-1 bg-slate-700/50 px-3 py-1 rounded-full backdrop-blur-sm">
                                            <i class="fas fa-star text-yellow-400 text-xs"></i>
                                            <span
                                                class="text-slate-200 text-sm font-bold">{{ number_format($topOrganizations[1]->rating, 1) }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Hạng 1 - GOLD --}}
                            @if(isset($topOrganizations[0]))
                                <div class="relative flex flex-col items-center z-20 group transform scale-110">
                                    <div class="absolute -top-8 w-full text-center animate-bounce"
                                        style="animation-delay: 0.3s;">
                                        <i
                                            class="fas fa-trophy text-6xl golden-text drop-shadow-[0_0_30px_rgba(251,191,36,0.8)]"></i>
                                    </div>
                                    <div class="relative mb-4 mt-12">
                                        <div
                                            class="absolute inset-0 bg-emerald-400 rounded-xl blur-2xl opacity-60 animate-pulse">
                                        </div>
                                        <img src="{{ $topOrganizations[0]->user->avatar_url ? asset('storage/' . $topOrganizations[0]->user->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($topOrganizations[0]->organization_name) . '&background=random' }}"
                                            class="relative w-32 h-32 rounded-xl object-cover golden-border group-hover:scale-110 transition-all duration-300"
                                            style="animation: glow-pulse 2s infinite;">
                                        <div
                                            class="absolute -bottom-4 left-1/2 -translate-x-1/2 bg-gradient-to-r from-yellow-400 via-amber-500 to-yellow-400 text-amber-950 text-2xl font-black px-6 py-2 rounded-full shadow-2xl border-4 border-yellow-300">
                                            1</div>
                                    </div>
                                    <div
                                        class="w-full bg-gradient-to-b from-emerald-500/30 via-teal-600/20 to-slate-800/80 backdrop-blur-md rounded-t-3xl p-6 flex flex-col items-center justify-end h-48 border-t-4 border-emerald-400 relative overflow-hidden">
                                        <div class="absolute inset-0 shine-effect"></div>
                                        <h3
                                            class="relative text-white font-black text-lg truncate w-full text-center mb-3 drop-shadow-lg">
                                            {{ $topOrganizations[0]->organization_name }}</h3>
                                        <div
                                            class="relative flex items-center gap-2 bg-gradient-to-r from-yellow-600/50 to-amber-600/50 px-4 py-2 rounded-full backdrop-blur-sm border-2 border-yellow-400/50">
                                            <i class="fas fa-star text-yellow-300 text-lg"></i>
                                            <span
                                                class="golden-text text-lg font-black">{{ number_format($topOrganizations[0]->rating, 1) }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Hạng 3 - BRONZE --}}
                            @if(isset($topOrganizations[2]))
                                <div class="relative flex flex-col items-center group">
                                    <div class="absolute -top-6 w-full text-center">
                                        <i class="fas fa-medal text-4xl text-amber-700 drop-shadow-lg"></i>
                                    </div>
                                    <div class="relative mb-4 mt-8">
                                        <div class="absolute inset-0 bg-amber-700 rounded-xl blur-xl opacity-50"></div>
                                        <img src="{{ $topOrganizations[2]->user->avatar_url ? asset('storage/' . $topOrganizations[2]->user->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($topOrganizations[2]->organization_name) . '&background=random' }}"
                                            class="relative w-24 h-24 rounded-xl object-cover border-4 border-amber-700 shadow-2xl group-hover:scale-110 transition-all duration-300">
                                        <div
                                            class="absolute -bottom-3 left-1/2 -translate-x-1/2 bg-gradient-to-r from-amber-600 to-amber-800 text-amber-100 text-lg font-black px-4 py-1 rounded-full shadow-lg border-2 border-amber-400">
                                            3</div>
                                    </div>
                                    <div
                                        class="w-full bg-gradient-to-b from-amber-700/20 to-slate-800/80 backdrop-blur-md rounded-t-3xl p-5 flex flex-col items-center justify-end h-28 border-t-4 border-amber-700 relative overflow-hidden">
                                        <div class="absolute inset-0 shine-effect"></div>
                                        <h3
                                            class="relative text-white font-bold text-sm truncate w-full text-center mb-2 drop-shadow-lg">
                                            {{ $topOrganizations[2]->organization_name }}</h3>
                                        <div
                                            class="relative flex items-center gap-1 bg-amber-900/50 px-3 py-1 rounded-full backdrop-blur-sm">
                                            <i class="fas fa-star text-yellow-400 text-xs"></i>
                                            <span
                                                class="text-amber-200 text-sm font-bold">{{ number_format($topOrganizations[2]->rating, 1) }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- List 4-10 --}}
                    <div
                        class="bg-gradient-to-br from-slate-800/50 to-slate-900/50 rounded-3xl border-2 border-yellow-600/30 p-6 backdrop-blur-sm shadow-2xl">
                        <div class="space-y-3">
                            @foreach($topOrganizations->slice(3) as $index => $org)
                                <div
                                    class="flex items-center p-4 rounded-xl bg-slate-800/40 hover:bg-gradient-to-r hover:from-emerald-900/20 hover:to-slate-800/40 transition-all duration-300 group border border-slate-700/50 hover:border-emerald-600/50">
                                    <div class="w-10 text-center">
                                        <span
                                            class="text-2xl font-black text-yellow-600/50 group-hover:text-yellow-400 transition">{{ $loop->iteration + 3 }}</span>
                                    </div>
                                    <img src="{{ $org->user->avatar_url ? asset('storage/' . $org->user->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($org->organization_name) . '&background=random' }}"
                                        class="w-12 h-12 rounded-lg object-cover mx-4 border-2 border-slate-600 group-hover:border-emerald-500 transition-all">
                                    <div class="flex-grow">
                                        <a href="{{ route('organizations.show', $org->org_id) }}"
                                            class="text-slate-100 font-bold hover:text-emerald-300 transition block text-lg">
                                            {{ $org->organization_name }}
                                        </a>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <div class="bg-emerald-900/30 px-3 py-1 rounded-full flex items-center gap-1">
                                            <i class="fas fa-bullhorn text-emerald-400 text-xs"></i>
                                            <span
                                                class="text-emerald-300 text-sm font-bold">{{ $org->opportunities_count }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Footer Decoration --}}
        <div class="relative z-10 text-center pb-12">
            <div class="flex items-center justify-center gap-3">
                <div class="h-px w-24 bg-gradient-to-r from-transparent to-yellow-500/50"></div>
                <i class="fas fa-trophy text-yellow-400 text-2xl"></i>
                <i class="fas fa-star text-yellow-400 text-lg"></i>
                <i class="fas fa-trophy text-yellow-400 text-2xl"></i>
                <div class="h-px w-24 bg-gradient-to-l from-transparent to-yellow-500/50"></div>
            </div>
        </div>
    </div>
@endsection