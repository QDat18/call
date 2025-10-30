import React, { useState, useEffect, useMemo, useCallback } from 'react';
import axios, { AxiosError } from 'axios';

/**
 * ============================================================================
 * INTERFACES & TYPES
 * ============================================================================
 */

interface Caller {
    user_id: number;
    name: string;
    avatar_url?: string;
}

interface IncomingCall {
    call_id: number;
    call_type: 'video' | 'audio';
    caller: Caller;
}

interface CallStatus {
    type: 'success' | 'error' | 'info' | 'warning';
    title: string;
    message: string;
}

interface VideoOfferData {
    call_id: number;
    call_type: 'video' | 'audio';
    offer: RTCSessionDescriptionInit;
    from_user_id: number;
}

interface VideoDeclinedData {
    call_id: number;
    from_user_id: number;
    reason?: string;
}

interface VideoEndedData {
    call_id: number;
    from_user_id: number;
}

interface InitiateCallResponse {
    success: boolean;
    call_id: number;
    room_id: string;
    call_type: string;
    participants: number[];
    message?: string;
}

interface CallDetailsResponse {
    success: boolean;
    call: {
        call_id: number;
        call_type: string;
        initiator: Caller;
    };
}

interface ErrorResponse {
    message?: string;
    success?: boolean;
}

/**
 * ============================================================================
 * PROPS INTERFACE
 * ============================================================================
 */

interface VideoChatProps {
    conversationId: number;
    currentUserId: number;
}

/**
 * ============================================================================
 * VIDEOCHAT COMPONENT
 * ============================================================================
 */

