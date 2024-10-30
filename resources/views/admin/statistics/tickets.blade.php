@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Thống Kê Lượng Vé Đặt</h1>
        
        <h3>Số lượng vé đặt theo thời gian</h3>
        <ul>
            <li>Hôm nay: {{ $tickets['today'] }} vé</li>
            <li>Tuần này: {{ $tickets['week'] }} vé</li>
            <li>Tháng này: {{ $tickets['month'] }} vé</li>
            <li>Năm nay: {{ $tickets['year'] }} vé</li>
        </ul>

        <h3>Số lượng vé đặt theo tuyến đường</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Tuyến đường</th>
                    <th>Số vé đặt</th>
                </tr>
            </thead>
            <tbody>
                @foreach($routes as $route)
                    <tr>
                        <td>{{ $route->name }}</td>
                        <td>{{ $route->trips_count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3>Số lượng vé đặt theo loại xe</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Loại xe</th>
                    <th>Số vé đặt</th>
                </tr>
            </thead>
            <tbody>
                @foreach($buses as $bus)
                    <tr>
                        <td>{{ $bus->type }}</td>
                        <td>{{ $bus->trips_count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
