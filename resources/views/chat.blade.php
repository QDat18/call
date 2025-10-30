@extends('layouts.app')

@section('title', 'Chat')

@section('content')
<div class="chat-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="chat-container">
                    <!-- Header -->
                    <div class="chat-header">
                        <div class="chat-info">
                            <div class="avatar">
                                <img 
                                    src="{{ $participant->avatar_url ?? asset('images/default-avatar.png') }}" 
                                    alt="{{ $participant->first_name }}"
                                    class="rounded-circle">
                            </div>
                            <div>
                                <h5 class="mb-0">{{ $participant->first_name }} {{ $participant->last_name }}</h5>
                                <small class="text-muted">
                                    <i class="fas fa-circle text-success"></i> Online
                                </small>
                            </div>
                        </div>
                        <div class="chat-actions">
                            <button class="btn btn-light btn-sm me-2">
                                <i class="fas fa-phone"></i>
                            </button>
                            <button class="btn btn-light btn-sm me-2">
                                <i class="fas fa-video"></i>
                            </button>
                            <button class="btn btn-light btn-sm">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Messages -->
                    <div class="messages-container" id="messages-container">
                        <div class="messages-wrapper" id="messages-wrapper">
                            <div class="text-center py-3">
                                <div class="spinner-border text-primary" role="status"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Typing Indicator -->
                    <div class="typing-indicator" id="typing-indicator" style="display: none;">
                        <div class="typing-dots">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <small class="ms-2">typing...</small>
                    </div>

                    <!-- Input -->
                    <div class="message-input-container">
                        <form id="message-form" class="d-flex align-items-end gap-2">
                            <button type="button" class="btn btn-light">
                                <i class="fas fa-paperclip"></i>
                            </button>
                            
                            <div class="flex-grow-1">
                                <textarea 
                                    class="form-control message-input" 
                                    id="message-input" 
                                    rows="1"
                                    placeholder="Type a message..."
                                    required></textarea>
                            </div>

                            <button type="button" class="btn btn-light">
                                <i class="fas fa-smile"></i>
                            </button>
                            
                            <button type="submit" class="btn btn-primary send-btn">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .chat-page {
        background: #f5f7fb;
        min-height: 100vh;
        padding: 0;
    }

    .chat-container {
        height: 100vh;
        display: flex;
        flex-direction: column;
        background: white;
    }

    .chat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.5rem;
        background: white;
        border-bottom: 1px solid #e5e7eb;
    }

    .chat-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .chat-info .avatar img {
        width: 45px;
        height: 45px;
        object-fit: cover;
    }

    .messages-container {
        flex: 1;
        overflow-y: auto;
        background: #f9fafb;
        padding: 1.5rem;
    }

    .messages-wrapper {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .message-item {
        display: flex;
        align-items: flex-end;
        gap: 0.5rem;
        max-width: 70%;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .message-item.own {
        align-self: flex-end;
        flex-direction: row-reverse;
    }

    .message-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
    }

    .message-content {
        display: flex;
        flex-direction: column;
    }

    .message-bubble {
        background: white;
        padding: 0.75rem 1rem;
        border-radius: 18px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        word-wrap: break-word;
    }

    .message-item.own .message-bubble {
        background: #3b82f6;
        color: white;
    }

    .message-time {
        font-size: 11px;
        color: #9ca3af;
        margin-top: 0.25rem;
        padding: 0 0.5rem;
    }

    .typing-indicator {
        padding: 0.5rem 1.5rem;
        background: #f9fafb;
        display: flex;
        align-items: center;
    }

    .typing-dots {
        display: flex;
        gap: 4px;
    }

    .typing-dots span {
        width: 8px;
        height: 8px;
        background: #9ca3af;
        border-radius: 50%;
        animation: typing 1.4s infinite;
    }

    .typing-dots span:nth-child(2) { animation-delay: 0.2s; }
    .typing-dots span:nth-child(3) { animation-delay: 0.4s; }

    @keyframes typing {
        0%, 60%, 100% { transform: translateY(0); }
        30% { transform: translateY(-10px); }
    }

    .message-input-container {
        padding: 1rem 1.5rem;
        background: white;
        border-top: 1px solid #e5e7eb;
    }

    .message-input {
        border: 1px solid #e5e7eb;
        border-radius: 24px;
        padding: 0.75rem 1rem;
        resize: none;
        max-height: 120px;
    }

    .message-input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .send-btn {
        border-radius: 50%;
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .messages-container::-webkit-scrollbar { width: 6px; }
    .messages-container::-webkit-scrollbar-track { background: #f1f1f1; }
    .messages-container::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }

    @media (max-width: 768px) {
        .message-item { max-width: 85%; }
    }
</style>
@endpush

@push('scripts')
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
// Config
const conversationId = {{ $conversationId }};
const currentUserId = {{ auth()->id() }};
const participantAvatar = '{{ $participant->avatar_url ?? asset("images/default-avatar.png") }}';
const currentUserAvatar = '{{ auth()->user()->avatar_url ?? asset("images/default-avatar.png") }}';
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

// Elements
const messagesWrapper = document.getElementById('messages-wrapper');
const messagesContainer = document.getElementById('messages-container');
const messageForm = document.getElementById('message-form');
const messageInput = document.getElementById('message-input');
const typingIndicator = document.getElementById('typing-indicator');

// Pusher
const pusher = new Pusher('{{ env("PUSHER_APP_KEY") }}', {
    cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
    encrypted: true
});

const channel = pusher.subscribe('chat.' + conversationId);

// Listen for new messages - QUAN TRỌNG: Đây là nơi nhận tin nhắn real-time
channel.bind('MessageSent', function(data) {
    console.log('📩 Pusher received:', data);
    
    // Chỉ thêm tin nhắn của người khác (tin nhắn của mình đã thêm khi gửi)
    if (data.user_id !== currentUserId) {
        addMessageToUI(data);
    }
});

// Listen for typing
channel.bind('UserTyping', function(data) {
    if (data.user_id !== currentUserId && data.typing) {
        typingIndicator.style.display = 'flex';
        scrollToBottom();
    } else {
        typingIndicator.style.display = 'none';
    }
});

// Load old messages
function loadMessages() {
    fetch(`/messages/${conversationId}`, {
        headers: { 'X-CSRF-TOKEN': csrfToken }
    })
    .then(res => res.json())
    .then(messages => {
        messagesWrapper.innerHTML = '';
        messages.forEach(msg => {
            addMessageToUI({
                id: msg.id,
                user_id: msg.user_id,
                message: msg.message,
                created_at: msg.created_at
            }, false);
        });
        scrollToBottom();
    })
    .catch(err => {
        console.error('❌ Load messages error:', err);
        messagesWrapper.innerHTML = '<div class="alert alert-danger">Error loading messages</div>';
    });
}

// Add message to UI
function addMessageToUI(data, scroll = true) {
    const isOwn = data.user_id === currentUserId;
    const time = new Date(data.created_at).toLocaleTimeString('en-US', { 
        hour: '2-digit', 
        minute: '2-digit' 
    });
    
    const html = `
        <div class="message-item ${isOwn ? 'own' : ''}">
            ${!isOwn ? `<img src="${participantAvatar}" class="message-avatar">` : ''}
            <div class="message-content">
                <div class="message-bubble">${escapeHtml(data.message)}</div>
                <div class="message-time">${time}</div>
            </div>
            ${isOwn ? `<img src="${currentUserAvatar}" class="message-avatar">` : ''}
        </div>
    `;
    
    messagesWrapper.insertAdjacentHTML('beforeend', html);
    if (scroll) scrollToBottom();
}

// Send message
messageForm.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const message = messageInput.value.trim();
    if (!message) return;
    
    fetch('/messages', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            conversation_id: conversationId,
            message: message
        })
    })
    .then(res => res.json())
    .then(data => {
        console.log('✅ Message sent:', data);
        
        // Hiển thị tin nhắn của mình ngay lập tức
        addMessageToUI({
            id: data.id,
            user_id: data.user_id,
            message: data.message,
            created_at: data.created_at
        });
        
        messageInput.value = '';
        messageInput.style.height = 'auto';
    })
    .catch(err => {
        console.error('❌ Send error:', err);
        alert('Failed to send message!');
    });
});

// Typing indicator
let typingTimer;
messageInput.addEventListener('input', function() {
    clearTimeout(typingTimer);
    
    if (this.value.trim()) {
        sendTypingStatus(true);
        typingTimer = setTimeout(() => sendTypingStatus(false), 1000);
    }
    
    // Auto resize
    this.style.height = 'auto';
    this.style.height = Math.min(this.scrollHeight, 120) + 'px';
});

function sendTypingStatus(typing) {
    fetch('/chat/typing', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            conversation_id: conversationId,
            typing: typing
        })
    }).catch(err => console.error('Typing error:', err));
}

function scrollToBottom() {
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Pusher debug
pusher.connection.bind('connected', () => console.log('✅ Pusher connected'));
pusher.connection.bind('error', err => console.error('❌ Pusher error:', err));

// Init
loadMessages();
</script>
@endpush