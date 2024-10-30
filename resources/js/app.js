const userId = document.getElementById('user-id').value; // Lấy user ID từ DOM hoặc nơi khác

Echo.private('user.' + userId)
    .listen('VoucherNotification', (e) => {
        console.log('Voucher received:', e.voucher);
        // Hiển thị thông báo voucher cho người dùng
    });
