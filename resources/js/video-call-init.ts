/**
 * video-call-init.ts
 * Initialize video call functionality from chat page
 */
/* eslint-disable @typescript-eslint/no-unused-vars */
/* eslint-disable @typescript-eslint/no-explicit-any */
interface VideoCallConfig {
    currentUserId: number;
    receiverId: number;
    conversationId: number;
}

class VideoCallInitializer {
    private config: VideoCallConfig;
    private isListening: boolean = false;

    constructor(currentUserId: number, receiverId: number, conversationId: number) {
        this.config = {
            currentUserId,
            receiverId,
            conversationId
        };

        console.log('📞 Video call initializer created:', this.config);
    }

    /**
     * Setup call button listeners
     */
    setupCallButtons(): void {
        const videoBtn = document.getElementById('start-video-call');
        const voiceBtn = document.getElementById('start-voice-call');

        if (videoBtn) {
            videoBtn.addEventListener('click', () => this.initiateCall('video'));
            console.log('✅ Video call button listener attached');
        }

        if (voiceBtn) {
            voiceBtn.addEventListener('click', () => this.initiateCall('audio'));
            console.log('✅ Voice call button listener attached');
        }
    }

    /**
     * Listen for incoming calls via Echo
     */
    listenForIncomingCalls(): void {
        if (this.isListening) {
            console.warn('⚠️ Already listening for incoming calls');
            return;
        }

        if (!(window as any).Echo) {
            console.error('❌ Echo not available for video call');
            return;
        }

        const channel = `user.${this.config.currentUserId}`;
        
        (window as any).Echo.private(channel)
            .listen('.call.invitation', (data: any) => {
                console.log('📞 Incoming call notification:', data);
                this.handleIncomingCall(data);
            });

        this.isListening = true;
        console.log(`✅ Listening for calls on channel: ${channel}`);
    }

    /**
     * Initiate a new call
     */
    private async initiateCall(callType: 'video' | 'audio'): Promise<void> {
        try {
            console.log(`🚀 Initiating ${callType} call...`);

            // Disable buttons
            this.setCallButtonsDisabled(true);

            // Show loading
            this.showLoading(`Starting ${callType} call...`);

            const response = await fetch('/api/video-calls/initiate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.getCSRFToken()
                },
                body: JSON.stringify({
                    conversation_id: this.config.conversationId,
                    call_type: callType
                })
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.error || 'Failed to initiate call');
            }

            console.log('✅ Call initiated successfully:', data);

