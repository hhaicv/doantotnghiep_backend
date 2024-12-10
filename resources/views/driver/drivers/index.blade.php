@extends('driver.layouts.mater')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card-header">
                <form method="GET" action="{{ route('drivers.index') }}">
                    <label for="date">Chọn ngày:</label>
                    <input type="date" id="date" name="date" value="{{ $date }}">
                    <button type="submit">Lọc</button>
                </form>
            </div>

            <table>
                <thead>
                <tr>
                    <th>Thời gian</th>
                    <th>Tuyến đường</th>
                    <th>Số vé</th>
                    <th>Tổng tiền</th>
                    <th>Hành động</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($groupedTrips as $tripId => $trip)
                    <tr>
                        <td>{{ $trip['time_start'] }}</td>
                        <td>{{ $trip['route_name'] }}</td>
                        <td>{{ $trip['total_tickets'] }}</td>
                        <td>{{ number_format($trip['total_price'], 0, ',', '.') }} VND</td>
                        <td>
                            <a href="{{ route('drivers.show', $tripId) }}" class="btn btn-primary btn-sm">Chi tiết</a>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
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
