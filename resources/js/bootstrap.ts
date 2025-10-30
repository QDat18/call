/* eslint-disable @typescript-eslint/no-explicit-any */
import _ from 'lodash';
import axios from 'axios';
import { initializeEcho } from './echo';

(window as any)._ = _;
(window as any).axios = axios;
(window as any).axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * CSRF Token Setup
 */
const token = document.head.querySelector<HTMLMetaElement>('meta[name="csrf-token"]');

if (token) {
    (window as any).axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

// ✅ KHỞI TẠO ECHO NGAY LẬP TỨC (không đợi DOMContentLoaded)
console.log('🚀 Initializing Echo immediately...');
initializeEcho();

// ✅ Đảm bảo Echo sẵn sàng trước khi load chat
document.addEventListener('DOMContentLoaded', () => {
    console.log('✅ DOM loaded, Echo status:', window.Echo ? 'Ready' : 'Not ready');
});