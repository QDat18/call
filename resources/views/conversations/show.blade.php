@extends('layouts.app')

@section('title', 'Chat with ' . ($otherUser ? $otherUser->first_name : 'User'))

@push('styles')
<style>
:root {
    --primary-color: #6366f1;
    --secondary-color: #8b5cf6;
    --success-color: #10b981;
    --danger-color: #ef4444;
    --dark-color: #1f2937;
    --light-color: #f3f4f6;
    --border-color: #e5e7eb;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    background: #f8fafc;
}

.chat-container {
    height: calc(100vh - 70px);
    display: flex;
    flex-direction: column;
    background: white;
    max-width: 1200px;
    margin: 0 auto;
}

/* Chat Header */
.chat-header {
    padding: 15px 25px;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    align-items: center;
    gap: 15px;
    background: white;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.back-button {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--light-color);
    color: var(--dark-color);
    border: none;
    cursor: pointer;
    transition: all 0.3s;
    text-decoration: none;
}

.back-button:hover {
    background: var(--border-color);
    transform: scale(1.05);
}

.header-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid var(--primary-color);
}

.header-info {
    flex: 1;
}

.header-name {
    font-size: 18px;
    font-weight: 700;
    color: var(--dark-color);
    margin: 0;
}

.header-status {
    font-size: 13px;
    color: #6b7280;
    margin: 0;
}

.header-status.online {
    color: var(--success-color);
}

.header-actions {
    display: flex;
    gap: 10px;
}

.action-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--light-color);
    border: none;
    cursor: pointer;
    transition: all 0.3s;
    color: var(--dark-color);
}

.action-btn:hover {
    background: var(--primary-color);
    color: white;
    transform: scale(1.05);
}

/* Messages Area */
.messages-area {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
    background: linear-gradient(to bottom, #f9fafb 0%, #ffffff 100%);
    display: flex;
    flex-direction: column;
}

.message-date-divider {
    text-align: center;
    margin: 20px 0;
    position: relative;
}

.message-date-divider span {
    background: white;
    padding: 5px 15px;
    border-radius: 15px;
    font-size: 12px;
    color: #6b7280;
    border: 1px solid var(--border-color);
}

.message-wrapper {
    display: flex;
    margin-bottom: 15px;
    animation: messageSlideIn 0.3s ease-out;
}

.message-wrapper.sent {
    justify-content: flex-end;
}

.message-wrapper.received {
    justify-content: flex-start;
}

.message-avatar {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    object-fit: cover;
    margin: 0 10px;
    flex-shrink: 0;
}

.message-wrapper.sent .message-avatar {
    order: 2;
}

.message-content {
    max-width: 60%;
    display: flex;
    flex-direction: column;
}

.message-bubble {
    padding: 12px 16px;
    border-radius: 18px;
    word-wrap: break-word;
    position: relative;
}

.message-wrapper.sent .message-bubble {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    border-bottom-right-radius: 4px;
}

.message-wrapper.received .message-bubble {
    background: var(--light-color);
    color: var(--dark-color);
    border-bottom-left-radius: 4px;
}

.message-text {
    font-size: 15px;
    line-height: 1.5;
    margin: 0;
}

.message-attachment {
    margin-top: 8px;
}

.message-attachment img {
    max-width: 100%;
    border-radius: 12px;
    cursor: pointer;
}

.message-attachment a {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    background: rgba(255,255,255,0.2);
    border-radius: 8px;
    color: inherit;
    text-decoration: none;
    transition: all 0.3s;
}

.message-attachment a:hover {
    background: rgba(255,255,255,0.3);
}

.message-time {
    font-size: 11px;
    color: #9ca3af;
    margin-top: 4px;
    padding: 0 5px;
}

.message-wrapper.sent .message-time {
    text-align: right;
    color: rgba(255,255,255,0.7);
}

.typing-indicator {
    display: none;
    padding: 12px 16px;
    background: var(--light-color);
    border-radius: 18px;
    width: fit-content;
    margin: 10px 0;
}

.typing-indicator.show {
    display: flex;
    align-items: center;
    gap: 5px;
}

.typing-dot {
    width: 8px;
    height: 8px;
    background: #9ca3af;
    border-radius: 50%;
    animation: typingBounce 1.4s infinite;
}

.typing-dot:nth-child(2) {
    animation-delay: 0.2s;
}

.typing-dot:nth-child(3) {
    animation-delay: 0.4s;
}

@keyframes typingBounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-5px); }
}

