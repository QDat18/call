@extends('layouts.app')

@section('title', 'Video Call Room')

@section('content')
<div class="video-call-room">
    <div class="room-container">
        <!-- Top Header Bar -->
        <div class="call-header">
            <div class="header-left">
                <div class="call-type-badge {{ $callType === 'video' ? 'badge-video' : 'badge-audio' }}">
                    <i class="fas fa-{{ $callType === 'video' ? 'video' : 'phone' }}"></i>
                </div>
                <div class="call-info">
                    <h5 class="mb-0">{{ $participant->first_name }} {{ $participant->last_name }}</h5>
                    <small class="text-muted">
                        <span id="call-status">Connecting...</span>
                        <span class="mx-2">•</span>
                        <span id="call-timer">00:00</span>
                    </small>
                </div>
            </div>
            <div class="header-right">
                <button class="btn-icon btn-minimize" title="Minimize" onclick="toggleMinimize()">
                    <i class="fas fa-minus"></i>
                </button>
                <button class="btn-icon btn-fullscreen" title="Fullscreen" onclick="toggleFullscreen()">
                    <i class="fas fa-expand"></i>
                </button>
            </div>
        </div>

        <!-- Main Video Area -->
        <div class="video-area">
            <!-- Remote Video (Main Display) -->
            <div class="remote-video-container">
                <video 
                    id="remote-video" 
                    class="remote-video"
                    autoplay 
                    playsinline>
                </video>
                
                <!-- Remote Video Placeholder -->
                <div class="video-placeholder" id="remote-placeholder">
                    <div class="placeholder-content">
                        <img 
                            src="{{ $participant->avatar_url ?? asset('images/default-avatar.png') }}" 
                            alt="{{ $participant->first_name }}"
                            class="placeholder-avatar">
                        <h4 class="mt-3 text-white">{{ $participant->first_name }} {{ $participant->last_name }}</h4>
                        <p class="text-white-50">
                            <i class="fas fa-spinner fa-spin me-2"></i>
                            Waiting for {{ $participant->first_name }} to join...
                        </p>
                    </div>
                </div>

                <!-- Connection Status Overlay -->
                <div class="connection-overlay" id="connection-overlay" style="display: none;">
                    <div class="connection-message">
                        <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
                        <h5>Connection Issues</h5>
                        <p id="connection-message">Reconnecting...</p>
                    </div>
                </div>

                <!-- Participant Name Badge -->
                <div class="participant-badge">
                    <i class="fas fa-user me-2"></i>
                    {{ $participant->first_name }}
                </div>

                <!-- Network Quality Indicator -->
                <div class="network-indicator" id="network-indicator">
                    <i class="fas fa-signal"></i>
                    <span class="network-text">Excellent</span>
                </div>
            </div>

            <!-- Local Video (Picture-in-Picture) -->
            @if($callType === 'video')
            <div class="local-video-container" id="local-video-container">
                <video 
                    id="local-video" 
                    class="local-video"
                    autoplay 
                    muted 
                    playsinline>
                </video>
                
                <!-- Local Video Placeholder -->
                <div class="local-placeholder" id="local-placeholder">
                    <img 
                        src="{{ auth()->user()->avatar_url ?? asset('images/local.jpg?v=' . time()) }}" 
                        alt="You"
                        class="local-avatar">
                </div>

                <div class="local-label">You</div>
                
                <!-- Camera Off Badge -->
                <div class="camera-off-badge" id="camera-off-badge" style="display: none;">
                    <i class="fas fa-video-slash"></i>
                </div>
            </div>
            @endif
        </div>

        <!-- Bottom Controls Bar -->
        <div class="controls-bar">
            <div class="controls-container">
                <!-- Left Controls (Info) -->
                <div class="controls-left">
                    <div class="call-id-badge">
                        <i class="fas fa-hashtag me-1"></i>
                        Call ID: {{ $callId }}
                    </div>
                </div>

                <!-- Center Controls (Main Actions) -->
                <div class="controls-center">
                    <!-- Microphone Toggle -->
                    <button 
                        class="control-button" 
                        id="btn-microphone"
                        title="Mute/Unmute"
                        data-state="on">
                        <i class="fas fa-microphone"></i>
                        <span class="control-label">Mute</span>
                    </button>

                    <!-- Camera Toggle -->
                    @if($callType === 'video')
                    <button 
                        class="control-button" 
                        id="btn-camera"
                        title="Turn Camera On/Off"
                        data-state="on">
                        <i class="fas fa-video"></i>
                        <span class="control-label">Camera</span>
                    </button>
                    @endif

                    <!-- Screen Share -->
                    <button 
                        class="control-button" 
                        id="btn-screen-share"
                        title="Share Screen"
                        data-state="off">
                        <i class="fas fa-desktop"></i>
                        <span class="control-label">Share</span>
                    </button>

                    <!-- Settings -->
                    <button 
                        class="control-button" 
                        id="btn-settings"
                        title="Settings"
                        data-bs-toggle="modal"
                        data-bs-target="#settingsModal">
                        <i class="fas fa-cog"></i>
                        <span class="control-label">Settings</span>
                    </button>

                    <!-- End Call Button -->
                    <button 
                        class="control-button btn-end-call" 
                        id="btn-end-call"
                        title="End Call">
                        <i class="fas fa-phone-slash"></i>
                        <span class="control-label">End Call</span>
                    </button>
                </div>

                <!-- Right Controls (Additional) -->
                <div class="controls-right">
                    <!-- Participants Count -->
                    <div class="participants-badge">
                        <i class="fas fa-users me-1"></i>
                        <span>2</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Settings Modal -->
    <div class="modal fade" id="settingsModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-cog mb-2"></i>
                        Call Settings
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Audio Input Device -->
                    <div class="setting-group mb-3">
                        <label class="setting-label">
                            <i class="fas fa-microphone me-2"></i>
                            Microphone
                        </label>
                        <select class="form-select" id="audio-input-select">
                            <option selected>Default - Microphone (Built-in)</option>
                        </select>
                        <button class="btn btn-sm btn-outline-primary mt-2" onclick="testAudio()">
                            <i class="fas fa-volume-up me-1"></i>Test
                        </button>
                    </div>

                    <!-- Audio Output Device -->
                    <div class="setting-group mb-3">
                        <label class="setting-label">
                            <i class="fas fa-volume-up me-2"></i>
                            Speaker
                        </label>
                        <select class="form-select" id="audio-output-select">
                            <option selected>Default - Speaker (Built-in)</option>
                        </select>
                        <button class="btn btn-sm btn-outline-success mt-2" onclick="testSpeaker()">
                            <i class="fas fa-play me-1"></i>Test
                        </button>
                    </div>

                    @if($callType === 'video')
                    <!-- Video Input Device -->
                    <div class="setting-group mb-3">
                        <label class="setting-label">
                            <i class="fas fa-video me-2"></i>
                            Camera
                        </label>
                        <select class="form-select" id="video-input-select">
                            <option selected>Default - Camera (Built-in)</option>
                        </select>
                    </div>

                    <!-- Video Quality -->
                    <div class="setting-group mb-3">
                        <label class="setting-label">
                            <i class="fas fa-film me-2"></i>
                            Video Quality
                        </label>
                        <select class="form-select" id="video-quality-select">
                            <option value="360">Low (360p) - Save Bandwidth</option>
                            <option value="480">Medium (480p)</option>
                            <option value="720" selected>HD (720p)</option>
                            <option value="1080">Full HD (1080p)</option>
                        </select>
                    </div>
                    @endif

                    <!-- Background Blur -->
                    <div class="setting-group mb-3">
                        <label class="setting-label">
                            <i class="fas fa-image me-2"></i>
                            Background Effects
                        </label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="background-blur">
                            <label class="form-check-label" for="background-blur">
                                Enable Background Blur
                            </label>
                        </div>
                    </div>

                    <!-- Connection Stats -->
                    <div class="setting-group">
                        <label class="setting-label">
                            <i class="fas fa-chart-line me-2"></i>
                            Connection Stats
                        </label>
                        <div class="stats-display">
                            <div class="stat-item">
                                <span class="stat-label">Bitrate:</span>
                                <span class="stat-value" id="stat-bitrate">— kbps</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Packet Loss:</span>
                                <span class="stat-value" id="stat-packet-loss">—%</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Latency:</span>
                                <span class="stat-value" id="stat-latency">— ms</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveSettings()">
                        <i class="fas fa-save me-2"></i>Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden Ringtone Audio -->
    <audio id="ringtone-audio" loop>
        <source src="{{ asset('sounds/ringtone.mp3') }}" type="audio/mpeg">
    </audio>