const VideoChat: React.FC<VideoChatProps> = ({ conversationId, currentUserId }) => {
    // ========================================================================
    // STATE MANAGEMENT
    // ========================================================================
    // eslint-disable-next-line @typescript-eslint/no-unused-vars
    const [isCallActive, setIsCallActive] = useState<boolean>(false);
    const [isInitiating, setIsInitiating] = useState<boolean>(false);
    const [incomingCall, setIncomingCall] = useState<IncomingCall | null>(null);
    const [callStatus, setCallStatus] = useState<CallStatus | null>(null);

    // ========================================================================
    // COMPUTED VALUES
    // ========================================================================

    /**
     * Get appropriate icon for call status
     */
    const callStatusIcon = useMemo<string>(() => {
        if (!callStatus) return '';
        
        const icons: Record<CallStatus['type'], string> = {
            success: 'fas fa-check-circle text-success',
            error: 'fas fa-exclamation-circle text-danger',
            info: 'fas fa-info-circle text-info',
            warning: 'fas fa-exclamation-triangle text-warning'
        };
        
        return icons[callStatus.type] || icons.info;
    }, [callStatus]);

    // ========================================================================
    // HELPER FUNCTIONS
    // ========================================================================

    /**
     * Show status message to user
     */
    const showStatus = useCallback((status: CallStatus): void => {
        setCallStatus(status);
        
        // Auto-hide after 5 seconds
        setTimeout(() => {
            setCallStatus(null);
        }, 5000);
    }, []);

    /**
     * Play ringtone audio
     */
    const playRingtone = useCallback((): void => {
        const audio = document.getElementById('ringtone-audio') as HTMLAudioElement | null;
        if (audio) {
            audio.play().catch((e: Error) => {
                console.warn('Error playing ringtone:', e.message);
            });
        }
    }, []);

    /**
     * Stop ringtone audio
     */
    const stopRingtone = useCallback((): void => {
        const audio = document.getElementById('ringtone-audio') as HTMLAudioElement | null;
        if (audio) {
            audio.pause();
            audio.currentTime = 0;
        }
    }, []);

    // ========================================================================
    // CALL MANAGEMENT FUNCTIONS
    // ========================================================================

    /**
     * Initiate a new call
     */
    const initiateCall = useCallback(async (callType: 'video' | 'audio'): Promise<void> => {
        setIsInitiating(true);
        
        try {
            const response = await axios.post<InitiateCallResponse>('/api/video-calls/initiate', {
                conversation_id: conversationId,
                call_type: callType
            });

            if (response.data.success) {
                // Redirect to call room
                window.location.href = `/video-calls/${response.data.call_id}/join`;
            } else {
                showStatus({
                    type: 'error',
                    title: 'Call Failed',
                    message: response.data.message || 'Failed to initiate call.'
                });
            }
        } catch (error) {
            console.error('Error initiating call:', error);
            
            const axiosError = error as AxiosError<ErrorResponse>;
            
            showStatus({
                type: 'error',
                title: 'Call Failed',
                message: axiosError.response?.data?.message || 'Failed to initiate call. Please try again.'
            });
        } finally {
            setIsInitiating(false);
        }
    }, [conversationId, showStatus]);

    /**
     * Handle incoming call
     */
    const handleIncomingCall = useCallback(async (data: VideoOfferData): Promise<void> => {
        try {
            // Fetch call details
            const response = await axios.get<CallDetailsResponse>(`/api/video-calls/${data.call_id}`);
            
            if (response.data.success) {
                const call = response.data.call;
                
                setIncomingCall({
                    call_id: call.call_id,
                    call_type: call.call_type as 'video' | 'audio',
                    caller: call.initiator
                });

                // Play ringtone
                playRingtone();
            }
        } catch (error) {
            console.error('Error fetching call details:', error);
            showStatus({
                type: 'error',
                title: 'Error',
                message: 'Failed to retrieve call information.'
            });
        }
    }, [playRingtone, showStatus]);

    /**
     * Accept incoming call
     */
    const acceptCall = useCallback((): void => {
        if (incomingCall) {
            stopRingtone();
            window.location.href = `/video-calls/${incomingCall.call_id}/join`;
        }
    }, [incomingCall, stopRingtone]);

    /**
     * Decline incoming call
     */
    const declineCall = useCallback(async (): Promise<void> => {
        if (!incomingCall) return;

        try {
            await axios.post('/api/video-calls/decline', {
                call_id: incomingCall.call_id,
                reason: 'User declined'
            });

            stopRingtone();
            setIncomingCall(null);
            
            showStatus({
                type: 'info',
                title: 'Call Declined',
                message: 'You declined the call.'
            });
        } catch (error) {
            console.error('Error declining call:', error);
            
            // Still close the modal even if request fails
            stopRingtone();
            setIncomingCall(null);
        }
    }, [incomingCall, stopRingtone, showStatus]);

    // ========================================================================
    // LARAVEL ECHO EVENT LISTENERS
    // ========================================================================

    /**
     * Listen for incoming calls via Laravel Echo
     */
    const listenForIncomingCalls = useCallback((): void => {
        if (!window.Echo) {
            console.error('Laravel Echo not initialized');
            return;
        }
        
        const channel = window.Echo.private(`video-call.${currentUserId}`);
        
        channel
            // Handle incoming call offer
            .listen('.video.offer', (data: VideoOfferData) => {
                console.log('Incoming call offer:', data);
                handleIncomingCall(data);
            })
            // Handle call declined
            .listen('.video.declined', (data: VideoDeclinedData) => {
                console.log('Call declined:', data);
                showStatus({
                    type: 'warning',
                    title: 'Call Declined',
                    message: data.reason || 'The call was declined.'
                });
                setIncomingCall(null);
                stopRingtone();
            })
            // Handle call ended
            .listen('.video.ended', (data: VideoEndedData) => {
                console.log('Call ended:', data);
                if (incomingCall && incomingCall.call_id === data.call_id) {
                    showStatus({
                        type: 'info',
                        title: 'Call Ended',
                        message: 'The call has ended.'
                    });
                    setIncomingCall(null);
                    stopRingtone();
                }
            });
    }, [currentUserId, handleIncomingCall, incomingCall, showStatus, stopRingtone]);

    // ========================================================================
    // LIFECYCLE HOOKS
    // ========================================================================

    /**
     * Component Did Mount
     */
    useEffect(() => {
        // Start listening for incoming calls
        listenForIncomingCalls();
        
        // Cleanup on unmount
        return () => {
            if (window.Echo) {
                window.Echo.leave(`video-call.${currentUserId}`);
            }
            stopRingtone();
        };
    }, [listenForIncomingCalls, currentUserId, stopRingtone]);

    // ========================================================================
    // RENDER
    // ========================================================================

    return (
        <div className="video-chat-component">
            {/* ============================================================
                CALL BUTTONS
            ============================================================ */}
            <div className="call-actions">
                <button 
                    onClick={() => initiateCall('video')} 
                    className="btn btn-primary me-2"
                    disabled={isCallActive || isInitiating}
                    title="Start Video Call"
                >
                    <i className="fas fa-video me-2"></i>
                    {isInitiating ? 'Connecting...' : 'Video Call'}
                </button>
                
                <button 
                    onClick={() => initiateCall('audio')} 
                    className="btn btn-secondary"
                    disabled={isCallActive || isInitiating}
                    title="Start Audio Call"
                >
                    <i className="fas fa-phone me-2"></i>
                    {isInitiating ? 'Connecting...' : 'Audio Call'}
                </button>
            </div>

            {/* ============================================================
                INCOMING CALL MODAL
            ============================================================ */}
            {incomingCall && (
                <div 
                    className="modal fade show d-block" 
                    tabIndex={-1} 
                    style={{ background: 'rgba(0,0,0,0.8)' }}
                    role="dialog"
                    aria-labelledby="incomingCallModalLabel"
                    aria-hidden="false"
                >
                    <div className="modal-dialog modal-dialog-centered">
                        <div className="modal-content">
                            {/* Modal Header */}
                            <div className="modal-header border-0">
                                <h5 className="modal-title" id="incomingCallModalLabel">
                                    <i className="fas fa-phone-volume me-2 text-primary"></i>
                                    Incoming {incomingCall.call_type === 'video' ? 'Video' : 'Audio'} Call
                                </h5>
                            </div>
                            
                            {/* Modal Body */}
                            <div className="modal-body text-center py-4">
                                <div className="caller-info mb-4">
                                    <img 
                                        src={incomingCall.caller.avatar_url || '/images/default-avatar.png'} 
                                        className="rounded-circle mb-3"
                                        style={{ 
                                            width: '100px', 
                                            height: '100px', 
                                            objectFit: 'cover',
                                            border: '4px solid #667eea'
                                        }}
                                        alt={incomingCall.caller.name}
                                    />
                                    <h4 className="mb-2">{incomingCall.caller.name}</h4>
                                    <p className="text-muted">
                                        <i className={`fas fa-${incomingCall.call_type === 'video' ? 'video' : 'phone'} me-2`}></i>
                                        {incomingCall.call_type === 'video' ? 'Video' : 'Audio'} Call
                                    </p>
                                </div>
                                
                                {/* Ringing Animation */}
                                <div className="ringing-animation">
                                    <i className="fas fa-phone ringing-icon"></i>
                                </div>
                            </div>
                            
                            {/* Modal Footer */}
                            <div className="modal-footer justify-content-center border-0">
                                <button 
                                    onClick={acceptCall} 
                                    className="btn btn-success btn-lg me-3"
                                    title="Accept Call"
                                >
                                    <i className="fas fa-phone me-2"></i>
                                    Accept
                                </button>
                                <button 
                                    onClick={declineCall} 
                                    className="btn btn-danger btn-lg"
                                    title="Decline Call"
                                >
                                    <i className="fas fa-phone-slash me-2"></i>
                                    Decline
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            )}

            {/* ============================================================
                CALL STATUS TOAST
            ============================================================ */}
            {callStatus && (
                <div className="toast-container position-fixed bottom-0 end-0 p-3" style={{ zIndex: 9999 }}>
                    <div className="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                        <div className="toast-header">
                            <i className={callStatusIcon + ' me-2'}></i>
                            <strong className="me-auto">{callStatus.title}</strong>
                            <button 
                                type="button" 
                                className="btn-close" 
                                onClick={() => setCallStatus(null)}
                                aria-label="Close"
                            ></button>
                        </div>
                        <div className="toast-body">
                            {callStatus.message}
                        </div>
                    </div>
                </div>
            )}

            {/* ============================================================
                HIDDEN AUDIO ELEMENT
            ============================================================ */}
            <audio id="ringtone-audio" loop>
                <source src="/sounds/ringtone.mp3" type="audio/mpeg" />
                Your browser does not support the audio element.
            </audio>

            {/* ============================================================
                COMPONENT STYLES
            ============================================================ */}
            <style>{`
                .video-chat-component {
                    position: relative;
                }

                .call-actions {
                    display: flex;
                    gap: 10px;
                }

                .call-actions button {
                    transition: all 0.3s ease;
                }

                .call-actions button:disabled {
                    opacity: 0.6;
                    cursor: not-allowed;
                }

                .call-actions button:not(:disabled):hover {
                    transform: translateY(-2px);
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                }

                /* Ringing Animation */
                .ringing-animation {
                    margin: 20px 0;
                }

                .ringing-icon {
                    font-size: 48px;
                    color: #10b981;
                    animation: ring 1s ease-in-out infinite;
                }

                @keyframes ring {
                    0%, 100% {
                        transform: rotate(-15deg);
                    }
                    50% {
                        transform: rotate(15deg);
                    }
                }

                /* Modal Styles */
                .modal.show {
                    display: block !important;
                }

                .caller-info img {
                    animation: pulse 2s ease-in-out infinite;
                }

                @keyframes pulse {
                    0%, 100% {
                        transform: scale(1);
                    }
                    50% {
                        transform: scale(1.05);
                    }
                }

                /* Toast Styles */
                .toast-container {
                    z-index: 9999;
                }

                .toast {
                    min-width: 300px;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                }

                /* Modal Backdrop */
                .modal-backdrop {
                    background-color: rgba(0, 0, 0, 0.8);
                }

                /* Responsive Design */
                @media (max-width: 768px) {
                    .call-actions {
                        flex-direction: column;
                        width: 100%;
                    }

                    .call-actions button {
                        width: 100%;
                        margin: 0 !important;
                    }

                    .modal-dialog {
                        margin: 1rem;
                    }

                    .caller-info img {
                        width: 80px !important;
                        height: 80px !important;
                    }

                    .btn-lg {
                        padding: 0.75rem 1.5rem;
                        font-size: 1rem;
                    }
                }
            `}</style>
        </div>
    );
};

export default VideoChat;