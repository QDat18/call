/**
 * Global type definitions
 * Khai báo types cho window object và các biến global
 */

/* eslint-disable @typescript-eslint/no-explicit-any */

import type Echo from 'laravel-echo';
import type Pusher from 'pusher-js';

declare global {
    interface Window {
        /**
         * Laravel Echo instance
         */
        Echo: Echo | undefined;

        /**
         * Pusher instance
         */
        Pusher: typeof Pusher | undefined;

        /**
         * Axios instance
         */
        axios: any;

        /**
         * Lodash instance
         */
        _: any;

        /**
         * Chat initialization function
         */
        initializeChat?: (
            conversationId: number,
            currentUserId: number,
            currentUserName: string
        ) => Promise<void>;

        /**
         * Current user ID (for WebRTC)
         */
        currentUserId?: number;

        /**
         * Current ringtone audio element
         */
        currentRingtone?: HTMLAudioElement;

        /**
         * Typing timer
         */
        typingTimer?: number;
    }
}

export {};