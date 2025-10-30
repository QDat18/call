import { useState, useEffect, useRef, useCallback } from 'react';
import axios from 'axios';

/**
 * WebRTC Hook Configuration
 */
interface UseWebRTCConfig {
    conversationId: number;
    currentUserId: number;
    callId: number;
    callType: 'video' | 'audio';
    isInitiator: boolean;
}

/**
 * Call State Types
 */
type CallState = 'idle' | 'connecting' | 'connected' | 'failed' | 'ended';
type PeerConnectionState = 'new' | 'connecting' | 'connected' | 'disconnected' | 'failed' | 'closed';

/**
 * Media Stream Constraints
 */
interface MediaStreamConstraints {
    audio: boolean | MediaTrackConstraints;
    video: boolean | MediaTrackConstraints;
}

/**
 * WebRTC Hook Return Type
 */
interface UseWebRTCReturn {
    localStream: MediaStream | null;
    remoteStream: MediaStream | null;
    connectionState: PeerConnectionState;
    callState: CallState;
    isAudioEnabled: boolean;
    isVideoEnabled: boolean;
    isScreenSharing: boolean;
    error: string | null;
    
    // Actions
    startCall: () => Promise<void>;
    endCall: () => Promise<void>;
    toggleAudio: () => void;
    toggleVideo: () => void;
    startScreenShare: () => Promise<void>;
    stopScreenShare: () => void;
}

/**
 * Signal Event Payload Types
 */
interface SignalPayload {
    call_id: number;
    offer?: RTCSessionDescriptionInit;
    answer?: RTCSessionDescriptionInit;
    candidate?: RTCIceCandidateInit;
    from_user_id?: number;
    [key: string]: unknown;
}

/**
 * Default ICE Servers Configuration
 */
const defaultIceServers: RTCIceServer[] = [
    { urls: 'stun:stun.l.google.com:19302' },
    { urls: 'stun:stun1.l.google.com:19302' },
    { urls: 'stun:stun2.l.google.com:19302' },
    { urls: 'stun:stun3.l.google.com:19302' },
    { urls: 'stun:stun4.l.google.com:19302' },
];

/**
 * useWebRTC Hook
 * 
 * Manages WebRTC peer connection, media streams, and signaling
 */