@keyframes messageSlideIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Input Area */
.input-area {
    padding: 15px 25px;
    border-top: 1px solid var(--border-color);
    background: white;
}

#message-form {
    display: flex;
}

.input-wrapper {
    display: flex;
    align-items: center;
    background: var(--light-color);
    border-radius: 25px;
    padding: 5px 10px;
    flex: 1;
}

.input-actions {
    display: flex;
    gap: 8px;
}

.input-btn {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: transparent;
    border: none;
    cursor: pointer;
    color: var(--dark-color);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s;
}

.input-btn:hover {
    background: rgba(0,0,0,0.05);
}

.message-input-wrapper {
    flex: 1;
    display: flex;
    align-items: center;
}

.message-input {
    flex: 1;
    border: none;
    background: transparent;
    resize: none;
    max-height: 150px;
    overflow-y: auto;
    font-size: 15px;
    padding: 8px 15px;
    line-height: 1.5;
    color: var(--dark-color);
}

.message-input:focus {
    outline: none;
}

.emoji-btn {
    border: none;
    background: transparent;
    font-size: 20px;
    cursor: pointer;
    margin: 0 5px;
    color: #eab308;
}

.send-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--primary-color);
    color: white;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: 10px;
    transition: all 0.3s;
}

.send-btn:hover {
    background: var(--secondary-color);
    transform: scale(1.05);
}

/* Scrollbar */
.messages-area::-webkit-scrollbar {
    width: 6px;
}

.messages-area::-webkit-scrollbar-track {
    background: transparent;
}

.messages-area::-webkit-scrollbar-thumb {
    background: var(--border-color);
    border-radius: 3px;
}

/* Responsive */
@media (max-width: 768px) {
    .chat-header { padding: 12px 15px; }
    .header-avatar { width: 40px; height: 40px; }
    .header-name { font-size: 16px; }
    .header-status { font-size: 12px; }
    .action-btn { width: 35px; height: 35px; }
    .messages-area { padding: 15px; }
    .message-bubble { padding: 10px 14px; }
    .message-text { font-size: 14px; }
    .message-time { font-size: 10px; }
    .input-area { padding: 12px 15px; }
    .input-btn { width: 30px; height: 30px; }
    .send-btn { width: 35px; height: 35px; margin-left: 8px; }
}
</style>
@endpush

