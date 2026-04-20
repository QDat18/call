// Basic Service Worker to satisfy the registration request and prevent MIME type errors.
// This service worker currently does nothing but can be expanded for PWA features.

self.addEventListener('install', (event) => {
    console.log('[Service Worker] Installing Service Worker...', event);
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    console.log('[Service Worker] Activating Service Worker...', event);
    return self.clients.claim();
});

self.addEventListener('fetch', (event) => {
    // Standard fetch pass-through
    event.respondWith(fetch(event.request));
});
