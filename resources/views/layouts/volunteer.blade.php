{{-- resources/views/layouts/volunteer.blade.php --}}

<!DOCTYPE html>
<html lang="vi" class="h-full" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true', mobileMenuOpen: false }"
    :class="{ 'dark': darkMode }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Lan Tỏa Yêu Thương')</title>
    <link rel="icon" href="{{ asset('local.jpg') }}" type="image/jpeg">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#8b5cf6',
                        'primary-hover': '#7c3aed',
                    },
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] }
                }
            }
        }
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        .glass { background: rgba(255,255,255,0.92); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(139,92,246,0.1); }
        .glass-dark { background: rgba(15,23,42,0.95); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(139,92,246,0.2); }
        .gradient-text { background: linear-gradient(135deg, #a78bfa, #8b5cf6); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; }
    </style>
    @stack('styles')
</head>

<body class="h-full bg-gradient-to-br from-purple-50 via-white to-pink-50 dark:from-slate-900 dark:via-purple-950/30 dark:to-pink-950/20">

<div class="flex min-h-screen">

    <!-- SIDEBAR TRÁI - MÀU TÍM -->
    <aside class="fixed inset-y-0 left-0 w-64 bg-white dark:bg-slate-900 border-r border-purple-100 dark:border-purple-900/50 shadow-2xl z-50">
        <div class="p-6">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center shadow-lg">
                    <i class="fas fa-heart text-white text-xl"></i>
                </div>
                <h1 class="text-xl font-bold text-gray-800 dark:text-white">Lan Tỏa Yêu Thương</h1>
            </div>

            <div class="bg-purple-50 dark:bg-purple-900/30 rounded-2xl p-5 text-center mb-6 border border-purple-200 dark:border-purple-800">
                <img src="{{ auth()->user()->avatar_url ? asset('storage/'.auth()->user()->avatar_url) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=8b5cf6&color=fff&size=100' }}"
                     class="w-20 h-20 rounded-full mx-auto mb-3 object-cover ring-4 ring-purple-300 dark:ring-purple-700">
                <h3 class="font-bold text-gray-800 dark:text-white text-lg">{{ auth()->user()->first_name }}</h3>
                <p class="text-xs text-purple-600 dark:text-purple-400 mt-2">
                    <i class="fas fa-clock"></i> {{ auth()->user()->volunteerProfile->total_volunteer_hours ?? 0 }} giờ tình nguyện
                </p>
            </div>

            <nav class="space-y-2">
                <x-volunteer.sidebar-link route="volunteer.dashboard" icon="fa-home">Trang chủ</x-volunteer.sidebar-link>
                <x-volunteer.sidebar-link route="opportunities.index" icon="fa-search">Tìm cơ hội</x-volunteer.sidebar-link>
                <x-volunteer.sidebar-link route="volunteer.applications.my" icon="fa-heart">Đơn của tôi</x-volunteer.sidebar-link>
                <x-volunteer.sidebar-link route="volunteer.activities.index" icon="fa-history">Lịch sử</x-volunteer.sidebar-link>
                <x-volunteer.sidebar-link route="volunteer.favorites.index" icon="fa-bookmark">Yêu thích</x-volunteer.sidebar-link>
                <x-volunteer.sidebar-link route="volunteer.analytics" icon="fa-chart-pie">Thống kê</x-volunteer.sidebar-link>
                <x-volunteer.sidebar-link route="volunteer.profile.edit" icon="fa-user">Hồ sơ</x-volunteer.sidebar-link>
            </nav>
        </div>

        <div class="p-6 border-t border-purple-100 dark:border-purple-900/50">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-purple-600 dark:text-purple-400 hover:bg-purple-100 dark:hover:bg-purple-900/50 transition font-medium">
                    <i class="fas fa-sign-out-alt"></i> Đăng xuất
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="flex-1 ml-64 min-h-screen flex flex-col">

        <!-- TOPBAR - NỀN TRẮNG + TÍM -->
        <nav class="glass dark:glass-dark sticky top-0 z-40 shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">

                    <div class="flex items-center gap-8">
                        <a href="{{ route('home') }}" class="flex items-center gap-3">
                            <div class="relative group">
                                <div class="absolute inset-0 bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl blur-lg opacity-70 group-hover:opacity-100 transition"></div>
                                <img src="{{ asset('local.jpg') }}" class="relative w-10 h-10 rounded-xl object-cover shadow-md">
                            </div>
                            <span class="font-bold text-2xl gradient-text hidden sm:block">VolunteerConnect</span>
                        </a>

                        <div class="hidden lg:flex items-center gap-1">
                            <a href="{{ route('opportunities.index') }}" class="px-5 py-2.5 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-purple-100 dark:hover:bg-purple-900/40 hover:text-purple-600 font-medium transition">Tìm Cơ Hội</a>
                            <a href="{{ route('organizations.index') }}" class="px-5 py-2.5 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-purple-100 dark:hover:bg-purple-900/40 hover:text-purple-600 font-medium transition">Tổ Chức</a>
                            <a href="{{ route('posts.index') }}" class="px-5 py-2.5 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-purple-100 dark:hover:bg-purple-900/40 hover:text-purple-600 font-medium transition">Cộng Đồng</a>
                            <a href="{{ route('about') }}" class="px-5 py-2.5 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-purple-100 dark:hover:bg-purple-900/40 hover:text-purple-600 font-medium transition">Giới Thiệu</a>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">

                        <!-- Dark Mode -->
                        <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)"
                                class="p-3 rounded-xl hover:bg-purple-100 dark:hover:bg-purple-900/40 transition">
                            <i class="fas text-lg" :class="darkMode ? 'fa-sun text-yellow-400' : 'fa-moon text-purple-600'"></i>
                        </button>

                        @auth
                            <!-- Notification -->
                            <button class="relative p-3 rounded-xl hover:bg-purple-100 dark:hover:bg-purple-900/40 transition">
                                <i class="fas fa-bell text-xl text-gray-700 dark:text-gray-300"></i>
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                    <span class="absolute -top-1 -right-1 w-3 h-3 bg-pink-500 rounded-full animate-pulse"></span>
                                @endif
                            </button>

                            <!-- USER MENU - TRẮNG + TÍM ĐẸP NHẤT -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center gap-3 p-2 rounded-2xl hover:bg-purple-100 dark:hover:bg-purple-900/50 transition-all duration-300">
                                    <img src="{{ Auth::user()->avatar_url ? asset('storage/'.Auth::user()->avatar_url) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->first_name).'&background=8b5cf6&color=fff' }}"
                                         class="w-10 h-10 rounded-full ring-4 ring-purple-200 dark:ring-purple-700 object-cover">
                                    <span class="hidden md:block font-semibold text-gray-800 dark:text-white">{{ Auth::user()->first_name }}</span>
                                    <i class="fas fa-chevron-down text-sm transition-transform duration-300" :class="{ 'rotate-180': open }"></i>
                                </button>

                                <!-- DROPDOWN SIÊU ĐẸP - NỀN TRẮNG -->
                                <div x-show="open"
                                     @click.away="open = false"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-end="opacity-0 scale-95"
                                     class="absolute right-0 mt-3 w-80 bg-white dark:bg-slate-800 rounded-3xl shadow-2xl border border-purple-200 dark:border-purple-700 overflow-hidden z-50">

                                    <div class="px-6 py-5 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/40 dark:to-pink-900/30 border-b border-purple-200 dark:border-purple-800">
                                        <p class="font-bold text-lg text-gray-900 dark:text-white">{{ Auth::user()->name }}</p>
                                        <p class="text-sm text-purple-700 dark:text-purple-300">{{ Auth::user()->email }}</p>
                                    </div>

                                    <div class="py-3">
                                        <a href="{{ route('dashboard') }}" class="flex items-center gap-4 px-6 py-4 hover:bg-purple-50 dark:hover:bg-purple-900/50 text-gray-700 dark:text-gray-200 hover:text-purple-600 transition">
                                            <i class="fas fa-tachometer-alt text-purple-600 w-5"></i>
                                            <span class="font-medium">Dashboard</span>
                                        </a>

                                        @if(Auth::user()->user_type === 'Volunteer')
                                            <a href="{{ route('volunteer.profile.profile') }}" class="flex items-center gap-4 px-6 py-4 hover:bg-purple-50 dark:hover:bg-purple-900/50 text-gray-700 dark:text-gray-200 hover:text-purple-600 transition">
                                                <i class="fas fa-user-tie text-purple-600 w-5"></i>
                                                <span class="font-medium">Hồ Sơ Của Tôi</span>
                                            </a>
                                            <a href="{{ route('volunteer.profile.edit') }}" class="flex items-center gap-4 px-6 py-4 hover:bg-purple-50 dark:hover:bg-purple-900/50 text-gray-700 dark:text-gray-200 hover:text-purple-600 transition">
                                                <i class="fas fa-edit text-purple-600 w-5"></i>
                                                <span class="font-medium">Chỉnh sửa hồ sơ</span>
                                            </a>
                                        @elseif(Auth::user()->user_type === 'Organization')
                                            <a href="{{ route('organization.profile.show') }}" class="flex items-center gap-4 px-6 py-4 hover:bg-purple-50 dark:hover:bg-purple-900/50 text-gray-700 dark:text-gray-200 hover:text-purple-600 transition">
                                                <i class="fas fa-building text-purple-600 w-5"></i>
                                                <span class="font-medium">Hồ Sơ Tổ Chức</span>
                                            </a>
                                        @elseif(Auth::user()->user_type === 'Admin')
                                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 px-6 py-4 hover:bg-purple-50 dark:hover:bg-purple-900/50 text-gray-700 dark:text-gray-200 hover:text-purple-600 transition">
                                                <i class="fas fa-cog text-purple-600 w-5"></i>
                                                <span class="font-medium">Admin Panel</span>
                                            </a>
                                        @endif

                                        <div class="border-t border-purple-200 dark:border-purple-800 my-2"></div>

                                        <form method="POST" action="{{ route('logout') }}" class="px-6 py-3">
                                            @csrf
                                            <button class="w-full text-left flex items-center gap-4 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-xl px-4 py-3 font-medium transition">
                                                <i class="fas fa-sign-out-alt w-5"></i>
                                                <span>Đăng xuất</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endauth

                        <!-- Mobile menu button -->
                        <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-3 rounded-xl hover:bg-purple-100 dark:hover:bg-purple-900/40">
                            <i class="fas text-xl" :class="mobileMenuOpen ? 'fa-times' : 'fa-bars'"></i>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- MAIN CONTENT -->
        <main class="flex-1 p-6 lg:p-10">
            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>