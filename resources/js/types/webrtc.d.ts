/**
 * WebRTC Type Definitions
 */
/* eslint-disable @typescript-eslint/no-explicit-any */
export type PeerConnectionState = 
    | 'new' 
    | 'connecting' 
    | 'connected' 
    | 'disconnected' 
    | 'failed' 
    | 'closed';

export type CallState = 
    | 'idle' 
    | 'connecting' 
    | 'connected' 
    | 'ringing' 
    | 'ended' 
    | 'failed';

export interface MediaStreamConstraints {
    audio?: boolean | MediaTrackConstraints;
    video?: boolean | MediaTrackConstraints;
}

export interface MediaTrackConstraints {
    echoCancellation?: boolean;
    noiseSuppression?: boolean;
    autoGainControl?: boolean;
    width?: { ideal: number };
    height?: { ideal: number };
    facingMode?: 'user' | 'environment';
    cursor?: 'always' | 'motion' | 'never';
}

/**
 * Global Window Types
 */
declare global {
    interface Window {
        _: any;
        axios: any;
        Echo: any;
        Pusher: any;
        currentUserId?: number;
        currentRingtone?: HTMLAudioElement;
        callTimerInterval?: number;
        videoCallData?: {
            conversationId: number;
            currentUserId: number;
            callId: number;
            callType: 'video' | 'audio';
            isInitiator: boolean;
        };
    }
}

export {};