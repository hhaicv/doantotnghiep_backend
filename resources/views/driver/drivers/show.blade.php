@extends('driver.layouts.mater')

@section('title')
    Chi tiết danh sách
@endsection

@section('content')
    <div class="card-header">
        <h2>Chi tiết chuyến</h2>
        <p><strong>Tuyến đường:</strong> {{ $tripInfo['route_name'] }}</p>
        <p><strong>Thời gian khởi hành:</strong> {{ $tripInfo['time_start'] }}</p>
        <p><strong>Ngày:</strong> {{ $tripInfo['date'] }}</p>
        <p><strong>Xe:</strong> {{ $tripInfo['bus']->license_plate }}</p>
        <p><strong>Tổng số vé:</strong> {{ $tripInfo['total_tickets'] }}</p>
        <p><strong>Tổng tiền:</strong> {{ number_format($tripInfo['total_price'], 0, ',', '.') }} VND</p>

        <h3>Danh sách vé</h3>
        <table>
            <thead>
            <tr>
                <th>Tên hành khách</th>
                <th>Số ghế</th>
                <th>Giá vé</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($tickets as $ticket)
                @foreach ($ticket->ticketDetails as $detail)
                    <tr>
                        <td>{{ $detail->passenger_name }}</td>
                        <td>{{ $detail->seat_number }}</td>
                        <td>{{ number_format($detail->price, 0, ',', '.') }} VND</td>
                    </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>

        <a href="javascript:window.print()" class="btn btn-success"><i class="ri-printer-line align-bottom me-1"></i> Print</a>
    </div>


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
