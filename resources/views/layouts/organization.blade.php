<!DOCTYPE html>
<html lang="en" x-data="appData()" :class="{ 'dark': darkMode }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Organization Dashboard') - Volunteer Connect</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        org: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                            950: '#022c22',
                        }
                    }
                }
            }
        }
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(5, 150, 105, 0.5);
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(5, 150, 105, 0.8);
        }

        /* Smooth transitions */
        * {
            transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease;
        }

        /* Glass morphism effect */
        .glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .glass-dark {
            background: rgba(17, 24, 39, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        /* Floating animation */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .float-animation {
            animation: float 3s ease-in-out infinite;
        }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Notification badge pulse */
        @keyframes pulse-badge {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.8;
                transform: scale(1.05);
            }
        }

        .pulse-badge {
            animation: pulse-badge 2s ease-in-out infinite;
        }

        /* Sidebar link hover effect */
        .sidebar-link {
            position: relative;
            overflow: hidden;
        }

        .sidebar-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .sidebar-link:hover::before {
            left: 100%;
        }

        /* Loading spinner */
        .spinner {
            border: 3px solid rgba(5, 150, 105, 0.3);
            border-top-color: #059669;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>

    @stack('styles')
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-950">

    <div x-show="loading" x-cloak
        class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[100] flex items-center justify-center">
        <div class="text-center">
            <div class="spinner mx-auto mb-4"></div>
            <p class="text-white text-sm">Loading...</p>
        </div>
    </div>

    <aside class="fixed inset-y-0 left-0 z-50 w-64 transform transition-all duration-300 ease-in-out lg:translate-x-0"
        :class="{ '-translate-x-full': !mobileMenuOpen, 'translate-x-0': mobileMenuOpen }"
        x-show="sidebarOpen || mobileMenuOpen" @click.away="mobileMenuOpen = false">

        <div
            class="absolute inset-0 bg-gradient-to-b from-org-800 via-org-900 to-org-950 dark:from-org-950 dark:to-black">
        </div>
        <div
            class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9ImdyaWQiIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTSAwIDEwIEwgNDAgMTAgTSAxMCAwIEwgMTAgNDAgTSAwIDIwIEwgNDAgMjAgTSAyMCAwIEwgMjAgNDAgTSAwIDMwIEwgNDAgMzAgTSAzMCAwIEwgMzAgNDAiIGZpbGw9Im5vbmUiIHN0cm9rZT0icmdiYSgyNTUsMjU1LDI1NSwwLjAzKSIgc3Ryb2tlLXdpZHRoPSIxIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI2dyaWQpIi8+PC9zdmc+')] opacity-30">
        </div>

        <div class="relative h-full flex flex-col">

            <div class="flex items-center justify-between h-16 px-6 border-b border-org-700/30 dark:border-org-800/30">
                <a href="{{ route('home') }}" class="flex items-center space-x-3 hover:opacity-80 transition-opacity">
                    <div class="relative">
                        <div class="absolute inset-0 bg-org-400 rounded-lg blur-md opacity-50"></div>
                        <div
                            class="relative w-10 h-10 bg-gradient-to-br from-org-500 to-emerald-600 rounded-lg flex items-center justify-center shadow-lg">
                            <i class="fas fa-heart text-white text-xl"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-white">VolunteerConnect</h1>
                        <p class="text-xs text-org-300">Organization Portal</p>
                    </div>
                </a>
                <button @click="mobileMenuOpen = false"
                    class="lg:hidden text-org-300 hover:text-white transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="px-4 pt-4 pb-2">
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20">
                    <div class="flex items-center space-x-3">
                        <img src="{{ Auth::user()->avatar_url ? asset('storage/' . Auth::user()->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->organization->organization_name ?? 'Org') . '&background=059669&color=fff' }}"
                            alt="Org Avatar" class="w-12 h-12 rounded-full border-2 border-org-400 object-cover">
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-semibold text-white truncate">
                                {{ Auth::user()->organization->organization_name ?? 'Organization' }}
                            </h3>
                            <div class="flex items-center space-x-2 mt-1">
                                @if(Auth::user()->organization && Auth::user()->organization->verification_status === 'Verified')
                                    <span class="flex items-center space-x-1 text-xs text-org-300">
                                        <i class="fas fa-check-circle text-org-400"></i>
                                        <span>Verified</span>
                                    </span>
                                @else
                                    <span class="flex items-center space-x-1 text-xs text-yellow-300">
                                        <i class="fas fa-clock text-yellow-400"></i>
                                        <span>Pending</span>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto custom-scrollbar">

                <a href="{{ route('organization.dashboard') }}"
                    class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg transition-all group {{ request()->routeIs('organization.dashboard') ? 'bg-org-600 text-white shadow-lg' : 'text-org-100 hover:bg-org-700/50 hover:text-white' }}">
                    <i
                        class="fas fa-tachometer-alt w-5 {{ request()->routeIs('organization.dashboard') ? 'text-white' : 'text-org-300 group-hover:text-white' }}"></i>
                    <span class="font-medium">Dashboard</span>
                    @if(request()->routeIs('organization.dashboard'))
                        <div class="ml-auto w-1.5 h-1.5 bg-white rounded-full"></div>
                    @endif
                </a>

                <a href="{{ route('organization.profile.show') }}"
                    class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg transition-all group {{ request()->routeIs('organization.profile.*') ? 'bg-org-600 text-white shadow-lg' : 'text-org-100 hover:bg-org-700/50 hover:text-white' }}">
                    <i
                        class="fas fa-building w-5 {{ request()->routeIs('organization.profile.*') ? 'text-white' : 'text-org-300 group-hover:text-white' }}"></i>
                    <span class="font-medium">Profile</span>
                </a>

                <div x-data="{ open: {{ request()->routeIs('organization.opportunities.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="w-full sidebar-link flex items-center justify-between px-4 py-3 rounded-lg transition-all group text-org-100 hover:bg-org-700/50 hover:text-white">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-clipboard-list w-5 text-org-300 group-hover:text-white"></i>
                            <span class="font-medium">Opportunities</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-200"
                            :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-cloak x-collapse class="ml-8 mt-2 space-y-1">
                        <a href="{{ route('organization.opportunities.index') }}"
                            class="block px-4 py-2 rounded text-sm transition-colors {{ request()->routeIs('organization.opportunities.index') ? 'text-org-300 bg-org-700/30' : 'text-org-200 hover:text-white hover:bg-org-700/30' }}">
                            All Opportunities
                        </a>
                        <a href="{{ route('organization.opportunities.create') }}"
                            class="block px-4 py-2 rounded text-sm text-org-200 hover:text-white hover:bg-org-700/30 transition-colors">
                            Create New
                        </a>
                    </div>
                </div>

                <a href="{{ route('organization.applications.index') }}"
                    class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg transition-all group {{ request()->routeIs('organization.applications.*') ? 'bg-org-600 text-white shadow-lg' : 'text-org-100 hover:bg-org-700/50 hover:text-white' }}">
                    <i
                        class="fas fa-file-alt w-5 {{ request()->routeIs('organization.applications.*') ? 'text-white' : 'text-org-300 group-hover:text-white' }}"></i>
                    <span class="font-medium">Applications</span>
                    @php
                        // Có thể optimize query này bằng cách dùng View Composer hoặc load ở Controller
                        $pendingCount = Auth::user()->organization->opportunities()
                            ->withCount([
                                'applications' => function ($q) {
                                    $q->where('status', 'Pending');
                                }
                            ])
                            ->get()
                            ->sum('applications_count');
                    @endphp
                    @if($pendingCount > 0)
                        <span
                            class="ml-auto px-2 py-1 bg-red-500 text-white text-xs rounded-full font-bold pulse-badge shadow-lg">
                            {{ $pendingCount }}
                        </span>
                    @endif
                </a>

                <a href="{{ route('organization.volunteers.index') }}"
                    class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg transition-all group {{ request()->routeIs('organization.volunteers.*') ? 'bg-org-600 text-white shadow-lg' : 'text-org-100 hover:bg-org-700/50 hover:text-white' }}">
                    <i
                        class="fas fa-users w-5 {{ request()->routeIs('organization.volunteers.*') ? 'text-white' : 'text-org-300 group-hover:text-white' }}"></i>
                    <span class="font-medium">Volunteers</span>
                </a>

                <a href="{{ route('organization.activities.index') }}"
                    class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg transition-all group {{ request()->routeIs('organization.activities.*') ? 'bg-org-600 text-white shadow-lg' : 'text-org-100 hover:bg-org-700/50 hover:text-white' }}">
                    <i
                        class="fas fa-calendar-check w-5 {{ request()->routeIs('organization.activities.*') ? 'text-white' : 'text-org-300 group-hover:text-white' }}"></i>
                    <span class="font-medium">Activities</span>
                </a>

                <div class="border-t border-org-700/30 my-3"></div>

                <a href="{{ route('organization.analytics.index') }}"
                    class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg transition-all group {{ request()->routeIs('organization.analytics.*') ? 'bg-org-600 text-white shadow-lg' : 'text-org-100 hover:bg-org-700/50 hover:text-white' }}">
                    <i
                        class="fas fa-chart-bar w-5 {{ request()->routeIs('organization.analytics.*') ? 'text-white' : 'text-org-300 group-hover:text-white' }}"></i>
                    <span class="font-medium">Analytics</span>
                </a>

                <a href="{{ route('conversations.index') }}" x-data="{ unreadCount: 0 }" x-init="async () => {
                       try {
                           const res = await fetch('/api/messages/unread-count');
                           const data = await res.json();
                           unreadCount = data.count;
                       } catch(e) {}
                   }"
                    class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg transition-all group text-org-100 hover:bg-org-700/50 hover:text-white">
                    <i class="fas fa-comments w-5 text-org-300 group-hover:text-white"></i>
                    <span class="font-medium">Messages</span>
                    <span x-show="unreadCount > 0" x-text="unreadCount"
                        class="ml-auto px-2 py-1 bg-blue-500 text-white text-xs rounded-full font-bold pulse-badge"></span>
                </a>

                <div class="border-t border-org-700/30 my-3"></div>

                <a href="{{ route('home') }}" target="_blank"
                    class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-lg transition-all group text-org-100 hover:bg-org-700/50 hover:text-white">
                    <i class="fas fa-home w-5 text-org-300 group-hover:text-white"></i>
                    <span class="font-medium">View Public Site</span>
                    <i class="fas fa-external-link-alt ml-auto text-xs text-org-400 group-hover:text-white"></i>
                </a>

            </nav>

            <div class="p-4 border-t border-org-700/30">
                <div class="bg-gradient-to-r from-org-600/50 to-org-500/50 rounded-lg p-4 border border-org-500/30">
                    <div class="flex items-start space-x-3">
                        <div class="w-10 h-10 bg-org-500 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-lightbulb text-white"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-white mb-1">Need Help?</h4>
                            <p class="text-xs text-org-200 mb-2">Check our guide for organizations</p>
                            <a href="{{ route('contact') }}" target="_blank"
                                class="inline-block text-xs text-white bg-org-600 hover:bg-org-700 px-3 py-1 rounded transition-colors">
                                Contact Support
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </aside>

    <div class="transition-all duration-300" :class="{ 'lg:ml-64': sidebarOpen, 'lg:ml-0': !sidebarOpen }">

        <header class="sticky top-0 z-40 backdrop-blur-md"
            :class="darkMode ? 'glass-dark border-gray-700' : 'glass border-gray-200'"
            style="border-bottom-width: 1px;">
            <div class="flex items-center justify-between h-16 px-6">

                <div class="flex items-center space-x-4">
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="hidden lg:block p-2 rounded-lg transition-all hover:bg-org-50 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-400">
                        <i class="fas fa-bars text-xl"></i>
                    </button>

                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="lg:hidden p-2 rounded-lg transition-all hover:bg-org-50 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-400">
                        <i class="fas fa-bars text-xl"></i>
                    </button>

                    <nav class="hidden md:flex items-center space-x-2 text-sm">
                        <a href="{{ route('organization.dashboard') }}"
                            class="text-gray-500 dark:text-gray-400 hover:text-org-600 dark:hover:text-org-400 transition-colors">
                            <i class="fas fa-home"></i>
                        </a>
                        <i class="fas fa-chevron-right text-gray-400 dark:text-gray-600 text-xs"></i>
                        <span class="text-gray-700 dark:text-gray-300 font-medium">
                            @yield('breadcrumb', 'Dashboard')
                        </span>
                    </nav>
                </div>

                <div class="flex items-center space-x-2">

                    <div x-data="{ open: false }" class="relative hidden lg:block">
                        <button @click="open = !open"
                            class="p-2 rounded-lg transition-all hover:bg-org-50 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-400">
                            <i class="fas fa-plus-circle text-xl"></i>
                        </button>

                        <div x-show="open" @click.away="open = false" x-cloak x-transition
                            class="absolute right-0 mt-2 w-64 bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 py-2">
                            <div class="px-4 py-2 border-b border-gray-200 dark:border-gray-700">
                                <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Quick Actions</p>
                            </div>
                            <a href="{{ route('organization.opportunities.create') }}"
                                class="flex items-center space-x-3 px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <i class="fas fa-plus-circle text-blue-600"></i>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Create Opportunity</span>
                            </a>
                            <a href="{{ route('conversations.create') }}"
                                class="flex items-center space-x-3 px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <i class="fas fa-comment text-green-600"></i>
                                <span class="text-sm text-gray-700 dark:text-gray-300">New Message</span>
                            </a>
                            <a href="{{ route('organization.analytics.index') }}"
                                class="flex items-center space-x-3 px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <i class="fas fa-chart-bar text-purple-600"></i>
                                <span class="text-sm text-gray-700 dark:text-gray-300">View Analytics</span>
                            </a>
                        </div>
                    </div>

                    <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)"
                        class="p-2 rounded-lg transition-all hover:bg-org-50 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-400">
                        <i class="fas text-xl" :class="darkMode ? 'fa-sun text-yellow-400' : 'fa-moon'"></i>
                    </button>

                    <div x-data="notificationDropdown()" x-init="init()" class="relative">
                        <button @click="toggleDropdown()"
                            class="relative p-2 rounded-lg transition-all hover:bg-org-50 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-400">
                            <i class="fas fa-bell text-xl"></i>
                            <span x-show="unreadCount > 0" x-text="unreadCount"
                                class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold pulse-badge">
                            </span>
                        </button>

                        <div x-show="open" @click.away="open = false" x-cloak
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-96 bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">

                            <div
                                class="px-4 py-3 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between bg-gradient-to-r from-org-50 to-emerald-50 dark:from-org-950 dark:to-gray-800">
                                <h3 class="font-semibold text-gray-800 dark:text-gray-200">Notifications</h3>
                                <button @click="markAllAsRead()"
                                    class="text-xs text-org-600 dark:text-org-400 hover:underline">
                                    Mark all read
                                </button>
                            </div>

                            <div class="max-h-96 overflow-y-auto custom-scrollbar">
                                <template x-if="notifications.length === 0">
                                    <div class="p-8 text-center">
                                        <div
                                            class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-3">
                                            <i class="fas fa-bell-slash text-3xl text-gray-400 dark:text-gray-500"></i>
                                        </div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">No notifications yet</p>
                                    </div>
                                </template>

                                <template x-for="notif in notifications" :key="notif.id">
                                    <div class="px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors border-b border-gray-100 dark:border-gray-700 cursor-pointer"
                                        :class="{ 'bg-org-50/30 dark:bg-org-950/30': !notif.is_read }">
                                        <div class="flex items-start space-x-3">
                                            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0"
                                                :class="getNotificationColor(notif.notification_type)">
                                                <i :class="getNotificationIcon(notif.notification_type)"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-800 dark:text-gray-200"
                                                    x-text="notif.title"></p>
                                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1"
                                                    x-text="notif.content"></p>
                                                <p class="text-xs text-gray-500 dark:text-gray-500 mt-2"
                                                    x-text="formatTime(notif.created_at)"></p>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <div
                                class="px-4 py-3 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                                <a href="{{ route('notifications.index') }}"
                                    class="text-sm text-org-600 dark:text-org-400 hover:underline font-medium">
                                    View all notifications →
                                </a>
                            </div>
                        </div>
                    </div>

                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open"
                            class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-org-50 dark:hover:bg-gray-700 transition-all">
                            <img src="{{ Auth::user()->avatar_url ? asset('storage/' . Auth::user()->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->organization->organization_name ?? Auth::user()->first_name) . '&background=059669&color=fff' }}"
                                alt="Avatar"
                                class="w-9 h-9 rounded-full border-2 border-org-200 dark:border-org-700 object-cover">
                            <div class="hidden md:block text-left">
                                <p class="text-sm font-medium text-gray-800 dark:text-gray-200 leading-tight">
                                    {{ Str::limit(Auth::user()->organization->organization_name ?? Auth::user()->first_name . ' ' . Auth::user()->last_name, 20) }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Organization</p>
                            </div>
                            <i class="fas fa-chevron-down text-gray-500 dark:text-gray-400 text-xs transition-transform"
                                :class="{ 'rotate-180': open }"></i>
                        </button>

                        <div x-show="open" @click.away="open = false" x-cloak
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-64 bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">

                            <div
                                class="px-4 py-3 bg-gradient-to-r from-org-50 to-emerald-50 dark:from-org-950 dark:to-gray-800 border-b border-gray-200 dark:border-gray-700">
                                <div class="flex items-center space-x-3">
                                    <img src="{{ Auth::user()->avatar_url ? asset('storage/' . Auth::user()->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->organization->organization_name ?? Auth::user()->first_name) . '&background=059669&color=fff' }}"
                                        alt="Avatar"
                                        class="w-12 h-12 rounded-full border-2 border-org-300 object-cover">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">
                                            {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                                        </p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">
                                            {{ Auth::user()->email }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="py-2">
                                <a href="{{ route('organization.profile.show') }}"
                                    class="flex items-center space-x-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-org-50 dark:hover:bg-gray-700 transition-colors">
                                    <i class="fas fa-building w-5 text-org-600 dark:text-org-400"></i>
                                    <span>Organization Profile</span>
                                </a>

                                <a href="{{ route('profile') }}"
                                    class="flex items-center space-x-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-org-50 dark:hover:bg-gray-700 transition-colors">
                                    <i class="fas fa-user w-5 text-blue-600 dark:text-blue-400"></i>
                                    <span>Personal Profile</span>
                                </a>

                                <a href="{{ route('user.change-password') }}"
                                    class="flex items-center space-x-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-org-50 dark:hover:bg-gray-700 transition-colors">
                                    <i class="fas fa-lock w-5 text-purple-600 dark:text-purple-400"></i>
                                    <span>Change Password</span>
                                </a>

                                <a href="{{ route('notifications.index') }}"
                                    class="flex items-center space-x-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-org-50 dark:hover:bg-gray-700 transition-colors">
                                    <i class="fas fa-bell w-5 text-yellow-600 dark:text-yellow-400"></i>
                                    <span>Notifications</span>
                                </a>
                            </div>

                            <div class="border-t border-gray-200 dark:border-gray-700"></div>

                            <div class="py-2">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center space-x-3 px-4 py-2.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                        <i class="fas fa-sign-out-alt w-5"></i>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </header>

        <main class="p-6 min-h-screen">

            @if(request()->routeIs('organization.dashboard'))
                <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4" x-data="quickStats()"
                    x-init="loadStats()">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Active Opportunities</p>
                                <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1"
                                    x-text="stats.opportunities || '0'"></h3>
                            </div>
                            <div
                                class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                <i class="fas fa-clipboard-list text-blue-600 dark:text-blue-400 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Pending Applications</p>
                                <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1"
                                    x-text="stats.pending || '0'"></h3>
                            </div>
                            <div
                                class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center">
                                <i class="fas fa-clock text-yellow-600 dark:text-yellow-400 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Active Volunteers</p>
                                <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1"
                                    x-text="stats.volunteers || '0'"></h3>
                            </div>
                            <div
                                class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                                <i class="fas fa-users text-green-600 dark:text-green-400 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Volunteer Hours</p>
                                <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1"
                                    x-text="stats.hours || '0'"></h3>
                            </div>
                            <div
                                class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                                <i class="fas fa-hourglass-half text-purple-600 dark:text-purple-400 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 py-6 px-6 mt-auto">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    © {{ date('Y') }} VolunteerConnect. All rights reserved.
                </p>
                <div class="flex items-center space-x-4 mt-4 md:mt-0">
                    <a href="{{ route('about') }}"
                        class="text-sm text-gray-600 dark:text-gray-400 hover:text-org-600 dark:hover:text-org-400 transition-colors">About</a>
                    <a href="{{ route('contact') }}"
                        class="text-sm text-gray-600 dark:text-gray-400 hover:text-org-600 dark:hover:text-org-400 transition-colors">Contact</a>
                    <a href="{{ route('privacy') }}"
                        class="text-sm text-gray-600 dark:text-gray-400 hover:text-org-600 dark:hover:text-org-400 transition-colors">Privacy</a>
                    <a href="{{ route('terms') }}"
                        class="text-sm text-gray-600 dark:text-gray-400 hover:text-org-600 dark:hover:text-org-400 transition-colors">Terms</a>
                </div>
            </div>
        </footer>

    </div>

    <div id="toast-container" class="fixed bottom-4 right-4 z-[60] space-y-2"></div>

    <script>
        // Main App Data
        function appData() {
            return {
                darkMode: localStorage.getItem('darkMode') === 'true',
                sidebarOpen: window.innerWidth >= 1024,
                mobileMenuOpen: false,
                loading: false,

                init() {
                    window.addEventListener('resize', () => {
                        if (window.innerWidth >= 1024) {
                            this.sidebarOpen = true;
                            this.mobileMenuOpen = false;
                        }
                    });

                    document.documentElement.classList.toggle('dark', this.darkMode);
                }
            }
        }

        // Notification Dropdown Component
        function notificationDropdown() {
            return {
                open: false,
                unreadCount: 0,
                notifications: [],

                async init() {
                    await this.loadNotifications();
                    setInterval(() => this.loadNotifications(), 30000);
                },

                toggleDropdown() {
                    this.open = !this.open;
                    if (this.open) {
                        this.loadNotifications();
                    }
                },

                async loadNotifications() {
                    try {
                        const response = await fetch('{{ route("notifications.recent") }}');
                        const data = await response.json();

                        if (data.success) {
                            this.notifications = data.notifications || [];
                            this.unreadCount = data.unread_count || 0;
                        }
                    } catch (error) {
                        console.error('Error loading notifications:', error);
                    }
                },

                async markAllAsRead() {
                    try {
                        const response = await fetch('{{ route("notifications.mark-all-read") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });

                        if (response.ok) {
                            this.notifications.forEach(n => n.is_read = true);
                            this.unreadCount = 0;
                            showToast('All notifications marked as read', 'success');
                        }
                    } catch (error) {
                        console.error('Error marking notifications as read:', error);
                    }
                },

                getNotificationIcon(type) {
                    const icons = {
                        'Application': 'fas fa-file-alt',
                        'Message': 'fas fa-envelope',
                        'Video Call': 'fas fa-video',
                        'Review': 'fas fa-star',
                        'System': 'fas fa-info-circle',
                        'Opportunity': 'fas fa-clipboard-list'
                    };
                    return icons[type] || 'fas fa-bell';
                },

                getNotificationColor(type) {
                    const colors = {
                        'Application': 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400',
                        'Message': 'bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400',
                        'Video Call': 'bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400',
                        'Review': 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400',
                        'System': 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400',
                        'Opportunity': 'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400'
                    };
                    return colors[type] || 'bg-gray-100 text-gray-600';
                },

                formatTime(timestamp) {
                    const date = new Date(timestamp);
                    const now = new Date();
                    const diff = Math.floor((now - date) / 1000); // seconds

                    if (diff < 60) return 'Just now';
                    if (diff < 3600) return Math.floor(diff / 60) + ' min ago';
                    if (diff < 86400) return Math.floor(diff / 3600) + ' hours ago';
                    if (diff < 604800) return Math.floor(diff / 86400) + ' days ago';
                    return date.toLocaleDateString();
                }
            }
        }

        // Quick Stats Component (Dashboard)
        function quickStats() {
            return {
                stats: {
                    opportunities: 0,
                    pending: 0,
                    volunteers: 0,
                    hours: 0
                },

                async loadStats() {
                    try {
                        const response = await fetch('/organization/analytics/data?range=30');
                        const data = await response.json();

                        if (data.success && data.stats) {
                            this.stats = {
                                opportunities: data.stats.active_opportunities || 0,
                                pending: data.stats.pending_applications || 0,
                                volunteers: data.stats.active_volunteers || 0,
                                hours: Math.round(data.stats.total_hours) || 0
                            };
                        }
                    } catch (error) {
                        console.error('Error loading quick stats:', error);
                    }
                }
            }
        }

        // Toast Notification Function
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');

            const toast = document.createElement('div');
            toast.className = `transform transition-all duration-300 translate-x-0 px-6 py-4 rounded-xl shadow-2xl text-white max-w-sm ${type === 'success' ? 'bg-gradient-to-r from-green-500 to-emerald-600' :
                type === 'error' ? 'bg-gradient-to-r from-red-500 to-rose-600' :
                    type === 'warning' ? 'bg-gradient-to-r from-yellow-500 to-orange-600' :
                        'bg-gradient-to-r from-blue-500 to-cyan-600'
                }`;

            toast.innerHTML = `
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <i class="fas fa-${type === 'success' ? 'check-circle' :
                    type === 'error' ? 'exclamation-circle' :
                        type === 'warning' ? 'exclamation-triangle' :
                            'info-circle'
                } text-2xl"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium">${message}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 hover:bg-white/20 rounded-lg p-1 transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;

            container.appendChild(toast);

            setTimeout(() => {
                toast.style.transform = 'translateX(400px)';
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 5000);
        }

        @if(session('success')) showToast("{{ session('success') }}", 'success'); @endif
        @if(session('error')) showToast("{{ session('error') }}", 'error'); @endif
        @if(session('warning')) showToast("{{ session('warning') }}", 'warning'); @endif
        @if(session('info')) showToast("{{ session('info') }}", 'info'); @endif

        window.addEventListener('error', function (e) {
            console.error('Global error:', e.error);
        });

        const setupAjax = () => {
            const token = document.querySelector('meta[name="csrf-token"]')?.content;
            if (token) {
                window.axios = window.axios || {};
                window.axios.defaults = window.axios.defaults || {};
                window.axios.defaults.headers = window.axios.defaults.headers || {};
                window.axios.defaults.headers.common = window.axios.defaults.headers.common || {};
                window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
            }
        };
        setupAjax();

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                window.dispatchEvent(new Event('click'));
            }
        });

        window.addEventListener('online', () => {
            showToast('You are back online!', 'success');
        });

        window.addEventListener('offline', () => {
            showToast('You are offline. Some features may not work.', 'warning');
        });
    </script>

    @stack('scripts')
    <div x-data="{
        show: !localStorage.getItem('cookie_consent_accepted'),
        accept() {
            localStorage.setItem('cookie_consent_accepted', 'true');
            this.show = false;
        },
        decline() {
            this.show = false;
            // Xử lý logic từ chối nếu cần (tuỳ chọn)
        }
    }" x-init="$watch('show', value => { if(value) document.body.classList.add('overflow-hidden'); else document.body.classList.remove('overflow-hidden'); })"
        x-show="show" x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0 translate-y-full" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-300" x-transition:leave-end="opacity-0 translate-y-full"
        class="fixed bottom-0 left-0 right-0 z-[100] p-4 md:p-6" style="display: none;"> {{-- style display none để
        tránh giật layout khi load --}}

        <div
            class="max-w-6xl mx-auto bg-white/90 dark:bg-slate-900/95 backdrop-blur-xl rounded-2xl shadow-[0_-10px_40px_rgba(0,0,0,0.1)] border border-purple-100 dark:border-purple-800 p-6 md:flex items-center justify-between gap-6 relative overflow-hidden">

            {{-- Background decoration --}}
            <div
                class="absolute top-0 right-0 w-32 h-32 bg-purple-500/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2">
            </div>

            <div class="flex items-start gap-4 mb-4 md:mb-0 relative z-10">
                <div
                    class="hidden sm:flex flex-shrink-0 w-12 h-12 bg-gradient-to-br from-purple-100 to-indigo-100 dark:from-purple-900/50 dark:to-indigo-900/50 rounded-xl items-center justify-center text-purple-600 dark:text-purple-400">
                    <i class="fas fa-cookie-bite text-2xl"></i>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 dark:text-white text-lg mb-1 flex items-center gap-2">
                        <i class="fas fa-cookie-bite sm:hidden text-purple-600"></i>
                        Chúng tôi trân trọng quyền riêng tư của bạn
                    </h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                        Website sử dụng cookies để cải thiện trải nghiệm người dùng, phân tích lưu lượng truy cập và cá
                        nhân hóa nội dung. Bằng cách nhấn "Chấp nhận", bạn đồng ý với việc lưu trữ cookies trên thiết bị
                        của mình.
                        <a href="{{ route('privacy') ?? '#' }}"
                            class="text-purple-600 hover:text-purple-700 font-medium underline decoration-purple-300 underline-offset-2">Xem
                            Chính sách bảo mật</a>.
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3 flex-shrink-0 relative z-10">
                <button @click="decline()"
                    class="px-5 py-2.5 text-sm font-semibold text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-800 rounded-xl transition">
                    Để sau
                </button>
                <button @click="accept()"
                    class="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 shadow-lg hover:shadow-purple-500/30 rounded-xl transform hover:-translate-y-0.5 transition-all duration-200">
                    Chấp nhận tất cả
                </button>
            </div>
        </div>
    </div>
</body>

</html>