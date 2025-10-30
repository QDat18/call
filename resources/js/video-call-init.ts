/* eslint-disable @typescript-eslint/no-explicit-any */
import axios from "axios";
import { createWebRTCInstance } from "./hooks/useWebRTCHelper";

declare global {
    interface Window {
        Echo: any;
        currentUserId?: number;
        receiverId?: number;
        conversationId: number;
        isInitiator?: boolean;
        acceptCall?: (callId: number) => Promise<void>;
        declineCall?: (callId: number, btn: HTMLElement) => Promise<void>;
        initializeVideoCall?: (currentUserId: number, receiverId: number, isInitiator?: boolean) => Promise<void>;
    }
}

/**
 * Hàm khởi tạo toàn bộ video call logic (caller + callee)
 */
export async function initializeVideoCall(
    currentUserId: number,
    receiverId: number,
    isInitiator = false
): Promise<void> {
    window.currentUserId = currentUserId;
    window.receiverId = receiverId;
    window.isInitiator = isInitiator;

    const api = axios.create({
        baseURL: "/api",
        headers: { "Content-Type": "application/json" },
    });

    const conversationId = window.conversationId;

    /**
     * ✅ Caller: Bắt đầu gọi
     */
    const startCall = async (type: "video" | "audio") => {
        try {
            console.log("📞 Starting new call as initiator:", isInitiator);

            if (!isInitiator) {
                console.warn("⚠️ You are not initiator — skipping initiate()");
                return;
            }

            const res = await api.post("/video-calls/initiate", {
                conversation_id: conversationId,
                call_type: type,
            });

            const callId = res.data.call_id;
            console.log("✅ Call created:", callId);

            const webRTC = createWebRTCInstance({
                currentUserId,
                callId,
                callType: type,
                isInitiator: true,
                remoteUserId: receiverId,
            });

            await webRTC.startCall();

            const offer = await webRTC.peerConnection.createOffer();
            await webRTC.peerConnection.setLocalDescription(offer);

            // gửi offer lên server
            await api.post("/video-calls/offer", {
                call_id: callId,
                offer,
                to_user_id: receiverId,
            });

            console.log("📨 Offer sent to server");
        } catch (error: any) {
            console.error("❌ Error starting call:", error);
            if (error.response?.status === 409) {
                alert("⚠️ Đã có cuộc gọi đang diễn ra trong cuộc trò chuyện này.");
            }
        }
    };

    /**
     * ✅ Caller chỉ có nút gọi video/audio
     */
    const videoBtn = document.getElementById("start-video-call");
    if (isInitiator) {
        videoBtn?.addEventListener("click", () => startCall("video"));
    } else {
        console.log("👂 Waiting for incoming call...");
    }

    /**
     * ✅ Nhận cuộc gọi mới qua Pusher
     */
    const echo = window.Echo.private(`video-call.${currentUserId}`);
    echo.listen(".offer.created", (e: any) => {
        console.log("📞 Incoming offer:", e);

        // Không tạo thêm div nếu đã có popup
        if (document.querySelector(".incoming-call")) return;

        const div = document.createElement("div");
        div.className =
            "incoming-call fixed bottom-4 right-4 bg-white border shadow-lg p-4 rounded-xl z-50";
        div.innerHTML = `
            <strong>📞 Người dùng ${e.from_user_id} đang gọi video!</strong>
            <div class="mt-2 space-x-2">
                <button id="accept-call" class="bg-green-600 text-white px-3 py-1 rounded">Chấp nhận</button>
                <button id="decline-call" class="bg-red-600 text-white px-3 py-1 rounded">Từ chối</button>
            </div>
        `;
        document.body.appendChild(div);

        document
            .getElementById("accept-call")
            ?.addEventListener("click", () => window.acceptCall?.(e.call_id));
        document
            .getElementById("decline-call")
            ?.addEventListener("click", (btn) =>
                window.declineCall?.(e.call_id, btn.target as HTMLElement)
            );
    });

    /**
     * ✅ Người nhận: Chấp nhận cuộc gọi
     */
    window.acceptCall = async (callId: number) => {
        try {
            const res = await api.get(`/video-calls/offer-sdp/${callId}`);
            const offer = res.data.offer;
            const fromId = res.data.from_user_id;

            console.log("🎧 Accepting call from", fromId);

            const webRTC = createWebRTCInstance({
                currentUserId,
                callId,
                callType: "video",
                isInitiator: false,
                remoteUserId: fromId,
            });

            await webRTC.startCall();
            await webRTC.peerConnection.setRemoteDescription(
                new RTCSessionDescription(offer)
            );

            const answer = await webRTC.peerConnection.createAnswer();
            await webRTC.peerConnection.setLocalDescription(answer);

            await api.post("/video-calls/answer", {
                call_id: callId,
                answer,
                to_user_id: fromId,
            });

            console.log("✅ Answer sent!");
            document.querySelector(".incoming-call")?.remove();
        } catch (error) {
            console.error("❌ Error accepting call:", error);
        }
    };

    /**
     * ❌ Người nhận: Từ chối cuộc gọi
     */
    window.declineCall = async (callId: number, btn: HTMLElement) => {
        try {
            await api.post("/video-calls/decline", { call_id: callId });
            btn.closest(".incoming-call")?.remove();
            console.log("❌ Call declined");
        } catch (error) {
            console.error("❌ Error declining call:", error);
        }
    };
}

// ✅ Gắn global
window.initializeVideoCall = initializeVideoCall;
