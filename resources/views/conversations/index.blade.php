@extends('layouts.app')

@section('title', 'Tin nhắn')

@push('styles')
    <style>
        :root {
            --primary-color: #4f46e5;
            /* Indigo 600 */
            --primary-light: #e0e7ff;
            --secondary-color: #8b5cf6;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --dark-color: #1f2937;
            --light-color: #f3f4f6;
            --border-color: #e5e7eb;
            --text-muted: #6b7280;
        }

        body {
            background-color: #f9fafb;
            overflow-y: hidden;
            /* Cố định body để scroll nội dung bên trong */
        }

        /* Layout chính */
        .messages-container {
            height: calc(100vh - 65px);
            /* Trừ header của layout app */
            display: flex;
            background: white;
            max-width: 1600px;
            margin: 0 auto;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        /* --- SIDEBAR --- */
        .messages-sidebar {
            width: 380px;
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            background: white;
            flex-shrink: 0;
        }

        /* Sidebar Header: Title + Button tìm bạn */
        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
            background: #fff;
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .header-title {
            font-size: 22px;
            font-weight: 800;
            color: var(--dark-color);
            margin: 0;
        }

        /* Nút "Tìm bạn mới" */
        .btn-new-chat {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 12px;
            background-color: var(--primary-light);
            color: var(--primary-color);
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-new-chat:hover {
            background-color: var(--primary-color);
            color: white;
        }

        /* Search Box */
        .search-box {
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 10px 12px 10px 38px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 14px;
            background: var(--light-color);
            transition: all 0.2s;
        }

        .search-input:focus {
            outline: none;
            background: white;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 14px;
        }

        /* Danh sách hội thoại */
        .conversations-list {
            flex: 1;
            overflow-y: auto;
            padding: 10px;
        }

        .conversation-item {
            display: flex;
            align-items: center;
            padding: 12px;
            border-radius: 12px;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            transition: background 0.2s;
            margin-bottom: 4px;
            border: 1px solid transparent;
        }

        .conversation-item:hover {
            background-color: #f3f4f6;
        }

        .conversation-item.active {
            background-color: #eef2ff;
            /* Màu nền khi đang chọn */
            border-color: #e0e7ff;
        }

        .conversation-item.unread {
            background-color: #fffbeb;
            /* Màu nền tin chưa đọc (vàng nhạt) */
        }

        /* Avatar & Status */
        .avatar-wrapper {
            position: relative;
            margin-right: 12px;
            flex-shrink: 0;
        }

        .avatar-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid var(--border-color);
        }

        .status-dot {
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 2px solid white;
        }

        .status-dot.online {
            background-color: var(--success-color);
        }

        .status-dot.offline {
            background-color: #9ca3af;
        }

        /* Nội dung item */
        .conv-details {
            flex: 1;
            min-width: 0;
            /* Quan trọng để text-overflow hoạt động */
        }

        .conv-top {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 4px;
        }

        .conv-name {
            font-weight: 600;
            font-size: 15px;
            color: var(--dark-color);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .conv-time {
            font-size: 11px;
            color: var(--text-muted);
            white-space: nowrap;
        }

        .conv-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .conv-message {
            font-size: 13px;
            color: var(--text-muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 85%;
        }

        /* Style cho tin chưa đọc */
        .conversation-item.unread .conv-name {
            color: black;
            font-weight: 700;
        }

        .conversation-item.unread .conv-message {
            color: var(--dark-color);
            font-weight: 600;
        }

        .badge-unread {
            background-color: var(--primary-color);
            color: white;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 10px;
            min-width: 18px;
            text-align: center;
        }

        /* --- MAIN CONTENT (Placeholder) --- */
        .messages-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: #fff;
            background-image: radial-gradient(#e5e7eb 1px, transparent 1px);
            background-size: 20px 20px;
        }

        .empty-state {
            text-align: center;
            padding: 20px;
            animation: fadeIn 0.5s ease-out;
        }

        .empty-icon-circle {
            width: 100px;
            height: 100px;
            background-color: #e0e7ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .empty-icon-circle i {
            font-size: 40px;
            color: var(--primary-color);
        }

        .empty-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 10px;
        }

        .empty-desc {
            color: var(--text-muted);
            max-width: 400px;
            margin: 0 auto 25px;
            line-height: 1.5;
        }

        .btn-find-friends {
            background-color: var(--primary-color);
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 6px rgba(79, 70, 229, 0.2);
        }

        .btn-find-friends:hover {
            background-color: #4338ca;
            /* Indigo 700 */
            transform: translateY(-1px);
        }

        /* Scrollbar đẹp */
        .conversations-list::-webkit-scrollbar {
            width: 5px;
        }

        .conversations-list::-webkit-scrollbar-track {
            background: transparent;
        }

        .conversations-list::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 3px;
        }

        .conversations-list::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .messages-sidebar {
                width: 100%;
                border-right: none;
            }

            .messages-content {
                display: none;
            }

            /* Ẩn phần nội dung trên mobile khi đang xem list */
        }
    </style>
@endpush

