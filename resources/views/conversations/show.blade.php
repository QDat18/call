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
    position: relative;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid var(--primary-color);
}

.online-indicator {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 14px;
    height: 14px;
    background: var(--success-color);
    border: 2px solid white;
    border-radius: 50%;
}

.offline-indicator {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 14px;
    height: 14px;
    background: #9ca3af;
    border: 2px solid white;
    border-radius: 50%;
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
    margin: 0;
}

.header-status.online {
    color: var(--success-color);
    font-weight: 500;
}

.header-status.offline {
    color: #6b7280;
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

.action-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Video Call Button */
#start-video-call {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
}

#start-video-call:hover:not(:disabled) {
    background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);
}

/* Voice Call Button */
#start-voice-call {
    background: linear-gradient(135deg, var(--success-color), #059669);
    color: white;
}

#start-voice-call:hover:not(:disabled) {
    background: linear-gradient(135deg, #059669, var(--success-color));
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
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
    align-items: center;
    gap: 10px;
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
    position: relative;
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
    min-height: 40px;
}

.message-input:focus {
    outline: none;
}

.emoji-btn {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: transparent;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s;
    color: #eab308;
    position: relative;
}

.emoji-btn:hover {
    background: rgba(234, 179, 8, 0.1);
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
    transition: all 0.3s;
    flex-shrink: 0;
}

.send-btn:hover {
    background: var(--secondary-color);
    transform: scale(1.05);
}

.send-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Emoji Picker - Moved to right side */
.emoji-picker {
    position: absolute;
    bottom: 50px;
    right: 0;
    width: 320px;
    max-height: 350px;
    background: white;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    border: 1px solid var(--border-color);
    z-index: 1000;
    display: none;
    overflow: hidden;
}

.emoji-picker.show {
    display: block;
    animation: emojiPickerSlide 0.3s ease-out;
}

@keyframes emojiPickerSlide {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.emoji-picker-header {
    padding: 12px 16px;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    gap: 10px;
    background: var(--light-color);
    overflow-x: auto;
}

.emoji-category-btn {
    padding: 6px 12px;
    border-radius: 20px;
    border: none;
    background: transparent;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s;
    color: var(--dark-color);
    white-space: nowrap;
}

.emoji-category-btn:hover {
    background: rgba(0,0,0,0.05);
}

.emoji-category-btn.active {
    background: var(--primary-color);
    color: white;
}

.emoji-picker-body {
    height: 250px;
    overflow-y: auto;
    padding: 12px;
}

.emoji-grid {
    display: grid;
    grid-template-columns: repeat(8, 1fr);
    gap: 8px;
}

.emoji-item {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    cursor: pointer;
    border-radius: 8px;
    transition: all 0.2s;
}

.emoji-item:hover {
    background: var(--light-color);
    transform: scale(1.2);
}

.emoji-picker-footer {
    padding: 10px 16px;
    border-top: 1px solid var(--border-color);
    font-size: 12px;
    color: #6b7280;
    background: var(--light-color);
    text-align: center;
}

/* Incoming Call Modal */
.incoming-call-modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
}

.incoming-call-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.8);
    backdrop-filter: blur(10px);
}

.incoming-call-content {
    position: relative;
    background: white;
    border-radius: 24px;
    padding: 2rem;
    max-width: 400px;
    width: 90%;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    animation: modalSlideIn 0.3s ease-out;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-50px) scale(0.9);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.incoming-call-header {
    text-align: center;
    margin-bottom: 2rem;
}

.incoming-call-header i {
    font-size: 48px;
    color: var(--primary-color);
    margin-bottom: 1rem;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.incoming-call-header h3 {
    font-size: 24px;
    font-weight: 700;
    color: var(--dark-color);
    margin: 0;
}

.incoming-call-body {
    text-align: center;
    margin-bottom: 2rem;
}

.caller-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 48px;
    color: white;
}

.caller-avatar img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
}

.caller-name {
    font-size: 20px;
    font-weight: 600;
    color: var(--dark-color);
    margin: 0 0 0.5rem 0;
}

