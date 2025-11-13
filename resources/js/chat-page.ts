/**
 * chat-page.ts
 * Main entry point for chat page with video call integration
 */
/* eslint-disable @typescript-eslint/no-explicit-any */
import { initializeChat } from './chat-init';
import { initializeVideoCall } from './video-call-init';

declare global {
    interface Window {
        conversationId: number;
        currrentUserId?: number;
        receiverId: number;
        currentUserName: string;
        chatConfig?: {
            conversationId: number;
            currentUserId: number;
            receiverId: number;
            currentUserName: string;
            otherUserName: string;
            otherUserAvatar: string;
        };
    }
}

/**
 * Initialize chat page with all features
 */
async function initializeChatPage(): Promise<void> {
    console.log('🚀 Initializing chat page...');

    try {
        // Get configuration from window
        const config = window.chatConfig || {
            conversationId: window.conversationId,
            currentUserId: window.currentUserId,
            receiverId: window.receiverId,
            currentUserName: window.currentUserName || 'User'
        };

        console.log('📋 Chat page config:', config);

        // Validate required data
        if (!config.conversationId || !config.currentUserId || !config.receiverId) {
            console.error('❌ Missing required configuration:', config);
            alert('Invalid page configuration. Please refresh.');
            return;
        }

        // Wait for Echo to be ready
        console.log('⏳ Waiting for Echo...');
        const echoReady = await waitForEcho(10000);

        if (!echoReady) {
            console.warn('⚠️ Echo not ready, some features may not work');
        } else {
            console.log('✅ Echo is ready');
        }

        // Initialize chat functionality
        console.log('💬 Initializing chat...');
        await initializeChat(
            config.conversationId,
            config.currentUserId,
            config.currentUserName
        );
        console.log('✅ Chat initialized');

        // Initialize video call functionality
        console.log('📞 Initializing video call...');
        const videoCallInitializer = await initializeVideoCall(
            config.currentUserId,
            config.receiverId,
            true // isInitiator
        );

        if (videoCallInitializer) {
            console.log('✅ Video call initialized');
            
            // Store for cleanup
            (window as any).videoCallInitializer = videoCallInitializer;
        } else {
            console.warn('⚠️ Video call initialization failed');
        }

        // Setup cleanup on page unload
        window.addEventListener('beforeunload', () => {
            console.log('🧹 Cleaning up before page unload...');
            
            if ((window as any).videoCallInitializer) {
                (window as any).videoCallInitializer.destroy();
            }
        });

        console.log('✅ Chat page initialization complete');

    } catch (error) {
        console.error('❌ Chat page initialization failed:', error);
        alert('Failed to initialize chat. Please refresh the page.');
    }
}

/**
 * Wait for Echo to be initialized
 */
async function waitForEcho(maxWait: number = 10000): Promise<boolean> {
    const startTime = Date.now();
    
    while (!(window as any).Echo) {
        // Check timeout
        if (Date.now() - startTime > maxWait) {
            console.error('❌ Echo timeout after', maxWait, 'ms');
            return false;
        }
        
        // Wait 100ms before checking again
        await new Promise(resolve => setTimeout(resolve, 100));
    }
    
    const elapsed = Date.now() - startTime;
    console.log(`✅ Echo ready after ${elapsed}ms`);
    return true;
}

/**
 * Auto-initialize when DOM is ready
 */
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeChatPage);
} else {
    // DOM already loaded
    initializeChatPage();
}

// Export for manual initialization if needed
export { initializeChatPage };