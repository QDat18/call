@extends('layouts.app')

@section('content')
<div class="flex h-[85vh] bg-white rounded-2xl shadow-md overflow-hidden">
    {{-- Sidebar: Danh sách bạn bè --}}
    <div class="w-1/3 border-r bg-gray-50 p-4 flex flex-col">
        <h2 class="text-xl font-semibold mb-4">Bạn bè</h2>

        {{-- Debug: Kiểm tra số lượng bạn bè --}}
        @if($connections->count() > 0)
            <div class="text-green-600 text-sm mb-2">✅ Có {{ $connections->count() }} bạn bè</div>
        @else
            <div class="text-red-600 text-sm mb-2">❌ Không có kết nối nào</div>
        @endif

        {{-- Ô tìm kiếm --}}
        <input type="text" 
               id="searchFriend"
               placeholder="Tìm kiếm..." 
               class="px-3 py-2 rounded-md border border-gray-300 mb-3 focus:outline-none focus:ring focus:ring-blue-300">

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
                    $avatar = $friend->profile_picture ?? 'https://ui-avatars.com/api/?name=' . urlencode($friendName) . '&background=random';
                @endphp
                
                <div 
                    x-data 
                    @click="$dispatch('open-chat', { 
                        id: {{ $friend->user_id }}, 
                        name: '{{ addslashes($friendName) }}',
                        email: '{{ $friend->email }}',
                        avatar: '{{ $avatar }}'
                    })"
                    data-friend-name="{{ strtolower($friendName) }}"
                    class="friend-item flex items-center gap-3 p-3 rounded-lg hover:bg-blue-100 cursor-pointer transition">
                    
                    <img src="{{ $avatar }}" 
                         alt="{{ $friendName }}"
                         class="w-12 h-12 rounded-full object-cover border border-gray-200">
                    
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">{{ $friendName }}</p>
                        <p class="text-sm text-gray-500 truncate">{{ $friend->email }}</p>
                    </div>
                </div>
            @empty
                <div class="text-gray-500 text-center mt-10">
                    <i class="fa-solid fa-user-group text-4xl mb-3"></i>
                    <p>Chưa có bạn bè nào để chat.</p>
                    <a href="{{ route('connections.index') }}" class="text-blue-500 hover:underline mt-2 inline-block">
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
             console.log('Opened chat with:', activeFriend);
         ">

        {{-- Header khi có người được chọn --}}
        <template x-if="activeFriend">
            <div class="p-4 border-b flex items-center justify-between bg-gray-50">
                <div class="flex items-center gap-3">
                    <img :src="activeFriend.avatar"
                         :alt="activeFriend.name"
                         class="w-12 h-12 rounded-full object-cover border border-gray-200">
                    <div>
                        <h2 class="text-lg font-semibold" x-text="activeFriend.name"></h2>
                        <p class="text-sm text-gray-500" x-text="activeFriend.email"></p>
                    </div>
                </div>
                
                {{-- Nút tạo conversation --}}
                <form method="POST" action="{{ route('conversations.store') }}" class="inline">
                    @csrf
                    <input type="hidden" name="conversation_type" value="direct">
                    <input type="hidden" name="participant_ids[]" :value="activeFriend.id">
                    <input type="hidden" name="initial_message" x-model="newMessage">
                    
                    <button type="submit" 
                            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                        <i class="fa-solid fa-paper-plane mr-2"></i>
                        Bắt đầu trò chuyện
                    </button>
                </form>
            </div>
        </template>

        {{-- Placeholder khi chưa chọn ai --}}
        <template x-if="!activeFriend">
            <div class="flex flex-col justify-center items-center flex-1 text-gray-400">
                <i class="fa-solid fa-comments text-6xl mb-4"></i>
                <p class="text-xl">Chọn một người bạn để bắt đầu trò chuyện 💬</p>
                <p class="text-sm mt-2">Click vào tên bạn bên trái</p>
            </div>
        </template>

        {{-- Messages Preview (có thể để trống hoặc thêm tin nhắn mẫu) --}}
        <div class="flex-1 overflow-y-auto p-4 space-y-3 bg-gray-50" x-show="activeFriend">
            <div class="text-center text-gray-400 mt-10">
                <p>Đây là cuộc trò chuyện mới với <span class="font-semibold" x-text="activeFriend?.name"></span></p>
                <p class="text-sm mt-1">Nhập tin nhắn đầu tiên bên dưới và nhấn "Bắt đầu trò chuyện"</p>
            </div>
            
            {{-- Hiển thị tin nhắn tạm thời nếu có --}}
            <template x-if="newMessage.trim()">
                <div class="text-right">
                    <div class="inline-block bg-blue-500 text-white px-4 py-2 rounded-2xl max-w-[70%]">
                        <span x-text="newMessage"></span>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Tin nhắn này sẽ được gửi khi bạn bắt đầu trò chuyện</p>
                </div>
            </template>
        </div>

        {{-- Input gửi tin nhắn --}}
        <div class="p-4 border-t flex items-center gap-3 bg-white" x-show="activeFriend">
            <input x-model="newMessage" 
                   type="text" 
                   placeholder="Nhập tin nhắn đầu tiên (tùy chọn)..."
                   class="flex-1 px-4 py-3 border rounded-full focus:outline-none focus:ring-2 focus:ring-blue-300">
            
            <button @click="$el.closest('div').querySelector('form').submit()"
                    class="bg-blue-500 text-white rounded-full px-6 py-3 hover:bg-blue-600 transition">
                <i class="fa-solid fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>

{{-- Script tìm kiếm --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchFriend');
    const friendsList = document.getElementById('friendsList');
    
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const friendItems = friendsList.querySelectorAll('.friend-item');
            
            friendItems.forEach(item => {
                const friendName = item.getAttribute('data-friend-name');
                if (friendName.includes(searchTerm)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }
});
</script>
@endsection