.call-type {
    font-size: 14px;
    color: #6b7280;
}

.incoming-call-actions {
    display: flex;
    gap: 1rem;
}

.call-action-btn {
    flex: 1;
    padding: 1rem;
    border-radius: 12px;
    border: none;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.3s;
}

.btn-accept {
    background: linear-gradient(135deg, var(--success-color), #059669);
    color: white;
}

.btn-accept:hover {
    background: linear-gradient(135deg, #059669, var(--success-color));
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
}

.btn-decline {
    background: linear-gradient(135deg, var(--danger-color), #dc2626);
    color: white;
}

.btn-decline:hover {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(239, 68, 68, 0.4);
}

/* Loading Overlay */
.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(5px);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 9998;
}

.loading-overlay.show {
    display: flex;
}

.loading-content {
    background: white;
    padding: 2rem 3rem;
    border-radius: 16px;
    text-align: center;
}

.loading-spinner {
    width: 48px;
    height: 48px;
    border: 4px solid var(--light-color);
    border-top-color: var(--primary-color);
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto 1rem;
}

@keyframes spin {
    to { transform: rotate(360deg); }
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
    #message-form { gap: 8px; }
    .input-btn { width: 30px; height: 30px; }
    .emoji-btn { width: 30px; height: 30px; }
    .send-btn { width: 35px; height: 35px; }
    .message-input { 
        min-height: 35px;
        padding: 6px 12px;
    }
    .emoji-picker { 
        width: 280px; 
        right: 0;
        bottom: 45px;
    }
    .emoji-grid {
        grid-template-columns: repeat(6, 1fr);
    }
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
            <div class="relative">
                <img src="{{ $otherUser->avatar_url ?? asset('images/default-avatar.png') }}"
                     alt="{{ $otherUser->first_name }}"
                     class="header-avatar">
                @if($otherUser->is_online)
                    <div class="online-indicator" title="Online"></div>
                @else
                    <div class="offline-indicator" title="Offline"></div>
                @endif
            </div>
        @endif

        <div class="header-info">
            <h4 class="header-name">
                {{ $otherUser ? $otherUser->first_name . ' ' . $otherUser->last_name : 'User' }}
            </h4>
            <p class="header-status {{ $otherUser && $otherUser->is_online ? 'online' : 'offline' }}">
                {{ $otherUser ? $otherUser->last_activity_text : 'Offline' }}
            </p>
        </div>

        <div class="header-actions">
            @if($otherUser)
                <button id="start-voice-call" class="action-btn" title="Voice Call">
                    <i class="fas fa-phone"></i>
                </button>
                <button id="start-video-call" class="action-btn" title="Video Call">
                    <i class="fas fa-video"></i>
                </button>
            @endif
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

                <div class="message-wrapper {{ $isSent ? 'sent' : 'received' }}" data-message-id="{{ $message->message_id }}">
                    @if(!$isSent)
                        <img src="{{ $message->sender->avatar_url ?? asset('images/default-avatar.png') }}"
                             alt="{{ $message->sender->first_name }}"
                             class="message-avatar">
                    @endif

                    <div class="message-content">
                        <div class="message-bubble">
                            @if($message->content)
                                <p class="message-text">{!! nl2br(e($message->content)) !!}</p>
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
        @else
            <div class="empty-messages text-center text-gray-500 py-12">
                <i class="fas fa-comments text-5xl mb-4 opacity-50"></i>
                <p class="text-lg">No messages yet. Start the conversation!</p>
            </div>
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
                </div>
            </div>
            
            <!-- Emoji Button - moved outside input wrapper -->
            <button type="button" class="emoji-btn" id="emoji-toggle-btn" title="Emoji">
                😊
            </button>
            
            <!-- Send Button -->
            <button type="submit" class="send-btn" id="send-btn">
                <i class="fas fa-paper-plane"></i>
            </button>
        </form>
    </div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loading-overlay">
    <div class="loading-content">
        <div class="loading-spinner"></div>
        <p id="loading-text">Initiating call...</p>
    </div>
</div>
@endsection

@push('scripts')
<script>
/**
 * Chat & Video Call Integration
 */

// Global configuration
window.chatConfig = {
    conversationId: {{ $conversation->conversation_id }},
    currentUserId: {{ auth()->id() }},
    receiverId: {{ $otherUser?->user_id ?? 0 }},
    currentUserName: "{{ addslashes(auth()->user()->first_name) }}",
    otherUserName: "{{ addslashes($otherUser ? $otherUser->first_name . ' ' . $otherUser->last_name : 'User') }}",
    otherUserAvatar: "{{ $otherUser ? ($otherUser->avatar_url ?? asset('images/default-avatar.png')) : asset('images/default-avatar.png') }}",
    otherUserIsOnline: {{ $otherUser && $otherUser->is_online ? 'true' : 'false' }},
    otherUserLastActivity: "{{ $otherUser ? addslashes($otherUser->last_activity_text) : 'Offline' }}"
};

console.log('💬 Chat configuration:', window.chatConfig);

// Emoji data
const emojiCategories = {
    people: ['😀', '😁', '😂', '🤣', '😃', '😄', '😅', '😆', '😉', '😊', '😋', '😎', '😍', '😘', '🥰', '😗', '😙', '😚', '🙂', '🤗', '🤩', '🤔', '🤨', '😐', '😑', '😶', '🙄', '😏', '😣', '😥', '😮', '🤐', '😯', '😪', '😫', '🥱', '😴', '😌', '😛', '😜', '😝', '🤤', '😒', '😓', '😔', '😕', '🙃', '🤑', '😲', '🙁', '😖', '😞', '😟', '😤', '😢', '😭', '😦', '😧', '😨', '😩', '🤯', '😬', '😰', '😱', '🥵', '🥶', '😳', '🤪', '😵', '🥴', '😠', '😡', '🤬', '😷', '🤒', '🤕', '🤢', '🤮', '🤧', '😇', '🥳', '🥺', '🤠', '🤡', '🤥', '🤫', '🤭', '🧐'],
    animals: ['🐶', '🐱', '🐭', '🐹', '🐰', '🦊', '🐻', '🐼', '🐨', '🐯', '🦁', '🐮', '🐷', '🐽', '🐸', '🐵', '🙈', '🙉', '🙊', '🐒', '🐔', '🐧', '🐦', '🐤', '🐣', '🐥', '🦆', '🦅', '🦉', '🦇', '🐺', '🐗', '🐴', '🦄', '🐝', '🐛', '🦋', '🐌', '🐞', '🐜', '🦟', '🦗', '🕷', '🦂', '🐢', '🐍', '🦎', '🦖', '🦕', '🐙', '🦑', '🦐', '🦞', '🦀', '🐡', '🐠', '🐟', '🐬', '🐳', '🐋', '🦈', '🐊', '🐅', '🐆', '🦓', '🦍', '🦧', '🐘', '🦛', '🦏', '🐪', '🐫', '🦒', '🦘', '🐃', '🐂', '🐄', '🐎', '🐖', '🐏', '🐑', '🦙', '🐐', '🦌', '🐕', '🐩', '🦮', '🐕‍🦺', '🐈', '🐓', '🦃', '🦚', '🦜', '🦢', '🦩', '🐇', '🦝', '🦨', '🦦', '🦥', '🐁', '🐀', '🦔'],
    food: ['🍏', '🍎', '🍐', '🍊', '🍋', '🍌', '🍉', '🍇', '🍓', '🫐', '🍈', '🍒', '🍑', '🥭', '🍍', '🥥', '🥝', '🍅', '🍆', '🥑', '🥦', '🥬', '🥒', '🌶', '🫑', '🌽', '🥕', '🫒', '🧄', '🧅', '🥔', '🍠', '🥐', '🥯', '🍞', '🥖', '🥨', '🧀', '🥚', '🍳', '🧈', '🥞', '🧇', '🥓', '🥩', '🍗', '🍖', '🦴', '🌭', '🍔', '🍟', '🍕', '🫓', '🥪', '🥙', '🧆', '🌮', '🌯', '🫔', '🥗', '🥘', '🫕', '🥫', '🍝', '🍜', '🍲', '🍛', '🍣', '🍱', '🥟', '🦪', '🍤', '🍙', '🍚', '🍘', '🍥', '🥠', '🥮', '🍢', '🍡', '🍧', '🍨', '🍦', '🥧', '🧁', '🍰', '🎂', '🍮', '🍭', '🍬', '🍫', '🍿', '🍩', '🍪', '🌰', '🥜', '🍯'],
    activities: ['⚽', '🏀', '🏈', '⚾', '🥎', '🎾', '🏐', '🏉', '🥏', '🎱', '🪀', '🏓', '🏸', '🏒', '🏑', '🥍', '🏏', '🪃', '🥅', '⛳', '🪁', '🏹', '🎣', '🤿', '🥊', '🥋', '🎽', '🛹', '🛼', '🛷', '⛸', '🥌', '🎿', '⛷', '🏂', '🪂', '🏋️', '🤼', '🤸', '🤺', '🤾', '🏌️', '🏇', '🧘', '🏄', '🏊', '🤽', '🚣', '🧗', '🚵', '🚴', '🏆', '🥇', '🥈', '🥉', '🏅', '🎖', '🏵', '🎗', '🎫', '🎟', '🎪', '🤹', '🎭', '🩰', '🎨', '🎬', '🎤', '🎧', '🎼', '🎹', '🥁', '🎷', '🎺', '🎸', '🪕', '🎻', '🎲', '♟', '🎯', '🎳', '🎮', '🎰'],
    objects: ['💡', '🔦', '🕯', '🪔', '🧯', '🛢', '💸', '💵', '💴', '💶', '💷', '💰', '💎', '🪙', '💳', '💻', '🖥', '🖨', '⌨️', '🖱', '🖲', '💽', '💾', '💿', '📀', '📼', '📷', '📸', '📹', '🎥', '📽', '🎞', '📞', '☎️', '📟', '📠', '📺', '📻', '🎙', '🎚', '🎛', '🧭', '⏱', '⏲', '⏰', '🕰', '⌛', '⏳', '📡', '🔋', '🔌', '💻', '🖨', '🖱', '🖲', '💽', '💾', '💿', '📀', '📼', '📷', '📸', '📹', '🎥', '📽', '🎞', '📞', '☎️', '📟', '📠', '📺', '📻', '🎙', '🎚', '🎛', '🧭', '⏱', '⏲', '⏰', '🕰', '⌛', '⏳', '📡', '🔋', '🔌']
};

// Emoji Picker Manager
class EmojiPickerManager {
    constructor() {
        this.picker = null;
        this.createPicker();
        this.toggleBtn = document.getElementById('emoji-toggle-btn');
        this.messageInput = document.getElementById('message-input');
        this.isPickerVisible = false;
        
        this.init();
    }
    
    createPicker() {
        // Create emoji picker element
        this.picker = document.createElement('div');
        this.picker.id = 'emoji-picker';
        this.picker.className = 'emoji-picker';
        this.picker.innerHTML = `
            <div class="emoji-picker-header">
                <button class="emoji-category-btn active" data-category="people">😀</button>
                <button class="emoji-category-btn" data-category="animals">🐶</button>
                <button class="emoji-category-btn" data-category="food">🍎</button>
                <button class="emoji-category-btn" data-category="activities">⚽</button>
                <button class="emoji-category-btn" data-category="objects">💡</button>
            </div>
            <div class="emoji-picker-body">
                <div class="emoji-grid" id="emoji-grid">
                    <!-- Emojis will be populated by JavaScript -->
                </div>
            </div>
            <div class="emoji-picker-footer">
                Click an emoji to insert
            </div>
        `;
        
        // Append to body
        document.body.appendChild(this.picker);
        
        // Get references to internal elements
        this.emojiGrid = this.picker.querySelector('#emoji-grid');
        this.categoryButtons = this.picker.querySelectorAll('.emoji-category-btn');
    }
    
    init() {
        // Toggle picker visibility
        this.toggleBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            this.togglePicker();
        });
        
        // Load default category
        this.loadCategory('people');
        
        // Setup category buttons
        this.categoryButtons.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const category = btn.dataset.category;
                this.loadCategory(category);
                
                // Update active state
                this.categoryButtons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
            });
        });
        
        // Close picker when clicking outside
        document.addEventListener('click', (e) => {
            if (this.isPickerVisible && 
                !this.picker.contains(e.target) && 
                e.target !== this.toggleBtn) {
                this.hidePicker();
            }
        });
        
        // Close on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isPickerVisible) {
                this.hidePicker();
            }
        });
    }
    
    loadCategory(category) {
        const emojis = emojiCategories[category] || [];
        this.emojiGrid.innerHTML = '';
        
        emojis.forEach(emoji => {
            const emojiElement = document.createElement('div');
            emojiElement.className = 'emoji-item';
            emojiElement.textContent = emoji;
            emojiElement.title = `Emoji: ${emoji}`;
            
            emojiElement.addEventListener('click', (e) => {
                e.stopPropagation();
                this.insertEmoji(emoji);
            });
            
            this.emojiGrid.appendChild(emojiElement);
        });
    }
    
    insertEmoji(emoji) {
        const input = this.messageInput;
        const start = input.selectionStart;
        const end = input.selectionEnd;
        const text = input.value;
        
        // Insert emoji at cursor position
        input.value = text.substring(0, start) + emoji + text.substring(end);
        
        // Move cursor after inserted emoji
        input.selectionStart = input.selectionEnd = start + emoji.length;
        
        // Focus back on input
        input.focus();
        
        // Trigger input event for auto-resize
        input.dispatchEvent(new Event('input'));
        
        // Close picker after insertion
        this.hidePicker();
    }
    
    togglePicker() {
        if (this.isPickerVisible) {
            this.hidePicker();
        } else {
            this.showPicker();
        }
    }
    
    showPicker() {
        // Position picker relative to emoji button
        const buttonRect = this.toggleBtn.getBoundingClientRect();
        const pickerWidth = 320;
        
        // Calculate position
        let left = buttonRect.left + window.scrollX;
        let bottom = window.innerHeight - buttonRect.top + 10;
        
        // Adjust if picker would go off screen on the right
        if (left + pickerWidth > window.innerWidth) {
            left = window.innerWidth - pickerWidth - 10;
        }
        
        // Adjust if picker would go off screen on the left
        if (left < 10) {
            left = 10;
        }
        
        // Set position
        this.picker.style.position = 'fixed';
        this.picker.style.left = left + 'px';
        this.picker.style.bottom = bottom + 'px';
        this.picker.style.right = 'auto';
        this.picker.style.top = 'auto';
        
        // Show picker
        this.picker.classList.add('show');
        this.isPickerVisible = true;
    }
    
    hidePicker() {
        this.picker.classList.remove('show');
        this.isPickerVisible = false;
    }
}

