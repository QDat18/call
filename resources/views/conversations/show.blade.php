@extends('layouts.app')

@section('title', 'Trò chuyện với ' . ($otherUser ? $otherUser->first_name : 'Người dùng'))

{{-- --- 1. PHP HELPER --- --}}
@php
    // Helper Avatar chuẩn
    $getAvatar = function($user) {
        if (!$user) return asset('images/default-avatar.png');
        $path = $user->avatar_url;
        if (empty($path)) {
            $name = urlencode($user->first_name . ' ' . $user->last_name);
            return "https://ui-avatars.com/api/?name={$name}&background=6366f1&color=ffffff&size=128";
        }
        if (Str::startsWith($path, ['http://', 'https://'])) return $path;
        return Str::startsWith($path, 'storage/') ? asset($path) : asset('storage/' . $path);
    };

    // Helper Trạng thái Online
    $getStatusText = function($user) {
        if (!$user) return 'Không xác định';
        if ($user->is_online) return 'Đang hoạt động';
        return 'Hoạt động ' . ($user->last_activity_at ? \Carbon\Carbon::parse($user->last_activity_at)->diffForHumans() : 'gần đây');
    };

    $currentUserAvatar = $getAvatar(auth()->user());
    $otherUserAvatar = $otherUser ? $getAvatar($otherUser) : asset('images/default-avatar.png');
@endphp

