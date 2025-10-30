import React, { useState, useEffect, useRef, useCallback } from 'react';
import { useWebRTC } from './hooks/useWebRTC';
import './bootstrap';
import './echo';
import './chat/chat-init';


console.log('✅ Application loaded');
console.log('📡 Echo status:', window.Echo ? 'Connected' : 'Not connected');
/**
 * Props Interface
 */
interface VideoChatProps {
    conversationId: number;
    currentUserId: number;
}

/**
 * VideoChat Component with WebRTC Hook
 */
const VideoChat: React.FC<VideoChatProps> = ({ conversationId, currentUserId }) => {
    // Get call data from window (set by Blade template)
    const callData = (window as Window).videoCallData;
    
    // State
    const [isInCall, setIsInCall] = useState<boolean>(false);
    
    // Refs for video elements
    const localVideoRef = useRef<HTMLVideoElement>(null);
    const remoteVideoRef = useRef<HTMLVideoElement>(null);
    
    // Use WebRTC Hook
    const {
        localStream,
        remoteStream,
        connectionState,
        isAudioEnabled,
        isVideoEnabled,
        isScreenSharing,
        error,
        startCall,
        endCall,
        toggleAudio,
        toggleVideo,
        startScreenShare,
        stopScreenShare,
    } = useWebRTC({
        conversationId: callData?.conversationId || conversationId,
        currentUserId: callData?.currentUserId || currentUserId,
        callId: callData?.callId || 0,
        callType: callData?.callType || 'video',
        isInitiator: callData?.isInitiator || false,
    });

    /**
     * Update video elements when streams change
     */
    useEffect(() => {
        if (localVideoRef.current && localStream) {
            localVideoRef.current.srcObject = localStream;
        }
    }, [localStream]);

    useEffect(() => {
        if (remoteVideoRef.current && remoteStream) {
            remoteVideoRef.current.srcObject = remoteStream;
            
            // Hide placeholder, show video
            const placeholder = document.getElementById('remote-placeholder');
            if (placeholder) {
                placeholder.classList.remove('show');
            }
        } else {
            // Show placeholder when no remote stream
            const placeholder = document.getElementById('remote-placeholder');
            if (placeholder) {
                placeholder.classList.add('show');
            }
        }
    }, [remoteStream]);

    /**
     * Update connection status display
     */
    useEffect(() => {
        const statusElement = document.getElementById('connection-status');
        if (statusElement) {
            const icon = statusElement.querySelector('i');
            const text = statusElement.querySelector('span');
            
            if (icon && text) {
                switch (connectionState) {
                    case 'connected':
                        icon.className = 'fas fa-circle text-success';
                        text.textContent = 'Connected';
                        break;
                    case 'connecting':
                        icon.className = 'fas fa-circle text-warning';
                        text.textContent = 'Connecting...';
                        break;
                    case 'disconnected':
                        icon.className = 'fas fa-circle text-danger';
                        text.textContent = 'Disconnected';
                        break;
                    case 'failed':
                        icon.className = 'fas fa-circle text-danger';
                        text.textContent = 'Connection Failed';
                        break;
                }
            }
        }
    }, [connectionState]);

    /**
     * Call Timer
     */
    const startCallTimer = useCallback(() => {
        let seconds = 0;
        const timerElement = document.getElementById('call-timer');
        
        const interval = setInterval(() => {
            seconds++;
            const hours = Math.floor(seconds / 3600);
            const minutes = Math.floor((seconds % 3600) / 60);
            const secs = seconds % 60;
            
            if (timerElement) {
                timerElement.textContent = 
                    `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
            }
        }, 1000);

        // Store interval for cleanup
        window.callTimerInterval = interval;
    }, []);

    /**
     * Start call on component mount
     */
    useEffect(() => {
        if (callData?.callId && !isInCall) {
            startCall();
            setIsInCall(true);
            startCallTimer();
        }
        
        // Cleanup timer on unmount
        return () => {
            if (window.callTimerInterval) {
                clearInterval(window.callTimerInterval);
            }
        };
    }, [callData, isInCall, startCall, startCallTimer]);

    /**
     * Handle End Call
     */
    const handleEndCall = useCallback(async () => {
        await endCall();
        
        // Clear timer
        if (window.callTimerInterval) {
            clearInterval(window.callTimerInterval);
        }
        
        // Redirect to call ended page
        if (callData?.callId) {
            window.location.href = `/video-calls/${callData.callId}/ended`;
        }
    }, [endCall, callData]);

    /**
     * Handle Toggle Audio
     */
    const handleToggleAudio = useCallback(() => {
        const newAudioState = !isAudioEnabled;
        toggleAudio();
        
        const button = document.getElementById('toggle-audio');
        if (button) {
            const icon = button.querySelector('i');
            if (icon) {
                if (newAudioState) {
                    icon.className = 'fas fa-microphone';
                    button.classList.remove('disabled');
                } else {
                    icon.className = 'fas fa-microphone-slash';
                    button.classList.add('disabled');
                }
            }
        }
    }, [toggleAudio, isAudioEnabled]);

    /**
     * Handle Toggle Video
     */
    const handleToggleVideo = useCallback(() => {
        const newVideoState = !isVideoEnabled;
        toggleVideo();
        
        const button = document.getElementById('toggle-video');
        if (button) {
            const icon = button.querySelector('i');
            if (icon) {
                if (newVideoState) {
                    icon.className = 'fas fa-video';
                    button.classList.remove('disabled');
                } else {
                    icon.className = 'fas fa-video-slash';
                    button.classList.add('disabled');
                }
            }
        }
        
        // Show/hide local video
        const localWrapper = document.getElementById('local-video-wrapper');
        if (localWrapper) {
            localWrapper.style.display = newVideoState ? 'block' : 'none';
        }
    }, [toggleVideo, isVideoEnabled]);

    /**
     * Handle Screen Share
     */
    const handleScreenShare = useCallback(async () => {
        if (isScreenSharing) {
            stopScreenShare();
            
            const button = document.getElementById('screen-share');
            if (button) {
                button.classList.remove('active');
            }
        } else {
            await startScreenShare();
            
            const button = document.getElementById('screen-share');
            if (button) {
                button.classList.add('active');
            }
        }
    }, [isScreenSharing, startScreenShare, stopScreenShare]);

    /**
     * Attach event listeners
     */
    useEffect(() => {
        const audioBtn = document.getElementById('toggle-audio');
        const videoBtn = document.getElementById('toggle-video');
        const screenBtn = document.getElementById('screen-share');
        const endBtn = document.getElementById('end-call');

        if (audioBtn) audioBtn.addEventListener('click', handleToggleAudio);
        if (videoBtn) videoBtn.addEventListener('click', handleToggleVideo);
        if (screenBtn) screenBtn.addEventListener('click', handleScreenShare);
        if (endBtn) endBtn.addEventListener('click', handleEndCall);

        return () => {
            if (audioBtn) audioBtn.removeEventListener('click', handleToggleAudio);
            if (videoBtn) videoBtn.removeEventListener('click', handleToggleVideo);
            if (screenBtn) screenBtn.removeEventListener('click', handleScreenShare);
            if (endBtn) endBtn.removeEventListener('click', handleEndCall);
        };
    }, [handleToggleAudio, handleToggleVideo, handleScreenShare, handleEndCall]);

    /**
     * Show error if any
     */
    useEffect(() => {
        if (error) {
            alert(`Error: ${error}`);
        }
    }, [error]);

    return (
        <>
            {/* Video elements are in the Blade template */}
            {/* This component manages the WebRTC logic */}
            <video 
                ref={localVideoRef}
                id="local-video-react"
                autoPlay
                muted
                playsInline
                style={{ display: 'none' }}
            />
            <video 
                ref={remoteVideoRef}
                id="remote-video-react"
                autoPlay
                playsInline
                style={{ display: 'none' }}
            />
        </>
    );
};

export default VideoChat;