// Video Call Manager
class VideoCallManager {
    constructor() {
        this.config = window.chatConfig;
        this.currentCallId = null;
        this.setupCallButtons();
        this.listenForIncomingCalls();
    }

    setupCallButtons() {
        const videoBtn = document.getElementById('start-video-call');
        const voiceBtn = document.getElementById('start-voice-call');

        if (videoBtn) {
            videoBtn.addEventListener('click', () => this.initiateCall('video'));
        }

        if (voiceBtn) {
            voiceBtn.addEventListener('click', () => this.initiateCall('audio'));
        }
    }

    listenForIncomingCalls() {
        if (!window.Echo) {
            console.error('❌ Echo not initialized');
            return;
        }

        window.Echo.private(`user.${this.config.currentUserId}`)
            .listen('.call.invitation', (data) => {
                console.log('📞 Incoming call:', data);
                this.showIncomingCallModal(data);
            });
    }

    async initiateCall(callType) {
        try {
            console.log(`🚀 Initiating ${callType} call...`);

            this.showLoading(`Starting ${callType} call...`);

            const response = await fetch('/api/video-calls/initiate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': this.getCSRFToken(),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    conversation_id: this.config.conversationId,
                    call_type: callType
                })
            });

            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                const text = await response.text();
                console.error('❌ Non-JSON response:', text.substring(0, 500));
                throw new Error('Server returned HTML instead of JSON. Check if you are logged in.');
            }

            const data = await response.json();
            console.log('Response data:', data);

            if (!response.ok) {
                throw new Error(data.error || data.message || 'Failed to initiate call');
            }

            if (!data.success || !data.call_id) {
                throw new Error('Invalid response from server: ' + JSON.stringify(data));
            }

            console.log('✅ Call initiated successfully:', data);

            // Redirect to call room
            const roomUrl = `/video-calls/${data.call_id}/room`;
            console.log('Redirecting to:', roomUrl);
            window.location.href = roomUrl;

        } catch (error) {
            console.error('❌ Failed to initiate call:', error);
            this.hideLoading();
            
            let errorMessage = error.message;
            if (errorMessage.includes('HTML instead of JSON')) {
                errorMessage = 'Server error. Please refresh the page and try again.';
            }
            
            alert('Failed to start call:\n' + errorMessage);
        }
    }

    showIncomingCallModal(callData) {
        const { callId, roomId, caller, callType } = callData;

        const modal = document.createElement('div');
        modal.id = 'incoming-call-modal';
        modal.className = 'incoming-call-modal';
        modal.innerHTML = `
            <div class="incoming-call-overlay"></div>
            <div class="incoming-call-content">
                <div class="incoming-call-header">
                    <i class="fas fa-${callType === 'video' ? 'video' : 'phone'}"></i>
                    <h3>Incoming ${callType === 'video' ? 'Video' : 'Voice'} Call</h3>
                </div>
                
                <div class="incoming-call-body">
                    <div class="caller-avatar">
                        <img src="${this.config.otherUserAvatar}" alt="${caller.name}">
                    </div>
                    <h4 class="caller-name">${caller.name}</h4>
                    <p class="call-type">${callType === 'video' ? 'Video' : 'Voice'} call</p>
                </div>

                <div class="incoming-call-actions">
                    <button class="call-action-btn btn-decline" onclick="videoCallManager.declineCall(${callId})">
                        <i class="fas fa-phone-slash"></i>
                        Decline
                    </button>
                    <button class="call-action-btn btn-accept" onclick="videoCallManager.acceptCall(${callId})">
                        <i class="fas fa-phone"></i>
                        Accept
                    </button>
                </div>
            </div>
        `;

        document.body.appendChild(modal);

        // Play ringtone
        const ringtone = document.getElementById('ringtone-audio');
        if (ringtone) {
            ringtone.play().catch(e => console.warn('Cannot play ringtone:', e));
        }
    }

    async acceptCall(callId) {
        try {
            console.log('✅ Accepting call:', callId);

            const response = await fetch('/api/video-calls/accept', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': this.getCSRFToken()
                },
                body: JSON.stringify({ call_id: callId })
            });

            if (!response.ok) {
                const data = await response.json();
                throw new Error(data.error || 'Failed to accept call');
            }

            // Stop ringtone
            const ringtone = document.getElementById('ringtone-audio');
            if (ringtone) ringtone.pause();

            // Remove modal
            this.removeIncomingCallModal();

            // Redirect to call room
            window.location.href = `/video-calls/${callId}/room`;

        } catch (error) {
            console.error('❌ Failed to accept call:', error);
            alert('Failed to accept call: ' + error.message);
        }
    }

    async declineCall(callId) {
        try {
            console.log('❌ Declining call:', callId);

            const response = await fetch('/api/video-calls/decline', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': this.getCSRFToken()
                },
                body: JSON.stringify({ call_id: callId })
            });

            if (!response.ok) {
                console.error('Failed to decline call');
            }

            // Stop ringtone
            const ringtone = document.getElementById('ringtone-audio');
            if (ringtone) ringtone.pause();

            // Remove modal
            this.removeIncomingCallModal();

        } catch (error) {
            console.error('❌ Failed to decline call:', error);
            this.removeIncomingCallModal();
        }
    }

    removeIncomingCallModal() {
        const modal = document.getElementById('incoming-call-modal');
        if (modal) modal.remove();
    }

    showLoading(message = 'Loading...') {
        let overlay = document.getElementById('loading-overlay');
        if (overlay) {
            overlay.classList.add('show');
            const text = document.getElementById('loading-text');
            if (text) text.textContent = message;
        }
    }

    hideLoading() {
        const overlay = document.getElementById('loading-overlay');
        if (overlay) {
            overlay.classList.remove('show');
        }
    }

    getCSRFToken() {
        const token = document.querySelector('meta[name="csrf-token"]')?.content;
        if (!token) {
            console.error('❌ CSRF token not found!');
        }
        return token || '';
    }
}

