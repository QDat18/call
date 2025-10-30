/* eslint-disable @typescript-eslint/no-explicit-any */
import Echo from "laravel-echo";
import Pusher from "pusher-js";

export function initializeEcho(): void {
    if ((window as any).Echo) {
        console.log("ℹ️ Echo already initialized");
        return;
    }

    console.log("🚀 Initializing Echo (Pusher Cloud)...");

    (window as any).Pusher = Pusher;
    Pusher.logToConsole = false; // bật true nếu muốn debug

    const pusherKey = import.meta.env.VITE_PUSHER_APP_KEY || "your_pusher_key";
    const pusherCluster = import.meta.env.VITE_PUSHER_APP_CLUSTER || "ap1";
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute("content") ?? "";

    (window as any).Echo = new Echo({
        broadcaster: "pusher",
        key: pusherKey,
        cluster: pusherCluster,
        forceTLS: true,
        authEndpoint: "/broadcasting/auth",
        disableStats: false,
        auth: {
            headers: {
                "X-CSRF-TOKEN": csrfToken,
                Accept: "application/json",
            },
        },
    });

    const echo = (window as any).Echo;
    const pusher = echo.connector.pusher;

    pusher.connection.bind("connected", () => console.log("✅ Pusher connected (Cloud)"));
    pusher.connection.bind("error", (err: any) => console.error("❌ Pusher error:", err));

    console.log("✅ Echo initialized with Pusher Cloud");
}
