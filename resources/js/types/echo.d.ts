import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
/* eslint-disable @typescript-eslint/no-explicit-any */
declare global {
    interface Window {
        Echo: Echo;
        Pusher: typeof Pusher;
        axios: any;
        _: any;
    }
}

export {};