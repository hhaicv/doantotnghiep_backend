@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Thống Kê Người Dùng</h1>

        <h3>Số lượng khách hàng đăng ký theo thời gian</h3>
        <ul>
            <li>Hôm nay: {{ $newUsers['daily'] }} khách</li>
            <li>Tuần này: {{ $newUsers['weekly'] }} khách</li>
            <li>Tháng này: {{ $newUsers['monthly'] }} khách</li>
        </ul>

        <h3>Tỷ lệ quay lại của khách hàng</h3>
        <p>{{ $returnRate }}%</p>

        <h3>Khách hàng tiềm năng</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Khách hàng</th>
                    <th>Số lượng vé đặt</th>
                </tr>
            </thead>
            <tbody>
                @foreach($frequentCustomers as $customer)
                    <tr>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->ticket_bookings_count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
