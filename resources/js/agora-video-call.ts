/**
 * agora-video-call.ts
 * Agora WebRTC Video Call Implementation
 */
/* eslint-disable @typescript-eslint/no-unused-vars */
/* eslint-disable @typescript-eslint/no-explicit-any */
import AgoraRTC, {
    IAgoraRTCClient,
    ICameraVideoTrack,
    IMicrophoneAudioTrack,
    IRemoteVideoTrack,
    IRemoteAudioTrack
} from 'agora-rtc-sdk-ng';

interface VideoCallConfig {
    callId: number;
    conversationId: number;
    currentUserId: number;
    receiverId: number;
    callType: 'video' | 'audio';
    isInitiator: boolean;
    participantName: string;
}

class AgoraVideoCall {
    private client: IAgoraRTCClient | null = null;
    private localAudioTrack: IMicrophoneAudioTrack | null = null;
    private localVideoTrack: ICameraVideoTrack | null = null;
    private remoteUsers: Map<number, any> = new Map();
    private config: VideoCallConfig;
    private isJoined: boolean = false;

    constructor(config: VideoCallConfig) {
        this.config = config;
        this.initializeClient();
    }

    private initializeClient() {
        this.client = AgoraRTC.createClient({
            mode: 'rtc',
            codec: 'vp8'
        });

        this.setupEventHandlers();
    }

    private setupEventHandlers() {
        if (!this.client) return;

        // User published (remote user shares audio/video)
        this.client.on('user-published', async (user, mediaType) => {
            await this.client!.subscribe(user, mediaType);
            console.log('Subscribe success:', user.uid, mediaType);

            if (mediaType === 'video') {
                const remoteVideoTrack = user.videoTrack;
                const remoteVideoContainer = document.getElementById('remote-video');
                if (remoteVideoContainer && remoteVideoTrack) {
                    remoteVideoTrack.play(remoteVideoContainer);
                    this.hideRemotePlaceholder();
                }
            }

            if (mediaType === 'audio') {
                const remoteAudioTrack = user.audioTrack;
                remoteAudioTrack?.play();
            }

            this.remoteUsers.set(user.uid as number, user);
            this.updateCallStatus('Connected');
        });

        // User unpublished
        this.client.on('user-unpublished', (user, mediaType) => {
            console.log('User unpublished:', user.uid, mediaType);
            if (mediaType === 'video') {
                this.showRemotePlaceholder();
            }
        });

        // User left
        this.client.on('user-left', (user) => {
            console.log('User left:', user.uid);
            this.remoteUsers.delete(user.uid as number);
            this.showRemotePlaceholder();
            this.handleCallEnded();
        });

        // Connection state changed
        this.client.on('connection-state-change', (curState, prevState) => {
            console.log('Connection state:', prevState, '->', curState);
            if (curState === 'DISCONNECTED') {
                this.handleCallEnded();
            }
        });
    }

    async joinCall(roomId: string): Promise<void> {
        try {
            if (!this.client) throw new Error('Client not initialized');

            // Get Agora token from server
            const tokenData = await this.getAgoraToken(roomId);
            console.log('Token from server:', tokenData);
            
            // Join channel
            await this.client.join(
                tokenData.appId,
                roomId,
                tokenData.token,
                this.config.currentUserId
            );

            this.isJoined = true;
            console.log('Joined channel:', roomId);

            // Create and publish local tracks
            await this.createLocalTracks();
            await this.publishLocalTracks();

            this.updateCallStatus('Connected');
            this.startCallTimer();

        } catch (error) {
            console.error('Failed to join call:', error);
            alert('Failed to join call. Please try again.');
            throw error;
        }
    }

    private async getAgoraToken(channel: string): Promise<any> {
    const response = await fetch('/api/video-calls/token', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        body: JSON.stringify({ channel })
    });

    if (!response.ok) {
        const err = await response.text();
        console.error('Token error:', err);
        throw new Error('Failed to get token');
    }

    const data = await response.json();
    
    // LOG ĐỂ KIỂM TRA
    console.log('AGORA TOKEN DATA:', data);

    // ĐẢM BẢO appId không bị null
    if (!data.appId) {
        throw new Error('appId is missing from token response');
    }