@section('content')
    <div class="messages-container">

        {{-- SIDEBAR --}}
        <div class="messages-sidebar">
            {{-- Header: Tiêu đề + Nút Tìm Bạn --}}
            <div class="sidebar-header">
                <div class="header-top">
                    <h1 class="header-title">Đoạn chat</h1>
                    {{-- Nút Liên kết sang trang Connections --}}
                    <a href="{{ route('connections.index') }}" class="btn-new-chat" title="Tìm bạn mới">
                        <i class="fas fa-user-plus"></i>
                        <span>Kết nối mới</span>
                    </a>
                </div>

                <div class="search-box">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" placeholder="Tìm kiếm cuộc trò chuyện..."
                        id="search-conversations">
                </div>
            </div>

            {{-- List Conversation --}}
            <div class="conversations-list" id="conversations-list">
                @forelse($conversations as $conversation)
                    @php
                        // Logic lấy người chat cùng
                        $otherParticipant = $conversation->participants->where('user_id', '!=', auth()->id())->first();
                        $otherUser = $otherParticipant ? $otherParticipant->user : null;

                        // Logic tin nhắn cuối
                        $lastMessage = $conversation->messages->first();

                        // Logic unread
                        $myParticipant = $conversation->participants->where('user_id', auth()->id())->first();
                        $unreadCount = $myParticipant ? $myParticipant->unread_count : 0;

                        // Avatar Helper (dùng asset nếu cần)
                        $avatarUrl = asset('images/default-avatar.png'); // Mặc định

                        if ($otherUser && $otherUser->avatar_url) {
                            // 1. Nếu là link online (http/https)
                            if (Str::startsWith($otherUser->avatar_url, ['http://', 'https://'])) {
                                $avatarUrl = $otherUser->avatar_url;
                            }
                            // 2. Nếu là file local
                            else {
                                // Kiểm tra xem đã có chữ 'storage/' ở đầu chưa
                                $path = Str::startsWith($otherUser->avatar_url, 'storage/')
                                    ? $otherUser->avatar_url
                                    : 'storage/' . $otherUser->avatar_url;

                                $avatarUrl = asset($path);
                            }
                        }
                    @endphp

                    @if($otherUser)
                        <a href="{{ route('conversations.show', $conversation->conversation_id) }}"
                            class="conversation-item {{ $unreadCount > 0 ? 'unread' : '' }}"
                            data-search-name="{{ strtolower($otherUser->first_name . ' ' . $otherUser->last_name) }}">

                            <div class="avatar-wrapper">
                                <img src="{{ $avatarUrl }}" alt="Avatar" class="avatar-img">
                                <span class="status-dot {{ $otherUser->is_online ? 'online' : 'offline' }}"></span>
                            </div>

                            <div class="conv-details">
                                <div class="conv-top">
                                    <span class="conv-name">{{ $otherUser->first_name }} {{ $otherUser->last_name }}</span>
                                    @if($lastMessage)
                                        <span class="conv-time">{{ $lastMessage->sent_at->diffForHumans(null, true) }}</span>
                                    @endif
                                </div>

                                <div class="conv-bottom">
                                    <div class="conv-message">
                                        @if($lastMessage)
                                            @if($lastMessage->sender_id === auth()->id())
                                                <span style="font-weight: normal; color: #6b7280;">Bạn:</span>
                                            @endif

                                            @if($lastMessage->is_deleted)
                                                <span style="font-style: italic;">Tin nhắn đã thu hồi</span>
                                            @elseif($lastMessage->message_type === 'image')
                                                <span><i class="fas fa-image"></i> Hình ảnh</span>
                                            @elseif($lastMessage->message_type === 'file')
                                                <span><i class="fas fa-file"></i> Tệp tin</span>
                                            @else
                                                {{ Str::limit($lastMessage->content, 35) }}
                                            @endif
                                        @else
                                            <span>Bắt đầu cuộc trò chuyện ngay!</span>
                                        @endif
                                    </div>

                                    @if($unreadCount > 0)
                                        <span class="badge-unread">{{ $unreadCount }}</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endif
                @empty
                    {{-- Empty state trong Sidebar nếu chưa có chat nào --}}
                    <div class="text-center py-8 px-4">
                        <p class="text-gray-500 text-sm mb-4">Bạn chưa có cuộc trò chuyện nào.</p>
                        <a href="{{ route('connections.index') }}"
                            class="text-indigo-600 font-semibold text-sm hover:underline">
                            Tìm bạn bè ngay
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- MAIN CONTENT (Placeholder khi chưa chọn chat) --}}
        <div class="messages-content">
            <div class="empty-state">
                <div class="empty-icon-circle">
                    <i class="far fa-comments"></i>
                </div>
                <h2 class="empty-title">Chào mừng đến với Chat!</h2>
                <p class="empty-desc">
                    Chọn một cuộc trò chuyện từ danh sách bên trái hoặc kết nối với bạn bè mới để bắt đầu nhắn tin.
                </p>
                <a href="{{ route('connections.index') }}" class="btn-find-friends">
                    <i class="fas fa-user-plus"></i>
                    Tìm bạn bè mới
                </a>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        // Xử lý tìm kiếm trong danh sách (Client-side search)
        document.getElementById('search-conversations').addEventListener('input', function (e) {
            const query = e.target.value.toLowerCase().trim();
            const items = document.querySelectorAll('.conversation-item');

            items.forEach(item => {
                // Tìm theo tên (được lưu trong data-attribute)
                const name = item.getAttribute('data-search-name');
                // Tìm theo nội dung tin nhắn mới nhất
                const msg = item.querySelector('.conv-message').textContent.toLowerCase();

                if (name.includes(query) || msg.includes(query)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>
@endpush