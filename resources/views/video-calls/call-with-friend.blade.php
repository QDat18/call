@extends('layouts.app')

@section('title', 'Video Call')

@section('content')
<div class="video-call-room-with-friend">
    <div class="room-container">
        <!-- Top Header Bar -->
        <div class="call-header">
            <div class="header-left">
                <div class="participant-info-header">
                    <img 
                        src="{{ $participant->avatar_url ?? asset('images/default-avatar.png') }}" 
                        alt="{{ $participant->first_name }}"
                        class="participant-avatar-small">
                    <div class="participant-details">
                        <h5 class="mb-0">{{ $participant->first_name }} {{ $participant->last_name }}</h5>
                        <small class="text-muted">
                            <span id="call-status">Connecting...</span>
                            <span class="mx-2">•</span>
                            <span id="call-timer">00:00</span>
                        </small>
                    </div>
                </div>
            </div>
            <div class="header-right">
                <!-- Add Friend Button -->
                <button 
                    class="btn-add-friend" 
                    id="btn-add-friend"
                    data-user-id="{{ $participant->user_id }}"
                    data-connection-status="{{ $connectionStatus ?? 'none' }}">
                    <i class="fas fa-user-plus me-2"></i>
                    <span id="friend-btn-text">Add Friend</span>
                </button>
            </div>
        </div>

        <!-- Main Video Area -->
        <div class="video-area">
            <!-- Remote Video -->
            <div class="remote-video-container">
                <video id="remote-video" class="remote-video" autoplay playsinline></video>
                
                <!-- Remote Placeholder -->
                <div class="video-placeholder" id="remote-placeholder">
                    <div class="placeholder-content">
                        <img 
                            src="{{ $participant->avatar_url ?? asset('images/default-avatar.png') }}" 
                            alt="{{ $participant->first_name }}"
                            class="placeholder-avatar">
                        <h4 class="mt-3 text-white">{{ $participant->first_name }} {{ $participant->last_name }}</h4>
                        <p class="text-white-50">
                            @if($participant->user_type === 'Organization')
                                <i class="fas fa-building me-2"></i>{{ $participant->organization_name ?? 'Organization' }}
                            @else
                                <i class="fas fa-user me-2"></i>{{ ucfirst($participant->user_type) }}
                            @endif
                        </p>
                        <div class="spinner-border text-white mt-3" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>

                <!-- Participant Info Overlay (Top) -->
                <div class="participant-overlay">
                    <div class="participant-badge">
                        <i class="fas fa-user me-2"></i>
                        {{ $participant->first_name }}
                    </div>
                    <div class="network-indicator" id="network-indicator">
                        <i class="fas fa-signal"></i>
                        <span class="network-text">Good</span>
                    </div>
                </div>
            </div>

            <!-- Local Video (PiP) -->
            @if($callType === 'video')
            <div class="local-video-container" id="local-video-container">
                <video id="local-video" class="local-video" autoplay muted playsinline></video>
                <div class="local-label">You</div>
                <div class="camera-off-badge" id="camera-off-badge" style="display: none;">
                    <i class="fas fa-video-slash"></i>
                </div>
            </div>
            @endif
        </div>

        <!-- Bottom Controls Bar -->
        <div class="controls-bar">
            <div class="controls-container">
                <!-- Left Info -->
                <div class="controls-left">
                    <div class="call-type-badge {{ $callType === 'video' ? 'badge-video' : 'badge-audio' }}">
                        <i class="fas fa-{{ $callType === 'video' ? 'video' : 'phone' }} me-1"></i>
                        {{ ucfirst($callType) }} Call
                    </div>
                </div>

                <!-- Center Controls -->
                <div class="controls-center">
                    <!-- Microphone -->
                    <button class="control-button" id="btn-microphone" data-state="on">
                        <i class="fas fa-microphone"></i>
                        <span class="control-label">Mute</span>
                    </button>

                    <!-- Camera -->
                    @if($callType === 'video')
                    <button class="control-button" id="btn-camera" data-state="on">
                        <i class="fas fa-video"></i>
                        <span class="control-label">Camera</span>
                    </button>
                    @endif

                    <!-- Screen Share -->
                    <button class="control-button" id="btn-screen-share" data-state="off">
                        <i class="fas fa-desktop"></i>
                        <span class="control-label">Share</span>
                    </button>

                    <!-- Settings -->
                    <button class="control-button" id="btn-settings" data-bs-toggle="modal" data-bs-target="#settingsModal">
                        <i class="fas fa-cog"></i>
                        <span class="control-label">Settings</span>
                    </button>

                    <!-- End Call -->
                    <button class="control-button btn-end-call" id="btn-end-call">
                        <i class="fas fa-phone-slash"></i>
                        <span class="control-label">End</span>
                    </button>
                </div>

                <!-- Right Actions -->
                <div class="controls-right">
                    <div class="call-actions">
                        <!-- View Profile -->
                        <button 
                            class="btn-action" 
                            onclick="window.open('{{ route('users.profile', $participant->user_id) }}', '_blank')"
                            title="View Profile">
                            <i class="fas fa-user"></i>
                        </button>

                        <!-- Send Message -->
                        <button 
                            class="btn-action" 
                            onclick="openChat()"
                            title="Send Message">
                            <i class="fas fa-comment"></i>
                        </button>
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
                        <i class="fas fa-cog me-2"></i>Call Settings
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Audio Input -->
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-microphone me-2 text-primary"></i>Microphone
                        </label>
                        <select class="form-select" id="audio-input-select">
                            <option>Default - Microphone</option>
                        </select>
                    </div>

                    <!-- Audio Output -->
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-volume-up me-2 text-success"></i>Speaker
                        </label>
                        <select class="form-select" id="audio-output-select">
                            <option>Default - Speaker</option>
                        </select>
                    </div>

                    @if($callType === 'video')
                    <!-- Video Input -->
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-video me-2 text-info"></i>Camera
                        </label>
                        <select class="form-select" id="video-input-select">
                            <option>Default - Camera</option>
                        </select>
                    </div>

                    <!-- Video Quality -->
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-film me-2 text-warning"></i>Video Quality
                        </label>
                        <select class="form-select" id="video-quality-select">
                            <option value="480">Medium (480p)</option>
                            <option value="720" selected>HD (720p)</option>
                            <option value="1080">Full HD (1080p)</option>
                        </select>
                    </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast Notifications -->
