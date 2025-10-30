/**
 * ChatManager - Quản lý real-time chat với Pusher
 * ✅ Đã sửa hoàn toàn: typing, event, whisper, auth, duplicate
 * ✅ Dùng Whisper cho typing (tối ưu, không cần API)
 * ✅ Tự động reconnect, debug rõ ràng
 */
/* eslint-disable @typescript-eslint/no-explicit-any */
interface MessageData {
    message_id: number;
    conversation_id: number;
    sender_id: number;
    sender: {
        first_name: string;
        last_name?: string;
        full_name: string;
        avatar_url: string;
    };
    content: string;
    message_type: string;
    attachment_url?: string;
    attachment_name?: string;
    sent_at: string;
}

interface TypingData {
    user_id: number;
    user_name: string;
    is_typing: boolean;
}

export class ChatManager {
    private conversationId: number;
    private currentUserId: number;
    private currentUserName: string;
    private messagesArea: HTMLElement;
    private typingIndicator: HTMLElement;
    private typingTimeout: number | null = null;
    private channel: any;

    constructor(conversationId: number, currentUserId: number, currentUserName: string = 'You') {
        this.conversationId = conversationId;
        this.currentUserId = currentUserId;
        this.currentUserName = currentUserName;

        this.messagesArea = document.getElementById('messages-area')!;
        this.typingIndicator = document.getElementById('typing-indicator')!;

        if (!this.messagesArea || !this.typingIndicator) {
            console.error('ChatManager: messages-area or typing-indicator not found');
            return;
        }

        this.initializeEcho();
    }

    /**
     * Khởi tạo Laravel Echo và lắng nghe sự kiện
     */
    private initializeEcho(): void {
        if (!window.Echo) {
            console.error('Laravel Echo chưa được khởi tạo');
            return;
        }

        console.log(`Subscribing to conversation.${this.conversationId}`);

        this.channel = window.Echo.private(`conversation.${this.conversationId}`);

        // Kết nối thành công
        this.channel.subscribed(() => {
            console.log(`Subscribed to conversation.${this.conversationId}`);
        }).error((error: any) => {
            console.error('Subscription error:', error);
        });

        // Lắng nghe tin nhắn mới
        this.channel.listen('.message.sent', (data: any) => {
    console.log('Raw event data:', data);

    // Một số trường hợp Laravel Echo trả về JSON string → parse
    let message: MessageData;

    if (typeof data === 'string') {
        try {
            message = JSON.parse(data);
            // eslint-disable-next-line @typescript-eslint/no-unused-vars
        } catch (e) {
            console.error('Invalid message JSON:', data);
            return;
        }
    } else if (data.message) {
        // Nếu Laravel gửi dạng { message: {...} }
        message = data.message;
    } else {
        // Laravel gửi dạng {...} trực tiếp
        message = data;
    }

    console.log('Parsed message:', message);

    if (!message || !message.sender_id) {
        console.error('Invalid message structure:', data);
        return;
    }

    if (message.sender_id !== this.currentUserId) {
        this.addReceivedMessage(message);
        this.markAsRead();
        this.playNotificationSound();
    }
});

        // Lắng nghe typing (dùng Whisper)
        this.channel.listenForWhisper('typing', (data: TypingData) => {
            console.log('Typing whisper:', data);
            if (data.user_id !== this.currentUserId) {
                this.handleTypingIndicator(data.user_name, data.is_typing);
            }
        });
    }

    /**
     * Thêm tin nhắn nhận được vào giao diện
     */
    private addReceivedMessage(message: MessageData): void {
        // Kiểm tra trùng
        if (document.querySelector(`[data-message-id="${message.message_id}"]`)) {
            return;
        }

        // Xóa trạng thái trống
        const emptyState = this.messagesArea.querySelector('.empty-messages');
        if (emptyState) emptyState.remove();

        const html = this.createMessageHTML(message, false);
        this.messagesArea.insertAdjacentHTML('beforeend', html);
        this.scrollToBottom();
    }