            // Redirect to call room
            window.location.href = `/video-calls/${data.call_id}/room`;

        } catch (error) {
            console.error('❌ Failed to initiate call:', error);
            this.hideLoading();
            this.setCallButtonsDisabled(false);
            alert(`Failed to start call: ${(error as Error).message}`);
        }
    }

    /**
     * Handle incoming call
     */
    private handleIncomingCall(data: any): void {
        const { callId, roomId, caller, callType } = data;

        console.log('📞 Processing incoming call:', {
            callId,
            roomId,
            caller,
            callType
        });

        // Show incoming call modal
        this.showIncomingCallModal({
            callId,
            roomId,
            callerName: caller.name,
            callerAvatar: caller.avatar || '/images/default-avatar.png',
            callType
        });

        // Play ringtone
        this.playRingtone();
    }

    /**
     * Show incoming call modal
     */
    private showIncomingCallModal(callData: any): void {
        // Remove existing modal if any
        this.removeIncomingCallModal();

        const modal = document.createElement('div');
        modal.id = 'incoming-call-modal';
        modal.className = 'incoming-call-modal';
        modal.innerHTML = `
            <div class="incoming-call-overlay"></div>
            <div class="incoming-call-content">
                <div class="incoming-call-header">
                    <i class="fas fa-${callData.callType === 'video' ? 'video' : 'phone'}"></i>
                    <h3>Incoming ${callData.callType === 'video' ? 'Video' : 'Voice'} Call</h3>
                </div>
                
                <div class="incoming-call-body">
                    <div class="caller-avatar">
                        <img src="${callData.callerAvatar}" alt="${callData.callerName}">
                    </div>
                    <h4 class="caller-name">${callData.callerName}</h4>
                    <p class="call-type">${callData.callType === 'video' ? 'Video' : 'Voice'} call</p>
                </div>

                <div class="incoming-call-actions">
                    <button class="call-action-btn btn-decline" id="decline-call-btn">
                        <i class="fas fa-phone-slash"></i>
                        Decline
                    </button>
                    <button class="call-action-btn btn-accept" id="accept-call-btn">
                        <i class="fas fa-phone"></i>
                        Accept
                    </button>
                </div>
            </div>
        `;

        document.body.appendChild(modal);

        // Attach event listeners
        const acceptBtn = document.getElementById('accept-call-btn');
        const declineBtn = document.getElementById('decline-call-btn');

        acceptBtn?.addEventListener('click', () => this.acceptCall(callData.callId));
        declineBtn?.addEventListener('click', () => this.declineCall(callData.callId));

        console.log('✅ Incoming call modal displayed');
    }

    /**
     * Accept incoming call
     */
    private async acceptCall(callId: number): Promise<void> {
        try {
            console.log('✅ Accepting call:', callId);

            this.showLoading('Joining call...');

            const response = await fetch('/api/video-calls/accept', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.getCSRFToken()
                },
                body: JSON.stringify({ call_id: callId })
            });

            if (!response.ok) {
                throw new Error('Failed to accept call');
            }

            console.log('✅ Call accepted, redirecting to room...');

            // Stop ringtone
            this.stopRingtone();

            // Remove modal
            this.removeIncomingCallModal();

            // Redirect to call room
            window.location.href = `/video-calls/${callId}/room`;

        } catch (error) {
            console.error('❌ Failed to accept call:', error);
            this.hideLoading();
            alert(`Failed to accept call: ${(error as Error).message}`);
        }
    }

    /**
     * Decline incoming call
     */
    private async declineCall(callId: number): Promise<void> {
        try {
            console.log('❌ Declining call:', callId);

            const response = await fetch('/api/video-calls/decline', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.getCSRFToken()
                },
                body: JSON.stringify({ call_id: callId })
            });

            if (!response.ok) {
                throw new Error('Failed to decline call');
            }

            console.log('✅ Call declined successfully');

            // Stop ringtone
            this.stopRingtone();

            // Remove modal
            this.removeIncomingCallModal();

        } catch (error) {
            console.error('❌ Failed to decline call:', error);
            this.removeIncomingCallModal();
        }
    }

    /**
     * Helper: Get CSRF token
     */
    private getCSRFToken(): string {
        return document.querySelector<HTMLMetaElement>('meta[name="csrf-token"]')?.content || '';
    }

    /**
     * Helper: Set call buttons disabled state
     */
    private setCallButtonsDisabled(disabled: boolean): void {
        const videoBtn = document.getElementById('start-video-call') as HTMLButtonElement;
        const voiceBtn = document.getElementById('start-voice-call') as HTMLButtonElement;

        if (videoBtn) videoBtn.disabled = disabled;
        if (voiceBtn) voiceBtn.disabled = disabled;
    }

    /**
     * Helper: Show loading overlay
     */
    private showLoading(message: string = 'Loading...'): void {
        let overlay = document.getElementById('loading-overlay');
        
        if (!overlay) {
            overlay = document.createElement('div');
            overlay.id = 'loading-overlay';
            overlay.className = 'loading-overlay';
            overlay.innerHTML = `
                <div class="loading-content">
                    <div class="loading-spinner"></div>
                    <p id="loading-text">${message}</p>
                </div>
            `;
            document.body.appendChild(overlay);
        }

        overlay.classList.add('show');
        const text = document.getElementById('loading-text');
        if (text) text.textContent = message;
    }

    /**
     * Helper: Hide loading overlay
     */
    private hideLoading(): void {
        const overlay = document.getElementById('loading-overlay');
        if (overlay) {
            overlay.classList.remove('show');
        }
    }

    /**
     * Helper: Remove incoming call modal
     */
    private removeIncomingCallModal(): void {
        const modal = document.getElementById('incoming-call-modal');
        if (modal) {
            modal.remove();
            console.log('✅ Incoming call modal removed');
        }
    }

    /**
     * Helper: Play ringtone
     */
    private playRingtone(): void {
        const ringtone = document.getElementById('ringtone-audio') as HTMLAudioElement;
        if (ringtone) {
            ringtone.play().catch(error => {
                console.warn('⚠️ Could not play ringtone:', error);
            });
        }
    }

    /**
     * Helper: Stop ringtone
     */
    private stopRingtone(): void {
        const ringtone = document.getElementById('ringtone-audio') as HTMLAudioElement;
        if (ringtone) {
            ringtone.pause();
            ringtone.currentTime = 0;
        }
    }

    /**
     * Cleanup
     */
    destroy(): void {
        this.stopRingtone();
        this.removeIncomingCallModal();
        console.log('🧹 Video call initializer destroyed');
    }
}

/**
 * Initialize video call functionality
 */
export async function initializeVideoCall(
    currentUserId: number,
    receiverId: number,
    isInitiator: boolean = true
): Promise<VideoCallInitializer | null> {
    try {
        // Validate parameters
        if (!currentUserId || !receiverId) {
            console.error('❌ Invalid user IDs for video call:', { currentUserId, receiverId });
            return null;
        }

        // Get conversation ID from window
        const conversationId = (window as any).conversationId || (window as any).chatConfig?.conversationId;

        if (!conversationId) {
            console.error('❌ Conversation ID not found');
            return null;
        }

        // Create initializer
        const initializer = new VideoCallInitializer(currentUserId, receiverId, conversationId);

        // Setup call buttons
        initializer.setupCallButtons();

        // Listen for incoming calls
        initializer.listenForIncomingCalls();

        console.log('✅ Video call initialized successfully');

        return initializer;

    } catch (error) {
        console.error('❌ Video call initialization failed:', error);
        return null;
    }
}

// Export class for direct usage
export { VideoCallInitializer };

// Make available globally for debugging
(window as any).initializeVideoCall = initializeVideoCall;