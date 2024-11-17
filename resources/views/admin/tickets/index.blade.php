@extends('admin.layouts.mater')

@section('title')
    Đặt vé hành khách
@endsection
@section('content')
    <style>
        .table-responsive {
            width: 100%;
            margin: 0 auto;
        }

        .time-cell {
            display: flex;
            align-items: center;
        }

        .time-cell i {
            margin-right: 5px;
            color: #6c757d;
        }

        .time-display {
            font-weight: bold;
            color: #343a40;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            height: 61.62px;
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        .table th {
            height: 39.79px;
            background-color: #f8f9fa;
        }

        .time-cell {
            display: flex;
            align-items: center;
        }

        .route-cell {
            display: flex;
            flex-direction: column;
        }

        .bus-name {
            font-size: 0.9em;
            color: #666;
            margin-top: 4px;
        }

        button {
            background-color: #405189;
            color: #ffffff;
            border: none;
            padding: 6px 12px;
            font-size: 13px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button:hover {
            background-color: #37477a;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        button:active {
            background-color: #51629a;
        }
    </style>
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công',
                    text: "{{ session('success') }}"
                });
            });
        </script>
    @endif

    @if (session('failes'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Thất bại',
                    text: "{{ session('failes') }}"
                });
            });
        </script>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Đặt vé</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header border-0">
                    <div class="row align-items-center gy-3">
                        <div class="col-sm">
                            <h5 class="card-title mb-0">Danh sách chuyến</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form>
                        <div class="row g-3">
                            <div class="col-1 ms-5"></div>
                            <div class="col-md-3">
                                <label for="fullnameInput" class="form-label mt-2">Điểm bắt đầu</label>
                                <select name="start_stop_id" class="form-control" id="input-from-stop-1">
                                    <option value="">Chọn điểm bắt đầu</option>
                                    <?php foreach ($data as $stop) { ?>
                                    <option value="<?php echo $stop['id']; ?>" <?php if ($stop['parent_id'] === null) {
                                        echo 'disabled';
                                    } ?> style="<?php if ($stop['parent_id'] === null) {
                                        echo 'background-color: #f8f9fa;font-weight: 600;font-size: 14px;  color: #000000;';
                                    } ?>">
                                        <?php echo $stop['stop_name']; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="fullnameInput" class="form-label mt-2">Điểm kết thúc</label>
                                <select name="end_stop_id" class="form-control" id="input-to-stop-1">
                                    <option value="">Chọn điểm kết thúc</option>
                                    <?php foreach ($data as $stop) { ?>
                                    <option value="<?php echo $stop['id']; ?>" <?php if ($stop['parent_id'] === null) {
                                        echo 'disabled';
                                    } ?> style="<?php if ($stop['parent_id'] === null) {
                                        echo 'background-color: #f8f9fa;font-weight: 600;font-size: 14px;  color: #000000;';
                                    } ?>">
                                        <?php echo $stop['stop_name']; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="fullnameInput" class="form-label mt-2">Ngày khởi hành</label>
                                <div>
                                    <input type="date" class="form-control" id="datepicker">
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
                </div>
                <div class="card-body pt-0 mt-5">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="orderTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th data-sort="id">Thời gian khởi hành</th>
                                        <th data-sort="customer_name">Tuyến Đường</th>
                                        <th data-sort="product_name">Chỗ ngồi</th>
                                        <th data-sort="date">Giá vé</th>
                                        <th data-sort="city">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    <tr>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('style-libs')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection

@section('script-libs')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fromStopSelect = document.getElementById('input-from-stop-1');
            const toStopSelect = document.getElementById('input-to-stop-1');

            fromStopSelect.addEventListener('change', function() {
                const selectedValue = fromStopSelect.value;

                for (let option of toStopSelect.options) {
                    if (option.value === selectedValue) {
                        option.style.display = 'none';
                    } else {
                        option.style.display = '';
                    }
                }
            });
        });
    </script>
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

        function displayTrips(trips) {
            const resultsBody = document.querySelector('#orderTable tbody');
            resultsBody.innerHTML = '';
            const tripsArray = Array.isArray(trips) ? trips : Object.values(trips);
            if (tripsArray.length === 0) {
                resultsBody.innerHTML = '<tr><td colspan="5">Không có chuyến nào.</td></tr>';
                return;
            }

            tripsArray.forEach(trip => {
                const row = document.createElement('tr');
                const timeCell = document.createElement('td');
                timeCell.classList.add('time-cell');
                const timeIcon = document.createElement('i');
                timeIcon.className = 'fas fa-clock';
                const timeDisplay = document.createElement('span');
                timeDisplay.className = 'time-display';
                timeDisplay.textContent = formatTime(trip.time_start);
                timeCell.appendChild(timeIcon);
                timeCell.appendChild(timeDisplay);

                const routeCell = document.createElement('td');
                const routeName = document.createElement('div');
                routeName.textContent = trip.route_name;
                const busName = document.createElement('div');
                busName.textContent = trip.name_bus;
                busName.classList.add('bus-name');

                routeCell.appendChild(routeName);
                routeCell.appendChild(busName);

                const seatsCell = document.createElement('td');
                seatsCell.textContent = `${trip.available_seats}/${trip.total_seats} chỗ trống`;

                const fareCell = document.createElement('td');
                fareCell.textContent = formatCurrency(trip.fare); // Giá vé

                const actionCell = document.createElement('td');
                const actionButton = document.createElement('button'); // Tạo nút button
                actionButton.textContent = 'Chọn chỗ'; // Nội dung nút
                actionButton.onclick = function() {
                    const orderDetails = {
                        bus_id: trip.bus_id,
                        route_id: trip.route_id,
                        trip_id: trip.trip_id,
                        route: trip.route_name,
                        bus: trip.name_bus,
                        time_start: trip.time_start,
                        totalSeats: trip.total_seats,
                        fare: trip.fare,
                        date: trip.date,
                        start_stop_id: trip.start_stop_id,
                        end_stop_id: trip.end_stop_id,
                        start_name: trip.start_stop_name,
                        end_name: trip.end_stop_name
                    };
                    const queryString = new URLSearchParams(orderDetails).toString();
                    window.location.href = `/admin/tickets/create?${queryString}`;
                };
                actionCell.appendChild(actionButton);

                row.appendChild(timeCell);
                row.appendChild(routeCell);
                row.appendChild(seatsCell);
                row.appendChild(fareCell);
                row.appendChild(actionCell);

                resultsBody.appendChild(row);
            });
        }



        function formatTime(timeString) {
            const [hour, minute] = timeString.split(':');
            return `${hour}:${minute}`; // Chỉ hiển thị giờ và phút
        }

        function formatCurrency(amount) {
            const integerAmount = Math.floor(amount);
            return `${integerAmount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")} VNĐ`; // Định dạng với dấu phân cách hàng nghìn và thêm "VNĐ"
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

    <script>
        new DataTable("#example", {
            order: [
                [0, 'desc']
            ]
        });
    </script>
@endsection
