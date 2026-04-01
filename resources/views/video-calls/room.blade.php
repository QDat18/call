@extends('layouts.app')

@section('title', 'Video Call Room')

@section('content')
    <div class="video-call-room">
        <div class="room-container">
            <div class="call-header">
                <div class="header-left">
                    <div class="call-type-badge {{ $callType === 'video' ? 'badge-video' : 'badge-audio' }}">
                        <i class="fas fa-{{ $callType === 'video' ? 'video' : 'phone' }}"></i>
                    </div>
                    <div class="call-info">
                        <h5 class="mb-0 text-white">{{ $participant->first_name }} {{ $participant->last_name }}</h5>
                        <small class="text-white-50">
                            <span id="call-status" class="status-dot">Connecting...</span>
                            <span class="mx-2">•</span>
                            <span id="call-timer">00:00</span>
                        </small>
                    </div>
                </div>
                <div class="header-right">
                    <button class="btn-icon-glass" title="Minimize" onclick="toggleMinimize()">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button class="btn-icon-glass" title="Fullscreen" onclick="toggleFullscreen()">
                        <i class="fas fa-expand"></i>
                    </button>
                </div>
            </div>

            <div class="video-area">
                <div class="remote-video-container">
                    <video id="remote-video" class="remote-video" autoplay playsinline></video>

                    <div class="video-placeholder" id="remote-placeholder">
                        <div class="placeholder-content">
                            <div class="avatar-pulse">
                                <img src="{{ $participant->avatar_url ?? asset('images/default-avatar.png') }}"
                                    alt="{{ $participant->first_name }}" class="placeholder-avatar">
                            </div>
                            <h3 class="mt-4 text-white">{{ $participant->first_name }} {{ $participant->last_name }}</h3>
                            <p class="text-white-50 calling-text">
                                Waiting for {{ $participant->first_name }} to join...
                            </p>
                        </div>
                    </div>

                    <div class="connection-overlay" id="connection-overlay" style="display: none;">
                        <div class="connection-alert">
                            <i class="fas fa-wifi fa-2x mb-2 text-warning"></i>
                            <h5>Unstable Connection</h5>
                            <p id="connection-message" class="mb-0 small">Reconnecting...</p>
                        </div>
                    </div>

                    <div class="network-indicator" id="network-indicator">
                        <i class="fas fa-signal"></i>
                        <span class="network-text">Excellent</span>
                    </div>
                </div>

                @if($callType === 'video')
                    <div class="local-video-container" id="local-video-container">
                        <video id="local-video" class="local-video" autoplay muted playsinline></video>

                        <div class="local-placeholder" id="local-placeholder">
                            <img src="{{ auth()->user()->avatar_url ?? asset('images/local.jpg?v=' . time()) }}" alt="You"
                                class="local-avatar">
                        </div>

                        <div class="local-label">You</div>

                        <div class="camera-off-badge" id="camera-off-badge" style="display: none;">
                            <i class="fas fa-video-slash"></i>
                        </div>
                    </div>
                @endif
            </div>

            <div class="controls-bar-wrapper">
                <div class="controls-bar">
                    <div class="controls-center">
                        <button class="control-button" id="btn-microphone" title="Mute/Unmute" data-state="on">
                            <div class="icon-circle"><i class="fas fa-microphone"></i></div>
                            <span class="control-label">Mute</span>
                        </button>

                        @if($callType === 'video')
                            <button class="control-button" id="btn-camera" title="Turn Camera On/Off" data-state="on">
                                <div class="icon-circle"><i class="fas fa-video"></i></div>
                                <span class="control-label">Camera</span>
                            </button>
                        @endif

                        <button class="control-button" id="btn-screen-share" title="Share Screen" data-state="off">
                            <div class="icon-circle"><i class="fas fa-desktop"></i></div>
                            <span class="control-label">Share</span>
                        </button>

                        <button class="control-button" id="btn-settings" title="Settings" data-bs-toggle="modal"
                            data-bs-target="#settingsModal">
                            <div class="icon-circle"><i class="fas fa-cog"></i></div>
                            <span class="control-label">Settings</span>
                        </button>

                        <button class="control-button btn-end-call" id="btn-end-call" title="End Call">
                            <div class="icon-circle end-call-icon"><i class="fas fa-phone-slash"></i></div>
                            <span class="control-label">End</span>
                        </button>
                    </div>
                </div>
                <div class="call-id-display">ID: {{ $callId }}</div>
            </div>
        </div>

        @include('partials.call-settings-modal')

        <audio id="ringtone-audio" loop>
            <source src="{{ asset('sounds/ringtone.mp3') }}" type="audio/mpeg">
        </audio>
    </div>
