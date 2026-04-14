import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import tailwindcss from '@tailwindcss/vite';
import path from 'path';

export default defineConfig({
    plugins: [
        tailwindcss(),
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/main.tsx',
                'resources/js/chat-init.ts',
                'resources/js/echo.ts',     
                'resources/js/bootstrap.ts',
                'resources/js/video-call-init.ts'
            ],
            refresh: true,
        }),
        react(),
    ],
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
            '~@fortawesome': path.resolve(__dirname, 'node_modules/@fortawesome'),
            '@': path.resolve(__dirname, 'resources/js'),
        },
    },
    server: {
        host: '0.0.0.0',
        port: 5173,
        hmr: {
            host: 'localhost',
        },
    },
    // build: {
    //     // rollupOptions: {
    //     //     output: {
    //     //         manualChunks: {
    //     //             'vendor': ['react', 'react-dom', 'axios', 'lodash'],
    //     //             'bootstrap': ['bootstrap', '@popperjs/core'],
    //     //             'echo': ['laravel-echo', 'pusher-js'],
    //     //         },
    //     //     },
    //     // },
    // },
    esbuild: {
        loader: 'tsx',
        include: /resources\/js\/.*\.[tj]sx?$/,
        exclude: [],
    },
    optimizeDeps: {
        esbuildOptions: {
            loader: {
                '.js': 'jsx',
                '.ts': 'tsx',
                '.tsx': 'tsx',
            },
        },
    },
});