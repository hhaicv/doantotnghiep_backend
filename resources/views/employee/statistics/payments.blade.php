@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Thống Kê Hoạt Động Thanh Toán</h1>

        <h3>Tỷ lệ thanh toán thành công</h3>
        <p>{{ $successRate }}%</p>

        <h3>Phân tích phương thức thanh toán</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Phương thức</th>
                    <th>Số lần thanh toán</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paymentMethods as $method)
                    <tr>
                        <td>{{ $method->name }}</td>
                        <td>{{ $method->payments_count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