export const useWebRTC = (config: UseWebRTCConfig): UseWebRTCReturn => {
    const {
        currentUserId,
        callId,
        callType,
        isInitiator
    } = config;

    // State
    const [localStream, setLocalStream] = useState<MediaStream | null>(null);
    const [remoteStream, setRemoteStream] = useState<MediaStream | null>(null);
    const [connectionState, setConnectionState] = useState<PeerConnectionState>('new');
    const [callState, setCallState] = useState<CallState>('idle');
    const [isAudioEnabled, setIsAudioEnabled] = useState<boolean>(true);
    const [isVideoEnabled, setIsVideoEnabled] = useState<boolean>(callType === 'video');
    const [isScreenSharing, setIsScreenSharing] = useState<boolean>(false);
    const [error, setError] = useState<string | null>(null);

    // Refs
    const peerConnection = useRef<RTCPeerConnection | null>(null);
    const screenShareStream = useRef<MediaStream | null>(null);
    const originalVideoTrack = useRef<MediaStreamTrack | null>(null);

    /**
     * Get User Media
     */
    const getUserMedia = useCallback(async (): Promise<MediaStream> => {
        const constraints: MediaStreamConstraints = {
            audio: {
                echoCancellation: true,
                noiseSuppression: true,
                autoGainControl: true,
            },
            video: callType === 'video' ? {
                width: { ideal: 1280 },
                height: { ideal: 720 },
                facingMode: 'user',
            } : false,
        };

        try {
            const stream = await navigator.mediaDevices.getUserMedia(constraints);
            return stream;
        } catch (err) {
            const error = err as Error;
            setError(`Failed to access media devices: ${error.message}`);
            throw error;
        }
    }, [callType]);

    /**
     * Send ICE Candidate
     */
    const sendIceCandidate = useCallback(async (candidate: RTCIceCandidate): Promise<void> => {
        if (!candidate) return;

        try {
            await axios.post('/api/video-calls/ice-candidate', {
                call_id: callId,
                candidate: candidate.toJSON(),
            });
        } catch (err) {
            console.error('Error sending ICE candidate:', err);
        }
    }, [callId]);

    /**
     * Create Peer Connection
     */
    const createPeerConnection = useCallback((): RTCPeerConnection => {
        const pcConfig: RTCConfiguration = {
            iceServers: defaultIceServers,
            iceTransportPolicy: 'all',
            bundlePolicy: 'max-bundle',
            rtcpMuxPolicy: 'require',
        };

        const pc = new RTCPeerConnection(pcConfig);

        // Handle ICE candidates
        pc.onicecandidate = (event: RTCPeerConnectionIceEvent) => {
            if (event.candidate) {
                sendIceCandidate(event.candidate);
            }
        };

        // Handle connection state changes
        pc.onconnectionstatechange = () => {
            setConnectionState(pc.connectionState as PeerConnectionState);
            
            if (pc.connectionState === 'failed') {
                setError('Connection failed. Please check your network.');
            } else if (pc.connectionState === 'connected') {
                setError(null);
            }
        };

        // Handle remote stream
        pc.ontrack = (event: RTCTrackEvent) => {
            const [stream] = event.streams;
            setRemoteStream(stream);
        };

        // Handle ICE connection state
        pc.oniceconnectionstatechange = () => {
            console.log('ICE Connection State:', pc.iceConnectionState);
            
            if (pc.iceConnectionState === 'disconnected') {
                console.warn('ICE connection disconnected');
            } else if (pc.iceConnectionState === 'failed') {
                console.error('ICE connection failed');
                setError('Connection failed. Trying to reconnect...');
            }
        };

        // Handle negotiation needed
        pc.onnegotiationneeded = async () => {
            console.log('Negotiation needed');
        };

        return pc;
    }, [sendIceCandidate]);

    /**
     * Create and Send Offer
     */
    const createOffer = useCallback(async (pc: RTCPeerConnection): Promise<void> => {
        try {
            const offer = await pc.createOffer({
                offerToReceiveAudio: true,
                offerToReceiveVideo: callType === 'video',
            });

            await pc.setLocalDescription(offer);

            await axios.post('/api/video-calls/offer', {
                call_id: callId,
                offer: offer,
            });
        } catch (err) {
            const error = err as Error;
            setError(`Failed to create offer: ${error.message}`);
            throw error;
        }
    }, [callId, callType]);

    /**
     * Create and Send Answer
     */
    const createAnswer = useCallback(async (
        pc: RTCPeerConnection,
        offer: RTCSessionDescriptionInit
    ): Promise<void> => {
        try {
            await pc.setRemoteDescription(new RTCSessionDescription(offer));

            const answer = await pc.createAnswer();
            await pc.setLocalDescription(answer);

            await axios.post('/api/video-calls/answer', {
                call_id: callId,
                answer: answer,
            });
        } catch (err) {
            const error = err as Error;
            setError(`Failed to create answer: ${error.message}`);
            throw error;
        }
    }, [callId]);

    /**
     * Handle Remote Answer
     */
    const handleAnswer = useCallback(async (
        pc: RTCPeerConnection,
        answer: RTCSessionDescriptionInit
    ): Promise<void> => {
        try {
            await pc.setRemoteDescription(new RTCSessionDescription(answer));
        } catch (err) {
            console.error('Error handling answer:', err);
            setError('Failed to process answer');
        }
    }, []);

    /**
     * Handle ICE Candidate
     */
    const handleIceCandidate = useCallback(async (
        pc: RTCPeerConnection,
        candidate: RTCIceCandidateInit
    ): Promise<void> => {
        try {
            await pc.addIceCandidate(new RTCIceCandidate(candidate));
        } catch (err) {
            console.error('Error adding ICE candidate:', err);
        }
    }, []);

    /**
     * Start Call
     */
    const startCall = useCallback(async (): Promise<void> => {
        setCallState('connecting');
        
        try {
            // Get user media
            const stream = await getUserMedia();
            setLocalStream(stream);

            // Create peer connection
            const pc = createPeerConnection();
            peerConnection.current = pc;

            // Add local tracks to peer connection
            stream.getTracks().forEach((track) => {
                pc.addTrack(track, stream);
            });

            // If initiator, create and send offer
            if (isInitiator) {
                await createOffer(pc);
            }

            setCallState('connected');
        } catch (err) {
            const error = err as Error;
            setError(error.message);
            setCallState('failed');
        }
    }, [getUserMedia, createPeerConnection, isInitiator, createOffer]);

    /**
     * End Call
     */
    const endCall = useCallback(async (): Promise<void> => {
        // Stop all tracks
        localStream?.getTracks().forEach((track) => track.stop());
        remoteStream?.getTracks().forEach((track) => track.stop());
        screenShareStream.current?.getTracks().forEach((track) => track.stop());

        // Close peer connection
        peerConnection.current?.close();
        peerConnection.current = null;

        // Reset state
        setLocalStream(null);
        setRemoteStream(null);
        setConnectionState('closed');
        setCallState('ended');
        setIsScreenSharing(false);

        // Notify backend
        try {
            await axios.post('/api/video-calls/end', { call_id: callId });
        } catch (err) {
            console.error('Error ending call:', err);
        }
    }, [localStream, remoteStream, callId]);

    /**
     * Toggle Audio
     */
    const toggleAudio = useCallback((): void => {
        if (localStream) {
            const audioTrack = localStream.getAudioTracks()[0];
            if (audioTrack) {
                audioTrack.enabled = !audioTrack.enabled;
                setIsAudioEnabled(audioTrack.enabled);
            }
        }
    }, [localStream]);

    /**
     * Toggle Video
     */
    const toggleVideo = useCallback((): void => {
        if (localStream) {
            const videoTrack = localStream.getVideoTracks()[0];
            if (videoTrack) {
                videoTrack.enabled = !videoTrack.enabled;
                setIsVideoEnabled(videoTrack.enabled);
            }
        }
    }, [localStream]);

    /**
     * Stop Screen Share
     */
    const stopScreenShare = useCallback((): void => {
        if (screenShareStream.current && originalVideoTrack.current) {
            // Stop screen share tracks
            screenShareStream.current.getTracks().forEach((track) => track.stop());

            // Replace with original video track
            const sender = peerConnection.current
                ?.getSenders()
                .find((s) => s.track?.kind === 'video');

            if (sender) {
                sender.replaceTrack(originalVideoTrack.current);
            }

            setIsScreenSharing(false);
            screenShareStream.current = null;
            originalVideoTrack.current = null;
        }
    }, []);

    /**
     * Start Screen Share
     */
    const startScreenShare = useCallback(async (): Promise<void> => {
        try {
            if (!navigator.mediaDevices?.getDisplayMedia) {
                throw new Error('Screen sharing not supported in this browser.');
            }

            const stream = await navigator.mediaDevices.getDisplayMedia({
                video: {
                    displaySurface: 'monitor', // hoặc 'window', 'application'
                    cursor: 'always',
                } as unknown as MediaTrackConstraints, // ✅ ép kiểu hợp lệ cho TypeScript
                audio: false,
            });

            screenShareStream.current = stream;

            // Replace video track
            const screenTrack = stream.getVideoTracks()[0];
            const sender = peerConnection.current
                ?.getSenders()
                .find((s) => s.track?.kind === 'video');

            if (sender && localStream) {
                originalVideoTrack.current = localStream.getVideoTracks()[0];
                await sender.replaceTrack(screenTrack);
                setIsScreenSharing(true);

                // Handle screen share stop
                screenTrack.onended = () => {
                    stopScreenShare();
                };
            }
        } catch (err) {
            const error = err as Error;
            setError(`Failed to start screen share: ${error.message}`);
        }
    }, [localStream, stopScreenShare]);

    /**
     * Listen for signaling events via Laravel Echo
     */
    useEffect(() => {
        if (!window.Echo || !callId) return;

        const channel = window.Echo.private(`video-call.${currentUserId}`);

        // Listen for offer
        channel.listen('.video.offer', (data: SignalPayload) => {
            if (data.call_id === callId && !isInitiator && peerConnection.current && data.offer) {
                createAnswer(peerConnection.current, data.offer);
            }
        });

        // Listen for answer
        channel.listen('.video.answer', (data: SignalPayload) => {
            if (data.call_id === callId && isInitiator && peerConnection.current && data.answer) {
                handleAnswer(peerConnection.current, data.answer);
            }
        });

        // Listen for ICE candidates
        channel.listen('.ice.candidate', (data: SignalPayload) => {
            if (data.call_id === callId && peerConnection.current && data.candidate) {
                handleIceCandidate(peerConnection.current, data.candidate);
            }
        });

        // Cleanup
        return () => {
            channel.stopListening('.video.offer');
            channel.stopListening('.video.answer');
            channel.stopListening('.ice.candidate');
        };
    }, [callId, currentUserId, isInitiator, createAnswer, handleAnswer, handleIceCandidate]);

    /**
     * Cleanup on unmount
     */
    useEffect(() => {
        return () => {
            localStream?.getTracks().forEach((track) => track.stop());
            remoteStream?.getTracks().forEach((track) => track.stop());
            peerConnection.current?.close();
        };
    }, [localStream, remoteStream]);

    return {
        localStream,
        remoteStream,
        connectionState,
        callState,
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
    };
};

export default useWebRTC;