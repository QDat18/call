<!DOCTYPE html>
<html lang="vi" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
    x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" :class="{ 'dark': darkMode }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - Volunteer Connect</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: { 50: '#eef2ff', 100: '#e0e7ff', 500: '#6366f1', 600: '#4f46e5', 700: '#4338ca', 900: '#312e81' },
                        dark: { 800: '#1e293b', 900: '#0f172a' },
                        sidebar: '#111827' // Màu nền sidebar tối
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        /* Custom Scrollbar for Sidebar */
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #374151;
            border-radius: 2px;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: #4b5563;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 transition-colors duration-300"
      x-data="{ 
          darkMode: localStorage.getItem('darkMode') === 'true', 
          sidebarOpen: true, 
          userDropdownOpen: false,
          toggleTheme() {
              this.darkMode = !this.darkMode;
              localStorage.setItem('darkMode', this.darkMode);
              if (this.darkMode) {
                  document.documentElement.classList.add('dark');
              } else {
                  document.documentElement.classList.remove('dark');
              }
          }
      }"
      x-init="$watch('darkMode', val => val ? document.documentElement.classList.add('dark') : document.documentElement.classList.remove('dark')); if(darkMode) document.documentElement.classList.add('dark');"
>

    <div class="flex h-screen overflow-hidden">

        <aside
            class="fixed inset-y-0 left-0 z-50 w-72 bg-sidebar text-white transition-transform duration-300 lg:static lg:translate-x-0 flex flex-col shadow-2xl"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            <div class="flex items-center justify-between h-20 px-6 border-b border-gray-800 bg-sidebar">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                    <div
                        class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-indigo-500/20 transform group-hover:scale-105 transition-all duration-300">
                        VC
                    </div>
                    <div class="flex flex-col">
                        <span class="text-lg font-bold tracking-tight text-white">VolunteerConnect</span>
                        <span class="text-[10px] uppercase tracking-wider text-gray-400 font-semibold">Admin
                            Panel</span>
                    </div>
                </a>
                <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-white transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <nav class="flex-1 overflow-y-auto sidebar-scroll px-4 py-6 space-y-1">

                <div class="px-4 mb-2 mt-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tổng quan</div>

                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 group relative overflow-hidden
                   {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/50' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <i
                        class="fas fa-chart-pie w-5 text-center {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-gray-500 group-hover:text-white transition-colors' }}"></i>
                    Dashboard
                </a>

                <a href="{{ route('admin.analytics.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 group
                   {{ request()->routeIs('admin.analytics.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/50' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <i
                        class="fas fa-chart-line w-5 text-center {{ request()->routeIs('admin.analytics.*') ? 'text-white' : 'text-gray-500 group-hover:text-white transition-colors' }}"></i>
                    Thống kê & Báo cáo
                </a>

                <div class="px-4 mb-2 mt-8 text-xs font-semibold text-gray-500 uppercase tracking-wider">Quản lý</div>

                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 group
                   {{ request()->routeIs('admin.users.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/50' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <i
                        class="fas fa-users w-5 text-center {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-gray-500 group-hover:text-white transition-colors' }}"></i>
                    Người dùng
                </a>

                <a href="{{ route('admin.organizations.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 group
                   {{ request()->routeIs('admin.organizations.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/50' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <i
                        class="fas fa-building w-5 text-center {{ request()->routeIs('admin.organizations.*') ? 'text-white' : 'text-gray-500 group-hover:text-white transition-colors' }}"></i>
                    Tổ chức
                </a>

                <a href="{{ route('admin.opportunities.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 group
                   {{ request()->routeIs('admin.opportunities.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/50' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <i
                        class="fas fa-briefcase w-5 text-center {{ request()->routeIs('admin.opportunities.*') ? 'text-white' : 'text-gray-500 group-hover:text-white transition-colors' }}"></i>
                    Cơ hội tình nguyện
                </a>

                <a href="{{ route('admin.applications.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 group
                   {{ request()->routeIs('admin.applications.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/50' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <i
                        class="fas fa-file-contract w-5 text-center {{ request()->routeIs('admin.applications.*') ? 'text-white' : 'text-gray-500 group-hover:text-white transition-colors' }}"></i>
                    Đơn đăng ký
                </a>

                <div class="px-4 mb-2 mt-8 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nội dung</div>

                <a href="{{ route('admin.posts.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 group
                   {{ request()->routeIs('admin.posts.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/50' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <i
                        class="fas fa-newspaper w-5 text-center {{ request()->routeIs('admin.posts.*') ? 'text-white' : 'text-gray-500 group-hover:text-white transition-colors' }}"></i>
                    Bài viết cộng đồng
                </a>

                <a href="{{ route('admin.campaigns.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 group
                {{ request()->routeIs('admin.campaigns.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/50' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <i class="fas fa-hand-holding-heart w-5 text-center {{ request()->routeIs('admin.campaigns.*') ? 'text-white' : 'text-gray-500 group-hover:text-white transition-colors' }}"></i>
                    Chiến dịch Quyên góp
                </a>
                
                <a href="{{ route('admin.categories.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 group
                   {{ request()->routeIs('admin.categories.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/50' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <i
                        class="fas fa-tags w-5 text-center {{ request()->routeIs('admin.categories.*') ? 'text-white' : 'text-gray-500 group-hover:text-white transition-colors' }}"></i>
                    Danh mục
                </a>

                <div class="px-4 mb-2 mt-8 text-xs font-semibold text-gray-500 uppercase tracking-wider">Hệ thống</div>

                <a href="{{ route('admin.settings.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 group
                   {{ request()->routeIs('admin.settings.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/50' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <i
                        class="fas fa-cog w-5 text-center {{ request()->routeIs('admin.settings.*') ? 'text-white' : 'text-gray-500 group-hover:text-white transition-colors' }}"></i>
                    Cài đặt
                </a>
            </nav>

            <div class="p-4 border-t border-gray-800 bg-sidebar">
                <a href="{{ route('home') }}"
                    class="flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-lg bg-gray-800 hover:bg-gray-700 text-gray-300 hover:text-white transition-all text-sm font-medium group">
                    <i class="fas fa-external-link-alt group-hover:text-indigo-400"></i>
                    <span>Xem trang chủ</span>
                </a>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden relative">

            <header
                class="h-20 bg-white dark:bg-dark-800 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between px-6 lg:px-8 z-40 shadow-sm">

                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="text-gray-500 hover:text-indigo-600 lg:hidden transition p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800 dark:text-white tracking-tight">
                            @yield('breadcrumb', 'Dashboard')
                        </h1>
                        <p class="text-xs text-gray-500 dark:text-gray-400 hidden sm:block">Quản trị hệ thống
                            VolunteerConnect</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 sm:gap-5">

                    <a href="{{ route('home') }}"
                        class="hidden md:flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-indigo-50 hover:text-indigo-600 dark:hover:bg-indigo-900/30 dark:hover:text-indigo-400 rounded-lg transition-all"
                        target="_blank" title="Xem trang chủ">
                        <i class="fas fa-globe"></i>
                        <span>Website</span>
                    </a>

                    <div x-data="{ open: false, unreadCount: {{ auth()->user()->unreadNotifications->count() }} }"
                        class="relative">
                        <button @click="open = !open"
                            class="relative w-10 h-10 rounded-full flex items-center justify-center text-gray-500 hover:bg-gray-100 hover:text-indigo-600 dark:hover:bg-gray-700 transition">
                            <i class="fas fa-bell text-xl"></i>
                            <span x-show="unreadCount > 0"
                                class="absolute top-2 right-2 w-2.5 h-2.5 bg-red-500 rounded-full ring-2 ring-white dark:ring-dark-800 animate-pulse"></span>
                        </button>

                        <div x-show="open" @click.away="open = false" x-transition.origin.top.right x-cloak
                            class="absolute right-0 mt-4 w-80 bg-white dark:bg-dark-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 py-2 z-50 transform origin-top-right">
                            <div
                                class="px-4 py-3 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                                <span class="font-bold text-gray-800 dark:text-white">Thông báo</span>
                                <a href="{{ route('notifications.index') }}"
                                    class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 dark:hover:text-indigo-400">Xem
                                    tất cả</a>
                            </div>
                            <div class="max-h-[300px] overflow-y-auto sidebar-scroll">
                                @forelse(auth()->user()->unreadNotifications->take(5) as $notification)
                                    <a href="{{ route('notifications.read', $notification->getKey()) }}"
                                        class="block px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition border-b border-gray-50 dark:border-gray-700/50 last:border-0">
                                        <div class="flex gap-3">
                                            <div
                                                class="flex-shrink-0 w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center">
                                                <i class="fas fa-info text-xs"></i>
                                            </div>
                                            <div>
                                                <p
                                                    class="text-sm font-medium text-gray-900 dark:text-gray-100 line-clamp-1">
                                                    {{ $notification->data['title'] ?? 'Thông báo mới' }}</p>
                                                <p class="text-xs text-gray-500 line-clamp-1 mt-0.5">
                                                    {{ $notification->data['content'] ?? '' }}</p>
                                                <p class="text-[10px] text-gray-400 mt-1">
                                                    {{ $notification->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="py-10 text-center text-gray-400">
                                        <i class="far fa-bell-slash text-3xl mb-2 opacity-50"></i>
                                        <p class="text-xs">Không có thông báo mới</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div x-data="{ open: false }"
                        class="relative border-l border-gray-200 dark:border-gray-700 pl-3 ml-1">
                        <button @click="open = !open"
                            class="flex items-center gap-3 p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition ring-2 ring-transparent focus:ring-indigo-100 dark:focus:ring-indigo-900">
                            <div class="text-right hidden md:block">
                                <p class="text-sm font-bold text-gray-800 dark:text-white leading-tight">
                                    {{ Auth::user()->last_name }}</p>
                                <p
                                    class="text-[10px] font-medium text-indigo-600 dark:text-indigo-400 uppercase tracking-wide">
                                    Administrator</p>
                            </div>
                            <img src="{{ Auth::user()->avatar_url ? asset('storage/' . Auth::user()->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->first_name) . '&background=6366f1&color=fff' }}"
                                class="w-10 h-10 rounded-full object-cover border-2 border-white dark:border-gray-800 shadow-sm">
                            <i class="fas fa-chevron-down text-xs text-gray-400 md:hidden"></i>
                        </button>

                        <div x-show="open" @click.away="open = false" x-transition.origin.top.right x-cloak
                            class="absolute right-0 mt-4 w-60 bg-white dark:bg-dark-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 py-2 z-50 transform origin-top-right overflow-hidden">

                            <div
                                class="px-5 py-4 bg-gray-50 dark:bg-gray-700/50 border-b border-gray-100 dark:border-gray-700 mb-1">
                                <p class="text-sm font-bold text-gray-900 dark:text-white truncate">
                                    {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
                                <p class="text-xs text-gray-500 truncate mt-0.5">{{ Auth::user()->email }}</p>
                            </div>

                            <div class="px-2 py-2 space-y-1">
                                <a href="{{ route('profile') }}"
                                    class="flex items-center gap-3 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-indigo-50 hover:text-indigo-600 dark:hover:bg-indigo-900/30 dark:hover:text-indigo-400 rounded-lg transition">
                                    <i class="far fa-user w-5 text-center text-gray-400"></i> Hồ sơ cá nhân
                                </a>
                                <a href="{{ route('admin.settings.index') }}"
                                    class="flex items-center gap-3 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-indigo-50 hover:text-indigo-600 dark:hover:bg-indigo-900/30 dark:hover:text-indigo-400 rounded-lg transition">
                                    <i class="fas fa-cog w-5 text-center text-gray-400"></i> Cài đặt hệ thống
                                </a>
                                <div class="h-px bg-gray-100 dark:bg-gray-700 my-1 mx-2"></div>
                                <a href="{{ route('home') }}"
                                    class="flex items-center gap-3 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-indigo-50 hover:text-indigo-600 dark:hover:bg-indigo-900/30 dark:hover:text-indigo-400 rounded-lg transition">
                                    <i class="fas fa-external-link-alt w-5 text-center text-gray-400"></i> Xem trang chủ
                                </a>
                            </div>

                            <div class="border-t border-gray-100 dark:border-gray-700 mt-1 p-2">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center gap-3 w-full px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition">
                                        <i class="fas fa-sign-out-alt w-5 text-center"></i> Đăng xuất
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </header>

            <main class="flex-1 overflow-y-auto custom-scrollbar bg-gray-50 dark:bg-gray-900 p-6 lg:p-8">
                @yield('content')
            </main>

        </div>
    </div>

    <div id="toast-container" class="fixed bottom-6 right-6 z-[60] space-y-3 pointer-events-none"></div>

    <script>
        // ... (Giữ nguyên script Toast cũ của bạn) ...
        window.showToast = function (message, type = 'success') {
            // ... (Code toast cũ) ...
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');

            const colors = {
                success: 'bg-green-500', error: 'bg-red-500', warning: 'bg-yellow-500', info: 'bg-blue-500'
            };
            const icons = {
                success: 'fa-check-circle', error: 'fa-exclamation-circle', warning: 'fa-exclamation-triangle', info: 'fa-info-circle'
            };

            toast.className = `pointer-events-auto flex items-center gap-3 px-6 py-4 rounded-xl shadow-xl text-white transform transition-all duration-300 translate-y-10 opacity-0 ${colors[type]}`;
            toast.innerHTML = `<i class="fas ${icons[type]} text-xl"></i><span class="font-medium">${message}</span>`;

            container.appendChild(toast);

            requestAnimationFrame(() => { toast.classList.remove('translate-y-10', 'opacity-0'); });
            setTimeout(() => { toast.classList.add('opacity-0', 'translate-x-full'); setTimeout(() => toast.remove(), 300); }, 3000);
        }

        // Show Session Messages
        @if(session('success')) showToast("{{ session('success') }}", 'success'); @endif
        @if(session('error')) showToast("{{ session('error') }}", 'error'); @endif
    </script>
    @stack('scripts')
</body>

</html>