@extends('employee.layouts.mater')

@section('title')
    Danh sách tuyến đường
@endsection
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Seller Details</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a></li>
                        <li class="breadcrumb-item active">Seller Details</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xxl-4">
            <div class="card">
                <div class="card-body p-3">
                    <div>
                        <div class="text-center">
                            <h5 class="mb-1">Thông tin chuyến xe</h5>
                            <hr>
                        </div>
                        <div class="table-responsive">
                            <table class="table mb-0 table-borderless">
                                <tbody>
                                    <tr>
                                        <th><span class="fw-medium">Tuyến</span></th>
                                        <td>{{ $data->route->route_name }}</td>
                                    </tr>
                                    <tr>
                                        <th><span class="fw-medium">Giờ xuất bến</span></th>
                                        <td>{{ \Carbon\Carbon::parse($data->time_start)->format('H:i') }} -
                                            {{ $data->date }}</td>
                                    </tr>
                                    <tr>
                                        <th><span class="fw-medium">Điểm đi</span></th>
                                        <td>{{ $startStopName }}</td>
                                    </tr>
                                    <tr>
                                        <th><span class="fw-medium">Điểm đến</span></th>
                                        <td>{{ $endStopName }}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><span class="fw-medium">Vị trí ghế</span></th>
                                        <td>{{ $mergedNameSeats }}</td>
                                    </tr>
                                    <tr>
                                        <th><span class="fw-medium">Giá</span></th>
                                        <td>{{ number_format($data->total_price, 0, ',', '.') }} đ</td>
                                    </tr>
                                    <tr>
                                        <th><span class="fw-medium">Ghi chú</span></th>
                                        <td>{{ $data->note }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--end card-body-->
            </div>
            <!--end card-->
        </div>
        <!--end col-->

        <div class="col-xxl-8">
            <div class="card p-2">
                <div class="card-body">
                    <!-- Vùng hiển thị danh sách chuyến -->
                    <form>
                        <div class="row g-3">
                            <div class="col">
                                <label for="fullnameInput" class="form-label mt-2">Điểm bắt đầu</label>
                                <select name="start_stop_id" class="form-control" id="input-from-stop-1">
                                    <option value="">Chọn điểm bắt đầu</option>
                                    <?php foreach ($stops as $stop) { ?>
                                    <option value="<?php echo $stop['id']; ?>" <?php
                                    // Nếu parent_id là null, disable option
                                    if ($stop['parent_id'] === null) {
                                        echo 'disabled';
                                    }
                                    // Nếu id của stop bằng id_start_stop, đánh dấu là được chọn
                                    if ($stop['id'] == $data->id_start_stop) {
                                        echo 'selected';
                                    }
                                    ?> style="<?php
                                    // Nếu parent_id là null, thay đổi style cho option
                                    if ($stop['parent_id'] === null) {
                                        echo 'background-color: #f8f9fa;font-weight: 600;font-size: 14px; color: #000000;';
                                    }
                                    ?>">
                                        <?php echo $stop['stop_name']; ?>
                                    </option>

                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col">
                                <label for="fullnameInput" class="form-label mt-2">Điểm kết thúc</label>
                                <select name="end_stop_id" class="form-control" id="input-to-stop-1">
                                    <option value="">Chọn điểm kết thúc</option>
                                    <?php foreach ($stops as $stop) { ?>
                                    <option value="<?php echo $stop['id']; ?>" <?php
                                    // Disable nếu parent_id là null
                                    if ($stop['parent_id'] === null) {
                                        echo 'disabled';
                                    }
                                    // Chọn nếu id của stop bằng id_end_stop
                                    if ($stop['id'] == $data->id_end_stop) {
                                        echo 'selected';
                                    }
                                    ?> style="<?php
                                    // Thay đổi style nếu parent_id là null
                                    if ($stop['parent_id'] === null) {
                                        echo 'background-color: #f8f9fa;font-weight: 600;font-size: 14px; color: #000000;';
                                    }
                                    ?>">
                                        <?php echo $stop['stop_name']; ?>
                                    </option>
                                    <?php } ?>

                                </select>
                            </div>
                            <div class="col">
                                <label for="fullnameInput" class="form-label mt-2">Ngày khởi hành</label>
                                <div>
                                    <input type="date" class="form-control" id="datepicker"
                                        min="{{ \Carbon\Carbon::today()->toDateString() }}" value="{{ $data->date }}">
                                </div>
                            </div>
                            <div class="col" style="margin-top: 51px; width: 105px !important;">
                                <div style="width: 105px;">
                                    <button type="button" class="btn btn-primary" onclick="SearchData();"><i
                                            class="ri-search-2-line"></i>
                                        Tìm kiếm
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div id="tripsContainer" style="display: none;">
                        <!-- Nội dung sẽ được thêm qua JavaScript -->
                    </div>
                </div>
            </div>
        </div>

        <!--end col-->
    </div>
@endsection

@section('style-libs')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection

@section('script-libs')
    <script>
        function SearchData() {
            const startStopId = document.getElementById('input-from-stop-1').value;
            const endStopId = document.getElementById('input-to-stop-1').value;
            const date = document.getElementById('datepicker').value;

            if (!startStopId || !endStopId || !date) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Thông báo',
                    text: 'Vui lòng chọn điểm đủ thông tin.',
                    confirmButtonText: 'OK'
                });
                return;
            }
            fetch(`/admin/fetch-trips?start_stop_id=${startStopId}&end_stop_id=${endStopId}&date=${date}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Có lỗi xảy ra khi tìm kiếm chuyến.");
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(data);
                    displayTrips(data);
                })
                .catch(error => {
                    console.error(error);
                    alert(error.message);
                });
        }

        // Lấy đường dẫn từ URL hiện tại
        const url = window.location.pathname;

        // Tách đường dẫn thành mảng các phần tử
        const parts = url.split('/');

        // Lấy phần tử cuối cùng (ID)
        const id_change = parts[parts.length - 1];

        function displayTrips(trips) {
            const tripsContainer = document.getElementById('tripsContainer');

            // Xóa nội dung cũ
            tripsContainer.innerHTML = '';

            // Kiểm tra dữ liệu
            if (!trips || trips.length === 0) {
                tripsContainer.style.display = 'none'; // Ẩn container nếu không có dữ liệu
                return;
            }

            // Hiển thị container
            tripsContainer.style.display = 'block';


            // Render danh sách chuyến
            trips.forEach(trip => {
                const tripElement = document.createElement('div');
                tripElement.className = 'row mt-3';
                tripElement.style = 'border: 1px solid rgb(201, 201, 201); border-radius: 8px; padding: 13px';

                tripElement.innerHTML = `
            <div class="col-6">
                <h5>${trip.route_name}</h5>
                <p><i class="bi bi-clock"></i> ${formatTime(trip.time_start)}</p>
            </div>
            <div class="col-3">
                <h5>${trip.name_bus}</h5>
                <p>${trip.available_seats} chỗ trống</p>
            </div>
            <div class="col-3 float-end">
                <h5 style="color: red">${formatCurrency(trip.fare)}</h5>
                <button type="button" class="btn btn-primary" onclick="selectSeat(${trip.bus_id}, ${trip.route_id}, ${trip.trip_id}, '${trip.route_name}', '${trip.name_bus}', '${trip.time_start}', ${trip.total_seats}, ${trip.fare}, '${trip.date}', ${trip.start_stop_id}, ${trip.end_stop_id}, '${trip.start_stop_name}', '${trip.end_stop_name}', '${id_change}')">Chọn chỗ</button>
            </div>
        `;

                tripsContainer.appendChild(tripElement);
            });
        }


        // Hàm xử lý khi người dùng chọn chỗ
        function selectSeat(bus_id, route_id, trip_id, route, bus, time_start, totalSeats, fare, date, start_stop_id,
            end_stop_id, start_name, end_name, id_change) {
            const orderDetails = {
                id_change: id_change,
                bus_id: bus_id,
                route_id: route_id,
                trip_id: trip_id,
                route: route,
                bus: bus,
                time_start: time_start,
                totalSeats: totalSeats,
                fare: fare,
                date: date,
                start_stop_id: start_stop_id,
                end_stop_id: end_stop_id,
                start_name: start_name,
                end_name: end_name
            };

            const queryString = new URLSearchParams(orderDetails).toString();
            window.location.href = `/employee/load?${queryString}`;
        }

        // Hàm định dạng thời gian
        function formatTime(time) {
            const [hour, minute] = time.split(':');
            return `${hour}:${minute}`;
        }

        // Hàm định dạng tiền tệ
        function formatCurrency(value) {
            return new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(value);
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>


    <script src="{{ asset('theme/admin/assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/js/plugins.js') }}"></script>

    <!-- list.js min js -->
    <script src="{{ asset('theme/admin/assets/libs/list.js/list.min.js') }}"></script>

    <!--list pagination js-->
    <script src="{{ asset('theme/admin/assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>
@endsection