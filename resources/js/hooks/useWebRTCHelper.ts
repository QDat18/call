/* eslint-disable @typescript-eslint/no-explicit-any */
import axios from "axios";

interface WebRTCConfig {
    currentUserId: number;
    callId: number;
    callType: "video" | "audio";
    isInitiator: boolean;
    remoteUserId?: number;
}

interface UseWebRTCReturn {
    peerConnection: RTCPeerConnection;
    localStream: MediaStream | null;
    remoteStream: MediaStream | null;
    startCall: () => Promise<void>;
    endCall: () => Promise<void>;
    toggleAudio: () => void;
    toggleVideo: () => void;
}

const ICE_SERVERS = {
    iceServers: [
        { urls: "stun:stun.l.google.com:19302" },
        {
            urls: "turn:hk-turn1.xirsys.com:80?transport=udp",
            username: "8My9vEKgN_ztujbPb3pKVaXS6WsmCmh4E8abUZADTnRK1bYH-LWWKZykXbwaj80wAAAAAGj7qERraGllbWhvYW5nZw==",
            credential: "eecb6e84-b0f5-11f0-a713-0242ac120004",
        },
    ],
};

export function createWebRTCInstance(config: WebRTCConfig): UseWebRTCReturn {
    let pc: RTCPeerConnection | null = null;
    let localStream: MediaStream | null = null;
    let remoteStream: MediaStream | null = null;

    const api = axios.create({
        baseURL: "/api",
        headers: { "Content-Type": "application/json" },
    });

    function initPeerConnection(): RTCPeerConnection {
        const peer = new RTCPeerConnection(ICE_SERVERS);

        peer.onicecandidate = (event) => {
            if (event.candidate) {
                api.post("/video-calls/ice-candidate", {
                    call_id: config.callId,
                    from_user_id: config.currentUserId,
                    to_user_id: config.remoteUserId,
                    candidate: event.candidate,
                }).catch((err) => console.error("❌ ICE send failed:", err));
            }
        };

        peer.ontrack = (event) => {
            const remoteVideo = document.getElementById("remote-video") as HTMLVideoElement;
            if (event.streams?.[0] && remoteVideo) {
                remoteVideo.srcObject = event.streams[0];
                remoteStream = event.streams[0]; // ✅ gán giá trị
            }
        };

        return peer;
    }

    async function startCall(): Promise<void> {
        pc = initPeerConnection();
        localStream = await navigator.mediaDevices.getUserMedia({
            audio: true,
            video: config.callType === "video",
        });

        const localVideo = document.getElementById("local-video") as HTMLVideoElement;
        if (localVideo) localVideo.srcObject = localStream;

        localStream.getTracks().forEach((t) => pc!.addTrack(t, localStream!));
    }

    async function endCall(): Promise<void> {
        localStream?.getTracks().forEach((t) => t.stop());
        pc?.close();
        await api.post("/video-calls/end", { call_id: config.callId });
    }

    function toggleAudio() {
        const track = localStream?.getAudioTracks()[0];
        if (track) track.enabled = !track.enabled;
    }

    function toggleVideo() {
        const track = localStream?.getVideoTracks()[0];
        if (track) track.enabled = !track.enabled;
    }

    // ✅ Trả về cả remoteStream để không còn báo lỗi unused
    return {
        get peerConnection() {
            if (!pc) throw new Error("Peer not initialized");
            return pc;
        },
        get localStream() {
            return localStream;
        },
        get remoteStream() {
            return remoteStream;
        },
        startCall,
        endCall,
        toggleAudio,
        toggleVideo,
    };
}
