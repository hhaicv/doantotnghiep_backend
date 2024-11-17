/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';




/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    encrypted: true
});

import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true
});

// Thay `userId` bằng ID thực của người dùng (ví dụ bạn có thể truyền từ backend vào frontend).
let userId =  3    ;

// Lắng nghe kênh cho người dùng cụ thể
window.Echo.private(`user.${userId}`)
    .listen('.promotion.notification', (data) => {
        alert(`Bạn nhận được một khuyến mãi mới: ${data.promotionData.title}`);
    });

// Lắng nghe kênh chung cho tất cả người dùng
window.Echo.channel('promotions')
    .listen('.promotion.notification', (data) => {
        alert(`Thông báo khuyến mãi mới: ${data.promotionData.title}`);
    });
