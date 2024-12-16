document.querySelectorAll('.seat').forEach(function(button) {
            button.addEventListener('click', function() {
                const seatStatus = button.getAttribute('data-seat-status');

                if (seatStatus === 'available') {
                    // Kiểm tra số ghế đã chọn
                    if (selectedSeats.length < maxSeats) {
                        button.classList.toggle('selected');
                        const isSelected = button.classList.contains('selected');

                        // Cập nhật trạng thái ghế
                        button.setAttribute('data-seat-status', isSelected ? 'selected' : 'available');

                        // Cập nhật màu nền cho ghế đã chọn
                        if (isSelected) {
                            button.style.backgroundColor = '#9dc3fe'; // Màu nền cho ghế đã chọn
                            const seatName = button.getAttribute('data-name'); // Lấy tên ghế từ data-name
                            selectedSeats.push(seatName); // Thêm ghế đã chọn vào mảng
                        } else {
                            button.style.backgroundColor = ''; // Đặt lại màu nền khi bỏ chọn
                            const seatName = button.getAttribute('data-name'); // Lấy tên ghế từ data-name
                            selectedSeats = selectedSeats.filter(seat => seat !==
                                seatName); // Xóa ghế khỏi mảng
                        }

                        // Cập nhật hiển thị ghế đã chọn
                        document.getElementById('selected-seats').textContent = selectedSeats.join(', ');
                        document.getElementById('name_seat').value = selectedSeats.join(', ');

                        // Tính tổng tiền
                        const totalPrice = selectedSeats.length * fare; // Tổng tiền
                        document.getElementById('total-price').textContent = totalPrice.toLocaleString(
                            'vi-VN', {
                                style: 'currency',
                                currency: 'VND'
                            });
                        document.getElementById("billinginfo-thucthu").value = totalPrice;
                    } else {
                        alert('Bạn chỉ có thể chọn tối đa ' + maxSeats + ' ghế.');
                    }
                } else if (seatStatus === 'selected') {
                    // Nếu ghế đã được chọn, bỏ chọn nó
                    button.classList.remove('selected'); // Bỏ class 'selected'
                    button.setAttribute('data-seat-status', 'available'); // Đặt lại trạng thái ghế

                    // Đặt lại màu nền khi bỏ chọn
                    button.style.backgroundColor = '';

                    const seatName = button.getAttribute('data-name'); // Lấy tên ghế từ data-name
                    selectedSeats = selectedSeats.filter(seat => seat !== seatName); // Xóa ghế khỏi mảng

                    // Cập nhật hiển thị ghế đã chọn
                    document.getElementById('selected-seats').textContent = selectedSeats.join(', ');

                    document.getElementById('name_seat').value = selectedSeats.join(', ');

                    // Tính tổng tiền
                    const totalPrice = selectedSeats.length * fare; // Tổng tiền
                    document.getElementById('total-price').textContent = totalPrice.toLocaleString(
                        'vi-VN', {
                            style: 'currency',
                            currency: 'VND'
                        });
                    document.getElementById("billinginfo-thucthu").value = totalPrice;
                } else if (seatStatus === 'booked') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Thông báo',
                        text: 'Ghế đã đươc mua. Vui lòng chọn ghế khác!.',
                        confirmButtonText: 'OK'
                    });
                    return;
                } else if (seatStatus === 'lock') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Thông báo',
                        text: 'Ghế đã được đặt. Vui lòng chọn ghế khác!.',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
            });
        });