    return {
        token: data.token,
        uid: data.uid,
        appId: data.appId  // ← chắc chắn có
    };
}

    private async createLocalTracks(): Promise<void> {
        try {
            // Create audio track
            this.localAudioTrack = await AgoraRTC.createMicrophoneAudioTrack();

            // Create video track if video call
            if (this.config.callType === 'video') {
                this.localVideoTrack = await AgoraRTC.createCameraVideoTrack({
                    encoderConfig: '720p_2'
                });

                // Play local video
                const localVideoContainer = document.getElementById('local-video');
                if (localVideoContainer && this.localVideoTrack) {
                    this.localVideoTrack.play(localVideoContainer);
                    this.hideLocalPlaceholder();
                }
            }

        } catch (error) {
            console.error('Failed to create local tracks:', error);
            throw error;
        }
    }

    private async publishLocalTracks(): Promise<void> {
        try {
            if (!this.client) return;

            const tracks: any[] = [];
            if (this.localAudioTrack) tracks.push(this.localAudioTrack);
            if (this.localVideoTrack) tracks.push(this.localVideoTrack);

            if (tracks.length > 0) {
                await this.client.publish(tracks);
                console.log('Published local tracks');
            }
        } catch (error) {
            console.error('Failed to publish tracks:', error);
            throw error;
        }
    }

    async toggleAudio(): Promise<boolean> {
        if (!this.localAudioTrack) return false;
        
        const enabled = this.localAudioTrack.enabled;
        await this.localAudioTrack.setEnabled(!enabled);
        return !enabled;
    }

    async toggleVideo(): Promise<boolean> {
        if (!this.localVideoTrack) return false;
        
        const enabled = this.localVideoTrack.enabled;
        await this.localVideoTrack.setEnabled(!enabled);
        
        // Show/hide camera off badge
        const badge = document.getElementById('camera-off-badge');
        if (badge) {
            badge.style.display = enabled ? 'block' : 'none';
        }
        
        return !enabled;
    }

    async leaveCall(): Promise<void> {
        try {
            // Close local tracks
            if (this.localAudioTrack) {
                this.localAudioTrack.close();
                this.localAudioTrack = null;
            }
            
            if (this.localVideoTrack) {
                this.localVideoTrack.close();
                this.localVideoTrack = null;
            }

            // Leave channel
            if (this.client && this.isJoined) {
                await this.client.leave();
                this.isJoined = false;
            }

            console.log('Left call successfully');
        } catch (error) {
            console.error('Error leaving call:', error);
        }
    }

    private hideRemotePlaceholder() {
        const placeholder = document.getElementById('remote-placeholder');
        if (placeholder) placeholder.style.display = 'none';
    }

    private showRemotePlaceholder() {
        const placeholder = document.getElementById('remote-placeholder');
        if (placeholder) placeholder.style.display = 'flex';
    }

    private hideLocalPlaceholder() {
        const placeholder = document.getElementById('local-placeholder');
        if (placeholder) placeholder.style.display = 'none';
    }

    private updateCallStatus(status: string) {
        const statusEl = document.getElementById('call-status');
        if (statusEl) statusEl.textContent = status;
    }

    private startCallTimer() {
        const timerEl = document.getElementById('call-timer');
        if (!timerEl) return;

        let seconds = 0;
        setInterval(() => {
            seconds++;
            const mins = Math.floor(seconds / 60);
            const secs = seconds % 60;
            timerEl.textContent = `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
        }, 1000);
    }

    private async handleCallEnded() {
        await this.endCall();
    }

    async endCall(): Promise<void> {
        try {
            await this.leaveCall();

            // Notify server
            const response = await fetch('/api/video-calls/end', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({ call_id: this.config.callId })
            });

            if (response.ok) {
                window.location.href = `/video-calls/${this.config.callId}/ended`;
            }
        } catch (error) {
            console.error('Error ending call:', error);
        }
    }
}

// Initialize Agora call when page loads
async function initializeAgoraCall() {
    const callData = (window as any).videoCallData;
    if (!callData) {
        console.error('Video call data not found');
        return;
    }

    const agoraCall = new AgoraVideoCall({
        callId: callData.callId,
        conversationId: callData.conversationId,
        currentUserId: callData.currentUserId,
        receiverId: callData.participantId || callData.receiverId,
        callType: callData.callType,
        isInitiator: callData.isInitiator,
        participantName: callData.participantName
    });

    // Auto-join if room exists
    if (callData.roomId) {
        await agoraCall.joinCall(callData.roomId);
    }

    // Setup control buttons
    setupControlButtons(agoraCall);

    // Expose to window for debugging
    (window as any).agoraCall = agoraCall;
}

function setupControlButtons(call: AgoraVideoCall) {
    // Microphone toggle
    const micBtn = document.getElementById('btn-microphone');
    micBtn?.addEventListener('click', async () => {
        const enabled = await call.toggleAudio();
        micBtn.setAttribute('data-state', enabled ? 'on' : 'off');
        const icon = micBtn.querySelector('i');
        if (icon) {
            icon.className = enabled ? 'fas fa-microphone' : 'fas fa-microphone-slash';
        }
        const label = micBtn.querySelector('.control-label');
        if (label) {
            label.textContent = enabled ? 'Mute' : 'Unmute';
        }
    });

    // Camera toggle
    const camBtn = document.getElementById('btn-camera');
    camBtn?.addEventListener('click', async () => {
        const enabled = await call.toggleVideo();
        camBtn.setAttribute('data-state', enabled ? 'on' : 'off');
        const icon = camBtn.querySelector('i');
        if (icon) {
            icon.className = enabled ? 'fas fa-video' : 'fas fa-video-slash';
        }
    });

    // End call button
    const endBtn = document.getElementById('btn-end-call');
    endBtn?.addEventListener('click', async () => {
        if (confirm('End this call?')) {
            await call.endCall();
        }
    });
}

// Export for use in other files
export { AgoraVideoCall, initializeAgoraCall };

// Auto-initialize if on room page
if (document.querySelector('.video-call-room')) {
    document.addEventListener('DOMContentLoaded', initializeAgoraCall);
}