@push('styles')
<style>
    :root { --primary-color: #6366f1; --light-color: #f3f4f6; --dark-color: #1f2937; --border-color: #e5e7eb; }
    body { background-color: #f9fafb; overflow: hidden; }
    
    /* Layout */
    .chat-layout { display: flex; height: calc(100vh - 65px); max-width: 1600px; margin: 0 auto; background: white; }
    .chat-sidebar { width: 320px; border-right: 1px solid var(--border-color); display: flex; flex-direction: column; background: white; }
    .chat-main { flex: 1; display: flex; flex-direction: column; min-width: 0; background: white; position: relative; }
    
    /* Sidebar Items */
    .conv-item { display: flex; align-items: center; padding: 12px; cursor: pointer; transition: 0.2s; border-left: 3px solid transparent; }
    .conv-item:hover { background-color: #f9fafb; }
    .conv-item.active { background-color: #eef2ff; border-left-color: var(--primary-color); }
    .conv-avatar-wrap { position: relative; margin-right: 12px; }
    .conv-avatar { width: 48px; height: 48px; border-radius: 50%; object-fit: cover; border: 1px solid #eee; }
    .conv-status { position: absolute; bottom: 2px; right: 2px; width: 12px; height: 12px; border-radius: 50%; border: 2px solid white; }
    .conv-status.online { background: #10b981; } .conv-status.offline { background: #9ca3af; }
    
    /* Chat Header */
    .chat-header { height: 70px; padding: 0 24px; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between; background: white; z-index: 10; }
    .header-user { display: flex; align-items: center; gap: 12px; text-decoration: none; color: inherit; }
    .header-avatar { width: 42px; height: 42px; border-radius: 50%; object-fit: cover; }
    
    /* Messages Area */
    .messages-area { flex: 1; padding: 20px 24px; overflow-y: auto; background: #ffffff; display: flex; flex-direction: column; gap: 8px; }
    .message-wrapper { display: flex; margin-bottom: 24px; max-width: 100%; position: relative; } /* Tăng margin bottom để chừa chỗ cho reaction */
    .message-wrapper.sent { flex-direction: row-reverse; }
    .msg-avatar { width: 32px; height: 32px; border-radius: 50%; margin: 0 8px; align-self: flex-end; object-fit: cover; }
    .msg-content { max-width: 70%; display: flex; flex-direction: column; position: relative; }
    .message-wrapper.sent .msg-content { align-items: flex-end; }
    
    /* Bubbles */
    .msg-bubble { padding: 10px 16px; border-radius: 18px; font-size: 15px; line-height: 1.5; position: relative; box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .message-wrapper.sent .msg-bubble { background: var(--primary-color); color: white; border-bottom-right-radius: 4px; }
    .message-wrapper.received .msg-bubble { background: #f3f4f6; color: var(--dark-color); border-bottom-left-radius: 4px; }
    .msg-time { font-size: 11px; color: #9ca3af; margin-top: 4px; padding: 0 4px; }
    
    /* --- ACTION MENU (FIX GIẬT: Position Absolute) --- */
    .message-actions-menu { position: absolute; top: 50%; transform: translateY(-50%); background: white; padding: 2px; border-radius: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border: 1px solid var(--border-color); display: none; gap: 2px; z-index: 100; height: 32px; align-items: center; }
    .message-wrapper:hover .message-actions-menu { display: flex; animation: fadeIn 0.2s ease-out; }
    .message-wrapper.sent .message-actions-menu { right: 100%; margin-right: 12px; flex-direction: row-reverse; }
    .message-wrapper.received .message-actions-menu { left: 100%; margin-left: 12px; }
    
    .action-mini-btn { width: 28px; height: 28px; border-radius: 50%; border: none; background: transparent; cursor: pointer; color: #9ca3af; display: flex; align-items: center; justify-content: center; transition: 0.2s; flex-shrink: 0; }
    .action-mini-btn:hover { background: #f3f4f6; color: var(--primary-color); transform: scale(1.1); }
    .action-mini-btn.delete:hover { color: #ef4444; background: #fee2e2; }

    /* Reaction Popup (FIX GIẬT) */
    .reaction-popup { position: absolute; bottom: 40px; left: 50%; transform: translateX(-50%) scale(0.8); background: white; padding: 6px 12px; border-radius: 50px; box-shadow: 0 5px 20px rgba(0,0,0,0.15); border: 1px solid #e5e7eb; display: flex; gap: 8px; z-index: 200; opacity: 0; visibility: hidden; transition: all 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275); pointer-events: none; }
    .reaction-popup.show { opacity: 1; visibility: visible; transform: translateX(-50%) scale(1); pointer-events: auto; bottom: 45px; }
    .reaction-item { font-size: 22px; cursor: pointer; transition: transform 0.2s; user-select: none; line-height: 1; }
    .reaction-item:hover { transform: scale(1.3) translateY(-2px); }

    /* Reaction Display (FIX GIẬT: Absolute position) */
    .reaction-display { position: absolute; bottom: -14px; right: 0; background: white; border: 1px solid #f3f4f6; border-radius: 12px; padding: 2px 6px; font-size: 11px; display: flex; align-items: center; gap: 2px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); z-index: 5; cursor: pointer; height: 20px; white-space: nowrap; }
    .message-wrapper.received .reaction-display { left: 0; right: auto; }

    @keyframes fadeIn { from { opacity: 0; transform: translateY(-50%) scale(0.9); } to { opacity: 1; transform: translateY(-50%) scale(1); } }

    /* Input Area */
    .input-area { padding: 16px 24px; border-top: 1px solid var(--border-color); background: white; position: relative; z-index: 20; }
    .input-wrapper { background: #f3f4f6; border-radius: 24px; padding: 8px 16px; display: flex; align-items: center; gap: 10px; transition: 0.2s; }
    .input-wrapper:focus-within { background: white; box-shadow: 0 0 0 2px var(--primary-color); }
    .message-input { flex: 1; background: transparent; border: none; max-height: 120px; resize: none; padding: 8px 0; outline: none; }
    
    /* Emoji Picker */
    .emoji-picker { position: absolute; bottom: 80px; right: 24px; width: 300px; height: 250px; background: white; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.15); display: none; overflow: hidden; border: 1px solid var(--border-color); z-index: 100; flex-direction: column; }
    .emoji-picker.show { display: flex; animation: slideUp 0.2s ease-out; }
    .emoji-grid { display: grid; grid-template-columns: repeat(8, 1fr); gap: 5px; padding: 10px; overflow-y: auto; flex: 1; }
    .emoji-item { font-size: 22px; cursor: pointer; text-align: center; padding: 5px; border-radius: 5px; transition: 0.2s; }
    .emoji-item:hover { background: #f3f4f6; transform: scale(1.2); }
    @keyframes slideUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

    /* Loading Overlay */
    .loading-overlay { position: absolute; inset: 0; background: rgba(255,255,255,0.8); backdrop-filter: blur(2px); display: none; justify-content: center; align-items: center; z-index: 50; flex-direction: column; }
    .loading-overlay.show { display: flex; }
    
    /* Utils */
    .date-divider { text-align: center; margin: 20px 0; font-size: 12px; color: #9ca3af; }
    .date-divider span { background: #f3f4f6; padding: 4px 12px; border-radius: 12px; }
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
    
    @media (max-width: 768px) { .chat-sidebar { display: none; } .chat-header { padding: 0 16px; } }
</style>
@endpush

@section('content')
<div class="chat-layout">
    
    {{-- ========= 1. SIDEBAR ========= --}}
    <div class="chat-sidebar">
        <div class="p-4 border-b border-gray-200">
            <h2 class="text-xl font-bold mb-3">Tin nhắn</h2>
            <div class="relative">
                <input type="text" id="conv-search" class="w-full pl-9 pr-4 py-2 bg-gray-100 rounded-full text-sm focus:outline-none" placeholder="Tìm kiếm...">
                <i class="fas fa-search absolute left-3 top-2.5 text-gray-400"></i>
            </div>
        </div>
        
        <div class="flex-1 overflow-y-auto custom-scrollbar">
            @if(isset($sidebarConversations))
                @foreach($sidebarConversations as $sidebarConv)
                    @php
                        $p = $sidebarConv->participants->where('user_id', '!=', auth()->id())->first();
                        $u = $p ? $p->user : null;
                        $isActive = isset($conversation) && $sidebarConv->conversation_id == $conversation->conversation_id;
                        $myPart = $sidebarConv->participants->where('user_id', auth()->id())->first();
                        $isUnread = $myPart && $myPart->unread_count > 0;
                        $lastMsg = $sidebarConv->lastMessage;
                    @endphp
                    
                    @if($u)
                        <a href="{{ route('conversations.show', $sidebarConv->conversation_id) }}" 
                           class="conv-item {{ $isActive ? 'active' : '' }}">
                            <div class="conv-avatar-wrap">
                                <img src="{{ $getAvatar($u) }}" class="conv-avatar">
                                <span class="conv-status {{ $u->is_online ? 'online' : 'offline' }}"></span>
                            </div>
                            <div class="flex-1 min-w-0 ml-3">
                                <div class="flex justify-between mb-1">
                                    <span class="font-semibold text-sm truncate">{{ $u->first_name }} {{ $u->last_name }}</span>
                                    <span class="text-xs text-gray-500">{{ $lastMsg ? $lastMsg->sent_at->format('H:i') : '' }}</span>
                                </div>
                                <div class="text-xs text-gray-500 truncate {{ $isUnread ? 'font-bold text-gray-800' : '' }}">
                                    @if($lastMsg)
                                        {{ $lastMsg->sender_id == auth()->id() ? 'Bạn: ' : '' }}
                                        {{ $lastMsg->message_type == 'recalled' ? 'Tin nhắn đã thu hồi' : Str::limit($lastMsg->content, 25) }}
                                    @else
                                        Bắt đầu trò chuyện
                                    @endif
                                </div>
                            </div>
                            @if($isUnread && !$isActive)
                                <div class="w-2.5 h-2.5 bg-indigo-600 rounded-full ml-2"></div>
                            @endif
                        </a>
                    @endif
                @endforeach
            @endif
        </div>
    </div>

    {{-- ========= 2. MAIN CHAT ========= --}}
    <div class="chat-main">
        {{-- Loading Overlay --}}
        <div id="loading-overlay" class="loading-overlay">
            <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-indigo-600 mb-3"></div>
            <p class="text-gray-700 font-medium">Đang kết nối...</p>
        </div>

        {{-- Header --}}
        <div class="chat-header">
            @if($otherUser)
            <div class="flex items-center gap-3">
                <a href="{{ route('conversations.index') }}" class="md:hidden text-gray-500"><i class="fas fa-arrow-left"></i></a>
                <div class="relative">
                    <img src="{{ $getAvatar($otherUser) }}" class="header-avatar">
                    @if($otherUser->is_online)
                        <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 border-2 border-white rounded-full"></span>
                    @endif
                </div>
                <div>
                    <h4 class="font-bold text-gray-800">{{ $otherUser->first_name }} {{ $otherUser->last_name }}</h4>
                    <span class="text-xs {{ $otherUser->is_online ? 'text-green-500 font-medium' : 'text-gray-500' }}">
                        {{ $getStatusText($otherUser) }}
                    </span>
                </div>
            </div>
            <div class="flex gap-2 text-indigo-600">
                <button onclick="initiateCall('audio')" class="p-2 hover:bg-indigo-50 rounded-full transition" title="Gọi thoại"><i class="fas fa-phone"></i></button>
                <button onclick="initiateCall('video')" class="p-2 hover:bg-indigo-50 rounded-full transition" title="Gọi video"><i class="fas fa-video"></i></button>
                <button class="p-2 hover:bg-indigo-50 rounded-full transition" title="Thông tin"><i class="fas fa-info-circle"></i></button>
            </div>
            @endif
        </div>

        {{-- Messages List --}}
        <div class="messages-area custom-scrollbar" id="messages-area">
            @php $previousDate = null; @endphp
            @foreach($messages as $msg)
                @php
                    $isMe = $msg->sender_id == auth()->id();
                    $currentDate = $msg->sent_at->format('Y-m-d');
                    
                    // --- XỬ LÝ REACTION ---
                    $rawReactions = $msg->reactions ?? [];
                    $validReactions = array_filter($rawReactions, fn($val) => $val !== 'deleted');
                    $reactionCounts = array_count_values($validReactions);
                @endphp
                
                @if($previousDate !== $currentDate)
                    <div class="date-divider"><span>{{ $msg->sent_at->format('d/m/Y') }}</span></div>
                    @php $previousDate = $currentDate; @endphp
                @endif

                <div class="message-wrapper {{ $isMe ? 'sent' : 'received' }}" id="msg-{{ $msg->message_id }}">
                    @if(!$isMe) <img src="{{ $getAvatar($msg->sender) }}" class="msg-avatar"> @endif
                    
                    <div class="msg-content">
                        {{-- MENU ACTIONS (Fixed Position) --}}
                        <div class="message-actions-menu">
                            @if($msg->message_type !== 'recalled')
                                <button class="action-mini-btn reaction-trigger" onclick="toggleReactionPopup({{ $msg->message_id }})"><i class="far fa-smile"></i></button>
                                <div class="reaction-popup" id="popup-{{ $msg->message_id }}">
                                    @foreach(['like'=>'👍','love'=>'❤️','haha'=>'😂','sad'=>'😢','angry'=>'😠'] as $type => $icon)
                                        <span class="reaction-item" onclick="submitReaction({{ $msg->message_id }}, '{{ $type }}')">{{ $icon }}</span>
                                    @endforeach
                                </div>
                                
                                @if($isMe)
                                    <button class="action-mini-btn" onclick="recallMessage({{ $msg->message_id }})" title="Thu hồi"><i class="fas fa-undo"></i></button>
                                @endif
                            @endif
                            <button class="action-mini-btn delete" onclick="deleteMessage({{ $msg->message_id }})" title="Xóa phía tôi"><i class="far fa-trash-alt"></i></button>
                        </div>

                        {{-- BONG BÓNG CHAT --}}
                        <div class="msg-bubble">
                            @if($msg->message_type === 'recalled')
                                <em class="text-sm opacity-70 italic flex items-center gap-1"><i class="fas fa-ban text-xs"></i> Tin nhắn đã thu hồi</em>
                            @else
                                <div class="whitespace-pre-wrap">{!! nl2br(e($msg->content)) !!}</div>
                                @if($msg->attachment_url)
                                    <div class="mt-2">
                                        @if($msg->message_type == 'image')
                                            <img src="{{ asset($msg->attachment_url) }}" class="rounded-lg max-w-xs cursor-pointer hover:opacity-90" onclick="window.open(this.src)">
                                        @else
                                            <a href="{{ asset($msg->attachment_url) }}" target="_blank" class="flex items-center gap-2 bg-black/5 p-2 rounded text-sm">
                                                <i class="fas fa-file-download"></i> {{ $msg->attachment_name ?? 'File đính kèm' }}
                                            </a>
                                        @endif
                                    </div>
                                @endif

                                {{-- Hiển thị Reaction (Fixed Position) --}}
                                @if(count($validReactions) > 0)
                                    <div class="reaction-display" id="reaction-display-{{ $msg->message_id }}">
                                        @foreach($reactionCounts as $type => $cnt)
                                            <span>
                                                @if($type=='like')👍@elseif($type=='love')❤️@elseif($type=='haha')😂@elseif($type=='sad')😢@elseif($type=='angry')😠@endif
                                            </span>
                                        @endforeach
                                        <span class="ml-1 font-bold text-gray-600">{{ count($validReactions) }}</span>
                                    </div>
                                @else
                                    <div class="reaction-display" id="reaction-display-{{ $msg->message_id }}" style="display:none"></div>
                                @endif
                            @endif
                        </div>
                        <div class="msg-time">{{ $msg->sent_at->format('H:i') }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Input Area --}}
        <div class="input-area">
            <form id="message-form" class="flex items-end gap-2">
                @csrf
                <button type="button" class="p-2 text-gray-400 hover:text-indigo-600 transition"><i class="fas fa-paperclip text-xl"></i></button>
                
                <div class="input-wrapper flex-1">
                    <textarea id="message-input" class="message-input" placeholder="Nhập tin nhắn..." rows="1"></textarea>
                    <button type="button" id="emoji-toggle-btn" class="text-yellow-500 hover:scale-110 transition"><i class="fas fa-smile text-xl"></i></button>
                </div>
                
                <button type="submit" id="send-btn" class="w-10 h-10 rounded-full bg-indigo-600 hover:bg-indigo-700 text-white flex items-center justify-center transition shadow-lg disabled:opacity-50" disabled>
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>
</div>

{{-- Sound --}}
<audio id="msg-sound" src="{{ asset('sounds/message_tone.mp3') }}" preload="auto"></audio>

@endsection

@push('scripts')
<script>
    // 1. CONFIG & INIT
    window.chatConfig = {
        conversationId: {{ $conversation->conversation_id }},
        csrfToken: '{{ csrf_token() }}',
        currentUserId: {{ auth()->id() }},
        currentUserAvatar: "{!! $currentUserAvatar !!}", 
        otherUserAvatar: "{!! $otherUserAvatar !!}"
    };

    const msgArea = document.getElementById('messages-area');
    function scrollToBottom() { msgArea.scrollTop = msgArea.scrollHeight; }
    scrollToBottom();

    // 2. INPUT LOGIC
    const input = document.getElementById('message-input');
    const sendBtn = document.getElementById('send-btn');

    input.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 120) + 'px';
        sendBtn.disabled = !this.value.trim();
    });

    input.addEventListener('keydown', function(e) {
        if(e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            if(!sendBtn.disabled) document.getElementById('message-form').dispatchEvent(new Event('submit'));
        }
    });

    // 3. SEND MESSAGE
    document.getElementById('message-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const content = input.value.trim();
        if(!content) return;

        input.value = '';
        input.style.height = 'auto';
        sendBtn.disabled = true;

        // Optimistic UI
        const tempMsg = {
            content: content,
            sent_at: new Date().toISOString(),
            message_type: 'text'
        };
        appendMessage(tempMsg, true);

        fetch(`/conversations/${window.chatConfig.conversationId}/messages`, {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json', 
                'X-CSRF-TOKEN': window.chatConfig.csrfToken 
            },
            body: JSON.stringify({ content: content, message_type: 'text' })
        })
        .then(r => r.json())
        .catch(err => console.error(err));
    });

    // 4. APPEND FUNCTION
    function appendMessage(msg, isMe) {
        const time = new Date(msg.sent_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        const avatar = isMe ? window.chatConfig.currentUserAvatar : window.chatConfig.otherUserAvatar;
        
        const html = `
            <div class="message-wrapper ${isMe ? 'sent' : 'received'}" id="msg-${msg.message_id || 'temp'}">
                ${!isMe ? `<img src="${avatar}" class="msg-avatar">` : ''}
                <div class="msg-content">
                    <div class="message-actions-menu">
                        <button class="action-mini-btn reaction-trigger"><i class="far fa-smile"></i></button>
                        <button class="action-mini-btn delete"><i class="far fa-trash-alt"></i></button>
                    </div>
                    <div class="msg-bubble">
                        <div class="whitespace-pre-wrap">${msg.content}</div>
                    </div>
                    <div class="msg-time">${time}</div>
                </div>
            </div>
        `;
        msgArea.insertAdjacentHTML('beforeend', html);
        scrollToBottom();
    }

    // 5. VIDEO CALL
    window.initiateCall = function(type) {
        const overlay = document.getElementById('loading-overlay');
        overlay.classList.add('show');

        fetch('/api/video-calls/initiate', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': window.chatConfig.csrfToken },
            body: JSON.stringify({ conversation_id: window.chatConfig.conversationId, call_type: type })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) window.location.href = `/video-calls/${data.call_id}/room`;
            else { alert(data.message); overlay.classList.remove('show'); }
        })
        .catch(err => { alert('Lỗi kết nối'); overlay.classList.remove('show'); });
    };

    // 6. EMOJI PICKER
    class EmojiPickerManager {
        constructor() {
            this.picker = null;
            this.toggleBtn = document.getElementById('emoji-toggle-btn');
            this.messageInput = document.getElementById('message-input');
            this.createPicker();
            this.init();
        }
        createPicker() {
            if(document.querySelector('.emoji-picker')) return;
            this.picker = document.createElement('div');
            this.picker.className = 'emoji-picker';
            this.picker.innerHTML = `<div class="emoji-grid"></div>`;
            document.querySelector('.input-area').appendChild(this.picker);
            this.emojiGrid = this.picker.querySelector('.emoji-grid');
        }
        init() {
            const emojis = ['😀','😁','😂','🤣','😃','😄','😅','😉','😊','😍','🥰','😘','😎','😭','😤','😡','👍','👎','❤️','💔','🎉','🔥','💯'];
            emojis.forEach(emoji => {
                const el = document.createElement('div');
                el.className = 'emoji-item';
                el.textContent = emoji;
                el.onclick = () => {
                    this.messageInput.value += emoji;
                    this.messageInput.dispatchEvent(new Event('input'));
                };
                this.emojiGrid.appendChild(el);
            });
            this.toggleBtn.addEventListener('click', (e) => { e.stopPropagation(); this.picker.classList.toggle('show'); });
            document.addEventListener('click', (e) => {
                if(this.picker.classList.contains('show') && !this.picker.contains(e.target) && e.target !== this.toggleBtn) {
                    this.picker.classList.remove('show');
                }
            });
        }
    }
    new EmojiPickerManager();

    // 7. REACT & RECALL LOGIC
    window.toggleReactionPopup = function(id) {
        document.querySelectorAll('.reaction-popup').forEach(el => el.classList.remove('show'));
        const p = document.getElementById('popup-' + id);
        if(p) p.classList.toggle('show');
    };

    window.submitReaction = function(msgId, type) {
        toggleReactionPopup(msgId);
        fetch(`/conversations/messages/${msgId}/react`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': window.chatConfig.csrfToken },
            body: JSON.stringify({ reaction: type })
        }).then(r => r.json()).then(d => { if(d.success) location.reload(); });
    };

    window.recallMessage = function(msgId) {
        if(confirm('Thu hồi?')) {
            fetch(`/conversations/messages/${msgId}/recall`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': window.chatConfig.csrfToken }
            }).then(r=>r.json()).then(d => { if(d.success) location.reload(); });
        }
    };

    window.deleteMessage = function(msgId) {
        if(confirm('Xóa?')) {
            fetch(`/conversations/messages/${msgId}/delete`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': window.chatConfig.csrfToken }
            }).then(r=>r.json()).then(d => { if(d.success) document.getElementById('msg-'+msgId).remove(); });
        }
    };

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.reaction-trigger') && !e.target.closest('.reaction-popup')) {
            document.querySelectorAll('.reaction-popup').forEach(el => el.classList.remove('show'));
        }
    });

    // 8. POLLING (Heartbeat & Realtime fallback)
    let lastMsgId = {{ $messages->last()->message_id ?? 0 }};
    setInterval(() => {
        fetch(`/conversations/${window.chatConfig.conversationId}/messages/latest?after_id=${lastMsgId}`)
            .then(r => r.json())
            .then(data => {
                if(data.success && data.messages.length > 0) {
                    data.messages.forEach(msg => {
                        if(msg.sender_id != window.chatConfig.currentUserId) {
                            appendMessage(msg, false);
                            document.getElementById('msg-sound').play().catch(()=>{});
                        }
                        lastMsgId = msg.message_id;
                    });
                }
            });
    }, 1500);

</script>
@endpush