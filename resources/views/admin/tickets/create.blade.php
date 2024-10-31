@extends('admin.layouts.mater')
@section('title')
    Đặt vé
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Chọn chỗ</h4>
            </div>
        </div>
    </div>
    <style>
        li {
            list-style-type: none;
            /* Bỏ dấu chấm */
        }

        li>button {
            margin: 5px 0px;
            padding: 13px 23px;

            border-radius: 2px;
        }



        .seat.booked {
            background: #f5c170;
            /* Màu nền cho ghế "booked" */
        }

        .seat.selected {
            background: #9dc3fe;


        }
    </style>
    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body checkout-tab">
                    <div class="row">
                        <div class="col">
                            <h5 class="pt-3 fw-semibold">Tầng 1</h5>
                        </div>
                        <div class="col">
                            <li><button class="seat" data-name="A1" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A2" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A3" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A4" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A5" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A6" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" type="submit"></button></li>
                        </div>
                        <div class="col">
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button class="seat" type="submit"></button></li>
                        </div>
                        <div class="col">
                            <li><button class="seat" data-name="A7" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A8" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A9" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A10" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A11" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A12" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" type="submit"></button></li>
                        </div>
                        <div class="col">
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button class="seat" type="submit"></button></li>
                        </div>
                        <div class="col">
                            <li><button class="seat" data-name="A13" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A14" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A15" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A16" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A17" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A18" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" type="submit"></button></li>
                        </div>
                    </div>
                    <hr>
                    <div class="row mt-3">
                        <div class="col">
                            <h5 class="pt-3 fw-semibold">Tầng 2</h5>
                        </div>
                        <div class="col">
                            <li><button class="seat" data-name="B1" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B2" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B3" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B4" data-trip-id="2" data-seat-status="selected"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B5" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B6" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                        </div>
                        <div class="col">
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button class="seat" type="submit"></button></li>
                        </div>
                        <div class="col">
                            <li><button class="seat" data-name="B7" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B8" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B9" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B10" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B11" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B12" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                        </div>
                        <div class="col">
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button class="seat" type="submit"></button></li>
                        </div>
                        <div class="col">
                            <li><button class="seat" data-name="B13" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B14" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B15" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B16" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B17" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B18" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                        </div>
                    </div>


                    <div class="row mt-2 p-2" style="background: #ecedf1 !important;">
                        <div class="col">
                            <li><button type="submit"></button> <br> Ghế trống</li>
                        </div>
                        <div class="col">
                            <li><button style="background: #9dc3fe;" type="submit"></button> <br> Ghế đang chọn</li>
                        </div>
                        <div class="col">
                            <li><button style="background: #f5c170;" type="submit"></button> <br> Ghế đã đặt</li>
                        </div>
                        <div class="col">
                            <li><button style="background: #e76966;" type="submit"></button> <br> Ghế bảo trì</li>
                        </div>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>


        <!-- end col -->

        <div class="col-xl-4">
            <div class="card">
                <div class="card-body checkout-tab">
                    <form action="{{ route('admin.tickets.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="step-arrow-nav mt-n3 mx-n3 mb-3">
                            <ul class="nav nav-pills nav-justified custom-nav" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3 active" id="pills-bill-info-tab"
                                        data-bs-toggle="pill" data-bs-target="#pills-bill-info" type="button"
                                        role="tab" aria-controls="pills-bill-info" aria-selected="true">
                                        <i
                                            class="ri-truck-line fs-16 p-2 bg-primary-subtle text-primary rounded-circle align-middle me-2"></i>
                                        Thông tin chuyến
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3" id="pills-bill-address-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-bill-address" type="button" role="tab"
                                        aria-controls="pills-bill-address" aria-selected="false">

                                        <i
                                            class="ri-user-2-line fs-16 p-2 bg-primary-subtle text-primary rounded-circle align-middle me-2"></i>
                                        Thông tin người đặt
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3" id="pills-payment-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-payment" type="button" role="tab"
                                        aria-controls="pills-payment" aria-selected="false">
                                        <i
                                            class="ri-bank-card-line fs-16 p-2 bg-primary-subtle text-primary rounded-circle align-middle me-2"></i>
                                        Thanh toán
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3" id="pills-finish-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-finish" type="button" role="tab"
                                        aria-controls="pills-finish" aria-selected="false">
                                        <i
                                            class="ri-checkbox-circle-line fs-16 p-2 bg-primary-subtle text-primary rounded-circle align-middle me-2"></i>
                                        Thông báo
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="pills-bill-info" role="tabpanel"
                                aria-labelledby="pills-bill-info-tab">
                                <div>
                                    <h4 class="mb-1" id="route-info">Chiêm hóa - Bến xe Mỹ Đình</h4>
                                    <span class="fs-5" id="time-info">06:50 - 29/10/2024</span>
                                </div>
                                <hr>
                                <div class="mt-4">
                                    <div class="row gy-3">
                                        <div class="col-4">
                                            <p class="fs-5">Ghế đã chọn: </p>
                                            <p class="fs-5">Tổng tiền: </p>
                                            <p class="fs-5">Điểm đi:<span style="color: red">*</span></p>
                                            <br>
                                            <br>
                                            <br>
                                            <p class="fs-5">Điểm đến:<span style="color: red">*</span></p>
                                        </div>
                                        <div class="col">
                                            <p class="fs-5" id="selected-seats">...</p>
                                            <p class="fs-5" id="total-price">...</p>
                                            <select name="location_start" class="form-select" aria-label="Default select example">
                                                <option value="Tại bến">Tại bến</option>
                                                <option value="Dọc đường">Dọc đường</option>
                                            </select>
                                            <select name="id_start_stop" class="form-select mt-2" aria-label="Default select example"
                                                id="start-stop">
                                                <!-- ID và tên sẽ được cập nhật ở đây -->
                                            </select>
                                            <select name="location_end" class="form-select mt-3" aria-label="Default select example">
                                                <option value="1">Tại bến</option>
                                                <option value="2">Dọc đường</option>
                                            </select>
                                            <select name="id_end_stop" class="form-select mt-2" aria-label="Default select example"
                                                id="end-stop">
                                                <!-- ID và tên sẽ được cập nhật ở đây -->
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end tab pane -->

                            <div class="tab-pane fade" id="pills-bill-address" role="tabpanel"
                                aria-labelledby="pills-bill-address-tab">
                                <div>
                                    <h5 class="mb-1">Thông tin khách hàng</h5>
                                    <p class="text-muted mb-4">Vui lòng nhập đầy đủ thông tin</p>
                                </div>

                                <div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="billinginfo-firstName" class="form-label">Họ tên</label>
                                                <input type="text" name="name" class="form-control" id="billinginfo-firstName"
                                                    placeholder="Nhập họ tên" value="">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="billinginfo-lastName" class="form-label">Số điện thoại</label>
                                                <input type="text" name="phone" class="form-control" id="billinginfo-lastName"
                                                    placeholder="Nhập số điện thoại" value="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="billinginfo-email" class="form-label">Email <span
                                                        class="text-muted">(Optional)</span></label>
                                                <input type="email" name="email" class="form-control" id="billinginfo-email"
                                                    placeholder="Nhập email">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="billinginfo-address" class="form-label">Ghi chú</label>
                                        <textarea class="form-control" name="note" id="billinginfo-address" placeholder="Nhập ghi chú" rows="3"></textarea>
                                    </div>

                                </div>
                            </div>
                            <!-- end tab pane -->

                            <div class="tab-pane fade" id="pills-payment" role="tabpanel"
                                aria-labelledby="pills-payment-tab">
                                <div>
                                    <h5 class="mb-1">Thông tin thanh toán</h5>
                                    <p class="text-muted mb-4">Vui long nhập đầy đủ thông tin</p>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="billinginfo-thucthu" class="form-label">Thực thu</label>
                                            <input type="text" name="total_amount" class="form-control" id="billinginfo-thucthu" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="billinginfo-dathu" class="form-label">Đã thu</label>
                                            <input type="text" class="form-control" id="billinginfo-dathu"
                                                oninput="calculateRefund()">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="billinginfo-tralai" class="form-label">Trả lại</label>
                                            <input type="text" class="form-control" id="billinginfo-tralai" readonly>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label for="billinginfo-email" class="form-label">Hình thức thanh toán</label>
                                            <select name="payment_method" class="form-select" aria-label="Default select example">
                                                <option value="Thu tiền tại quầy">Thu tiền tại quầy</option>
                                                <option value="Thanh toán trên xe">Thanh toán trên xe</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="formCheck6" checked>
                                            <label class="form-check-label" for="formCheck6">
                                                Gửi vé điện tử qua Emali
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="formCheck6" checked>
                                            <label class="form-check-label" for="formCheck6">
                                                Gửi thông tin qua Zalo
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-start gap-3 mt-4">

                                    <button type="submit" class="btn btn-primary btn-label right ms-auto nexttab fs-5"
                                        data-nexttab="pills-finish-tab"><i
                                            class="ri-coins-fill label-icon align-middle fs-16 ms-2"></i>Thu tiền</button>
                                </div>
                            </div>
                            <!-- end tab pane -->

                            <div class="tab-pane fade" id="pills-finish" role="tabpanel"
                                aria-labelledby="pills-finish-tab">
                                <div class="text-center py-5">

                                    <div class="mb-4">
                                        <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop"
                                            colors="primary:#0ab39c,secondary:#405189"
                                            style="width:120px;height:120px"></lord-icon>
                                    </div>
                                    <h5>Cảm ơn ! Đơn hàng đã được tạo thành công !</h5>
                                    <p class="text-muted">Quý khách sẽ nhận được email vé và thông tin chi tiết.</p>

                                    <h3 class="fw-semibold">Mã vé: <ae href="apps-ecommerce-order-details.html"
                                            class="text-decoration-underline">VZ2451</ae>
                                    </h3>
                                </div>
                            </div>
                            <!-- end tab pane -->
                        </div>
                        <!-- end tab content -->
                    </form>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <script>
        // Lấy giá trị từ phần tử có id "total-price"



        function calculateRefund() {
            const thucThu = parseInt(document.getElementById('billinginfo-thucthu').value.replace(/\./g, '')) || 0;
            const daThu = parseInt(document.getElementById('billinginfo-dathu').value.replace(/\./g, '')) || 0;
            const traLai = daThu - thucThu;

            document.getElementById('billinginfo-tralai').value = formatVND(Math.max(traLai, 0));
        }

        function formatVND(number) {
            return number.toLocaleString('vi-VN') + ' đ';
        }

        function getUrlParams() {
            const params = new URLSearchParams(window.location.search);
            return {
                bus_id: params.get('bus_id'),
                route_id: params.get('route_id'),
                trip_id: params.get('trip_id'),
                start_stop_id: params.get('start_stop_id'),
                end_stop_id: params.get('end_stop_id'),
                start_name: params.get('start_name'),
                end_name: params.get('end_name'),
                route: params.get('route').replace(/\+/g, ' '),
                bus: params.get('bus').replace(/\+/g, ' '),
                time_start: params.get('time_start').substring(0, 5),
                totalSeats: params.get('totalSeats'),
                fare: parseFloat(params.get('fare')).toLocaleString('vi-VN') + ' VND',
                date: params.get('date').split('-').reverse().join('/')
            };
        }

        function displayInfo() {
            const info = getUrlParams();
            document.getElementById('route-info').textContent = info.route;
            document.getElementById('time-info').textContent = `${info.time_start} - ${info.date}`;

            document.getElementById('start-stop').innerHTML = `
                                        <option value="${info.start_stop_id}">${info.start_name}</option>
                                    `;

            document.getElementById('end-stop').innerHTML = `
                                        <option value="${info.end_stop_id}">${info.end_name}</option>
                                    `;
        }

        displayInfo();



        // Lấy giá trị trip_id từ URL
        const params = new URLSearchParams(window.location.search);
        const tripId = params.get('trip_id');

        // Gán trip_id vào các nút ghế
        const seatButtons = document.querySelectorAll('button[data-trip-id]');
        seatButtons.forEach(button => {
            button.setAttribute('data-trip-id', tripId);
        });

        let selectedSeats = []; // Mảng lưu trữ ghế đã chọn
        const fare = parseFloat(new URLSearchParams(window.location.search).get('fare')); // Lấy fare từ URL
        const maxSeats = 8; // Giới hạn số ghế tối đa

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

                    // Tính tổng tiền
                    const totalPrice = selectedSeats.length * fare; // Tổng tiền
                    document.getElementById('total-price').textContent = totalPrice.toLocaleString(
                        'vi-VN', {
                            style: 'currency',
                            currency: 'VND'
                        });
                    document.getElementById("billinginfo-thucthu").value = totalPrice;
                } else if (seatStatus === 'booked') {
                    alert('Ghế này đã được đặt.');
                } else if (seatStatus === 'maintenance') {
                    alert('Ghế này đang trong tình trạng bảo trì.');
                }
            });
        });
    </script>
@endsection