// Chat Input Manager
class ChatInputManager {
    constructor() {
        this.messageInput = document.getElementById('message-input');
        this.messageForm = document.getElementById('message-form');
        this.sendBtn = document.getElementById('send-btn');
        
        this.init();
    }
    
    init() {
        // Auto-resize textarea
        this.messageInput.addEventListener('input', () => {
            this.autoResizeTextarea();
        });
        
        // Form submission
        this.messageForm.addEventListener('submit', (e) => {
            e.preventDefault();
            this.sendMessage();
        });
        
        // Enable/disable send button based on input
        this.messageInput.addEventListener('input', () => {
            this.sendBtn.disabled = !this.messageInput.value.trim();
        });
        
        // Submit on Ctrl+Enter
        this.messageInput.addEventListener('keydown', (e) => {
            if (e.ctrlKey && e.key === 'Enter') {
                e.preventDefault();
                this.sendMessage();
            }
        });
        
        // Initial disable
        this.sendBtn.disabled = true;
    }
    
    autoResizeTextarea() {
        const textarea = this.messageInput;
        textarea.style.height = 'auto';
        const maxHeight = 150;
        textarea.style.height = Math.min(textarea.scrollHeight, maxHeight) + 'px';
    }
    
    async sendMessage() {
        const content = this.messageInput.value.trim();
        if (!content) return;
        
        // Add sending logic here
        console.log('Sending message:', content);
        
        // Clear input
        this.messageInput.value = '';
        this.autoResizeTextarea();
        this.sendBtn.disabled = true;
        
        // You would typically make an AJAX request here
        // await fetch('/api/messages/send', { ... })
    }
}

