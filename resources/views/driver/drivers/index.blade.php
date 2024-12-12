@extends('driver.layouts.mater')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">Danh sách chuyến xe của bạn</h5>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                           style="width:100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Thời gian khởi hành</th>
                            <th>Ngày khởi hành</th>
                            <th>Tuyến đường</th>
                            <th>Xe</th>
                            <th>Ghế</th>
                            <th>Biển số xe</th>
                            <th>Trạng thái</th>
                            <th>Chi tiết</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($trips as $trip)
                            <tr>
                                <td>{{ $trip->id }}</td>
                                <td>{{ \Carbon\Carbon::parse($trip->time_start)->format('H:i') }}</td>
                                <td>{{ $trip->date }}</td>
                                <td>{{ $trip->route->route_name }}</td>
                                <td>{{ $trip->bus->name_bus }}</td>
                                <td>{{ $trip->bus->total_seats }}</td>
                                <td>{{ $trip->bus->license_plate }}</td>
                                <td>
                                    <span class="{{ $trip->is_active ? 'text-success' : 'text-danger' }}">
                                        {{ $trip->is_active ? 'Hoạt động' : 'Chờ' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('drivers.show', $trip->id) }}" class="btn btn-primary btn-sm">
                                        Xem chi tiết
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

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
