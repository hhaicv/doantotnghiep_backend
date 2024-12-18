@extends('driver.layouts.mater')
@section('title')
    Đặt vé
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Chi tiết chuyến xe</h5>
                <div class="header">
                    <form method="GET" style="display: flex; justify-content-between;"
                        action="{{ route('driver.drivers.seats') }}">
                        <label class="me-3" for="date">Chọn ngày:</label>
                        <input type="date" id="date" name="date" class="form-control"
                            value="{{ $date }}">
                        <button type="submit" class="btn btn-primary ms-3">Lọc</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công',
                    text: "{{ session('success') }}"
                });
            });
        </script>
    @endif
    <style>
        li {
            list-style-type: none;
            /* Bỏ dấu chấm */
        }

        li>button {
            margin: 5px 0px;
            padding: 13px 23px;

            border-radius: 2px;
        }

        .seat.booked {
            background-color: red;
            color: white;
        }

        .seat.available {
            background-color: white;
            color: black;
        }
    </style>

    @if ($trips->isEmpty())
        <h2 style="text-align: center">Không có dữ liệu chuyến xe nào.</h2>
    @else
        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    @foreach ($trips as $trip)
                        @php
                            $seatCount = $trip->bus->total_seats;
                        @endphp
                        <div class="card-body checkout-tab">

                            @if ($seatCount == 40)
                                <div class="row">
                                    <div class="col">
                                        <h5 class="pt-3 fw-semibold">Tầng 1</h5>
                                    </div>
                                    <div class="col">
                                        <li>
                                            <button class="seat" data-name="A1" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A2" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A3" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A4" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A5" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A6" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                    </div>
                                    <div class="col">
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A19" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                    </div>
                                    <div class="col">
                                        <li>
                                            <button class="seat" data-name="A7" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A8" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A9" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A10" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A11" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A12" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                    </div>
                                    <div class="col">
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A20" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                    </div>
                                    <div class="col">
                                        <li>
                                            <button class="seat" data-name="A13" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A14" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A15" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A16" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A17" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A18" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mt-3">
                                    <div class="col">
                                        <h5 class="pt-3 fw-semibold">Tầng 2</h5>
                                    </div>
                                    <div class="col">
                                        <li>
                                            <button class="seat" data-name="B1" data-trip-id="2"
                                                data-seat-status="available" data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B2" data-trip-id="2"
                                                data-seat-status="available" data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B3" data-trip-id="2"
                                                data-seat-status="available" data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B4" data-trip-id="2"
                                                data-seat-status="selected" data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B5" data-trip-id="2"
                                                data-seat-status="available" data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B6" data-trip-id="2"
                                                data-seat-status="available" data-seat-floor="2" type="submit"></button>
                                        </li>
                                    </div>
                                    <div class="col">
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B19" data-trip-id="2"
                                                data-seat-status="available" data-seat-floor="2" type="submit"></button>
                                        </li>
                                    </div>
                                    <div class="col">
                                        <li>
                                            <button class="seat" data-name="B7" data-trip-id="2"
                                                data-seat-status="available" data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B8" data-trip-id="2"
                                                data-seat-status="available" data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B9" data-trip-id="2"
                                                data-seat-status="available" data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B10" data-trip-id="2"
                                                data-seat-status="available" data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B11" data-trip-id="2"
                                                data-seat-status="available" data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B12" data-trip-id="2"
                                                data-seat-status="available" data-seat-floor="2" type="submit"></button>
                                        </li>
                                    </div>
                                    <div class="col">
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B20" data-trip-id="2"
                                                data-seat-status="available" data-seat-floor="2" type="submit"></button>
                                        </li>
                                    </div>
                                    <div class="col">
                                        <li>
                                            <button class="seat" data-name="B13" data-trip-id="2"
                                                data-seat-status="available" data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B14" data-trip-id="2"
                                                data-seat-status="available" data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B15" data-trip-id="2"
                                                data-seat-status="available" data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B16" data-trip-id="2"
                                                data-seat-status="available" data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B17" data-trip-id="2"
                                                data-seat-status="available" data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B18" data-trip-id="2"
                                                data-seat-status="available" data-seat-floor="2" type="submit"></button>
                                        </li>
                                    </div>
                                </div>
                            @elseif ($seatCount == 34)
                                <div class="row">
                                    <div class="col">
                                        <h5 class="pt-3 fw-semibold">Tầng 1</h5>
                                    </div>
                                    <div class="col">
                                        <li>
                                            <button class="seat" data-name="A1" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A2" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A3" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A4" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A5" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A6" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                    </div>
                                    <div class="col">
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                    </div>
                                    <div class="col">
                                        <li>
                                            <button class="seat" data-name="A7" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A8" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A9" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A10" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A11" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                    </div>
                                    <div class="col">
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                    </div>
                                    <div class="col">
                                        <li>
                                            <button class="seat" data-name="A12" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A13" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A14" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A15" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A16" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A17" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mt-3">
                                    <div class="col">
                                        <h5 class="pt-3 fw-semibold">Tầng 2</h5>
                                    </div>
                                    <div class="col">
                                        <li>
                                            <button class="seat" data-name="B1" data-trip-id="2"
                                                data-seat-status="available" data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B2" data-trip-id="2"
                                                data-seat-status="available" data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B3" data-trip-id="2"
                                                data-seat-status="available" data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B4" data-trip-id="2"
                                                data-seat-status="selected" data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B5" data-trip-id="2"
                                                data-seat-status="available" data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B6" data-trip-id="2"
                                                data-seat-status="available" data-seat-floor="2" type="submit"></button>
                                        </li>
                                    </div>
                                    <div class="col">
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                    </div>
                                    <div class="col">
                                        <li>
                                            <button class="seat" data-name="B7" data-trip-id="2"
                                                data-seat-status="available" data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B8" data-trip-id="2"
                                                data-seat-status="available" data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B9" data-trip-id="2"
                                                data-seat-status="available" data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B10" data-trip-id="2"
                                                data-seat-status="available" data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B11" data-trip-id="2"
                                                data-seat-status="available" data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                    </div>
                                    <div class="col">
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                    </div>
                                    <div class="col">
                                        <li>
                                            <button class="seat" data-name="B12" data-trip-id="2"
                                                data-seat-status="available" data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B13" data-trip-id="2"
                                                data-seat-status="available" data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B14" data-trip-id="2"
                                                data-seat-status="available" data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B15" data-trip-id="2"
                                                data-seat-status="available" data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B16" data-trip-id="2"
                                                data-seat-status="available" data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B17" data-trip-id="2"
                                                data-seat-status="available" data-seat-floor="2" type="submit"></button>
                                        </li>
                                    </div>
                                </div>
                            @elseif ($seatCount == 45)
                                <div class="row">
                                    <div class="col">
                                        <h5 class="pt-3 fw-semibold">Tầng 1</h5>
                                    </div>
                                    <div class="col">
                                        <li>
                                            <button class="seat" data-name="A1" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A2" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A3" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A4" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A5" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A6" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A7" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A8" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A9" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A10" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A11" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                    </div>
                                    <div class="col">
                                        <li>
                                            <button class="seat" data-name="B1" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B2" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B3" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B4" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B5" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B6" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B7" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B8" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B9" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B10" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B11" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                    </div>
                                    <div class="col">

                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button style="visibility: hidden;" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="C1" data-trip-id="2"
                                                data-seat-status="available" data-seat-floor="2" type="submit"></button>
                                        </li>
                                    </div>
                                    <div class="col">
                                        <li>
                                            <button class="seat" data-name="D1" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="D2" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="D3" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="D4" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="D5" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="D6" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="D7" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="D8" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="D9" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="D10" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="D11" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                    </div>
                                    <div class="col">
                                        <li>
                                            <button class="seat" data-name="E1" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="E2" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="E3" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="E4" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="E5" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="E6" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="E7" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="E8" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="E9" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="E10" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="E11" data-trip-id="1"
                                                data-seat-status="available" data-seat-floor="1" type="submit"></button>
                                        </li>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-warning">Chuyến đi này có số ghế không xác định</div>
                            @endif
                            <div class="row mt-2 p-2" style="background: #ecedf1 !important;">
                                <div class="col">
                                    <li>
                                        <button type="submit"></button>
                                        <br> Ghế trống
                                    </li>
                                </div>
                                <div class="col">
                                    <li>
                                        <button style="background: #f5c170;" type="submit"></button>
                                        <br> Ghế đã đặt
                                    </li>
                                </div>
                                <div class="col">
                                    <li>
                                        <button style="background: #14f80b;" type="submit"></button>
                                        <br> Đã Lên Xe
                                    </li>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body checkout-tab">
                        <form action="{{ route('submit') }}" method="POST" enctype="multipart/form-data">
                            @csrf


                            <div class="step-arrow-nav mt-n3 mx-n3 mb-3">
                                <ul class="nav nav-pills nav-justified custom-nav" role="tablist">

                                    <li class="nav-item" style="display: none" role="presentation">
                                        <button class="nav-link" id="pills-bill-info-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-bill-info" type="button">
                                            Thông tin chuyến
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link fs-15 p-3" id="pills-bill-address-tab"
                                            data-bs-toggle="pill" data-bs-target="#pills-bill-address" type="button"
                                            role="tab" aria-controls="pills-bill-address" aria-selected="false">

                                            <i
                                                class="ri-user-2-line fs-16 p-2 bg-primary-subtle text-primary rounded-circle align-middle me-2"></i>
                                            Thông tin người đặt
                                        </button>
                                    </li>

                                </ul>
                            </div>

                            <div class="tab-content">
                                <div class="tab-pane fade" id="pills-bill-info" role="tabpanel"
                                    aria-labelledby="pills-bill-info-tab">
                                    <div>
                                        @foreach ($groupedTrips as $tripId => $trip)
                                            <h4 class="mb-1" id="route-info">{{ $trip['route_name'] }}</h4>
                                            <span class="fs-5" id="time-info">{{ $trip['date'] }} -
                                                {{ $trip['time_start'] }}</span>
                                        @endforeach
                                    </div>
                                    <hr>
                                    <div class="mt-4">
                                        <div class="row gy-3">
                                            <div class="col-4">
                                                <p class="fs-5">Ghế đã chọn: </p>
                                                <p class="fs-5">Điểm đi:<span style="color: red">*</span></p>
                                                <br>
                                                <p class="fs-5">Điểm đến:<span style="color: red">*</span></p>
                                            </div>
                                            <div class="col">
                                                <p class="fs-5" id="selected-seats">...</p>

                                                <select name="id_start_stop" id="start-stop" class="form-select"
                                                    aria-label="Default select example">
                                                    <option value="">Chọn điểm bắt đầu</option>
                                                    <?php foreach ($stops as $stop) { ?>
                                                    <option value="<?php echo $stop['id']; ?>" <?php if ($stop['parent_id'] === null) {
                                                        echo 'disabled';
                                                    } ?>
                                                        style="<?php if ($stop['parent_id'] === null) {
                                                            echo 'background-color: #f8f9fa;font-weight: 600;font-size: 14px;  color: #000000;';
                                                        } ?>">
                                                        <?php echo $stop['stop_name']; ?>
                                                    </option>
                                                    <?php } ?>
                                                </select>

                                                <select name="id_end_stop" id="end-stop" class="form-select mt-3"
                                                    aria-label="Default select example">
                                                    <option value="">Chọn điểm kết thúc</option>
                                                    <?php foreach ($stops as $stop) { ?>
                                                    <option value="<?php echo $stop['id']; ?>" <?php if ($stop['parent_id'] === null) {
                                                        echo 'disabled';
                                                    } ?>
                                                        style="<?php if ($stop['parent_id'] === null) {
                                                            echo 'background-color: #f8f9fa;font-weight: 600;font-size: 14px;  color: #000000;';
                                                        } ?>">
                                                        <?php echo $stop['stop_name']; ?>
                                                    </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label for="billinginfo-phone" style="font-size: 14px"
                                                            class="form-label">Số điện
                                                            thoại</label>
                                                        <input type="text" name="sdt" class="form-control"
                                                            value="000000000">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label for="billinginfo-name" style="font-size: 14px"
                                                            class="form-label">Họ tên</label>
                                                        <input type="text" name="hoten" class="form-control"
                                                            value="Khách vãn lai">
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" id="trip-id" name="trip_id"
                                                value="{{ $firstTripId }}">

                                            <input type="hidden" name="payment_method_id" value="1">

                                            <input type="hidden" name="total_price" id="total">
                                            <input type="hidden" name="fare" id="fare">


                                            <input type="hidden" name="name_seat" id="name_seat">

                                            @foreach ($groupedTrips as $tripId => $trip)
                                                <input type="hidden" name="date" id="date"
                                                    value="{{ $trip['date'] }}">
                                                <input type="hidden" name="bus_id" id="bus_id"
                                                    value="{{ $trip['bus_id'] }}">
                                                <input type="hidden" name="route_id" id="route_id"
                                                    value="{{ $trip['route_id'] }}">
                                                <input type="hidden" name="time_start" id="time_start"
                                                    value="{{ $trip['time_start'] }}">
                                            @endforeach
                                            <div class="col-4">
                                                <p class="fs-5">Tổng tiền: </p>
                                            </div>
                                            <div class="col">
                                                <p class="fs-5" id="total-price">...</p>
                                            </div>
                                        </div>
                                        <div class="align-items-start gap-3 mt-4">
                                            <button type="submit" class="btn btn-primary btn-label fs-5 w-100">
                                                Tạo vé
                                            </button>
                                        </div>
                                    </div>
                                </div>
                        </form>

                        <div class="tab-pane fade" id="pills-bill-address" role="tabpanel"
                            aria-labelledby="pills-bill-address-tab">
                            <div>
                                @foreach ($groupedTrips as $tripId => $trip)
                                    <h4 class="mb-1" id="route-info">{{ $trip['route_name'] }}</h4>
                                    <span class="fs-5" id="time-info">{{ $trip['date'] }} -
                                        {{ $trip['time_start'] }}</span>
                                @endforeach

                            </div>
                            <hr>
                            <div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="billinginfo-phone" class="form-label">Số điện
                                                thoại</label>
                                            <input type="text" name="phone" class="form-control"
                                                id="billinginfo-phone" value="{{ old('phone') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="billinginfo-name" class="form-label">Họ tên</label>
                                            <input type="text" name="name" class="form-control"
                                                id="billinginfo-name" value="{{ old('name') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label for="billinginfo-email" class="form-label">Email <span
                                                    class="text-muted">(Optional)</span></label>
                                            <input type="email" name="email" class="form-control"
                                                id="billinginfo-email">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="billinginfo-address" class="form-label">Ghi chú</label>
                                    <textarea class="form-control" name="note" id="billinginfo-address" rows="3">{{ old('note') }}</textarea>
                                </div>
                                <div class="align-items-start gap-3 mt-4">
                                    <button type="button" class="btn btn-primary btn-label fs-5 w-100"
                                        id="btn-up-seat" data-is-active="false" data-seat-id="1">
                                        Đã Lên Xe
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="header">
                        <h4 style="text-align: center; margin-top: 10px">Thông tin chuyến xe</h4>
                    </div>
                    <div class="card-body">
                        <table id="example"
                            class="table table-bordered dt-responsive nowrap table-striped align-middle"
                            style="width:100%">
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
                                            <a
                                                href="{{ route('driver.drivers.show', ['date' => request()->input('date'), 'trip_id' => $tripId]) }}">Xem
                                                chi tiết</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
    </div>
    <script>
        // Dữ liệu trạng thái ghế
        const seatStatusArray = @json($seatStatusFlat);

        // Hàm cập nhật trạng thái ghế dựa trên dữ liệu ban đầu
        function updateSeatStatus() {
            document.querySelectorAll('.seat').forEach(function(button) {
                const seatName = button.getAttribute('data-name');
                if (seatStatusArray[seatName]) {
                    const {
                        status,
                        is_active
                    } = seatStatusArray[seatName];
                    button.setAttribute('data-seat-status', status);
                    button.setAttribute('data-is-active', is_active);

                    if (is_active === true) {
                        button.classList.remove('selected');
                        button.style.backgroundColor = '#14f80b'; // Xanh lá
                        button.classList.add('active');
                    } else {
                        if (status === 'booked') {
                            button.classList.add('booked');
                            button.style.backgroundColor = '#f5c170'; // Màu cho ghế đã đặt
                        } else if (status === 'lock') {
                            button.classList.add('lock');
                            button.style.backgroundColor = '#ff0000'; // Màu đỏ
                        } else if (status === 'selected') {
                            button.style.backgroundColor = '#9dc3fe'; // Màu xanh dương nhạt
                        } else {
                            button.classList.remove('booked', 'selected', 'lock', 'active');
                            button.style.backgroundColor = ''; // Mặc định
                        }
                    }
                }
            });
        }

        // Cập nhật trạng thái ghế lúc tải trang
        updateSeatStatus();

        // Mảng lưu ghế được chọn
        let selectedSeats = [];
        let farePerSeat = 0; // Giá vé cho mỗi ghế
        const maxSeats = 8; // Giới hạn số ghế được chọn
        let totalPrice = 0; // Tổng giá tiền của ghế đã chọn


        // Xử lý sự kiện khi người dùng click vào ghế
        document.querySelectorAll('.seat').forEach(function(button) {
            button.addEventListener('click', function() {
                const seatStatus = button.getAttribute('data-seat-status');
                const seatName = button.getAttribute('data-name');

                if (seatStatus === 'available') {
                    if (selectedSeats.length < maxSeats) {
                        button.classList.toggle('selected');
                        const isSelected = button.classList.contains('selected');
                        button.setAttribute('data-seat-status', isSelected ? 'selected' : 'available');
                        if (isSelected) {
                            button.style.backgroundColor = '#9dc3fe';
                            selectedSeats.push(seatName);
                        } else {
                            button.style.backgroundColor = '';
                            selectedSeats = selectedSeats.filter(seat => seat !== seatName);
                        }

                        document.getElementById('selected-seats').textContent = selectedSeats.join(', ');
                        document.getElementById('name_seat').value = selectedSeats.join(', ');
                        updateTotalPrice();
                        const tabButton = document.querySelector('#pills-bill-info-tab');
                        if (tabButton) {
                            const tab = new bootstrap.Tab(tabButton); // Khởi tạo đối tượng tab
                            tab.show(); // Hiển thị tab "Thông tin chuyến"
                        } else {
                            console.error('Tab button not found.');
                        }
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Thông báo',
                            text: 'Bạn chỉ có thể chọn tối đa ' + maxSeats + ' ghế.',
                            confirmButtonText: 'OK',
                        });
                        return; // Ngăn không cho người dùng thao tác
                    }

                } else if (seatStatus === 'selected') {
                    button.classList.remove('selected');
                    button.setAttribute('data-seat-status', 'available');
                    button.style.backgroundColor = '';
                    selectedSeats = selectedSeats.filter(seat => seat !== seatName);
                    document.getElementById('selected-seats').textContent = selectedSeats.join(', ');
                    document.getElementById('name_seat').value = selectedSeats.join(', ');
                } else if (seatStatus === 'booked') {
                    const bookingInfo = seatStatusArray[seatName];

                    // Cập nhật các thông tin trong form
                    document.getElementById('billinginfo-name').value = bookingInfo.name;
                    document.getElementById('billinginfo-phone').value = bookingInfo.phone;
                    document.getElementById('billinginfo-email').value = bookingInfo.email;
                    document.getElementById('billinginfo-address').value = bookingInfo.note;

                    // Lấy button để cập nhật
                    const button = document.getElementById('btn-up-seat');

                    // Cập nhật thuộc tính value và data-is-active của nút
                    button.value = bookingInfo.id; // Truyền giá trị id vào value
                    button.dataset.isActive = bookingInfo.is_active ? 'true' :
                        'false'; // Truyền giá trị vào data-is-active

                    if (button.dataset.isActive === 'true') {
                        button.style.display = 'none'; // Ẩn nút nếu is-active là true
                    } else {
                        button.style.display = 'block'; // Hiển thị nút nếu is-active là false
                    }
                    // Chuyển tab nếu cần
                    document.querySelector('#pills-bill-address-tab').click();
                }
            });
        });



        // Xử lý cập nhật ghế qua nút cập nhật
        document.getElementById('btn-up-seat').addEventListener('click', function() {
            const seatId = this.getAttribute('value');
            if (!seatId) {
                alert('Không tìm thấy ID ghế!');
                return;
            }
            fetch(`/seats/${seatId}/active`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify({
                        is_active: 1
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công',
                            text: data.message,
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Thất bại',
                            text: 'Cập nhật thất bại!',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.reload();
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: 'Đã xảy ra lỗi khi cập nhật.',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.reload();
                    });
                });
        });
        $(document).ready(function() {
            // Khi người dùng thay đổi điểm bắt đầu hoặc điểm kết thúc
            $('#start-stop, #end-stop').on('change', function() {
                // Lấy giá trị của điểm bắt đầu, điểm kết thúc và trip_id
                var startStopId = $('#start-stop').val();
                var endStopId = $('#end-stop').val();
                var tripId = $('#trip-id').val();

                // Kiểm tra nếu tất cả các giá trị đều được chọn
                if (startStopId && endStopId && tripId) {
                    // Gửi yêu cầu Ajax đến API listPrice
                    $.ajax({
                        url: '/listPrice', // Địa chỉ API của bạn
                        method: 'GET',
                        data: {
                            start_stop_id: startStopId,
                            end_stop_id: endStopId,
                            trip_id: tripId,
                            _token: '{{ csrf_token() }}' // Thêm CSRF token nếu bạn đang sử dụng Laravel
                        },
                        success: function(response) {
                            // Kiểm tra nếu có giá vé
                            if (response.fare) {
                                // Cập nhật giá vé vào phần tử với id="total-price"
                                farePerSeat = response.fare;
                                // Cập nhật tổng tiền ban đầu
                                updateTotalPrice();
                            } else {
                                // Nếu không có giá vé, hiển thị thông báo lỗi
                                $('#total-price').text('Không có giá vé.');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log("Có lỗi xảy ra: " + error);
                            $('#total-price').text('Không thể lấy giá vé.');
                        }
                    });
                } else {
                    // Nếu chưa chọn đầy đủ thông tin, xóa giá vé
                    $('#total-price').text('...');
                }
            });
        });

        function updateTotalPrice() {
            // Tính tổng giá dựa trên số lượng ghế đã chọn
            let totalPrice = farePerSeat * selectedSeats.length;

            // Gán tổng tiền vào trường "fare" (giá từng ghế)
            $('#fare').val(farePerSeat); // Gán giá từng ghế vào input "fare"

            // Gán tổng tiền vào trường "total_price"
            $('#total').val(totalPrice); // Gán tổng tiền vào input "total_price"

            // Định dạng tổng tiền với dấu phân cách và đơn vị "đ"
            let formattedPrice = totalPrice.toLocaleString('vi-VN') + 'đ';

            // Cập nhật tổng tiền vào phần tử có id="total-price"
            $('#total-price').text(formattedPrice);
        }
    </script>


@endsection