@section('content')
<div class="chat-container">

    <!-- Header -->
    <div class="chat-header">
        <a href="{{ route('conversations.index') }}" class="back-button">
            <i class="fas fa-arrow-left"></i>
        </a>

        @if($otherUser)
            <img src="{{ $otherUser->avatar_url ?? asset('images/default-avatar.png') }}"
                 alt="{{ $otherUser->first_name }}"
                 class="header-avatar">
        @endif

        <div class="header-info">
            <h4 class="header-name">
                {{ $otherUser ? $otherUser->first_name . ' ' . $otherUser->last_name : 'User' }}
            </h4>
            <p class="header-status {{ $otherUser && $otherUser->is_online ? 'online' : '' }}">
                {{ $otherUser && $otherUser->is_online ? 'Online' : 'Offline' }}
            </p>
        </div>

        <div class="header-actions">
            <button id="start-voice-call" class="action-btn" title="Voice Call">
                <i class="fas fa-phone"></i>
            </button>
            <button id="start-video-call" class="action-btn" title="Video Call">
                <i class="fas fa-video"></i>
            </button>
        </div>
    </div>

    <!-- Messages -->
    <div class="messages-area" id="messages-area">
        @if(isset($messages) && $messages->isNotEmpty())
            @php $previousDate = null; @endphp
            @foreach($messages as $message)
                @php
                    $currentDate = $message->sent_at->format('Y-m-d');
                    $isSent = $message->sender_id === auth()->id();
                @endphp

                @if($previousDate !== $currentDate)
                    <div class="message-date-divider">
                        <span>{{ $message->sent_at->format('F j, Y') }}</span>
                    </div>
                    @php $previousDate = $currentDate; @endphp
                @endif

                <div class="message-wrapper {{ $isSent ? 'sent' : 'received' }}">
                    @if(!$isSent)
                        <img src="{{ $message->sender->avatar_url ?? asset('images/default-avatar.png') }}"
                             alt="{{ $message->sender->first_name }}"
                             class="message-avatar">
                    @endif

                    <div class="message-content">
                        <div class="message-bubble">
                            @if($message->content)
                                <p class="message-text">{{ $message->content }}</p>
                            @endif
                            @if($message->attachment_url)
                                <div class="message-attachment">
                                    @if($message->message_type === 'image')
                                        <img src="{{ asset($message->attachment_url) }}"
                                             alt="Image"
                                             class="clickable-image"
                                             onclick="window.open(this.src)">
                                    @else
                                        <a href="{{ asset($message->attachment_url) }}"
                                           target="_blank"
                                           download="{{ $message->attachment_name }}">
                                            <i class="fas fa-file"></i>
                                            {{ $message->attachment_name }}
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                        <div class="message-time">{{ $message->sent_at->format('g:i A') }}</div>
                    </div>

                    @if($isSent)
                        <img src="{{ auth()->user()->avatar_url ?? asset('images/default-avatar.png') }}"
                             alt="{{ auth()->user()->first_name }}"
                             class="message-avatar">
                    @endif
                </div>
            @endforeach
        @endif
    </div>

    <div class="typing-indicator" id="typing-indicator">
        <div class="typing-dot"></div>
        <div class="typing-dot"></div>
        <div class="typing-dot"></div>
    </div>

    <!-- Input Area -->
    <div class="input-area">
        <form id="message-form">
            @csrf
            <input type="hidden" name="conversation_id" value="{{ $conversation->conversation_id }}">

            <div class="input-wrapper">
                <div class="input-actions">
                    <button type="button" class="input-btn" id="attach-btn" title="Attach file">
                        <i class="fas fa-paperclip"></i>
                    </button>
                </div>

                <div class="message-input-wrapper">
                    <textarea name="content"
                              id="message-input"
                              class="message-input"
                              placeholder="Type a message..."
                              rows="1"></textarea>
                    <button type="button" class="emoji-btn" title="Emoji">Smile</button>
                </div>

                <button type="submit" class="send-btn" id="send-btn">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
{{-- Load JS --}}
@vite(['resources/js/bootstrap.ts'])
@vite(['resources/js/chat-init.ts'])
@vite(['resources/js/video-call-init.ts'])

<script type="module">
/**
 * Khởi tạo chat + video call
 */
(() => {
    const conversationId = {{ $conversation->conversation_id }};
    const currentUserId = {{ auth()->id() }};
    const receiverId = {{ $otherUser?->user_id ?? 0 }}; // FIX: Dùng user_id
    const currentUserName = "{{ addslashes(auth()->user()->first_name) }}";

    // TRUYỀN CHO video-call-init.ts
    window.conversationId = conversationId;
    window.currentUserId = currentUserId;

    // KIỂM TRA receiverId
    if (!receiverId || receiverId <= 0) {
        console.error("LỖI: Không tìm thấy người nhận (receiverId = 0)");
        alert("Không thể gọi video. Vui lòng tải lại trang.");
        return;
    }

    // Khởi tạo chat
    const initChat = async () => {
        let attempts = 0;
        while (!window.initializeChat && attempts < 50) {
            await new Promise(r => setTimeout(r, 100));
            attempts++;
        }
        if (window.initializeChat) {
            await window.initializeChat(conversationId, currentUserId, currentUserName);
        }
    };

    // Khởi tạo video call
    const initVideoCall = async () => {
        let attempts = 0;
        while (!window.initializeVideoCall && attempts < 50) {
            await new Promise(r => setTimeout(r, 100));
            attempts++;
        }
        if (window.initializeVideoCall) {
            await window.initializeVideoCall(currentUserId, receiverId);
        }
    };

    // Chạy khi DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            initChat();
            initVideoCall();
        });
    } else {
        initChat();
        initVideoCall();
    }
})();
</script>
@endpush