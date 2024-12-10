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

    <!-- Hiển thị danh sách vé nếu cần -->
    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Tỷ lệ lấp đầy các chuyến xe</h5>
                </div>
                <div class="card-body">
                    @if($busStats->isEmpty())
                        <p>Không có dữ liệu chuyến đi nào.</p>
                    @else
                        <table class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                            <thead>
                            <tr>
                                <th>Tên xe</th>
                                <th>Tuyến</th>
                                <th>Số ghế</th>
                                <th>Số ghế đã bán</th>
                                <th>Tỷ lệ lấp đầy (%)</th>
                                <th>Doanh thu chuyến</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($busStats as $busStat)
                                <tr>
                                    <td>{{ $busStat['name_bus'] }}</td>
                                    <td>{{ $busStat['route'] }}</td>
                                    <td>{{ $busStat['total_seats'] }}</td>
                                    <td>{{ $busStat['soldSeats'] }}</td>
                                    <td>{{ $busStat['fillRate'] }} %</td>
                                    <td>{{ $busStat['totalRevenue'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>


@endsection
