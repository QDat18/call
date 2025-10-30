import React from 'react';
import ReactDOM from 'react-dom/client';
import './bootstrap';
import VideoChat from './VideoChat';

/**
 * Global Type Definitions
 * ❌ XÓA PHẦN NÀY - ĐÃ DECLARE TRONG types/webrtc.d.ts
 */
// declare global {
//     interface Window {
//         Echo: any;
//         currentUserId?: number;
//         currentRingtone?: HTMLAudioElement;
//         Pusher?: any;
//     }
// }

/**
 * Mount React components on all elements with [data-video-chat]
 */
const mountVideoChat = (): void => {
    const elements = document.querySelectorAll<HTMLElement>('[data-video-chat]');
    
    elements.forEach((element) => {
        const conversationId = parseInt(element.dataset.conversationId || '0', 10);
        const currentUserId = parseInt(element.dataset.currentUserId || '0', 10);
        
        if (conversationId && currentUserId) {
            const root = ReactDOM.createRoot(element);
            root.render(
                <React.StrictMode>
                    <VideoChat 
                        conversationId={conversationId}
                        currentUserId={currentUserId}
                    />
                </React.StrictMode>
            );
        }
    });
};

/**
 * Initialize when DOM is ready
 */
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', mountVideoChat);
} else {
    mountVideoChat();
}

/**
 * Request notification permission
 */
if ('Notification' in window && Notification.permission === 'default') {
    Notification.requestPermission();
}

/**
 * Service Worker Registration (PWA)
 */
if ('serviceWorker' in navigator) {
    navigator.serviceWorker
        .register('/service-worker.js')
        .then((registration) => {
            console.log('Service Worker registered:', registration);
        })
        .catch((error) => {
            console.error('Service Worker registration failed:', error);
        });
}

export { mountVideoChat };