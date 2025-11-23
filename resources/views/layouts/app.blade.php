<!DOCTYPE html>
<html lang="vi" class="h-full scroll-smooth" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
    :class="{ 'dark': darkMode }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'VolunteerConnect Platform')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eef2ff', 100: '#e0e7ff', 200: '#c7d2fe',
                            300: '#a5b4fc', 400: '#818cf8', 500: '#6366f1',
                            600: '#4f46e5', 700: '#4338ca', 800: '#3730a3', 900: '#312e81',
                        }
                    },
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
                }
            }
        }
    </script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #6366f1, #4f46e5);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #4f46e5, #4338ca);
        }

        .dark ::-webkit-scrollbar-track {
            background: #1e293b;
        }

        .dark ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #4f46e5, #3730a3);
        }

        /* Glass morphism */
        .glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .glass-dark {
            background: rgba(30, 41, 59, 0.8);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        /* Animations */
        @keyframes pulse-ring {

            0%,
            100% {
                transform: scale(0.8);
                opacity: 1;
            }

            50% {
                transform: scale(1.2);
                opacity: 0.3;
            }
        }

        .notification-badge {
            animation: pulse-ring 2s ease-in-out infinite;
        }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Nav link underline */
        .nav-link {
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #6366f1, #8b5cf6);
            transition: width 0.3s ease, left 0.3s ease;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
            left: 0;
        }

        /* Avatar border */
        .avatar-border {
            border: 3px solid transparent;
            background: linear-gradient(white, white) padding-box, linear-gradient(135deg, #667eea, #764ba2) border-box;
        }

        /* Selection */
        ::selection {
            background-color: #6366f1;
            color: white;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    @stack('styles')
</head>

<body
    class="h-full bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800">
    <div class="min-h-full">
        <!-- Navigation -->
        <nav class="glass dark:glass-dark sticky top-0 z-50 border-b border-gray-200/50 dark:border-gray-700/50 shadow-lg"
            x-data="{ mobileMenuOpen: false }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Logo & Main Nav -->
                    <div class="flex items-center space-x-8">
                        <a href="{{ route('home') }}" class="flex items-center space-x-2 group">
                            <div class="relative">
                                <div
                                    class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg blur opacity-75 group-hover:opacity-100 transition">
                                </div>
                                <div class="relative bg-gradient-to-r from-indigo-600 to-purple-600 p-2 rounded-lg">
                                    <i class="fas fa-hands-helping text-white text-xl"></i>
                                </div>
                            </div>
                            <span class="font-bold text-xl gradient-text hidden sm:block">VolunteerConnect</span>
                        </a>

                        <!-- Desktop Navigation -->
                        <div class="hidden md:flex md:space-x-1">

                            <a href="{{ route('opportunities.index') }}"
                                class="nav-link inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 rounded-lg hover:bg-white/50 dark:hover:bg-gray-800/50 transition">
                                <i class="fas fa-search mr-2"></i>Tìm Cơ Hội
                            </a>
                            <a href="{{ route('organizations.index') }}"
                                class="nav-link inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 rounded-lg hover:bg-white/50 dark:hover:bg-gray-800/50 transition">
                                <i class="fas fa-building mr-2"></i>Tổ Chức
                            </a>
                            <a href="{{ route('posts.index') }}"
                                class="nav-link inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 rounded-lg hover:bg-white/50 dark:hover:bg-gray-800/50 transition">
                                <i class="fas fa-newspaper mr-2"></i>Cộng Đồng
                            </a>
                            <a href="{{ route('about') }}"
                                class="nav-link inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 rounded-lg hover:bg-white/50 dark:hover:bg-gray-800/50 transition">
                                <i class="fas fa-info-circle mr-2"></i>Giới Thiệu
                            </a>
                        </div>
                    </div>

                    <!-- Right Nav -->
                    <div class="flex items-center space-x-2">
                        <!-- Dark Mode Toggle -->
                        <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)"
                            class="p-2.5 text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-white/50 dark:hover:bg-gray-800/50 rounded-lg transition">
                            <i class="fas text-lg" :class="darkMode ? 'fa-sun' : 'fa-moon'"></i>
                        </button>

                        @guest
                            <a href="{{ route('login') }}"
                                class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 px-4 py-2 rounded-lg hover:bg-white/50 dark:hover:bg-gray-800/50 transition hidden sm:block">
                                Đăng Nhập
                            </a>
                            <a href="{{ route('register') }}"
                                class="inline-flex items-center px-5 py-2.5 text-sm font-medium rounded-lg text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all">
                                <i class="fas fa-user-plus mr-2"></i>Đăng Ký
                            </a>
                        @else
                            <!-- Notifications -->
                            <div class="relative hidden sm:block" x-data="{ open: false }">
                                <button @click="open = !open" type="button"
                                    class="relative p-2.5 text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-white/50 dark:hover:bg-gray-800/50 rounded-lg transition">
                                    <i class="fas fa-bell text-lg"></i>
                                    @if(auth()->user()->unreadNotifications->count() > 0)
                                        <span
                                            class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full notification-badge"></span>
                                    @endif
                                </button>
                            </div>

                            <!-- Messages -->
                            <a href="{{ route('conversations.index') }}"
                                class="relative p-2.5 text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-white/50 dark:hover:bg-gray-800/50 rounded-lg transition hidden sm:block">
                                <i class="fas fa-comments text-lg"></i>
                            </a>

                            <!-- User Menu -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" type="button"
                                    class="flex items-center space-x-2 p-1.5 rounded-lg hover:bg-white/50 dark:hover:bg-gray-800/50 transition">
                                    <img src="{{ Auth::user()->avatar_url ? asset('storage/' . Auth::user()->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->first_name . ' ' . Auth::user()->last_name) . '&background=6366f1&color=fff' }}"
                                        class="w-10 h-10 rounded-full avatar-border object-cover" alt="Avatar">
                                    <span
                                        class="hidden md:block text-sm font-medium text-gray-700 dark:text-gray-300">{{ Auth::user()->first_name }}</span>
                                    <i class="fas fa-chevron-down text-xs text-gray-500 transform transition-transform"
                                        :class="{ 'rotate-180': open }"></i>
                                </button>

                                <!-- Dropdown Menu -->
                                <div x-show="open" @click.away="open = false" x-transition
                                    class="absolute right-0 mt-2 w-64 glass dark:glass-dark rounded-xl shadow-2xl border border-gray-200/50 dark:border-gray-700/50 py-2 z-50"
                                    style="display: none;">
                                    <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</p>
                                    </div>

                                    {{-- CODE ĐÃ SỬA LỖI LOGIC --}}
                                    <div class="py-1">
                                        <a href="{{ route('dashboard') }}"
                                            class="flex items-center space-x-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                                            <i
                                                class="fas fa-tachometer-alt w-5 text-indigo-600 dark:text-indigo-400"></i><span>Dashboard</span>
                                        </a>

                                        {{-- START: SỬA LỖI LOGIC --}}
                                        @if(Auth::user()->user_type === 'Volunteer')
                                            {{-- Nếu là Tình nguyện viên, trỏ đến hồ sơ chuyên biệt --}}
                                            <a href="{{ route('volunteer.profile.profile') }}"
                                                class="flex items-center space-x-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                                                <i class="fas fa-user-tie w-5 text-blue-600 dark:text-blue-400"></i><span>Hồ Sơ
                                                    Của Tôi</span>
                                            </a>
                                            <a href="{{ route('volunteer.profile.edit') }}"
                                                class="flex items-center space-x-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                                                <i class="fas fa-edit w-5 text-purple-600 dark:text-purple-400"></i><span>Chỉnh
                                                    Sửa & Xác Thực</span>
                                            </a>

                                        @elseif(Auth::user()->user_type === 'Organization')
                                            {{-- Nếu là Tổ chức, trỏ đến hồ sơ tổ chức --}}
                                            <a href="{{ route('organization.profile.show') }}"
                                                class="flex items-center space-x-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                                                <i class="fas fa-building w-5 text-blue-600 dark:text-blue-400"></i><span>Hồ Sơ
                                                    Tổ Chức</span>
                                            </a>
                                            <a href="{{ route('organization.opportunities.index') }}"
                                                class="flex items-center space-x-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                                                <i class="fas fa-briefcase w-5 text-green-600 dark:text-green-400"></i><span>Cơ
                                                    Hội Của Tôi</span>
                                            </a>

                                        @elseif(Auth::user()->user_type === 'Admin')
                                            {{-- Nếu là Admin, giữ nguyên link Admin Panel --}}
                                            <a href="{{ route('admin.dashboard') }}"
                                                class="flex items-center space-x-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                                                <i class="fas fa-cog w-5 text-red-600 dark:text-red-400"></i><span>Admin
                                                    Panel</span>
                                            </a>

                                        @else
                                            {{-- Dự phòng cho các loại user khác (nếu có) --}}
                                            <a href="{{ route('profile') }}"
                                                class="flex items-center space-x-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                                                <i class="fas fa-user w-5 text-blue-600 dark:text-blue-400"></i><span>Cài Đặt Hồ
                                                    Sơ</span>
                                            </a>
                                        @endif
                                        {{-- END: SỬA LỖI LOGIC --}}
                                    </div>

                                    <div class="border-t border-gray-200 dark:border-gray-700 py-1">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit"
                                                class="flex items-center space-x-3 w-full px-4 py-2.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition">
                                                <i class="fas fa-sign-out-alt w-5"></i><span>Đăng Xuất</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endguest

                        <!-- Mobile menu button -->
                        <button @click="mobileMenuOpen = !mobileMenuOpen" type="button"
                            class="md:hidden p-2 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-white/50 dark:hover:bg-gray-800/50">
                            <i class="fas text-xl" :class="mobileMenuOpen ? 'fa-times' : 'fa-bars'"></i>
                        </button>
                    </div>
                </div>

                <!-- Mobile Menu -->
                <div x-show="mobileMenuOpen" x-transition class="md:hidden pb-4" style="display: none;">
                    <div class="space-y-1">
                        <a href="{{ route('opportunities.index') }}"
                            class="block px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-white/50 dark:hover:bg-gray-800/50 rounded-lg">
                            <i class="fas fa-search mr-2"></i>Tìm Cơ Hội
                        </a>
                        <a href="{{ route('organizations.index') }}"
                            class="block px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-white/50 dark:hover:bg-gray-800/50 rounded-lg">
                            <i class="fas fa-building mr-2"></i>Tổ Chức
                        </a>
                        <a href="{{ route('posts.index') }}"
                            class="block px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-white/50 dark:hover:bg-gray-800/50 rounded-lg">
                            <i class="fas fa-newspaper mr-2"></i>Cộng Đồng
                        </a>
                        <a href="{{ route('about') }}"
                            class="block px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-white/50 dark:hover:bg-gray-800/50 rounded-lg">
                            <i class="fas fa-info-circle mr-2"></i>Giới Thiệu
                        </a>
                        @guest
                            <a href="{{ route('login') }}"
                                class="block px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-white/50 dark:hover:bg-gray-800/50 rounded-lg">
                                <i class="fas fa-sign-in-alt mr-2"></i>Đăng Nhập
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        <!-- Flash Messages -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            @if(session('success'))
                <div
                    class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-4 py-3 rounded-xl mb-4 flex items-center justify-between shadow-lg animate-slide-down">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-white text-sm"></i>
                        </div>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()"
                        class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-200 p-1 hover:bg-green-100 dark:hover:bg-green-900/30 rounded transition">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div
                    class="bg-gradient-to-r from-red-50 to-rose-50 dark:from-red-900/20 dark:to-rose-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 px-4 py-3 rounded-xl mb-4 flex items-center justify-between shadow-lg animate-slide-down">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0 w-8 h-8 bg-red-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-exclamation text-white text-sm"></i>
                        </div>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()"
                        class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200 p-1 hover:bg-red-100 dark:hover:bg-red-900/30 rounded transition">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif
        </div>

        <!-- Main Content -->
        <main>@yield('content')</main>

        <!-- Footer -->
        <footer class="glass dark:glass-dark border-t border-gray-200/50 dark:border-gray-700/50 mt-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="col-span-1 md:col-span-2">
                        <div class="flex items-center space-x-2 mb-4 group">
                            <div class="relative">
                                <div
                                    class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg blur opacity-75 group-hover:opacity-100 transition">
                                </div>
                                <div class="relative bg-gradient-to-r from-indigo-600 to-purple-600 p-2 rounded-lg">
                                    <i class="fas fa-hands-helping text-white text-xl"></i>
                                </div>
                            </div>
                            <span class="font-bold text-xl gradient-text">VolunteerConnect</span>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 mb-6 leading-relaxed">
                            Kết nối tình nguyện viên với các tổ chức phi lợi nhuận, tạo ra những thay đổi tích cực cho
                            cộng đồng.
                        </p>
                        <div class="flex space-x-3">
                            <a href="#"
                                class="w-10 h-10 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg flex items-center justify-center shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all">
                                <i class="fab fa-facebook"></i>
                            </a>
                            <a href="#"
                                class="w-10 h-10 bg-gradient-to-r from-pink-600 to-rose-600 hover:from-pink-700 hover:to-rose-700 text-white rounded-lg flex items-center justify-center shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#"
                                class="w-10 h-10 bg-gradient-to-r from-sky-600 to-blue-600 hover:from-sky-700 hover:to-blue-700 text-white rounded-lg flex items-center justify-center shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </div>
                    </div>

                    <div>
                        <h6 class="font-bold text-gray-900 dark:text-gray-100 mb-4 text-lg">Liên Kết</h6>
                        <ul class="space-y-3">
                            <li><a href="{{ route('about') }}"
                                    class="text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition flex items-center space-x-2 group"><i
                                        class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-indigo-600 group-hover:translate-x-1 transition-all"></i><span>Giới
                                        Thiệu</span></a></li>
                            <li><a href="{{ route('contact') }}"
                                    class="text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition flex items-center space-x-2 group"><i
                                        class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-indigo-600 group-hover:translate-x-1 transition-all"></i><span>Liên
                                        Hệ</span></a></li>
                            <li><a href="{{ route('privacy') }}"
                                    class="text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition flex items-center space-x-2 group"><i
                                        class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-indigo-600 group-hover:translate-x-1 transition-all"></i><span>Chính
                                        Sách</span></a></li>
                            <li><a href="{{ route('terms') }}"
                                    class="text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition flex items-center space-x-2 group"><i
                                        class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-indigo-600 group-hover:translate-x-1 transition-all"></i><span>Điều
                                        Khoản</span></a></li>
                        </ul>
                    </div>

                    <div>
                        <h6 class="font-bold text-gray-900 dark:text-gray-100 mb-4 text-lg">Tài Nguyên</h6>
                        <ul class="space-y-3">
                            <li><a href="{{ route('opportunities.index') }}"
                                    class="text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition flex items-center space-x-2 group"><i
                                        class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-indigo-600 group-hover:translate-x-1 transition-all"></i><span>Cơ
                                        Hội</span></a></li>
                            <li><a href="{{ route('organizations.index') }}"
                                    class="text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition flex items-center space-x-2 group"><i
                                        class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-indigo-600 group-hover:translate-x-1 transition-all"></i><span>Tổ
                                        Chức</span></a></li>
                            <li><a href="{{ route('posts.index') }}"
                                    class="text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition flex items-center space-x-2 group"><i
                                        class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-indigo-600 group-hover:translate-x-1 transition-all"></i><span>Cộng
                                        Đồng</span></a></li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-gray-200 dark:border-gray-700 mt-10 pt-8 text-center">
                    <p class="text-sm text-gray-500 dark:text-gray-400">&copy; 2025 VolunteerConnect. All rights
                        reserved.</p>
                </div>
            </div>
        </footer>

        <!-- Scroll to Top -->
        <button id="scrollToTop" onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
            class="fixed bottom-8 right-8 w-12 h-12 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-full shadow-2xl hover:shadow-indigo-500/50 transform hover:scale-110 transition-all opacity-0 pointer-events-none z-50">
            <i class="fas fa-arrow-up"></i>
        </button>
    </div>

    <!-- Scripts -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @if (session('show_profile_toast'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'info',
                    title: 'Hãy hoàn thiện hồ sơ!',
                    html: 'Bạn nên cập nhật hồ sơ của mình để các tổ chức dễ dàng liên hệ với bạn!',
                    showConfirmButton: false,
                    timer: 7000,
                    timerProgressBar: true,
                    background: '#8b5cf6',
                    color: 'white',
                    iconColor: 'white'
                });
            });
        </script>
    @endif
    <script>
        // Auto-hide flash messages
        setTimeout(() => document.querySelectorAll('.animate-slide-down').forEach(el => {
            el.style.opacity = '0'; el.style.transform = 'translateY(-20px)';
            setTimeout(() => el.remove(), 500);
        }), 5000);

        // Scroll to top button
        const scrollBtn = document.getElementById('scrollToTop');
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                scrollBtn.classList.remove('opacity-0', 'pointer-events-none');
                scrollBtn.classList.add('opacity-100', 'pointer-events-auto');
            } else {
                scrollBtn.classList.add('opacity-0', 'pointer-events-none');
                scrollBtn.classList.remove('opacity-100', 'pointer-events-auto');
            }
        });

        // Active nav link
        document.addEventListener('DOMContentLoaded', () => {
            const currentPath = window.location.pathname;
            document.querySelectorAll('.nav-link').forEach(link => {
                if (link.getAttribute('href') === currentPath) link.classList.add('active');
            });
        });

        // CSRF Token Setup
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

        // Global toast notification
        window.showToast = function (message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = 'fixed top-4 right-4 z-[9999] animate-slide-down';
            const colors = {
                success: 'from-green-500 to-emerald-600',
                error: 'from-red-500 to-rose-600',
                warning: 'from-yellow-500 to-orange-600',
                info: 'from-blue-500 to-cyan-600'
            };
            const icons = {
                success: 'fa-check-circle',
                error: 'fa-exclamation-circle',
                warning: 'fa-exclamation-triangle',
                info: 'fa-info-circle'
            };
            toast.innerHTML = `
                <div class="bg-gradient-to-r ${colors[type]} text-white px-6 py-4 rounded-xl shadow-2xl flex items-center space-x-3 min-w-[300px]">
                    <i class="fas ${icons[type]} text-xl"></i>
                    <span class="flex-1 font-medium">${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="hover:bg-white/20 rounded-lg p-1">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            document.body.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 5000);
        };

        // Loading overlay
        window.showLoading = function () {
            const loader = document.createElement('div');
            loader.id = 'globalLoader';
            loader.className = 'fixed inset-0 bg-black/50 backdrop-blur-sm z-[9999] flex items-center justify-center';
            loader.innerHTML = `
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-2xl">
                    <div class="w-12 h-12 border-4 border-indigo-200 border-t-indigo-600 rounded-full animate-spin mx-auto mb-4"></div>
                    <p class="text-gray-600 dark:text-gray-400 font-medium">Loading...</p>
                </div>
            `;
            document.body.appendChild(loader);
        };

        window.hideLoading = function () {
            const loader = document.getElementById('globalLoader');
            if (loader) {
                loader.style.opacity = '0';
                setTimeout(() => loader.remove(), 300);
            }
        };

        // Prevent double form submission
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function (e) {
                const btn = this.querySelector('[type="submit"]');
                if (btn && !btn.disabled) {
                    btn.disabled = true;
                    const originalText = btn.innerHTML;
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
                    setTimeout(() => {
                        btn.disabled = false;
                        btn.innerHTML = originalText;
                    }, 3000);
                }
            });
        });

        // Console message
        console.log('%cVolunteerConnect Platform', 'color: #6366f1; font-size: 24px; font-weight: bold;');
        console.log('%cMade with ❤️ for the community', 'color: #8b5cf6; font-size: 14px;');
    </script>

    @stack('scripts')
</body>

</html>