</div>
@endsection

@push('styles')
<style>
:root {
    --primary: #6366f1;
    --secondary: #8b5cf6;
    --success: #10b981;
    --danger: #ef4444;
    --dark: #1f2937;
    --light: #f3f4f6;
    --border: #e5e7eb;
}

.video-call-room {
    height: 100vh;
    background: #000;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.room-container {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.call-header {
    padding: 15px 25px;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    background: white;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.call-type-badge {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: white;
}

.badge-video { background: linear-gradient(135deg, var(--primary), var(--secondary)); }
.badge-audio { background: linear-gradient(135deg, var(--success), #059669); }

.call-info {
    flex: 1;
    margin-left: 15px;
}

.header-right {
    display: flex;
    gap: 10px;
}

.btn-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: none;
    background: var(--light);
    color: var(--dark);
    cursor: pointer;
    transition: all 0.3s;
}

.btn-icon:hover {
    background: var(--primary);
    color: white;
    transform: scale(1.05);
}

.video-area {
    flex: 1;
    position: relative;
    background: #000;
}

.remote-video-container {
    height: 100%;
    position: relative;
}

.remote-video {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.video-placeholder {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    text-align: center;
    color: white;
}

.placeholder-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid rgba(255,255,255,0.3);
    margin-bottom: 15px;
}

.local-video-container {
    position: absolute;
    bottom: 120px;
    right: 20px;
    width: 150px;
    height: 110px;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.5);
    border: 2px solid var(--primary);
    z-index: 10;
}

.local-video {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transform: scaleX(-1);
}

.local-label {
    position: absolute;
    bottom: 5px;
    left: 5px;
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
}

.controls-bar {
    position: absolute;
    bottom: 25px;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(12px);
    border-radius: 40px;
    padding: 8px 14px;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 14px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    z-index: 20;
}

.controls-group {
    display: flex;
    gap: 15px;
}

.control-button {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    border: none;
    background: rgba(255,255,255,0.15);
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    transition: all 0.2s ease;
    position: relative;
}

.controls-center {
    display: flex;
    flex-direction: row; /* 🔥 nằm ngang */
    align-items: center;
    gap: 16px;
}

.control-button:hover {
    background: rgba(255,255,255,0.3);
    transform: scale(1.08);
}

.control-button.active {
    background: var(--success);
    color: white;
}

.btn-end-call {
    background: #ef4444;
}

.btn-end-call:hover {
    background: #dc2626;
}

.control-label {
    display: none; /* Ẩn chữ "Mute", "Camera" để gọn như Messenger */
}

/* Hiệu ứng icon đang bật/tắt */
.control-button[data-state="off"] {
    opacity: 0.6;
}

@media (max-width: 768px) {
    .local-video-container {
        width: 100px;
        height: 75px;
        bottom: 100px;
        right: 10px;
    }

    .control-button {
        width: 48px;
        height: 48px;
        font-size: 18px;
    }

    .controls-group {
        gap: 10px;
    }

    .call-header {
        padding: 12px 15px;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://download.agora.io/sdk/release/AgoraRTC_N-4.20.0.js"></script>

<script>
// ✅ Set global video call data
window.videoCallData = {
    callId: {{ $callId }},
    conversationId: {{ $conversationId }},
    currentUserId: {{ auth()->id() }},
    participantId: {{ $participant->user_id }},
    receiverId: {{ $receiverId }},
    participantName: '{{ $participant->first_name }} {{ $participant->last_name }}',
    callType: '{{ $callType }}',
    isInitiator: {{ $isInitiator ? 'true' : 'false' }},
    roomId: '{{ $roomId }}'
};

console.log('✅ Video call data initialized:', window.videoCallData);

// 🔥 POLLING: Kiểm tra call status mỗi 2 giây
let pollInterval = null;

function startCallStatusPolling() {
    console.log('🔄 Starting call status polling...');
    
    pollInterval = setInterval(async () => {
        try {
            const response = await fetch(`/api/video-calls/${window.videoCallData.callId}/status`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            if (response.ok) {
                const data = await response.json();
                console.log('📊 Call status:', data.status);

                // ✅ Nếu call ended/declined → redirect cả 2 bên
                if (data.status === 'ended' || data.status === 'declined') {
                    console.log('📞 Call ended by other user');
                    stopCallStatusPolling();
                    
                    if (window.agoraCall) {
                        await agoraCall.leaveCall();
                    }
                    
                    window.location.href = `/video-calls/${data.call_id}/ended`;
                }
            }
        } catch (error) {
            console.error('❌ Polling error:', error);
        }
    }, 2000);
}

function stopCallStatusPolling() {
    if (pollInterval) {
        clearInterval(pollInterval);
        pollInterval = null;
        console.log('⏹️ Stopped polling');
    }
}

// Agora Video Call Class
class AgoraVideoCall {
    constructor(config) {
        this.config = config;
        this.client = null;
        this.localAudioTrack = null;
        this.localVideoTrack = null;
        this.remoteUsers = new Map();
        this.isJoined = false;
        
        console.log('📞 AgoraVideoCall constructor:', config);
        this.initializeClient();
    }

    initializeClient() {
        this.client = AgoraRTC.createClient({
            mode: 'rtc',
            codec: 'vp8'
        });

        console.log('✅ Agora client created');
        this.setupEventHandlers();
    }

    setupEventHandlers() {
        this.client.on('user-published', async (user, mediaType) => {
            await this.client.subscribe(user, mediaType);
            console.log('✅ Subscribe success:', user.uid, mediaType);

            if (mediaType === 'video') {
                const remoteVideoContainer = document.getElementById('remote-video');
                if (remoteVideoContainer && user.videoTrack) {
                    user.videoTrack.play(remoteVideoContainer);
                    this.hideRemotePlaceholder();
                }
            }

            if (mediaType === 'audio') {
                user.audioTrack?.play();
            }

            this.remoteUsers.set(user.uid, user);
            this.updateCallStatus('Connected');
        });

        this.client.on('user-unpublished', (user, mediaType) => {
            console.log('❌ User unpublished:', user.uid, mediaType);
            if (mediaType === 'video') {
                this.showRemotePlaceholder();
            }
        });

        this.client.on('user-left', (user) => {
            console.log('👋 User left:', user.uid);
            this.remoteUsers.delete(user.uid);
            this.showRemotePlaceholder();
        });

        this.client.on('connection-state-change', (curState, prevState) => {
            console.log('🔌 Connection state:', prevState, '->', curState);
        });

        this.client.on('network-quality', (stats) => {
            this.updateNetworkQuality(stats.uplinkNetworkQuality);
        });
    }

    async joinCall(roomId) {
        try {
            console.log('🚀 Starting joinCall with roomId:', roomId);

            const tokenData = await this.getAgoraToken(roomId);

            console.log('📝 Token data received:', {
                appId: tokenData.appId,
                token: tokenData.token ? 'present' : 'null (testing mode)',
                uid: tokenData.uid,
                channel: roomId
            });

            if (!tokenData.appId) {
                throw new Error('App ID is missing from server response');
            }

            await this.client.join(
                tokenData.appId,
                roomId,
                tokenData.token,
                this.config.currentUserId
            );

            this.isJoined = true;
            console.log('✅ Joined channel successfully:', roomId);

            await this.createLocalTracks();
            await this.publishLocalTracks();

            this.updateCallStatus('Connected');
            this.startCallTimer();

            // ✅ BẮT ĐẦU POLLING SAU KHI JOIN THÀNH CÔNG
            startCallStatusPolling();

        } catch (error) {
            console.error('❌ Failed to join call:', error);
            alert('Failed to join call: ' + error.message);
            throw error;
        }
    }

    async getAgoraToken(channel) {
        try {
            console.log('🎫 Requesting token for channel:', channel);

            const response = await fetch('/api/video-calls/token', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ channel })
            });

            if (!response.ok) {
                const errorText = await response.text();
                console.error('❌ Token request failed:', errorText);
                throw new Error('Failed to get token from server');
            }

            const data = await response.json();
            console.log('✅ Token response:', data);

            if (!data.app_id) {
                console.error('❌ App ID missing in response:', data);
                throw new Error('App ID is missing from token response');
            }

            return {
                appId: data.app_id,
                token: data.token || null,
                uid: data.uid
            };

        } catch (error) {
            console.error('❌ Error fetching Agora token:', error);
            throw error;
        }
    }

    async createLocalTracks() {
        try {
            console.log('🎤 Creating local audio track...');
            this.localAudioTrack = await AgoraRTC.createMicrophoneAudioTrack();
            console.log('✅ Audio track created');

            if (this.config.callType === 'video') {
                console.log('📹 Creating local video track...');
                this.localVideoTrack = await AgoraRTC.createCameraVideoTrack({
                    encoderConfig: '720p_2'
                });
                console.log('✅ Video track created');

                const localVideoContainer = document.getElementById('local-video');
                if (localVideoContainer && this.localVideoTrack) {
                    this.localVideoTrack.play(localVideoContainer);
                    this.hideLocalPlaceholder();
                }
            }

        } catch (error) {
            console.error('❌ Failed to create local tracks:', error);
            alert('Could not access camera/microphone: ' + error.message);
            throw error;
        }
    }

    async publishLocalTracks() {
        try {
            const tracks = [];
            if (this.localAudioTrack) tracks.push(this.localAudioTrack);
            if (this.localVideoTrack) tracks.push(this.localVideoTrack);

            if (tracks.length > 0) {
                await this.client.publish(tracks);
                console.log('✅ Published local tracks:', tracks.length);
            }
        } catch (error) {
            console.error('❌ Failed to publish tracks:', error);
            throw error;
        }
    }

    async toggleAudio() {
        if (!this.localAudioTrack) return false;
        
        const enabled = this.localAudioTrack.enabled;
        await this.localAudioTrack.setEnabled(!enabled);
        return !enabled;
    }

    async toggleVideo() {
    if (!this.localVideoTrack) return false;
    
    const enabled = this.localVideoTrack.enabled;
    await this.localVideoTrack.setEnabled(!enabled);
    
    const placeholder = document.getElementById('local-placeholder');
    const video = document.getElementById('local-video');

    if (enabled) {
        // Tắt cam → hiện placeholder (có ảnh local.png)
        placeholder.style.display = 'flex';
        video.style.display = 'none';
    } else {
        // Bật cam → ẩn placeholder
        placeholder.style.display = 'none';
        video.style.display = 'block';
    }
    
    return !enabled;
}

    async leaveCall() {
        try {
            // ✅ DỪNG POLLING KHI LEAVE
            stopCallStatusPolling();

            if (this.localAudioTrack) {
                this.localAudioTrack.close();
                this.localAudioTrack = null;
            }
            
            if (this.localVideoTrack) {
                this.localVideoTrack.close();
                this.localVideoTrack = null;
            }

            if (this.client && this.isJoined) {
                await this.client.leave();
                this.isJoined = false;
            }

            console.log('✅ Left call successfully');
        } catch (error) {
            console.error('❌ Error leaving call:', error);
        }
    }

    async endCall() {
        try {
            await this.leaveCall();

            const response = await fetch('/api/video-calls/end', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ call_id: this.config.callId })
            });

            if (response.ok) {
                window.location.href = `/video-calls/${this.config.callId}/ended`;
            }
        } catch (error) {
            console.error('❌ Error ending call:', error);
        }
    }

    hideRemotePlaceholder() {
        const el = document.getElementById('remote-placeholder');
        if (el) el.style.display = 'none';
    }

    showRemotePlaceholder() {
        const el = document.getElementById('remote-placeholder');
        if (el) el.style.display = 'flex';
    }

    hideLocalPlaceholder() {
        const el = document.getElementById('local-placeholder');
        if (el) el.style.display = 'none';
    }

    updateCallStatus(status) {
        const el = document.getElementById('call-status');
        if (el) el.textContent = status;
    }

    updateNetworkQuality(quality) {
        const indicator = document.getElementById('network-indicator');
        if (!indicator) return;

        const texts = ['Excellent', 'Good', 'Fair', 'Poor', 'Bad', 'Very Bad'];
        const colors = ['#10b981', '#22c55e', '#eab308', '#f97316', '#ef4444', '#dc2626'];
        
        const text = texts[quality - 1] || 'Unknown';
        const color = colors[quality - 1] || '#6b7280';
        
        const textEl = indicator.querySelector('.network-text');
        if (textEl) {
            textEl.textContent = text;
            indicator.style.color = color;
        }
    }

    startCallTimer() {
        const timerEl = document.getElementById('call-timer');
        if (!timerEl) return;

        let seconds = 0;
        setInterval(() => {
            seconds++;
            const mins = Math.floor(seconds / 60);
            const secs = seconds % 60;
            timerEl.textContent = 
                `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
        }, 1000);
    }
}

// Initialize call
let agoraCall;

document.addEventListener('DOMContentLoaded', async () => {
    console.log('🚀 DOM loaded, initializing Agora call...');
    
    try {
        agoraCall = new AgoraVideoCall(window.videoCallData);
        
        if (window.videoCallData.roomId) {
            console.log('📞 Auto-joining room:', window.videoCallData.roomId);
            await agoraCall.joinCall(window.videoCallData.roomId);
        } else {
            console.error('❌ No room ID provided');
        }

        setupControlButtons();
        window.agoraCall = agoraCall;
        
    } catch (error) {
        console.error('❌ Failed to initialize Agora:', error);
        alert('Failed to initialize video call: ' + error.message);
    }
});

function setupControlButtons() {
    // Microphone
    document.getElementById('btn-microphone')?.addEventListener('click', async () => {
        const btn = document.getElementById('btn-microphone');
        const enabled = await agoraCall.toggleAudio();
        btn.setAttribute('data-state', enabled ? 'on' : 'off');
        btn.querySelector('i').className = enabled ? 'fas fa-microphone' : 'fas fa-microphone-slash';
        const label = btn.querySelector('.control-label');
        if (label) label.textContent = enabled ? 'Mute' : 'Unmute';
    });

    // Camera
    document.getElementById('btn-camera')?.addEventListener('click', async () => {
        const btn = document.getElementById('btn-camera');
        const enabled = await agoraCall.toggleVideo();
        btn.setAttribute('data-state', enabled ? 'on' : 'off');
        btn.querySelector('i').className = enabled ? 'fas fa-video' : 'fas fa-video-slash';
    });

    // End call
    document.getElementById('btn-end-call')?.addEventListener('click', async () => {
        if (confirm('End this call?')) {
            await agoraCall.endCall();
        }
    });
}

// ✅ CLEANUP: Dừng polling khi close/reload page
window.addEventListener('beforeunload', () => {
    stopCallStatusPolling();
    if (agoraCall) agoraCall.leaveCall();
});
</script>
@endpush
