@extends('driver.layouts.mater')

@section('title')
    Thống kê Dashboard
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Tổng số chuyến đã đi</h5>
                </div>
                <div class="card-body">
                    <p>Số chuyến đã đi: <strong>{{ $totalTrips }}</strong></p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Doanh thu</h5>
                </div>
                <div class="card-body">
                    <p>Tổng doanh thu: <strong>{{ number_format($totalRevenue) }} VNĐ</strong></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Hiển thị danh sách các chuyến đi theo ngày -->
    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Tỷ lệ lấp đầy các chuyến xe theo ngày</h5>
{{--                        <form method="GET" action="{{ route('driver.dashboard') }}">--}}
{{--                            <label for="date">Chọn ngày:</label>--}}
{{--                            <input type="date" id="date" name="date" value="{{ $date }}">--}}
{{--                            <button type="submit">Lọc</button>--}}
{{--                        </form>--}}
                </div>
                <div class="card-body">
                    @if($tripStatsByDate->isEmpty())
                        <p>Không có dữ liệu chuyến đi nào.</p>
                    @else
                        @foreach($tripStatsByDate as $date => $routes)
                            <h5>Ngày: <strong>{{ $date }}</strong></h5>
                            <table class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                <thead>
                                <tr>
                                    <th>Tuyến</th>
                                    <th>Số ghế</th>
                                    <th>Số ghế đã bán</th>
                                    <th>Tỷ lệ lấp đầy (%)</th>
                                    <th>Doanh thu chuyến</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($routes as $route)
                                    <tr>
                                        <td>{{ $route['route'] }}</td>
                                        <td>{{ $route['total_seats'] }}</td>
                                        <td>{{ $route['soldSeats'] }}</td>
                                        <td>{{ $route['fillRate'] }}%</td>
                                        <td>{{ number_format($route['totalRevenue'], 0, ',', '.') }} VNĐ</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endforeach
                        <!-- Hiển thị liên kết phân trang -->
                        <div class="mt-3">
                            {{ $tickets->links('pagination::bootstrap-4') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
