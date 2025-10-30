/**
 * chat-init.ts
 * Khởi tạo và quản lý chat functionality
 * ✅ Đợi Echo sẵn sàng trước khi khởi tạo
 * ✅ Xử lý form gửi tin nhắn
 * ✅ Typing indicator
 * ✅ Auto-resize textarea
 */

import { ChatManager } from './ChatManager';

/* eslint-disable @typescript-eslint/no-explicit-any */

let chatManager: ChatManager | null = null;

/**
 * Đợi Echo sẵn sàng
 * Timeout sau 10 giây nếu Echo không khởi tạo được
 */
async function waitForEcho(maxWait: number = 10000): Promise<boolean> {
    const startTime = Date.now();
    
    console.log('⏳ Waiting for Echo to initialize...');
    
    while (!window.Echo) {
        // Check timeout
        if (Date.now() - startTime > maxWait) {
            console.error('❌ Echo initialization timeout after', maxWait, 'ms');
            return false;
        }
        
        // Wait 100ms before checking again
        await new Promise(resolve => setTimeout(resolve, 100));
    }
    
    console.log('✅ Echo is ready after', Date.now() - startTime, 'ms');
    return true;
}

/**
 * Khởi tạo chat
 * @param conversationId ID của conversation
 * @param currentUserId ID của user hiện tại
 * @param currentUserName Tên của user hiện tại
 */
export async function initializeChat(
    conversationId: number,
    currentUserId: number,
    currentUserName: string = 'You'
): Promise<void> {
    console.log('🚀 Initializing chat...', { 
        conversationId, 
        currentUserId, 
        currentUserName 
    });

    try {
        // Đợi Echo sẵn sàng
        const echoReady = await waitForEcho();
        
        if (!echoReady) {
            console.warn('⚠️ Echo not available, chat will work in polling mode');
            // Vẫn tiếp tục khởi tạo - ChatManager sẽ fallback sang polling
        }

        // Kiểm tra các element cần thiết
        const messagesArea = document.getElementById('messages-area');
        const messageForm = document.getElementById('message-form');
        const messageInput = document.getElementById('message-input');
        
        if (!messagesArea || !messageForm || !messageInput) {
            console.error('❌ Required chat elements not found');
            return;
        }

        // Tạo ChatManager instance
        chatManager = new ChatManager(conversationId, currentUserId, currentUserName);
        console.log('✅ ChatManager created');

        // Setup form gửi tin nhắn
        setupMessageForm(conversationId, currentUserName);
        console.log('✅ Message form setup complete');

        // Setup auto-resize textarea
        setupTextareaResize();
        console.log('✅ Textarea auto-resize setup complete');

        // Cleanup khi rời trang
        window.addEventListener('beforeunload', handleBeforeUnload);
        console.log('✅ Cleanup handler registered');

        // Scroll to bottom
        scrollToBottom();

        console.log('✅ Chat initialized successfully');

    } catch (error) {
        console.error('❌ Chat initialization failed:', error);
        alert('Failed to initialize chat. Please refresh the page.');
    }
}

/**
 * Setup form gửi tin nhắn
 */
function setupMessageForm(conversationId: number, currentUserName: string): void {
    const form = document.getElementById('message-form') as HTMLFormElement;
    const input = document.getElementById('message-input') as HTMLTextAreaElement;
    const sendBtn = document.getElementById('send-btn') as HTMLButtonElement;

    if (!form || !input || !sendBtn) {
        console.error('❌ Message form elements not found');
        return;
    }

    // Xử lý submit form
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        await handleSendMessage(conversationId, currentUserName);
    });

    // Enter để gửi, Shift+Enter để xuống dòng
    input.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            form.dispatchEvent(new Event('submit'));
        }
    });

    // Typing indicator
    let typingTimer: number;
    input.addEventListener('input', () => {
        // Gửi tín hiệu đang typing
        if (input.value.trim()) {
            chatManager?.sendTypingSignal(true);
        }

        // Clear timer cũ
        if (typingTimer) {
            clearTimeout(typingTimer);
        }

        // Dừng typing sau 2 giây không gõ
        typingTimer = window.setTimeout(() => {
            chatManager?.sendTypingSignal(false);
        }, 2000);
    });

    // Dừng typing khi blur
    input.addEventListener('blur', () => {
        chatManager?.sendTypingSignal(false);
        if (typingTimer) {
            clearTimeout(typingTimer);
        }
    });

    console.log('✅ Message form event listeners attached');
}

