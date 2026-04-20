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

    const pusherKey = import.meta.env.VITE_PUSHER_APP_KEY;
    const pusherCluster = import.meta.env.VITE_PUSHER_APP_CLUSTER || "ap1";
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute("content") ?? "";

    if (!pusherKey || pusherKey === "your_pusher_key") {
        console.warn("⚠️ Pusher Key is missing or default! Please set VITE_PUSHER_APP_KEY in your Render environment.");
    }

    (window as any).Echo = new Echo({
        broadcaster: "pusher",
        key: pusherKey || "your_pusher_key",
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
    pusher.connection.bind("error", (err: any) => {
        console.error("❌ Pusher error details:", err);
        if (err.error && err.error.data && err.error.data.code === 4001) {
            console.error("👉 Error 4001: App key not found. Check your VITE_PUSHER_APP_KEY.");
        }
    });

    console.log("✅ Echo initialized with Pusher Cloud");
}
