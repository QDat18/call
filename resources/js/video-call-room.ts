import axios from "axios";
import { createWebRTCInstance } from "./hooks/useWebRTCHelper";
/* eslint-disable @typescript-eslint/no-explicit-any */
const api = axios.create({ baseURL: "/api" });
const localVideo = document.getElementById("local-video") as HTMLVideoElement;
const remoteVideo = document.getElementById("remote-video") as HTMLVideoElement;
const muteBtn = document.getElementById("mute-btn")!;
const videoBtn = document.getElementById("video-btn")!;
const endBtn = document.getElementById("end-btn")!;

let stream: MediaStream;
let pc: RTCPeerConnection;

async function init() {
    const callId = (window as any).callId;
    const userId = (window as any).currentUserId;

    stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
    localVideo.srcObject = stream;

    const res = await api.get(`/video-calls/${callId}`);
    const call = res.data;
    const isInitiator = call.initiated_by === userId;

    const webRTC = createWebRTCInstance({ currentUserId: userId, callId, callType: "video", isInitiator });
    pc = webRTC.peerConnection;
    stream.getTracks().forEach(t => pc.addTrack(t, stream));

    if (isInitiator) {
        const offer = await pc.createOffer();
        await pc.setLocalDescription(offer);
        await api.post("/video-calls/offer", { call_id: callId, offer, to_user_id: call.participants[0].user_id });
    } else {
        const sdp = await api.get(`/video-calls/offer-sdp/${callId}`);
        await pc.setRemoteDescription(new RTCSessionDescription(sdp.data.offer));
        const answer = await pc.createAnswer();
        await pc.setLocalDescription(answer);
        await api.post("/video-calls/answer", { call_id: callId, answer, to_user_id: call.initiated_by });
    }

    pc.ontrack = (e) => remoteVideo.srcObject = e.streams[0];
}

init();

muteBtn.onclick = () => {
    const audio = stream.getAudioTracks()[0];
    audio.enabled = !audio.enabled;
    muteBtn.innerHTML = audio.enabled ? '<i class="fas fa-microphone"></i>' : '<i class="fas fa-microphone-slash"></i>';
};

videoBtn.onclick = () => {
    const video = stream.getVideoTracks()[0];
    video.enabled = !video.enabled;
    videoBtn.classList.toggle("active", video.enabled);
};

endBtn.onclick = () => {
    api.post("/video-calls/end", { call_id: (window as any).callId });
    window.close();
};