/**
 * Xử lý gửi tin nhắn
 */
async function handleSendMessage(
    conversationId: number, 
    currentUserName: string
): Promise<void> {
    const input = document.getElementById('message-input') as HTMLTextAreaElement;
    const sendBtn = document.getElementById('send-btn') as HTMLButtonElement;

    if (!input || !sendBtn) return;

    const content = input.value.trim();
    
    if (!content) {
        console.warn('⚠️ Empty message, not sending');
        return;
    }

    // Disable input
    sendBtn.disabled = true;
    const originalHTML = sendBtn.innerHTML;
    sendBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    input.disabled = true;

    try {
        console.log('📤 Sending message:', content.substring(0, 50) + '...');

        const csrfToken = document.querySelector<HTMLMetaElement>(
            'meta[name="csrf-token"]'
        )?.content || '';

        const response = await fetch(`/conversations/${conversationId}/messages`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                content,
                message_type: 'text'
            })
        });

        const data = await response.json();

        if (response.ok && data.success && data.data) {
            console.log('✅ Message sent successfully:', data.data.message_id);

            // Thêm tin nhắn vào UI
            addSentMessage(data.data, currentUserName);

            // Reset input
            input.value = '';
            input.style.height = 'auto';

            // Dừng typing indicator
            chatManager?.sendTypingSignal(false);

            // Scroll to bottom
            scrollToBottom();

        } else {
            console.error('❌ Send failed:', data);
            alert('Failed to send message: ' + (data.message || 'Unknown error'));
        }

    } catch (error) {
        console.error('❌ Send error:', error);
        alert('Network error. Please check your connection and try again.');
    } finally {
        // Re-enable input
        sendBtn.disabled = false;
        sendBtn.innerHTML = originalHTML;
        input.disabled = false;
        input.focus();
    }
}

/**
 * Thêm tin nhắn đã gửi vào UI
 */
function addSentMessage(message: any, currentUserName: string): void {
    const messagesArea = document.getElementById('messages-area');
    if (!messagesArea) return;

    // Xóa empty state nếu có
    const emptyState = messagesArea.querySelector('.empty-messages');
    if (emptyState) {
        emptyState.remove();
    }

    // Kiểm tra trùng lặp
    if (document.querySelector(`[data-message-id="${message.message_id}"]`)) {
        console.warn('⚠️ Message already exists:', message.message_id);
        return;
    }

    // Format time
    const time = new Date(message.sent_at);
    const timeStr = time.toLocaleTimeString('en-US', {
        hour: 'numeric',
        minute: '2-digit',
        hour12: true
    });

    // Get sender info
    const senderName = message.sender
        ? `${message.sender.first_name || ''} ${message.sender.last_name || ''}`.trim()
        : currentUserName;

    const avatarUrl = message.sender?.avatar_url || '/images/default-avatar.png';

    // Create HTML
    const html = `
        <div class="message-wrapper sent" data-message-id="${message.message_id}">
            <div class="message-content">
                <div class="message-bubble">
                    <p class="message-text">${escapeHtml(message.content)}</p>
                </div>
                <div class="message-time">${timeStr}</div>
            </div>
            <img src="${avatarUrl}" 
                 alt="${senderName}" 
                 class="message-avatar">
        </div>
    `;

    messagesArea.insertAdjacentHTML('beforeend', html);
    console.log('✅ Message added to UI:', message.message_id);
}

/**
 * Setup auto-resize cho textarea
 */
function setupTextareaResize(): void {
    const input = document.getElementById('message-input') as HTMLTextAreaElement;
    
    if (!input) return;

    input.addEventListener('input', () => {
        input.style.height = 'auto';
        input.style.height = input.scrollHeight + 'px';
    });

    console.log('✅ Textarea auto-resize enabled');
}

/**
 * Scroll to bottom của messages area
 */
function scrollToBottom(): void {
    const messagesArea = document.getElementById('messages-area');
    if (messagesArea) {
        messagesArea.scrollTop = messagesArea.scrollHeight;
    }
}

/**
 * Escape HTML để tránh XSS
 */
function escapeHtml(text: string): string {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

/**
 * Cleanup trước khi rời trang
 */
function handleBeforeUnload(): void {
    if (chatManager) {
        chatManager.destroy();
        chatManager = null;
    }
    console.log('🧹 Chat cleanup completed');
}

/**
 * Gán vào window để có thể gọi từ blade template
 * Types được khai báo trong global.d.ts
 */
(window as any).initializeChat = initializeChat;

// Export default
export default initializeChat;