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
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                        <thead>
                        <tr>
                            <th>Chuyến</th>
                            <th>Giá vé</th>
                            <th>Ngày đi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tickets as $ticket)
                            <tr>
                                <td>{{ $ticket->route->route_name }}</td>
                                <td>{{ number_format($ticket->total_price) }} VNĐ</td>
                                <td>{{ \Carbon\Carbon::parse($ticket->date)->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
