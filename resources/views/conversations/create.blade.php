@extends('layouts.app')

@section('content')
<div class="flex h-[85vh] bg-white rounded-2xl shadow-md overflow-hidden">
    {{-- Sidebar: Danh sách bạn bè --}}
    <div class="w-1/3 border-r bg-gray-50 p-4 flex flex-col">
        <h2 class="text-xl font-semibold mb-4">Bạn bè</h2>

        {{-- Thống kê online --}}
        @php
            $onlineCount = 0;
            $offlineCount = 0;
            foreach($connections as $connection) {
                $friend = ($connection->user_id == auth()->id()) 
                    ? $connection->friend 
                    : $connection->user;
                if ($friend->is_online) {
                    $onlineCount++;
                } else {
                    $offlineCount++;
                }
            }
        @endphp
        
        <div class="flex gap-4 text-sm mb-3">
            <div class="flex items-center gap-1">
                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                <span class="text-green-600 font-medium">{{ $onlineCount }} online</span>
            </div>
            <div class="flex items-center gap-1">
                <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                <span class="text-gray-500">{{ $offlineCount }} offline</span>
            </div>
        </div>

        {{-- Ô tìm kiếm --}}
        <input type="text" 
               id="searchFriend"
               placeholder="Tìm kiếm bạn bè..." 
               class="px-3 py-2 rounded-md border border-gray-300 mb-3 focus:outline-none focus:ring-2 focus:ring-blue-300 transition">

        {{-- Danh sách bạn bè --}}
        <div class="overflow-y-auto flex-1" id="friendsList">
            @forelse($connections as $connection)
                @php
                    // Xác định ai là bạn (không phải current user)
                    $friend = ($connection->user_id == auth()->id()) 
                        ? $connection->friend 
                        : $connection->user;
                    
                    // Tạo tên đầy đủ
                    $friendName = trim(($friend->first_name ?? '') . ' ' . ($friend->last_name ?? ''));
                    if (empty($friendName)) {
                        $friendName = $friend->email ?? 'Unknown';
                    }
                    
                    // Avatar
                    $avatar = $friend->avatar_url ?? $friend->profile_picture ?? 'https://ui-avatars.com/api/?name=' . urlencode($friendName) . '&background=random&color=ffffff';
                    
                    // Online status
                    $isOnline = $friend->is_online;
                    $statusText = $friend->last_activity_text;
                    $statusClass = $isOnline ? 'text-green-600 font-medium' : 'text-gray-500';
                    $statusDotClass = $isOnline ? 'bg-green-500' : 'bg-gray-400';
                    $statusIcon = $isOnline ? 'fa-circle text-green-500' : 'fa-circle text-gray-400';
                @endphp
                
                <div 
                    x-data 
                    @click="$dispatch('open-chat', { 
                        id: {{ $friend->user_id }}, 
                        name: '{{ addslashes($friendName) }}',
                        email: '{{ $friend->email }}',
                        avatar: '{{ $avatar }}',
                        is_online: {{ $isOnline ? 'true' : 'false' }},
                        last_activity_text: '{{ addslashes($statusText) }}'
                    })"
                    data-friend-name="{{ strtolower($friendName) }}"
                    data-online="{{ $isOnline ? 'true' : 'false' }}"
                    class="friend-item flex items-center gap-3 p-3 rounded-lg hover:bg-blue-50 cursor-pointer transition border border-transparent hover:border-blue-200">
                    
                    <div class="relative flex-shrink-0">
                        <img src="{{ $avatar }}" 
                             alt="{{ $friendName }}"
                             class="w-12 h-12 rounded-full object-cover border-2 {{ $isOnline ? 'border-green-500' : 'border-gray-300' }} shadow-sm">
                        
                        {{-- Online indicator --}}
                        <div class="absolute -bottom-1 -right-1">
                            <div class="w-3 h-3 rounded-full border-2 border-white {{ $statusDotClass }}"></div>
                        </div>
                    </div>
                    
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <p class="font-medium text-gray-800 truncate">{{ $friendName }}</p>
                            @if($isOnline)
                                <i class="fas fa-circle text-green-500 text-xs" title="Đang online"></i>
                            @endif
                        </div>
                        <p class="text-sm text-gray-500 truncate">{{ $friend->email }}</p>
                        {{-- Hiển thị trạng thái online/offline --}}
                        <p class="text-xs {{ $statusClass }} mt-1">
                            @if($isOnline)
                                <i class="fas fa-wifi mr-1"></i>
                            @else
                                <i class="fas fa-clock mr-1"></i>
                            @endif
                            {{ $statusText }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="text-gray-500 text-center mt-10 py-8">
                    <i class="fa-solid fa-user-group text-5xl mb-4 text-gray-300"></i>
                    <p class="text-lg font-medium mb-2">Chưa có bạn bè nào</p>
                    <p class="text-sm mb-4">Kết nối với những người khác để bắt đầu trò chuyện</p>
                    <a href="{{ route('connections.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition inline-flex items-center gap-2">
                        <i class="fa-solid fa-user-plus"></i>
                        Thêm bạn bè
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Chat Box --}}
    <div class="flex-1 flex flex-col bg-white" 
         x-data="{ 
             activeFriend: null, 
             messages: [], 
             newMessage: '',
             isLoading: false
         }"
         @open-chat.window="
             activeFriend = $event.detail; 
             messages = []; 
             newMessage = '';
             console.log('💬 Opened chat with:', activeFriend);
         ">

        {{-- Header khi có người được chọn --}}
        <template x-if="activeFriend">
            <div class="p-4 border-b bg-white shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <img :src="activeFriend.avatar"
                                 :alt="activeFriend.name"
                                 class="w-12 h-12 rounded-full object-cover border-2"
                                 :class="activeFriend.is_online ? 'border-green-500' : 'border-gray-300'">
                            
                            {{-- Online indicator --}}
                            <div class="absolute -bottom-1 -right-1">
                                <div class="w-3 h-3 rounded-full border-2 border-white" 
                                     :class="activeFriend.is_online ? 'bg-green-500' : 'bg-gray-400'"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h2 class="text-lg font-semibold text-gray-800" x-text="activeFriend.name"></h2>
                                <span class="text-xs px-2 py-1 rounded-full"
                                      :class="activeFriend.is_online ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600'"
                                      x-text="activeFriend.is_online ? 'Online' : 'Offline'">
                                </span>
                            </div>
                            <p class="text-sm flex items-center gap-1"
                               :class="activeFriend.is_online ? 'text-green-600 font-medium' : 'text-gray-500'">
                                <i class="fas" :class="activeFriend.is_online ? 'fa-wifi' : 'fa-clock'"></i>
                                <span x-text="activeFriend.last_activity_text"></span>
                            </p>
                        </div>
                    </div>
                    
                    {{-- Nút tạo conversation --}}
                    <form method="POST" action="{{ route('conversations.store') }}" class="inline">
                        @csrf
                        <input type="hidden" name="conversation_type" value="direct">
                        <input type="hidden" name="participant_ids[]" :value="activeFriend.id">
                        <input type="hidden" name="initial_message" x-model="newMessage">
                        
                        <button type="submit" 
                                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition flex items-center gap-2 shadow-sm"
                                :disabled="!activeFriend">
                            <i class="fa-solid fa-paper-plane"></i>
                            Bắt đầu trò chuyện
                        </button>
                    </form>
                </div>
            </div>
        </template>

        {{-- Placeholder khi chưa chọn ai --}}
        <template x-if="!activeFriend">
            <div class="flex flex-col justify-center items-center flex-1 text-gray-400 bg-gray-50">
                <div class="text-center max-w-md">
                    <i class="fa-solid fa-comments text-7xl mb-6 text-gray-300"></i>
                    <h3 class="text-2xl font-semibold text-gray-500 mb-3">Chọn một người bạn</h3>
                    <p class="text-gray-400 mb-2">Để bắt đầu trò chuyện 💬</p>
                    <p class="text-sm text-gray-400">Click vào tên bạn bè trong danh sách bên trái</p>
                    
                    @if($connections->count() > 0)
                        <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                            <p class="text-blue-800 text-sm">
                                <i class="fas fa-info-circle mr-1"></i>
                                Bạn có <span class="font-semibold">{{ $onlineCount }} bạn</span> đang online 
                                và <span class="font-semibold">{{ $offlineCount }} bạn</span> offline
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </template>

        {{-- Messages Preview --}}
        <div class="flex-1 overflow-y-auto p-4 space-y-3 bg-gray-50" x-show="activeFriend">
            <div class="text-center text-gray-500 py-8">
                <div class="inline-flex items-center gap-2 bg-white px-4 py-3 rounded-lg border border-gray-200 shadow-sm">
                    <i class="fa-solid fa-hand-wave text-yellow-500"></i>
                    <p>Đây là cuộc trò chuyện mới với <span class="font-semibold text-gray-700" x-text="activeFriend?.name"></span></p>
                </div>
                <p class="text-sm text-gray-400 mt-3">Nhập tin nhắn đầu tiên bên dưới và nhấn "Bắt đầu trò chuyện"</p>
            </div>
            
            {{-- Hiển thị tin nhắn tạm thời nếu có --}}
            <template x-if="newMessage.trim()">
                <div class="flex justify-end">
                    <div class="max-w-[70%]">
                        <div class="inline-block bg-blue-500 text-white px-4 py-3 rounded-2xl rounded-br-md shadow-sm">
                            <span x-text="newMessage"></span>
                        </div>
                        <p class="text-xs text-gray-400 mt-1 text-right">Tin nhắn này sẽ được gửi khi bạn bắt đầu trò chuyện</p>
                    </div>
                </div>
            </template>
        </div>

        {{-- Input gửi tin nhắn --}}
        <div class="p-4 border-t bg-white" x-show="activeFriend">
            <div class="flex items-center gap-3">
                <input x-model="newMessage" 
                       type="text" 
                       placeholder="Nhập tin nhắn đầu tiên (tùy chọn)..."
                       class="flex-1 px-4 py-3 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-transparent transition"
                       @keyup.enter="$el.closest('div').querySelector('form').submit()">
                
                <button @click="$el.closest('div').querySelector('form').submit()"
                        class="bg-blue-500 text-white rounded-full w-12 h-12 flex items-center justify-center hover:bg-blue-600 transition shadow-sm"
                        :class="!newMessage.trim() ? 'opacity-50 cursor-not-allowed' : ''"
                        :disabled="!newMessage.trim()">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Script tìm kiếm và lọc --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchFriend');
    const friendsList = document.getElementById('friendsList');
    
    if (searchInput && friendsList) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase().trim();
            const friendItems = friendsList.querySelectorAll('.friend-item');
            
            let visibleCount = 0;
            
            friendItems.forEach(item => {
                const friendName = item.getAttribute('data-friend-name');
                const isOnline = item.getAttribute('data-online') === 'true';
                
                // Hiển thị nếu khớp với từ khóa tìm kiếm
                const matchesSearch = friendName.includes(searchTerm);
                
                if (matchesSearch) {
                    item.style.display = 'flex';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Hiển thị thông báo nếu không tìm thấy kết quả
            const noResultsElement = friendsList.querySelector('.no-results');
            if (noResultsElement) {
                noResultsElement.remove();
            }
            
            if (visibleCount === 0 && searchTerm) {
                const noResults = document.createElement('div');
                noResults.className = 'no-results text-center text-gray-500 py-8';
                noResults.innerHTML = `
                    <i class="fa-solid fa-search text-3xl mb-3 text-gray-300"></i>
                    <p class="font-medium">Không tìm thấy bạn bè phù hợp</p>
                    <p class="text-sm mt-1">Thử tìm kiếm với từ khóa khác</p>
                `;
                friendsList.appendChild(noResults);
            }
        });
        
        // Focus vào ô tìm kiếm
        searchInput.focus();
    }
});

// Auto-update online status (optional - for real-time updates)
function updateOnlineStatus() {
    // Có thể tích hợp WebSocket hoặc polling ở đây
    // để cập nhật trạng thái online/offline real-time
    console.log('Online status check...');
}

// Update mỗi 30 giây
setInterval(updateOnlineStatus, 30000);
</script>

<style>
.friend-item {
    transition: all 0.2s ease-in-out;
}

.friend-item:hover {
    transform: translateY(-1px);
}

/* Custom scrollbar */
#friendsList::-webkit-scrollbar {
    width: 6px;
}

#friendsList::-webkit-scrollbar-track {
    background: #f1f5f9;
}

#friendsList::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

#friendsList::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>
@endsection