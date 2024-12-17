@extends('driver.layouts.mater')

@section('title')
    Chi tiết danh sách
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1>Danh sách chuyến xe</h1>

            <form method="GET" action="{{ route('driver.drivers.show') }}">
                <div class="form-group">
                    <label for="date">Chọn ngày:</label>
                    <input type="date" class="form-control" id="date" name="date" value="{{ request()->input('date') }}">
                </div>
                <button type="submit" class="btn btn-primary">Lọc</button>
            </form>

            <div class="mt-4">
                @if ($groupedTrips->isEmpty())
                    <p>Không có dữ liệu chuyến xe nào.</p>
                @else
                    @foreach ($groupedTrips as $group)
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 style="text-align: center">{{ $group['route_name'] }} - {{ $group['time_start'] }}</h5>
                                <hr>
                                <section class="p-3" style="width: 100%;">
                                    <div class="row">
                                        <!-- Cột bên trái -->
                                        <div class="col-lg-6">
                                            <ul class="list-group list-group-flush rounded-3">
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    Tuyến Đường: <span>{{ $group['route_name'] }}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    Thời gian: <span>{{ \Carbon\Carbon::parse($group['time_start'])->format('H:i d/m/Y') }}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    Biển số: <span>{{ $group['bus_license_plate'] }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- Cột bên phải -->
                                        <div class="col-lg-6">
                                            <ul class="list-group list-group-flush rounded-3">
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    Tài xế: <span>{{ $group['driver_name'] }}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    Số vé: <span>{{ $group['total_tickets'] }}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    Tổng tiền: <span>{{ number_format($group['total_price'], 0, ',', '.') }} VND</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Mã</th>
                                        <th>Tên người dùng</th>
                                        <th>Ghế</th>
                                        <th>Giá</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($group['tickets'] as $ticket)
                                        <tr>
                                            <td>{{ $ticket->id }}</td>
                                            <td>{{ $ticket->ticket_code }}</td>
                                            <td>{{ $ticket->ticketBooking->name }}</td>
                                            <td>{{ $ticket->name_seat }}</td>
                                            <td>{{ number_format($ticket->price, 0, ',', '.') }} VND</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <a href="javascript:window.print()" class="btn btn-success"><i class="ri-printer-line align-bottom me-1"></i> Print</a>
@endsection

@section('script-libs')
    <script src="{{ asset('theme/admin/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/libs/jsvectormap/maps/world-merc.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/libs/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/js/pages/dashboard-ecommerce.init.js') }}"></script>
@endsection

@section('style-libs')
    <link href="{{ asset('theme/admin/assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/admin/assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
