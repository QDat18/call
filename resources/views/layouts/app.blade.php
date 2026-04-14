<!DOCTYPE html>
<html lang="vi" class="h-full scroll-smooth" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
    :class="{ 'dark': darkMode }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'VolunteerConnect Platform')</title>
    <link rel="icon" href="{{ asset('local.jpg') }}">
    <link rel="shortcut icon" href="{{ asset('local.jpg') }}">
    
    {{-- Vite Asset Management (Compiled Tailwind 4) --}}
    @vite(['resources/css/app.css', 'resources/js/main.tsx'])

    {{-- Fonts & Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    @stack('styles')
</head>

<body
    class="h-full bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800">
    <div class="min-h-full">
        <nav class="glass dark:glass-dark sticky top-0 z-50 border-b border-gray-200/50 dark:border-gray-700/50 shadow-lg"
            x-data="{ mobileMenuOpen: false }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center space-x-8">
                        <a href="{{ route('home') }}" class="flex items-center space-x-2 group">
                            <div class="relative">
                                <div
                                    class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg blur opacity-75 group-hover:opacity-100 transition">
                                </div>
                                <div class="relative bg-gradient-to-r from-indigo-600 to-purple-600 p-2 rounded-lg">
                                    <img src="{{ asset('local.jpg') }}" alt="Volunteer Logo"
                                        class="h-8 w-auto object-cover">

                                </div>
                            </div>
                            <span class="font-bold text-xl gradient-text hidden sm:block">VolunteerConnect</span>
                        </a>

                        <div class="hidden md:flex md:space-x-1">

                            <a href="{{ route('opportunities.index') }}"
                                class="nav-link inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 rounded-lg hover:bg-white/50 dark:hover:bg-gray-800/50 transition">
                                <i class="fas fa-search mr-2"></i>Tìm Cơ Hội
                            </a>

                            {{-- [MỚI] Thêm nút Bản đồ --}}
                            <a href="{{ route('map.index') }}"
                                class="nav-link inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 rounded-lg hover:bg-white/50 dark:hover:bg-gray-800/50 transition">
                                <i class="fas fa-map-marked-alt mr-2"></i>Bản Đồ
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

                    <div class="flex items-center space-x-2">
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
                            <div class="relative hidden sm:block" x-data="{ open: false }">
                                <button @click="open = !open" type="button"
                                    class="relative p-2.5 text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-white/50 dark:hover:bg-gray-800/50 rounded-lg transition">
                                    <i class="fas fa-bell text-lg"></i>
                                    @if(auth()->user()->unreadNotifications->count() > 0)
                                        <span
                                            class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full notification-badge"></span>
                                    @endif
                                </button>

                                <div x-show="open" @click.away="open = false" x-transition
                                    class="absolute right-0 mt-2 w-80 glass dark:glass-dark rounded-xl shadow-2xl border border-gray-200/50 dark:border-gray-700/50 py-2 z-50 overflow-hidden"
                                    style="display: none;">

                                    <div
                                        class="px-4 py-2 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                                        <h6 class="text-sm font-bold text-gray-900 dark:text-white">Notifications</h6>
                                        <a href="{{ route('notifications.index') }}"
                                            class="text-xs text-indigo-600 hover:underline">View all</a>
                                    </div>

                                    <div class="max-h-64 overflow-y-auto">
                                        @forelse(auth()->user()->unreadNotifications->take(5) as $notification)
                                            <a href="{{ route('notifications.read', $notification->getKey()) }}"
                                                class="block px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-800 transition border-b border-gray-100 dark:border-gray-700 last:border-0">                                                <p class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                                    {{ $notification->data['title'] ?? 'New Notification' }}</p>
                                                <p class="text-xs text-gray-500 mt-1 truncate">
                                                    {{ $notification->data['content'] ?? '' }}</p>
                                                <p class="text-[10px] text-gray-400 mt-1">
                                                    {{ $notification->created_at->diffForHumans() }}</p>
                                            </a>
                                        @empty
                                            <div class="px-4 py-6 text-center text-gray-500 text-sm">
                                                No new notifications
                                            </div>
                                        @endforelse
                                    </div>

                                    @if(auth()->user()->unreadNotifications->count() > 0)
                                        <div class="border-t border-gray-200 dark:border-gray-700 p-2 text-center">
                                            <form action="{{ route('notifications.read-all') }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="text-xs text-gray-500 hover:text-indigo-600 font-medium">
                                                    Mark all as read
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>

<div class="relative hidden sm:block" x-data="{ msgOpen: false }">
    <button @click="msgOpen = !msgOpen" type="button"
        class="relative p-2.5 text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-white/50 dark:hover:bg-gray-800/50 rounded-lg transition">
        <i class="fas fa-comments text-lg"></i>
        
        {{-- Badge tin nhắn chưa đọc --}}
        @php
            $unreadMsgCount = \App\Models\ConversationParticipant::where('user_id', auth()->id())
                ->where('is_active', true)
                ->sum('unread_count');
        @endphp
        
        @if($unreadMsgCount > 0)
            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full notification-badge"></span>
        @endif
    </button>

    {{-- Dropdown Content --}}
    <div x-show="msgOpen" @click.away="msgOpen = false" x-transition
        class="absolute right-0 mt-2 w-80 glass dark:glass-dark rounded-xl shadow-2xl border border-gray-200/50 dark:border-gray-700/50 py-2 z-50 overflow-hidden"
        style="display: none;">

        <div class="px-4 py-2 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h6 class="text-sm font-bold text-gray-900 dark:text-white">Tin nhắn</h6>
            <a href="{{ route('conversations.index') }}" class="text-xs text-indigo-600 hover:underline">Xem tất cả</a>
        </div>

        <div class="max-h-80 overflow-y-auto">
            @php
                // Lấy 5 cuộc trò chuyện gần nhất để hiển thị nhanh
                $recentConvs = \App\Models\Conversation::whereHas('participants', function ($q) {
                        $q->where('user_id', auth()->id())->where('is_active', true);
                    })
                    ->with(['participants.user', 'lastMessage'])
                    ->orderBy('last_message_at', 'desc')
                    ->take(5)
                    ->get();
            @endphp

            @forelse($recentConvs as $conv)
                @php
                    $p = $conv->participants->where('user_id', '!=', auth()->id())->first();
                    $u = $p ? $p->user : null;
                    $lastMsg = $conv->lastMessage;
                    $myPart = $conv->participants->where('user_id', auth()->id())->first();
                    $isUnread = $myPart && $myPart->unread_count > 0;
                @endphp

                @if($u)
                    <a href="{{ route('conversations.show', $conv->conversation_id) }}" 
                       class="block px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-800 transition border-b border-gray-100 dark:border-gray-700 last:border-0 flex items-center gap-3">
                        
                        {{-- Avatar --}}
                        <div class="relative flex-shrink-0">
                            <img src="{{ !empty($u->avatar_url) ? (Str::startsWith($u->avatar_url, ['http']) ? $u->avatar_url : asset('storage/'.$u->avatar_url)) : asset('images/default-avatar.png') }}" 
                                 class="w-10 h-10 rounded-full object-cover border border-gray-200">
                            @if($u->is_online)
                                <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 border-2 border-white rounded-full"></span>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-baseline mb-0.5">
                                <h4 class="text-sm font-semibold text-gray-900 dark:text-white truncate {{ $isUnread ? 'font-bold' : '' }}">
                                    {{ $u->first_name }} {{ $u->last_name }}
                                </h4>
                                <span class="text-[10px] text-gray-400 flex-shrink-0">
                                    {{ $lastMsg ? $lastMsg->sent_at->diffForHumans(null, true, true) : '' }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate {{ $isUnread ? 'font-semibold text-gray-800 dark:text-gray-200' : '' }}">
                                @if($lastMsg)
                                    {{ $lastMsg->sender_id == auth()->id() ? 'Bạn: ' : '' }}
                                    {{ $lastMsg->is_deleted ? 'Tin nhắn đã thu hồi' : $lastMsg->content }}
                                @else
                                    Bắt đầu trò chuyện
                                @endif
                            </p>
                        </div>

                        {{-- Unread Dot --}}
                        @if($isUnread)
                            <div class="w-2 h-2 bg-indigo-600 rounded-full flex-shrink-0"></div>
                        @endif
                    </a>
                @endif
            @empty
                <div class="px-4 py-8 text-center text-gray-500 text-sm">
                    <i class="far fa-comments text-2xl mb-2 text-gray-300"></i>
                    <p>Chưa có tin nhắn nào</p>
                </div>
            @endforelse
        </div>
        
        <div class="p-2 text-center border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
            <a href="{{ route('conversations.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700">
                Mở Messenger
            </a>
        </div>
    </div>
</div>
<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" type="button"
        class="flex items-center space-x-2 p-1.5 rounded-lg hover:bg-white/50 dark:hover:bg-gray-800/50 transition">
        <img src="{{ Auth::user()->avatar_url ? asset('storage/' . Auth::user()->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->first_name . ' ' . Auth::user()->last_name) . '&background=6366f1&color=fff' }}"
            class="w-10 h-10 rounded-full avatar-border object-cover" alt="Avatar">
        <span class="hidden md:block text-sm font-medium text-gray-700 dark:text-gray-300">
            {{ Auth::user()->first_name }}
        </span>
        <i class="fas fa-chevron-down text-xs text-gray-500 transform transition-transform"
            :class="{ 'rotate-180': open }"></i>
    </button>

    <div x-show="open" @click.away="open = false" x-transition
        class="absolute right-0 mt-2 w-64 glass dark:glass-dark rounded-xl shadow-2xl border border-gray-200/50 dark:border-gray-700/50 py-2 z-50"
        style="display: none;">
        
        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
            <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
            </p>
            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ Auth::user()->email }}</p>
            <span class="inline-block mt-1 px-2 py-0.5 text-[10px] font-bold rounded-full bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300">
                {{ Auth::user()->user_type }}
            </span>
        </div>

        <div class="py-1">
            <a href="{{ route('dashboard') }}"
                class="flex items-center space-x-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                <i class="fas fa-tachometer-alt w-5 text-indigo-600 dark:text-indigo-400"></i>
                <span>Dashboard</span>
            </a>

            @if(Auth::user()->user_type === 'Organization')
                {{-- ORGANIZATION LINKS --}}
                <div class="border-t border-gray-100 dark:border-gray-700 my-1"></div>
                
                <a href="{{ route('organization.profile.show') }}"
                    class="flex items-center space-x-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                    <i class="fas fa-building w-5 text-blue-600 dark:text-blue-400"></i>
                    <span>Hồ Sơ Tổ Chức</span>
                </a>
                
                <a href="{{ route('organization.opportunities.index') }}"
                    class="flex items-center space-x-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                    <i class="fas fa-briefcase w-5 text-green-600 dark:text-green-400"></i>
                    <span>Quản Lý Cơ Hội</span>
                </a>

                <a href="{{ route('organization.applications.index') }}"
                    class="flex items-center space-x-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                    <i class="fas fa-file-alt w-5 text-yellow-600 dark:text-yellow-400"></i>
                    <span>Duyệt Đơn Đăng Ký</span>
                </a>

                <a href="{{ route('organization.activities.index') }}"
                    class="flex items-center space-x-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                    <i class="fas fa-clock w-5 text-purple-600 dark:text-purple-400"></i>
                    <span>Xác Nhận Giờ Làm</span>
                </a>

            @elseif(Auth::user()->user_type === 'Volunteer')
                {{-- VOLUNTEER LINKS --}}
                <div class="border-t border-gray-100 dark:border-gray-700 my-1"></div>

                <a href="{{ route('volunteer.profile.profile') }}"
                    class="flex items-center space-x-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                    <i class="fas fa-user w-5 text-blue-600 dark:text-blue-400"></i>
                    <span>Hồ Sơ Cá Nhân</span>
                </a>
                
                <a href="{{ route('volunteer.applications.my') }}"
                    class="flex items-center space-x-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                    <i class="fas fa-folder-open w-5 text-yellow-600 dark:text-yellow-400"></i>
                    <span>Đơn Của Tôi</span>
                </a>

                <a href="{{ route('volunteer.activities.index') }}"
                    class="flex items-center space-x-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                    <i class="fas fa-history w-5 text-green-600 dark:text-green-400"></i>
                    <span>Lịch Sử Hoạt Động</span>
                </a>

@elseif(Auth::user()->user_type === 'Admin')
                {{-- ADMIN LINKS --}}
                <div class="border-t border-gray-100 dark:border-gray-700 my-1"></div>

                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center space-x-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                    <i class="fas fa-chart-line w-5 text-indigo-600 dark:text-indigo-400"></i>
                    <span>Tổng Quan (Dashboard)</span>
                </a>
                
                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center space-x-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                    <i class="fas fa-users w-5 text-blue-600 dark:text-blue-400"></i>
                    <span>Quản Lý Người Dùng</span>
                </a>

                <a href="{{ route('admin.organizations.index') }}"
                    class="flex items-center space-x-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                    <i class="fas fa-building w-5 text-orange-600 dark:text-orange-400"></i>
                    <span>Duyệt Tổ Chức</span>
                </a>

                <a href="{{ route('admin.posts.index') }}"
                    class="flex items-center space-x-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                    <i class="fas fa-shield-alt w-5 text-red-600 dark:text-red-400"></i>
                    <span>Kiểm Duyệt Bài Đăng</span>
                </a>

                <a href="{{ route('admin.analytics.index') }}"
                    class="flex items-center space-x-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                    <i class="fas fa-chart-pie w-5 text-purple-600 dark:text-purple-400"></i>
                    <span>Báo Cáo & Thống Kê</span>
                </a>

                <a href="{{ route('admin.settings.index') }}"
                    class="flex items-center space-x-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                    <i class="fas fa-cogs w-5 text-gray-500 dark:text-gray-400"></i>
                    <span>Cài Đặt Hệ Thống</span>
                </a>
            @endif

            <div class="border-t border-gray-100 dark:border-gray-700 my-1"></div>
            <a href="{{ route('profile') }}"
                class="flex items-center space-x-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                <i class="fas fa-cog w-5 text-gray-500 dark:text-gray-400"></i>
                <span>Cài Đặt Tài Khoản</span>
            </a>
        </div>

        <div class="border-t border-gray-200 dark:border-gray-700 py-1">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="flex items-center space-x-3 w-full px-4 py-2.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition">
                    <i class="fas fa-sign-out-alt w-5"></i>
                    <span>Đăng Xuất</span>
                </button>
            </form>
        </div>
    </div>
</div>
                        @endguest

                        <button @click="mobileMenuOpen = !mobileMenuOpen" type="button"
                            class="md:hidden p-2 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-white/50 dark:hover:bg-gray-800/50">
                            <i class="fas text-xl" :class="mobileMenuOpen ? 'fa-times' : 'fa-bars'"></i>
                        </button>
                    </div>
                </div>

                <div x-show="mobileMenuOpen" x-transition class="md:hidden pb-4" style="display: none;">
                    <div class="space-y-1">
                        <a href="{{ route('opportunities.index') }}"
                            class="block px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-white/50 dark:hover:bg-gray-800/50 rounded-lg">
                            <i class="fas fa-search mr-2"></i>Tìm Cơ Hội
                        </a>

                        {{-- [MỚI] Thêm nút Bản đồ Mobile --}}
                        <a href="{{ route('map.index') }}"
                            class="block px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-white/50 dark:hover:bg-gray-800/50 rounded-lg">
                            <i class="fas fa-map-marked-alt mr-2"></i>Bản Đồ
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

        <main>@yield('content')</main>

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
                                    <img src="{{ asset('local.jpg') }}" alt="VolunteerConnect Logo" class="h-8 w-auto object-cover">                                
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

                            {{-- [MỚI] Thêm link Bản đồ vào Footer --}}
                            <li><a href="{{ route('map.index') }}"
                                    class="text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition flex items-center space-x-2 group"><i
                                        class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-indigo-600 group-hover:translate-x-1 transition-all"></i><span>Bản
                                        Đồ</span></a></li>

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

        <button id="scrollToTop" onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
            class="fixed bottom-8 right-8 w-12 h-12 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-full shadow-2xl hover:shadow-indigo-500/50 transform hover:scale-110 transition-all opacity-0 pointer-events-none z-50">
            <i class="fas fa-arrow-up"></i>
        </button>
    </div>

    <div id="mediaLightbox"
        class="fixed inset-0 z-[9999] hidden bg-black/95 backdrop-blur-sm flex items-center justify-center opacity-0 transition-opacity duration-300"
        tabindex="-1">

        <button onclick="closeLightbox()"
            class="absolute top-4 right-4 text-white/70 hover:text-white p-2 rounded-full hover:bg-white/10 transition z-50">
            <i class="fas fa-times text-2xl"></i>
        </button>

        <button id="lbPrev" onclick="changeMedia(-1)"
            class="absolute left-4 text-white/70 hover:text-white p-4 rounded-full hover:bg-white/10 transition z-50 hidden md:block">
            <i class="fas fa-chevron-left text-3xl"></i>
        </button>

        <button id="lbNext" onclick="changeMedia(1)"
            class="absolute right-4 text-white/70 hover:text-white p-4 rounded-full hover:bg-white/10 transition z-50 hidden md:block">
            <i class="fas fa-chevron-right text-3xl"></i>
        </button>

        <div class="relative w-full h-full flex items-center justify-center p-4 md:p-10">
            <div id="lbContent"
                class="max-w-full max-h-full shadow-2xl rounded-lg overflow-hidden flex items-center justify-center">
            </div>
        </div>

        <div class="absolute bottom-4 left-0 right-0 text-center text-white pointer-events-none">
            <span id="lbCounter" class="bg-black/50 px-3 py-1 rounded-full text-sm backdrop-blur-md"></span>
        </div>
    </div>

    <div id="mediaLightbox"
        class="fixed inset-0 z-[9999] hidden bg-black/95 backdrop-blur-sm flex items-center justify-center opacity-0 transition-opacity duration-300"
        tabindex="-1">
        <button onclick="closeLightbox()"
            class="absolute top-4 right-4 text-white/70 hover:text-white p-2 rounded-full hover:bg-white/10 transition z-50"><i
                class="fas fa-times text-3xl"></i></button>
        <button onclick="changeMedia(-1)"
            class="absolute left-4 text-white/70 hover:text-white p-4 rounded-full hover:bg-white/10 transition z-50 hidden md:block"><i
                class="fas fa-chevron-left text-4xl"></i></button>
        <button onclick="changeMedia(1)"
            class="absolute right-4 text-white/70 hover:text-white p-4 rounded-full hover:bg-white/10 transition z-50 hidden md:block"><i
                class="fas fa-chevron-right text-4xl"></i></button>

        <div class="relative w-full h-full flex items-center justify-center p-4">
            <div id="lbContent" class="max-w-full max-h-full flex items-center justify-center shadow-2xl"></div>
        </div>
        <div class="absolute bottom-4 text-white font-medium bg-black/50 px-4 py-1 rounded-full backdrop-blur"><span
                id="lbCounter"></span></div>
    </div>

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

    <script>
        // --- LOGIC LIGHTBOX ---
        let currentMedia = [];
        let currentIndex = 0;
        const lightbox = document.getElementById('mediaLightbox');
        const lbContent = document.getElementById('lbContent');
        const lbCounter = document.getElementById('lbCounter');

        window.openLightbox = function (media, index) {
            if (!media || media.length === 0) return;
            // Dừng video trên feed
            document.querySelectorAll('video').forEach(v => v.pause());

            currentMedia = media;
            currentIndex = index;
            lightbox.classList.remove('hidden');
            setTimeout(() => lightbox.classList.remove('opacity-0'), 10);
            document.body.style.overflow = 'hidden';
            showMedia();
        }

        window.closeLightbox = function () {
            lightbox.classList.add('opacity-0');
            // Dừng video trong lightbox
            const v = lbContent.querySelector('video');
            if (v) v.pause();

            setTimeout(() => {
                lightbox.classList.add('hidden');
                lbContent.innerHTML = '';
                document.body.style.overflow = '';
            }, 300);
        }

        window.changeMedia = function (dir) {
            currentIndex = (currentIndex + dir + currentMedia.length) % currentMedia.length;
            showMedia();
        }

        function showMedia() {
            const item = currentMedia[currentIndex];
            const path = `/storage/${item.file_path}`;

            if (item.file_type === 'video') {
                lbContent.innerHTML = `<video src="${path}" controls autoplay class="max-w-full max-h-[85vh] rounded-lg"></video>`;
            } else {
                lbContent.innerHTML = `<img src="${path}" class="max-w-full max-h-[85vh] object-contain rounded-lg">`;
            }
            lbCounter.textContent = `${currentIndex + 1} / ${currentMedia.length}`;
        }

        document.addEventListener('keydown', e => {
            if (lightbox.classList.contains('hidden')) return;
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowLeft') changeMedia(-1);
            if (e.key === 'ArrowRight') changeMedia(1);
        });

        // --- LOGIC TƯƠNG TÁC BÀI VIẾT (LIKE, SAVE, DELETE) ---

        async function toggleLike(postId) {
            try {
                const response = await fetch(`/posts/${postId}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });

                if (response.status === 401) {
                    window.location.href = '{{ route("login") }}';
                    return;
                }

                const data = await response.json();
                if (data.success) {
                    // Cách đơn giản nhất: Reload để cập nhật UI
                    location.reload();
                }
            } catch (error) {
                console.error('Error liking post:', error);
            }
        }

        async function savePost(postId) {
            toggleBookmark(postId);
        }

        async function toggleBookmark(postId) {
            try {
                const response = await fetch(`/posts/${postId}/bookmark`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });

                if (response.status === 401) {
                    window.location.href = '{{ route("login") }}';
                    return;
                }

                const data = await response.json();
                if (data.success) {
                    location.reload();
                }
            } catch (error) {
                console.error('Error bookmarking post:', error);
            }
        }

        async function deletePost(postId) {
            if (!confirm('Are you sure you want to delete this post?')) return;

            try {
                const response = await fetch(`/posts/${postId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                if (data.success) {
                    // Nếu đang ở trang chi tiết, về trang chủ. Nếu ở trang list, reload.
                    if (window.location.pathname.includes('/posts/')) {
                        window.location.href = '{{ route("posts.index") }}';
                    } else {
                        location.reload();
                    }
                }
            } catch (error) {
                console.error('Error deleting post:', error);
                alert('Failed to delete post');
            }
        }
    </script>

    @stack('scripts')

    <style>
        @keyframes zoom-in {
            from {
                transform: scale(0.95);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .animate-zoom-in {
            animation: zoom-in 0.2s ease-out forwards;
        }
    </style>

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
    }"
    x-init="$watch('show', value => { if(value) document.body.classList.add('overflow-hidden'); else document.body.classList.remove('overflow-hidden'); })"
    x-show="show"
    x-transition:enter="transition ease-out duration-500"
    x-transition:enter-start="opacity-0 translate-y-full"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-end="opacity-0 translate-y-full"
    class="fixed bottom-0 left-0 right-0 z-[100] p-4 md:p-6"
    style="display: none;"> {{-- style display none để tránh giật layout khi load --}}
    
    <div class="max-w-6xl mx-auto bg-white/90 dark:bg-slate-900/95 backdrop-blur-xl rounded-2xl shadow-[0_-10px_40px_rgba(0,0,0,0.1)] border border-purple-100 dark:border-purple-800 p-6 md:flex items-center justify-between gap-6 relative overflow-hidden">
        
        {{-- Background decoration --}}
        <div class="absolute top-0 right-0 w-32 h-32 bg-purple-500/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        
        <div class="flex items-start gap-4 mb-4 md:mb-0 relative z-10">
            <div class="hidden sm:flex flex-shrink-0 w-12 h-12 bg-gradient-to-br from-purple-100 to-indigo-100 dark:from-purple-900/50 dark:to-indigo-900/50 rounded-xl items-center justify-center text-purple-600 dark:text-purple-400">
                <i class="fas fa-cookie-bite text-2xl"></i>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 dark:text-white text-lg mb-1 flex items-center gap-2">
                    <i class="fas fa-cookie-bite sm:hidden text-purple-600"></i>
                    Chúng tôi trân trọng quyền riêng tư của bạn
                </h4>
                <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                    Website sử dụng cookies để cải thiện trải nghiệm người dùng, phân tích lưu lượng truy cập và cá nhân hóa nội dung. Bằng cách nhấn "Chấp nhận", bạn đồng ý với việc lưu trữ cookies trên thiết bị của mình.
                    <a href="{{ route('privacy') ?? '#' }}" class="text-purple-600 hover:text-purple-700 font-medium underline decoration-purple-300 underline-offset-2">Xem Chính sách bảo mật</a>.
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