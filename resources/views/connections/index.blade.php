@extends('layouts.app')

@section('title', 'Quản lý mối quan hệ')

@section('content')
<div class="flex h-[calc(100vh-65px)] bg-gray-50 overflow-hidden">

    {{-- ==================== 1. SIDEBAR TRÁI ==================== --}}
    <aside class="w-72 bg-white border-r border-gray-200 flex flex-col flex-shrink-0 z-20">
        {{-- Header Sidebar --}}
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-users text-indigo-600"></i> Mối quan hệ
            </h2>
            <p class="text-xs text-gray-500 mt-1">Quản lý kết nối của bạn</p>
        </div>

        {{-- Menu Navigation --}}
        <nav class="flex-1 overflow-y-auto p-4 space-y-1">
            {{-- Tab: Bạn bè --}}
            <a href="{{ route('connections.index', ['status' => 'accepted']) }}" 
               class="flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 group {{ $status === 'accepted' ? 'bg-indigo-50 text-indigo-700 font-semibold shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $status === 'accepted' ? 'bg-white text-indigo-600' : 'bg-gray-100 text-gray-500 group-hover:bg-white' }}">
                        <i class="fas fa-user-friends text-sm"></i>
                    </div>
                    <span>Bạn bè</span>
                </div>
                <span class="text-xs font-bold px-2 py-0.5 rounded-full {{ $status === 'accepted' ? 'bg-white text-indigo-600' : 'bg-gray-100 text-gray-500' }}">
                    {{ $acceptedCount }}
                </span>
            </a>

            {{-- Tab: Lời mời --}}
            <a href="{{ route('connections.index', ['status' => 'pending']) }}" 
               class="flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 group {{ $status === 'pending' ? 'bg-indigo-50 text-indigo-700 font-semibold shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $status === 'pending' ? 'bg-white text-indigo-600' : 'bg-gray-100 text-gray-500 group-hover:bg-white' }}">
                        <i class="fas fa-user-clock text-sm"></i>
                    </div>
                    <span>Lời mời kết bạn</span>
                </div>
                @if($pendingCount > 0)
                    <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-red-500 text-white animate-pulse">
                        {{ $pendingCount }}
                    </span>
                @endif
            </a>

            {{-- Tab: Đã chặn --}}
            <a href="{{ route('connections.index', ['status' => 'blocked']) }}" 
               class="flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 group {{ $status === 'blocked' ? 'bg-indigo-50 text-indigo-700 font-semibold shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $status === 'blocked' ? 'bg-white text-indigo-600' : 'bg-gray-100 text-gray-500 group-hover:bg-white' }}">
                        <i class="fas fa-user-slash text-sm"></i>
                    </div>
                    <span>Đã chặn</span>
                </div>
            </a>
        </nav>

        {{-- Footer Sidebar --}}
        <div class="p-4 border-t border-gray-100 bg-gray-50">
            <div class="text-xs text-center text-gray-400">
                &copy; {{ date('Y') }} Volunteer App
            </div>
        </div>
    </aside>

    {{-- ==================== 2. MAIN CONTENT ==================== --}}
    <main class="flex-1 flex flex-col min-w-0 bg-gray-50">
        
        {{-- Top Bar: Search & Title --}}
        <header class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between shadow-sm sticky top-0 z-10">
            <div>
                <h1 class="text-xl font-bold text-gray-800">
                    @if($status === 'accepted') Danh sách bạn bè
                    @elseif($status === 'pending') Lời mời kết bạn
                    @else Danh sách chặn
                    @endif
                </h1>
                <p class="text-sm text-gray-500 mt-0.5">
                    @if($status === 'accepted') Những người bạn đã kết nối.
                    @elseif($status === 'pending') Quản lý các yêu cầu gửi đến và đi.
                    @else Những người dùng bạn không muốn tương tác.
                    @endif
                </p>
            </div>

            {{-- Search Box --}}
            <div class="relative w-96 group">
                <input type="text" id="global-search" 
                       class="w-full pl-10 pr-4 py-2.5 bg-gray-100 border-transparent rounded-full text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all" 
                       placeholder="Tìm người dùng qua tên, email..." autocomplete="off">
                <i class="fas fa-search absolute left-3.5 top-3 text-gray-400 group-focus-within:text-indigo-500 transition-colors"></i>
                
                {{-- Dropdown Search Results --}}
                <div id="search-dropdown" class="absolute top-full mt-2 left-0 w-full bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden hidden z-50 max-h-96 overflow-y-auto">
                    {{-- JS Render --}}
                </div>
            </div>
        </header>

        {{-- Content Grid --}}
        <div class="flex-1 overflow-y-auto p-8 custom-scrollbar">
            @if($connections->isEmpty())
                <div class="flex flex-col items-center justify-center h-full text-center pb-20">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4 text-gray-300">
                        <i class="fas fa-users-slash text-4xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-700">Không có dữ liệu</h3>
                    <p class="text-gray-500 text-sm mt-1 max-w-xs">
                        @if($status === 'accepted') Bạn chưa kết nối với ai cả. Hãy dùng thanh tìm kiếm để kết bạn mới!
                        @elseif($status === 'pending') Hiện không có lời mời kết bạn nào.
                        @else Danh sách chặn đang trống.
                        @endif
                    </p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($connections as $connection)
                        @php
                            $friend = $connection->user_id === auth()->id() ? $connection->friend : $connection->user;
                            $isSender = $connection->user_id === auth()->id();
                            $avatar = $friend->avatar_url ? (Str::startsWith($friend->avatar_url, 'http') ? $friend->avatar_url : asset($friend->avatar_url)) : asset('images/default-avatar.png');
                        @endphp

                        <div class="bg-white rounded-2xl border border-gray-200 p-5 flex flex-col items-center text-center shadow-sm hover:shadow-lg hover:border-indigo-200 transition-all duration-300 group">
                            {{-- Avatar --}}
                            <div class="relative mb-4">
                                <img src="{{ $avatar }}" class="w-20 h-20 rounded-full object-cover border-4 border-white shadow-md group-hover:scale-105 transition-transform">
                                @if($friend->is_online)
                                    <span class="absolute bottom-1 right-1 w-4 h-4 bg-green-500 border-2 border-white rounded-full" title="Online"></span>
                                @endif
                            </div>

                            {{-- Info --}}
                            <h3 class="font-bold text-gray-800 text-base mb-1 truncate w-full px-2" title="{{ $friend->first_name }} {{ $friend->last_name }}">
                                {{ $friend->first_name }} {{ $friend->last_name }}
                            </h3>
                            <p class="text-xs text-gray-500 mb-3 truncate w-full px-2">{{ $friend->email }}</p>
                            
                            <div class="flex gap-2 mb-5">
                                <span class="px-2.5 py-1 bg-gray-100 text-gray-600 text-[10px] uppercase font-bold tracking-wider rounded-md">{{ $friend->user_type }}</span>
                                @if($friend->city)
                                    <span class="px-2.5 py-1 bg-gray-100 text-gray-600 text-[10px] font-medium rounded-md"><i class="fas fa-map-marker-alt mr-1"></i>{{ $friend->city }}</span>
                                @endif
                            </div>

                            {{-- Actions --}}
                            <div class="mt-auto w-full grid gap-2">
                                @if($status === 'accepted')
                                    <a href="{{ route('conversations.create', ['user_id' => $friend->user_id]) }}" class="w-full py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition flex items-center justify-center gap-2">
                                        <i class="fas fa-comment-dots"></i> Nhắn tin
                                    </a>
                                    <button onclick="removeFriend({{ $connection->connection_id }})" class="w-full py-2 bg-white border border-gray-200 text-gray-600 hover:bg-red-50 hover:text-red-600 hover:border-red-200 rounded-lg text-sm font-medium transition">
                                        Hủy kết bạn
                                    </button>
                                @elseif($status === 'pending')
                                    @if($isSender)
                                        <button class="w-full py-2 bg-gray-100 text-gray-500 rounded-lg text-sm font-medium cursor-not-allowed flex items-center justify-center gap-2" disabled>
                                            <i class="fas fa-clock"></i> Đã gửi
                                        </button>
                                        <button onclick="removeFriend({{ $connection->connection_id }})" class="w-full py-2 bg-white border border-gray-200 text-gray-600 hover:bg-red-50 hover:text-red-600 rounded-lg text-sm font-medium transition">
                                            Hủy lời mời
                                        </button>
                                    @else
                                        <div class="grid grid-cols-2 gap-2">
                                            <button onclick="acceptRequest({{ $connection->connection_id }})" class="py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition">
                                                Chấp nhận
                                            </button>
                                            <button onclick="declineRequest({{ $connection->connection_id }})" class="py-2 bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 rounded-lg text-sm font-medium transition">
                                                Từ chối
                                            </button>
                                        </div>
                                    @endif
                                @elseif($status === 'blocked')
                                    <button onclick="unblockUser({{ $connection->connection_id }})" class="w-full py-2 bg-white border border-gray-200 text-gray-700 hover:bg-green-50 hover:text-green-600 hover:border-green-200 rounded-lg text-sm font-medium transition flex items-center justify-center gap-2">
                                        <i class="fas fa-unlock"></i> Bỏ chặn
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                
                {{-- Pagination --}}
                <div class="mt-8 flex justify-center">
                    {{ $connections->withQueryString()->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </main>
</div>

{{-- Toast Notification (Tailwind) --}}
<div id="toast-notification" class="fixed bottom-5 right-5 z-50 transform translate-y-20 opacity-0 transition-all duration-300 pointer-events-none">
    <div class="bg-white border-l-4 border-indigo-600 rounded-lg shadow-xl p-4 flex items-center gap-3 min-w-[300px]">
        <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center flex-shrink-0">
            <i class="fas fa-check" id="toast-icon"></i>
        </div>
        <div>
            <h4 class="font-bold text-gray-800 text-sm" id="toast-title">Thành công</h4>
            <p class="text-xs text-gray-500" id="toast-message">Thao tác đã được thực hiện.</p>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // SỬA LỖI 1: Không dùng const global để tránh xung đột
    // Hàm helper lấy token an toàn
    const getCsrfToken = () => document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    let searchTimeout;

    // --- 1. SEARCH LOGIC ---
    document.getElementById('global-search').addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        const query = e.target.value.trim();
        const dropdown = document.getElementById('search-dropdown');
        
        if(query.length < 2) {
            dropdown.classList.add('hidden');
            return;
        }

        searchTimeout = setTimeout(() => {
            fetch(`/connections/search?q=${encodeURIComponent(query)}`, {
                headers: { 
                    'X-CSRF-TOKEN': getCsrfToken(), // Dùng hàm getCsrfToken()
                    'Accept': 'application/json' 
                }
            })
            .then(res => res.json())
            .then(data => {
                if(data.success && data.users.length > 0) {
                    dropdown.innerHTML = data.users.map(user => `
                        <div class="flex items-center justify-between p-3 hover:bg-gray-50 border-b border-gray-100 last:border-0 transition-colors">
                            <div class="flex items-center gap-3">
                                <img src="${user.avatar_url ? (user.avatar_url.startsWith('http') ? user.avatar_url : '/' + user.avatar_url) : '/images/default-avatar.png'}" 
                                     class="w-10 h-10 rounded-full object-cover border border-gray-200">
                                <div>
                                    <h4 class="text-sm font-bold text-gray-800">${user.first_name} ${user.last_name}</h4>
                                    <p class="text-xs text-gray-500">${user.email}</p>
                                </div>
                            </div>
                            <div>${getActionButton(user)}</div>
                        </div>
                    `).join('');
                    dropdown.classList.remove('hidden');
                } else {
                    dropdown.innerHTML = `<div class="p-4 text-center text-sm text-gray-500">Không tìm thấy kết quả nào.</div>`;
                    dropdown.classList.remove('hidden');
                }
            });
        }, 300);
    });

    document.addEventListener('click', (e) => {
        if (!e.target.closest('.search-wrapper')) { // Sửa class selector cho đúng với HTML mới
            const dropdown = document.getElementById('search-dropdown');
            if(dropdown) dropdown.classList.add('hidden');
        }
    });

    function getActionButton(user) {
        if (user.connection_status === 'accepted') 
            return `<span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">Bạn bè</span>`;
        if (user.connection_status === 'pending') 
            return user.is_sender 
                ? `<span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full">Đã gửi</span>` 
                : `<button onclick="acceptRequest(${user.connection_id})" class="px-3 py-1 bg-indigo-600 text-white text-xs font-bold rounded-full hover:bg-indigo-700">Chấp nhận</button>`;
        if (user.connection_status === 'blocked') 
            return `<span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full">Đã chặn</span>`;
        return `<button onclick="sendFriendRequest(${user.user_id})" class="px-3 py-1 bg-indigo-50 text-indigo-600 border border-indigo-200 text-xs font-bold rounded-full hover:bg-indigo-600 hover:text-white transition">Kết bạn</button>`;
    }

    // --- 2. TOAST NOTIFICATION ---
    function showToast(message, type = 'success') {
        const toast = document.getElementById('toast-notification');
        // Check nếu toast tồn tại trong HTML
        if (!toast) return; 

        const title = document.getElementById('toast-title');
        const msg = document.getElementById('toast-message');
        const icon = document.getElementById('toast-icon');
        const container = toast.querySelector('div');

        // Reset classes
        container.className = `bg-white border-l-4 rounded-lg shadow-xl p-4 flex items-center gap-3 min-w-[300px] ${type === 'success' ? 'border-green-500' : 'border-red-500'}`;
        
        // Update icon bg color
        const iconWrapper = toast.querySelector('.w-8');
        if(iconWrapper) {
            iconWrapper.className = `w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 ${type === 'success' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600'}`;
        }
        
        if(icon) icon.className = type === 'success' ? 'fas fa-check' : 'fas fa-exclamation';
        if(title) title.innerText = type === 'success' ? 'Thành công' : 'Lỗi';
        if(msg) msg.innerText = message;

        // Show animate
        toast.classList.remove('translate-y-20', 'opacity-0', 'pointer-events-none');
        setTimeout(() => {
            toast.classList.add('translate-y-20', 'opacity-0', 'pointer-events-none');
        }, 3000);
    }

    // --- 3. ACTIONS ---
    // Helper fetch wrapper để xử lý lỗi chung
    async function fetchAPI(url, method, body = null) {
        try {
            const options = {
                method: method,
                headers: { 
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            };
            if (body) options.body = JSON.stringify(body);

            const res = await fetch(url, options);
            
            // Nếu server trả về HTML lỗi (như 404, 500 trang mặc định) thì sẽ fail ở bước json()
            if (!res.ok) throw new Error(`Lỗi server: ${res.status}`);
            
            return await res.json();
        } catch (error) {
            console.error(error);
            showToast('Đã xảy ra lỗi kết nối', 'error');
            return { success: false };
        }
    }

    async function sendFriendRequest(id) {
        const data = await fetchAPI('/connections/send-request', 'POST', { friend_id: id });
        if(data.success) { 
            showToast('Đã gửi lời mời kết bạn!'); 
            document.getElementById('search-dropdown').classList.add('hidden'); 
        } else if (data.message) {
            showToast(data.message, 'error');
        }
    }

    async function acceptRequest(id) { 
        const data = await fetchAPI(`/connections/${id}/accept`, 'POST');
        if(data.success) { showToast('Đã chấp nhận kết bạn!'); setTimeout(()=>location.reload(), 1000); }
    }

    async function declineRequest(id) { 
        if(confirm('Từ chối?')) {
            const data = await fetchAPI(`/connections/${id}/decline`, 'POST');
            if(data.success) { showToast('Đã từ chối lời mời.'); setTimeout(()=>location.reload(), 1000); }
        }
    }

    async function removeFriend(id) { 
        if(confirm('Hủy kết bạn?')) {
            // SỬA LỖI 404: Đảm bảo URL này khớp với Route đã khai báo ở Bước 1
            const data = await fetchAPI(`/connections/${id}/remove`, 'DELETE');
            if(data.success) { showToast('Đã hủy kết bạn.'); setTimeout(()=>location.reload(), 1000); }
        }
    }

    async function unblockUser(id) { 
        const data = await fetchAPI(`/connections/${id}/unblock`, 'POST');
        if(data.success) { showToast('Đã bỏ chặn.'); setTimeout(()=>location.reload(), 1000); }
    }
</script>
@endpush