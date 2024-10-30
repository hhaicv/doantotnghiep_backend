@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Thống Kê Doanh Thu</h1>
        
        <h3>Doanh thu theo thời gian</h3>
        <ul>
            <li>Hôm nay: {{ $revenue['today'] }} VND</li>
            <li>Tuần này: {{ $revenue['week'] }} VND</li>
            <li>Tháng này: {{ $revenue['month'] }} VND</li>
            <li>Năm nay: {{ $revenue['year'] }} VND</li>
        </ul>

        <h3>Doanh thu theo tuyến đường</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Tuyến đường</th>
                    <th>Doanh thu</th>
                </tr>
            </thead>
            <tbody>
                @foreach($routes as $route)
                    <tr>
                        <td>{{ $route->name }}</td>
                        <td>{{ $route->ticket_bookings_sum_amount }} VND</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3>Doanh thu theo loại xe</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Loại xe</th>
                    <th>Doanh thu</th>
                </tr>
            </thead>
            <tbody>
                @foreach($buses as $bus)
                    <tr>
                        <td>{{ $bus->type }}</td>
                        <td>{{ $bus->ticket_bookings_sum_amount }} VND</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