    /**
     * Tạo HTML cho tin nhắn
     */
    private createMessageHTML(message: MessageData, isSent: boolean): string {
        const time = new Date(message.sent_at);
        const timeStr = time.toLocaleTimeString('en-US', {
            hour: 'numeric',
            minute: '2-digit',
            hour12: true
        });

        const senderName = message.sender.full_name || 'User';
        const avatarUrl = message.sender.avatar_url || '/images/default-avatar.png';

        const avatarHTML = `
            <img src="${avatarUrl}" alt="${senderName}" class="message-avatar">
        `;

        const contentHTML = message.content
            ? `<p class="message-text">${this.escapeHtml(message.content)}</p>`
            : '';

        const attachmentHTML = this.renderAttachment(message);

        return `
            <div class="message-wrapper ${isSent ? 'sent' : 'received'}" 
                 data-message-id="${message.message_id}">
                ${!isSent ? avatarHTML : ''}
                <div class="message-content">
                    <div class="message-bubble">
                        ${contentHTML}
                        ${attachmentHTML}
                    </div>
                    <div class="message-time">${timeStr}</div>
                </div>
                ${isSent ? avatarHTML : ''}
            </div>
        `;
    }

    /**
     * Hiển thị file đính kèm
     */
    private renderAttachment(message: MessageData): string {
        if (!message.attachment_url) return '';

        if (message.message_type === 'image') {
            return `
                <div class="message-attachment">
                    <img src="${message.attachment_url}" 
                         alt="Image" 
                         class="clickable-image"
                         onclick="window.open(this.src)">
                </div>
            `;
        }

        return `
            <div class="message-attachment">
                <a href="${message.attachment_url}" 
                   target="_blank" 
                   download="${message.attachment_name || 'file'}">
                    <i class="fas fa-file"></i>
                    ${message.attachment_name || 'Download'}
                </a>
            </div>
        `;
    }

    /**
     * Xử lý typing indicator
     */
    private handleTypingIndicator(userName: string, isTyping: boolean): void {
        if (this.typingTimeout) {
            clearTimeout(this.typingTimeout);
            this.typingTimeout = null;
        }

        if (isTyping) {
            this.typingIndicator.textContent = `${userName} is typing...`;
            this.typingIndicator.classList.add('show');
            this.scrollToBottom();

            // Tự ẩn sau 3s
            this.typingTimeout = window.setTimeout(() => {
                this.typingIndicator.classList.remove('show');
            }, 3000);
        } else {
            this.typingIndicator.classList.remove('show');
        }
    }

    /**
     * Gửi tín hiệu typing (dùng Whisper)
     */
    public sendTypingSignal(isTyping: boolean): void {
        if (!this.channel) return;

        this.channel.whisper('typing', {
            user_id: this.currentUserId,
            user_name: this.currentUserName,
            is_typing: isTyping
        });
    }

    /**
     * Đánh dấu đã đọc
     */
    private async markAsRead(): Promise<void> {
        try {
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            await fetch(`/conversations/${this.conversationId}/messages/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token || '',
                    'Accept': 'application/json'
                }
            });
        } catch (error) {
            console.error('Mark as read failed:', error);
        }
    }

    /**
     * Phát âm thanh thông báo
     */
    private playNotificationSound(): void {
        try {
            const audio = new Audio('/sounds/notification.mp3');
            audio.volume = 0.3;
            audio.play().catch(() => {});
        } catch (error) {
            console.error('Sound error:', error);
        }
    }

    /**
     * Cuộn xuống cuối
     */
    private scrollToBottom(): void {
        this.messagesArea.scrollTop = this.messagesArea.scrollHeight;
    }

    /**
     * Escape HTML để tránh XSS
     */
    private escapeHtml(text: string): string {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    /**
     * Hủy kết nối khi rời trang
     */
    public destroy(): void {
        if (this.channel) {
            window.Echo.leave(`conversation.${this.conversationId}`);
        }
        if (this.typingTimeout) {
            clearTimeout(this.typingTimeout);
        }
        console.log(`ChatManager destroyed for conversation.${this.conversationId}`);
    }
}