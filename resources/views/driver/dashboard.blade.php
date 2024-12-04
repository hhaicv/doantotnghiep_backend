@extends('driver.layouts.mater')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="row">
        @foreach($tickets as $ticket)
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mb-0" style="text-align: center">Chuyến đi - {{ $ticket->route->name }}</h6>
                        <hr>
                        <section class="p-3" style="width: 100%;">
                            <div class="row">
                                <!-- Cột bên trái -->
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush rounded-3">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Tuyến Đường: <span>{{ $ticket->route->name }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Thời gian: <span>{{ $ticket->time_start }} {{ $ticket->date }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Biển số: <span>{{ $ticket->bus->license_plate }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Tổng tiền: <span>{{ number_format($ticket->total_price) }} VNĐ</span>
                                        </li>
                                    </ul>
                                </div>
                                <!-- Cột bên phải -->
                                <div class="col-lg-6">
                                    <ul class="list-group list-group-flush rounded-3">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Tài xế: <span>{{ $ticket->bus->driver->name }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Phụ xe: <span>{{ $ticket->bus->driver->assistant_name ?? 'N/A' }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Số vé: <span>{{ $ticket->total_tickets }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            PV đã thu: <span>{{ number_format($ticket->total_price / 2) }} VNĐ</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="card-body">
                        <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                            <thead>
                            <tr>
                                <th>Điểm lên</th>
                                <th>Điểm xuống</th>
                                <th>Tên</th>
                                <th>Số điện thoại</th>
                                <th>Vị trí</th>
                                <th>Giá vé</th>
                                <th>Ghi chú</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ticket->ticketDetails as $ticketDetail)
                                <tr>
                                    <td>{{ $ticket->location_start }}</td>
                                    <td>{{ $ticket->location_end }}</td>
                                    <td>{{ $ticketDetail->name_seat }}</td>
                                    <td>{{ $ticket->phone }}</td>
                                    <td>A8</td>
                                    <td>{{ number_format($ticketDetail->price) }} VNĐ</td>
                                    <td>DM MHH</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!--end col-->
        @endforeach
    </div><!--end row-->
@endsection
@section('script-libs')
    <script src="{{ asset('theme/admin/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Vector map-->
    <script src="{{ asset('theme/admin/assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/libs/jsvectormap/maps/world-merc.js') }}"></script>

    <!--Swiper slider js-->
    <script src="{{ asset('theme/admin/assets/libs/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Dashboard init -->
    <script src="{{ asset('theme/admin/assets/js/pages/dashboard-ecommerce.init.js') }}"></script>
@endsection

@section('style-libs')
    <link href="{{ asset('theme/admin/assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet"
          type="text/css" />

    <!--Swiper slider css-->
    <link href="{{ asset('theme/admin/assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
