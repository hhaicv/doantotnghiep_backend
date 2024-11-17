<<<<<<< HEAD
import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
=======
const userId = document.getElementById('user-id').value; // Lấy user ID từ DOM hoặc nơi khác

Echo.private('user.' + userId)
    .listen('VoucherNotification', (e) => {
        console.log('Voucher received:', e.voucher);
        // Hiển thị thông báo voucher cho người dùng
    });
>>>>>>> 34c47bae6f3296d062997e3851a02c5d8db8c579