<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 99999;">
    <div id="friendToast" class="toast" role="alert">
        <div class="toast-header">
            <i class="fas fa-user-plus me-2 text-primary"></i>
            <strong class="me-auto">Friend Request</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body" id="toast-message">
            Friend request sent successfully!
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    body {
        overflow: hidden;
    }

    .video-call-room-with-friend {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: #000;
        z-index: 9999;
    }

    .room-container {
        width: 100%;
        height: 100vh;
        display: flex;
        flex-direction: column;
    }

    /* Header */
    .call-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.5rem;
        background: rgba(0, 0, 0, 0.95);
        backdrop-filter: blur(10px);
        color: white;
        z-index: 10;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .participant-info-header {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .participant-avatar-small {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #667eea;
    }

    .participant-details h5 {
        color: white;
        margin-bottom: 2px;
    }

    /* Add Friend Button */
    .btn-add-friend {
        padding: 10px 20px;
        border-radius: 12px;
        border: 2px solid #667eea;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
    }

    .btn-add-friend:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
    }

    .btn-add-friend.pending {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        border-color: #f59e0b;
    }

    .btn-add-friend.accepted {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border-color: #10b981;
    }

    .btn-add-friend:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    /* Video Area */
    .video-area {
        flex: 1;
        position: relative;
        overflow: hidden;
        background: #000;
    }

    .remote-video-container {
        width: 100%;
        height: 100%;
        position: relative;
    }

    .remote-video {
        width: 100%;
        height: 100%;
        object-fit: contain;
        background: #000;
    }

    .video-placeholder {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
        z-index: 1;
    }

    .video-placeholder.hidden {
        display: none;
    }

    .placeholder-content {
        text-align: center;
    }

    .placeholder-avatar {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    }

    /* Participant Overlay */
    .participant-overlay {
        position: absolute;
        top: 20px;
        left: 20px;
        right: 20px;
        display: flex;
        justify-content: space-between;
        z-index: 2;
    }

    .participant-badge,
    .network-indicator {
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(10px);
        padding: 8px 16px;
        border-radius: 20px;
        color: white;
        font-size: 14px;
    }

    .network-indicator {
        color: #10b981;
    }

    /* Local Video */
    .local-video-container {
        position: absolute;
        bottom: 120px;
        right: 20px;
        width: 240px;
        height: 180px;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
        border: 3px solid #667eea;
        z-index: 3;
    }

    .local-video {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transform: scaleX(-1);
        background: #1a1a1a;
    }

    .local-label {
        position: absolute;
        bottom: 8px;
        left: 8px;
        background: rgba(0, 0, 0, 0.7);
        padding: 4px 10px;
        border-radius: 8px;
        color: white;
        font-size: 12px;
    }

    .camera-off-badge {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: rgba(239, 68, 68, 0.9);
        padding: 12px;
        border-radius: 50%;
        color: white;
        font-size: 24px;
    }

    /* Controls Bar */
    .controls-bar {
        padding: 1.5rem;
        background: rgba(0, 0, 0, 0.95);
        backdrop-filter: blur(20px);
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        z-index: 10;
    }

    .controls-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        max-width: 1400px;
        margin: 0 auto;
    }

    .controls-left,
    .controls-right {
        flex: 1;
    }

    .controls-center {
        display: flex;
        gap: 1rem;
        justify-content: center;
    }

    .controls-right {
        display: flex;
        justify-content: flex-end;
    }

    .call-type-badge {
        padding: 8px 16px;
        border-radius: 12px;
        color: white;
        font-size: 14px;
        font-weight: 600;
    }

    .badge-video {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .badge-audio {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    /* Control Buttons */
    .control-button {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        padding: 14px 18px;
        min-width: 70px;
        border-radius: 14px;
        border: none;
        background: rgba(255, 255, 255, 0.1);
        color: white;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 22px;
    }

    .control-button:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-3px);
    }

    .control-button[data-state="off"] {
        background: rgba(239, 68, 68, 0.3);
    }

    .control-label {
        font-size: 11px;
        font-weight: 500;
    }

    .btn-end-call {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    .btn-end-call:hover {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        transform: translateY(-3px) scale(1.05);
    }

    /* Action Buttons */
    .call-actions {
        display: flex;
        gap: 0.5rem;
    }

    .btn-action {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        border: none;
        background: rgba(255, 255, 255, 0.1);
        color: white;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-action:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: scale(1.1);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .call-header {
            padding: 0.75rem 1rem;
        }

        .btn-add-friend {
            padding: 8px 12px;
            font-size: 14px;
        }

        .btn-add-friend span {
            display: none;
        }

        .local-video-container {
            width: 120px;
            height: 90px;
            bottom: 100px;
            right: 10px;
        }

        .control-button {
            min-width: 60px;
            padding: 12px;
            font-size: 20px;
        }

        .control-label {
            font-size: 10px;
        }

        .controls-left .call-type-badge,
        .call-actions {
            display: none;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Call data
    window.videoCallData = {
        callId: {{ $callId }},
        conversationId: {{ $conversationId }},
        currentUserId: {{ auth()->id() }},
        participantId: {{ $participant->user_id }},
        participantName: '{{ $participant->first_name }} {{ $participant->last_name }}',
        callType: '{{ $callType }}',
        isInitiator: {{ $isInitiator ? 'true' : 'false' }}
    };

    // Call timer
    let callTimer;
    let callStartTime = Date.now();

    function startCallTimer() {
        callTimer = setInterval(() => {
            const elapsed = Math.floor((Date.now() - callStartTime) / 1000);
            const minutes = Math.floor(elapsed / 60);
            const seconds = elapsed % 60;
            document.getElementById('call-timer').textContent = 
                `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        }, 1000);
    }

    // Add Friend functionality
    const addFriendBtn = document.getElementById('btn-add-friend');
    const friendBtnText = document.getElementById('friend-btn-text');
    
    addFriendBtn.addEventListener('click', async function() {
        const userId = this.dataset.userId;
        const currentStatus = this.dataset.connectionStatus;

        if (currentStatus === 'accepted') {
            showToast('You are already friends!', 'info');
            return;
        }

        if (currentStatus === 'pending') {
            showToast('Friend request already sent', 'warning');
            return;
        }

        try {
            this.disabled = true;
            
            const response = await fetch('/api/connections/send-request', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ friend_id: userId })
            });

            const data = await response.json();

            if (data.success) {
                this.dataset.connectionStatus = 'pending';
                this.classList.add('pending');
                friendBtnText.textContent = 'Request Sent';
                this.querySelector('i').className = 'fas fa-clock me-2';
                showToast(data.message, 'success');
            } else {
                showToast(data.message, 'error');
                this.disabled = false;
            }
        } catch (error) {
            console.error('Error sending friend request:', error);
            showToast('Failed to send friend request', 'error');
            this.disabled = false;
        }
    });

    // Update button based on initial status
    function updateFriendButton() {
        const status = addFriendBtn.dataset.connectionStatus;
        
        if (status === 'accepted') {
            addFriendBtn.classList.add('accepted');
            friendBtnText.textContent = 'Friends';
            addFriendBtn.querySelector('i').className = 'fas fa-check me-2';
            addFriendBtn.disabled = true;
        } else if (status === 'pending') {
            addFriendBtn.classList.add('pending');
            friendBtnText.textContent = 'Pending';
            addFriendBtn.querySelector('i').className = 'fas fa-clock me-2';
            addFriendBtn.disabled = true;
        }
    }

    // Toast notification
    function showToast(message, type = 'success') {
        const toastEl = document.getElementById('friendToast');
        const toastMessage = document.getElementById('toast-message');
        
        toastMessage.textContent = message;
        
        const toast = new bootstrap.Toast(toastEl);
        toast.show();
    }

    // Control buttons
    document.getElementById('btn-microphone')?.addEventListener('click', function() {
        const isOn = this.dataset.state === 'on';
        this.dataset.state = isOn ? 'off' : 'on';
        this.querySelector('i').className = isOn ? 'fas fa-microphone-slash' : 'fas fa-microphone';
        this.querySelector('.control-label').textContent = isOn ? 'Unmute' : 'Mute';
    });

    document.getElementById('btn-camera')?.addEventListener('click', function() {
        const isOn = this.dataset.state === 'on';
        this.dataset.state = isOn ? 'off' : 'on';
        this.querySelector('i').className = isOn ? 'fas fa-video-slash' : 'fas fa-video';
        document.getElementById('camera-off-badge').style.display = isOn ? 'block' : 'none';
    });

    document.getElementById('btn-screen-share')?.addEventListener('click', function() {
        const isOn = this.dataset.state === 'on';
        this.dataset.state = isOn ? 'off' : 'on';
        this.style.background = isOn ? 'rgba(255, 255, 255, 0.1)' : 'rgba(16, 185, 129, 0.3)';
    });

    document.getElementById('btn-end-call')?.addEventListener('click', function() {
        if (confirm('End this call?')) {
            clearInterval(callTimer);
            window.location.href = `/video-calls/{{ $callId }}/ended`;
        }
    });

    function openChat() {
        window.location.href = `/conversations/{{ $conversationId }}`;
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        startCallTimer();
        updateFriendButton();
        
        // Hide placeholder after 2 seconds
        setTimeout(() => {
            document.getElementById('call-status').textContent = 'Connected';
            document.getElementById('remote-placeholder').classList.add('hidden');
        }, 2000);
    });

    // Cleanup
    window.addEventListener('beforeunload', () => clearInterval(callTimer));
</script>
@endpush
@endsection