// Initialize
let videoCallManager;
let emojiPickerManager;
let chatInputManager;

async function initializeApp() {
    console.log('🚀 Initializing app...');

    // Validate config
    if (!window.chatConfig.conversationId) {
        console.error('❌ Missing conversationId');
        return;
    }

    // Initialize managers
    emojiPickerManager = new EmojiPickerManager();
    chatInputManager = new ChatInputManager();

    // Wait for Echo
    let attempts = 0;
    while (!window.Echo && attempts < 50) {
        await new Promise(resolve => setTimeout(resolve, 100));
        attempts++;
    }

    if (!window.Echo) {
        console.error('❌ Echo not initialized after 5 seconds');
        return;
    }

    console.log('✅ Echo ready');

    // Initialize video call manager
    videoCallManager = new VideoCallManager();
    window.videoCallManager = videoCallManager;
    console.log('✅ Video call manager initialized');
}

// Run initialization
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeApp);
} else {
    initializeApp();
}
</script>

{{-- Load Vite assets for chat functionality --}}
@vite([
    'resources/js/bootstrap.ts',
    'resources/js/chat-page.ts'
])

{{-- Hidden ringtone audio --}}
<audio id="ringtone-audio" loop style="display: none;">
    <source src="{{ asset('sounds/ringtone.mp3') }}" type="audio/mpeg">
</audio>
@endpush