@endsection

@push('styles')
    <style>
        :root {
            --primary-color: #6366f1;
            --danger-color: #ef4444;
            --dark-bg: #0f172a;
            --glass-bg: rgba(255, 255, 255, 0.1);
            --glass-border: rgba(255, 255, 255, 0.05);
        }

        body {
            margin: 0;
            overflow: hidden;
            background: #000;
        }

        .video-call-room {
            height: 100vh;
            background: var(--dark-bg);
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .room-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        /* Header */
        .call-header {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 50;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.8), transparent);
        }

        .call-type-badge {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-right: 12px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
        }

        .badge-video {
            background: var(--primary-color);
        }

        .badge-audio {
            background: #10b981;
        }

        .header-left {
            display: flex;
            align-items: center;
        }

        .btn-icon-glass {
            width: 40px;
            height: 40px;
            border: none;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            cursor: pointer;
            transition: 0.2s;
            margin-left: 8px;
        }

        .btn-icon-glass:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        /* Video Area */
        .video-area {
            flex: 1;
            position: relative;
            background: #000;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .remote-video-container {
            width: 100%;
            height: 100%;
            position: relative;
        }

        .remote-video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Placeholder Pulse Effect */
        .video-placeholder {
            position: absolute;
            inset: 0;
            background: #111827;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
        }

        .placeholder-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #1f2937;
            position: relative;
            z-index: 2;
        }

        .avatar-pulse {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .avatar-pulse::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: var(--primary-color);
            opacity: 0.4;
            z-index: 1;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 0.4;
            }

            100% {
                transform: scale(1.5);
                opacity: 0;
            }
        }

        /* Local Video (PiP) */
        .local-video-container {
            position: absolute;
            bottom: 100px;
            right: 20px;
            width: 200px;
            height: 150px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
            border: 2px solid rgba(255, 255, 255, 0.1);
            z-index: 60;
            background: #1f2937;
            transition: all 0.3s ease;
        }

        .local-video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scaleX(-1);
        }

        .local-label {
            position: absolute;
            bottom: 8px;
            left: 8px;
            background: rgba(0, 0, 0, 0.6);
            color: white;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 11px;
        }

        /* Controls */
        .controls-bar-wrapper {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px 0 30px 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.9), transparent);
            z-index: 70;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .controls-bar {
            background: rgba(30, 41, 59, 0.8);
            backdrop-filter: blur(12px);
            padding: 10px 20px;
            border-radius: 50px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .controls-center {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .control-button {
            background: transparent;
            border: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
            color: white;
            transition: transform 0.2s;
            min-width: 60px;
        }

        .control-button:hover {
            transform: translateY(-3px);
        }

        .icon-circle {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            margin-bottom: 5px;
            transition: 0.2s;
        }

        .control-button:hover .icon-circle {
            background: rgba(255, 255, 255, 0.3);
        }

        /* States */
        .control-button[data-state="off"] .icon-circle {
            background: #374151;
            /* Dark grey when off */
            color: #ef4444;
            /* Red icon when off */
            position: relative;
        }

        .control-button[data-state="off"] .icon-circle::after {
            content: '\\';
            position: absolute;
            font-size: 24px;
            color: inherit;
            font-weight: 300;
        }

        .end-call-icon {
            background: var(--danger-color) !important;
        }

        .end-call-icon:hover {
            background: #dc2626 !important;
        }

        .control-label {
            font-size: 11px;
            opacity: 0.8;
            font-weight: 500;
        }

        .call-id-display {
            color: rgba(255, 255, 255, 0.3);
            font-size: 12px;
            margin-top: 10px;
        }

        /* Network Indicator */
        .network-indicator {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(0, 0, 0, 0.5);
            padding: 5px 12px;
            border-radius: 20px;
            color: #10b981;
            font-size: 13px;
            z-index: 50;
            backdrop-filter: blur(4px);
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .local-video-container {
                width: 100px;
                height: 140px;
                top: 80px;
                bottom: auto;
                /* Move to top on mobile */
                right: 15px;
                border-radius: 12px;
            }

            .controls-bar {
                padding: 8px 15px;
                width: 90%;
                justify-content: space-around;
                display: flex;
            }

            .controls-center {
                width: 100%;
                justify-content: space-between;
                gap: 0;
            }

            .control-button {
                min-width: auto;
            }

            .control-label {
                display: none;
            }

            /* Hide text on mobile */
            .icon-circle {
                width: 42px;
                height: 42px;
                margin-bottom: 0;
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