@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Thống Kê Chuyến Xe</h1>
        
        <h3>Chuyến xe được đặt nhiều nhất</h3>
        <p>
            Chuyến xe: {{ $mostBookedTrip->id }}<br>
            Số lượng vé đặt: {{ $mostBookedTrip->ticket_bookings_count }}
        </p>

        <h3>Tỷ lệ lấp đầy các chuyến xe</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Chuyến xe</th>
                    <th>Tỷ lệ lấp đầy (%)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($occupancyRates as $rate)
                    <tr>
                        <td>{{ $rate['trip_id'] }}</td>
                        <td>{{ $rate['occupancy_rate'] }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
