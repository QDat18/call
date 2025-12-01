@extends('layouts.app')

@section('title', 'Messages')

@push('styles')
<style>
:root {
    --primary-color: #6366f1;
    --secondary-color: #8b5cf6;
    --success-color: #10b981;
    --danger-color: #ef4444;
    --warning-color: #f59e0b;
    --dark-color: #1f2937;
    --light-color: #f3f4f6;
    --border-color: #e5e7eb;
    --shadow: 0 1px 3px rgba(0,0,0,0.1);
    --shadow-lg: 0 10px 25px rgba(0,0,0,0.15);
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    background: #f8fafc;
}

.messages-container {
    height: calc(100vh - 70px);
    display: flex;
    background: white;
}

/* Sidebar */
.messages-sidebar {
    width: 360px;
    border-right: 1px solid var(--border-color);
    display: flex;
    flex-direction: column;
    background: white;
}

.sidebar-header {
    padding: 20px;
    border-bottom: 1px solid var(--border-color);
}

.sidebar-header h4 {
    font-size: 24px;
    font-weight: 700;
    color: var(--dark-color);
    margin-bottom: 15px;
}

.search-box {
    position: relative;
}

.search-input {
    width: 100%;
    padding: 12px 40px 12px 15px;
    border: 1px solid var(--border-color);
    border-radius: 25px;
    font-size: 14px;
    transition: all 0.3s;
    background: var(--light-color);
}

.search-input:focus {
    outline: none;
    border-color: var(--primary-color);
    background: white;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

.search-icon {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
}

/* Conversations List */
.conversations-list {
    flex: 1;
    overflow-y: auto;
    padding: 10px 0;
}

.conversation-item {
    padding: 15px 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    cursor: pointer;
    transition: all 0.2s;
    border-left: 3px solid transparent;
    text-decoration: none;
    color: inherit;
}

.conversation-item:hover {
    background: var(--light-color);
}

.conversation-item.active {
    background: #eef2ff;
    border-left-color: var(--primary-color);
}

.conversation-item.unread {
    background: #fef3c7;
}

.conversation-avatar {
    position: relative;
    flex-shrink: 0;
}

.avatar-img {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid white;
}

.online-badge {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 14px;
    height: 14px;
    background: var(--success-color);
    border: 2px solid white;
    border-radius: 50%;
}

.offline-badge {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 14px;
    height: 14px;
    background: #9ca3af;
    border: 2px solid white;
    border-radius: 50%;
}

.conversation-info {
    flex: 1;
    min-width: 0;
}

.conversation-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 4px;
}

.conversation-name {
    font-weight: 600;
    font-size: 15px;
    color: var(--dark-color);
}

.conversation-time {
    font-size: 12px;
    color: #6b7280;
}

.conversation-status {
    font-size: 11px;
    margin-top: 2px;
}

.conversation-status.online {
    color: var(--success-color);
    font-weight: 500;
}

.conversation-status.offline {
    color: #6b7280;
}

