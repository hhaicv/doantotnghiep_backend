import './bootstrap';
import Swal from 'sweetalert2'; // Dùng SweetAlert2

window.Echo.channel("promotions").listen("PromotionCreated", (event) => {
    console.log("Dữ liệu sự kiện nhận được:", event);
console.log("Day la event code",event.code);
    // Sử dụng SweetAlert2 để hiển thị thông báo
    Swal.fire({
        title: `🎉 Voucher mới: ${event.title}!`,
        html: `
            <p style="font-size: 18px; margin: 0;">Giảm giá <strong>${event.discount}%</strong> cho khách hàng!</p>
            <p style="margin-top: 10px;">Mã khuyến mãi: <strong style="color: #ff5722; font-size: 20px;">${event.code}</strong></p>
            <p style="font-size: 14px; color: gray;">Hãy nhanh tay áp dụng để tận hưởng ưu đãi.</p>
        `,
        icon: 'success',
        confirmButtonText: 'OK',
        background: '#fff',
        color: '#333',
        timer: 10000, // Tự động ẩn sau 10 giây
        timerProgressBar: true,
        showCloseButton: true, // Nút đóng
        // backdrop: `
        //     rgba(0,0,123,0.4)
        //     url("https://media.giphy.com/media/3o7TKP9lnyMAkP4ZDi/giphy.gif")
        //     left top
        //     no-repeat
        // `, // Thêm hình nền sinh động
    });
});