.conversation-last-message {
    font-size: 14px;
    color: #6b7280;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.conversation-item.unread .conversation-name,
.conversation-item.unread .conversation-last-message {
    font-weight: 600;
    color: var(--dark-color);
}

.unread-badge {
    background: var(--primary-color);
    color: white;
    font-size: 11px;
    font-weight: 600;
    padding: 2px 8px;
    border-radius: 12px;
    margin-left: auto;
}

/* Empty State */
.empty-state {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 40px;
    text-align: center;
}

.empty-icon {
    width: 120px;
    height: 120px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
}

.empty-icon i {
    font-size: 48px;
    color: white;
}

.empty-state h4 {
    font-size: 22px;
    font-weight: 700;
    color: var(--dark-color);
    margin-bottom: 10px;
}

.empty-state p {
    font-size: 15px;
    color: #6b7280;
    margin-bottom: 20px;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    padding: 12px 24px;
    border: none;
    border-radius: 25px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

/* Main Content */
.messages-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    background: #fafafa;
}

.content-placeholder {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
}

.content-placeholder i {
    font-size: 64px;
    opacity: 0.3;
}

/* Scrollbar */
.conversations-list::-webkit-scrollbar {
    width: 6px;
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

/* Responsive */
@media (max-width: 768px) {
    .messages-sidebar {
        width: 100%;
    }
    
    .messages-content {
        display: none;
    }
}

/* Animation */
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

.conversation-item {
    animation: fadeIn 0.3s ease-out;
}
</style>
@endpush

@section('content')
<div class="messages-container">
    <!-- Left Sidebar -->
    <div class="messages-sidebar">
        <div class="sidebar-header">
            <h4><i class="fas fa-comments"></i> Messages</h4>
            <div class="search-box">
                <input 
                    type="text" 
                    class="search-input" 
                    placeholder="Search conversations..."
                    id="search-conversations">
                <i class="fas fa-search search-icon"></i>
            </div>
        </div>
        
        <!-- Conversations List -->
        <div class="conversations-list" id="conversations-list">
            @forelse($conversations as $conversation)
                @php
                    // Get other participant
                    $otherParticipant = $conversation->participants
                        ->where('user_id', '!=', auth()->id())
                        ->first();
                    
                    $otherUser = $otherParticipant ? $otherParticipant->user : null;
                    
                    // Get last message
                    $lastMessage = $conversation->messages->first();
                    
                    // Check unread
                    $myParticipant = $conversation->participants
                        ->where('user_id', auth()->id())
                        ->first();
                    
                    $unreadCount = $myParticipant ? $myParticipant->unread_count : 0;
                @endphp
                
                @if($otherUser)
                    <a href="{{ route('conversations.show', $conversation->conversation_id) }}" 
                       class="conversation-item {{ $unreadCount > 0 ? 'unread' : '' }}"
                       data-conversation-id="{{ $conversation->conversation_id }}">
                        <div class="conversation-avatar">
                            <img src="{{ $otherUser->avatar_url ?? asset('images/default-avatar.png') }}" 
                                 alt="{{ $otherUser->first_name }}" 
                                 class="avatar-img">
                            @if($otherUser->is_online)
                                <span class="online-badge" title="Online"></span>
                            @else
                                <span class="offline-badge" title="Offline"></span>
                            @endif
                        </div>
                        
                        <div class="conversation-info">
                            <div class="conversation-header">
                                <span class="conversation-name">
                                    {{ $otherUser->first_name }} {{ $otherUser->last_name }}
                                </span>
                                @if($lastMessage)
                                    <span class="conversation-time">
                                        {{ $lastMessage->sent_at->diffForHumans(null, true) }}
                                    </span>
                                @endif
                            </div>
                            
                            {{-- Hiển thị trạng thái online/offline --}}
                            <div class="conversation-status {{ $otherUser->is_online ? 'online' : 'offline' }}">
                                {{ $otherUser->last_activity_text }}
                            </div>
                            
                            <div class="conversation-last-message">
                                @if($lastMessage)
                                    @if($lastMessage->sender_id === auth()->id())
                                        <span>You: </span>
                                    @endif
                                    @if($lastMessage->message_type === 'text')
                                        {{ Str::limit($lastMessage->content, 50) }}
                                    @elseif($lastMessage->message_type === 'image')
                                        <i class="fas fa-image"></i> Photo
                                    @elseif($lastMessage->message_type === 'file')
                                        <i class="fas fa-file"></i> File
                                    @elseif($lastMessage->message_type === 'video')
                                        <i class="fas fa-video"></i> Video
                                    @endif
                                @else
                                    <span class="text-muted">No messages yet</span>
                                @endif
                            </div>
                        </div>
                        
                        @if($unreadCount > 0)
                            <span class="unread-badge">{{ $unreadCount }}</span>
                        @endif
                    </a>
                @endif
            @empty
                <!-- Empty State in Sidebar -->
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h4>No messages yet</h4>
                    <p>Start a conversation with your friends!</p>
                    <a href="{{ route('connections.index') }}" class="btn-primary">
                        <i class="fas fa-user-friends"></i> Find Friends
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Main Content -->
    <div class="messages-content">
        <div class="content-placeholder">
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-comments"></i>
                </div>
                <h4>Select a conversation</h4>
                <p>Choose a conversation from the list to start messaging</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Search conversations
document.getElementById('search-conversations').addEventListener('input', function(e) {
    const query = e.target.value.toLowerCase();
    const conversations = document.querySelectorAll('.conversation-item');
    
    conversations.forEach(conv => {
        const name = conv.querySelector('.conversation-name').textContent.toLowerCase();
        const message = conv.querySelector('.conversation-last-message').textContent.toLowerCase();
        
        if (name.includes(query) || message.includes(query)) {
            conv.style.display = 'flex';
        } else {
            conv.style.display = 'none';
        }
    });
});

// Real-time updates (if using Echo)
@if(config('broadcasting.default') !== 'null')
if (window.Echo) {
    window.Echo.private('user.{{ auth()->id() }}')
        .listen('.message.sent', (data) => {
            // Update conversation list
            console.log('New message received:', data);
            // Reload or update dynamically
            location.reload();
        });
}
@endif
</script>
@endpush