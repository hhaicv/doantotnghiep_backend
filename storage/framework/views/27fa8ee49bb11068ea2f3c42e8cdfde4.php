<?php $__env->startSection('title'); ?>
    Đặt vé
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Chọn chỗ</h4>
            </div>
        </div>
    </div>
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
            background: #f5c170;
            /* Màu nền cho ghế "booked" */
        }

        .seat.selected {
            background: #9dc3fe;

        }
    </style>
    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body checkout-tab">
                    <?php if ($seatCount == 40): ?>
                    <div class="row">
                        <div class="col">
                            <h5 class="pt-3 fw-semibold">Tầng 1</h5>
                        </div>
                        <div class="col">
                            <li><button class="seat" data-name="A1" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A2" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A3" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A4" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" data-user-id="1" data-user-id="1"
                                    type="submit"></button></li>
                            <li><button class="seat" data-name="A5" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A6" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" data-user-id="1" type="submit"></button></li>
                        </div>
                        <div class="col">
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button class="seat" data-name="A19" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" data-user-id="1" type="submit"></button></li>
                        </div>
                        <div class="col">
                            <li><button class="seat" data-name="A7" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A8" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A9" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A10" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A11" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A12" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                        </div>
                        <div class="col">
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button class="seat" data-name="A20" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                        </div>
                        <div class="col">
                            <li><button class="seat" data-name="A13" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A14" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A15" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A16" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A17" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A18" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                        </div>
                    </div>
                    <hr>
                    <div class="row mt-3">
                        <div class="col">
                            <h5 class="pt-3 fw-semibold">Tầng 2</h5>
                        </div>
                        <div class="col">
                            <li><button class="seat" data-name="B1" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B2" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B3" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B4" data-trip-id="2" data-seat-status="selected"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B5" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B6" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                        </div>
                        <div class="col">
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button class="seat" data-name="B19" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                        </div>
                        <div class="col">
                            <li><button class="seat" data-name="B7" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B8" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B9" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B10" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B11" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B12" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                        </div>
                        <div class="col">
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button class="seat" data-name="B20" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                        </div>
                        <div class="col">
                            <li><button class="seat" data-name="B13" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B14" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B15" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B16" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B17" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B18" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                        </div>
                    </div>
                    <?php elseif ($seatCount == 34): ?>
                    <div class="row">
                        <div class="col">
                            <h5 class="pt-3 fw-semibold">Tầng 1</h5>
                        </div>
                        <div class="col">
                            <li><button class="seat" data-name="A1" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A2" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A3" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A4" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A5" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A6" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                        </div>
                        <div class="col">
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                        </div>
                        <div class="col">
                            <li><button class="seat" data-name="A7" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A8" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A9" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A10" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A11" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                        </div>
                        <div class="col">
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                        </div>
                        <div class="col">
                            <li><button class="seat" data-name="A12" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A13" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A14" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A15" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A16" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A17" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                        </div>
                    </div>
                    <hr>
                    <div class="row mt-3">
                        <div class="col">
                            <h5 class="pt-3 fw-semibold">Tầng 2</h5>
                        </div>
                        <div class="col">
                            <li><button class="seat" data-name="B1" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B2" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B3" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B4" data-trip-id="2" data-seat-status="selected"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B5" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B6" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                        </div>
                        <div class="col">
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                        </div>
                        <div class="col">
                            <li><button class="seat" data-name="B7" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B8" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B9" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B10" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B11" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                        </div>
                        <div class="col">
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                        </div>
                        <div class="col">
                            <li><button class="seat" data-name="B12" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B13" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B14" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B15" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B16" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                            <li><button class="seat" data-name="B17" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                        </div>
                    </div>
                    <?php elseif ($seatCount == 45): ?>
                    <div class="row">
                        <div class="col">
                            <h5 class="pt-3 fw-semibold">Tầng 1</h5>
                        </div>
                        <div class="col">
                            <li><button class="seat" data-name="A1" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A2" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A3" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A4" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A5" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A6" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A7" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A8" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A9" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A10" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="A11" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                        </div>
                        <div class="col">
                            <li><button class="seat" data-name="B1" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="B2" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="B3" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="B4" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="B5" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="B6" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="B7" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="B8" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="B9" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="B10" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="B11" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                        </div>
                        <div class="col">

                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button style="visibility: hidden;" type="submit"></button></li>
                            <li><button class="seat" data-name="C1" data-trip-id="2" data-seat-status="available"
                                    data-seat-floor="2" type="submit"></button></li>
                        </div>
                        <div class="col">
                            <li><button class="seat" data-name="D1" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="D2" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="D3" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="D4" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="D5" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="D6" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="D7" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="D8" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="D9" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="D10" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="D11" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                        </div>
                        <div class="col">
                            <li><button class="seat" data-name="E1" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="E2" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="E3" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="E4" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="E5" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="E6" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="E7" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="E8" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="E9" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="E10" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                            <li><button class="seat" data-name="E11" data-trip-id="1" data-seat-status="available"
                                    data-seat-floor="1" data-user-id="1" type="submit"></button></li>
                        </div>
                    </div>

                    <?php endif; ?>

                    <div class="row mt-2 p-2" style="background: #ecedf1 !important;">
                        <div class="col">
                            <li><button type="submit"></button> <br> Ghế trống</li>
                        </div>
                        <div class="col">
                            <li><button style="background: #9dc3fe;" type="submit"></button> <br> Ghế đang chọn</li>
                        </div>
                        <div class="col">
                            <li><button style="background: #f5c170;" type="submit"></button> <br> Ghế đã mua</li>
                        </div>
                        <div class="col">
                            <li><button style="background: #e76966;" type="submit"></button> <br> Ghế đã đặt</li>
                        </div>
                    </div>

                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>


        <!-- end col -->

        <div class="col-xl-4">
            <div class="card">
                <div class="card-body checkout-tab">
                    <form action="<?php echo e(route('admin.tickets.store')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="trip_id" id="trip_id">
                        <input type="hidden" name="bus_id" id="bus_id">
                        <input type="hidden" name="route_id" id="route_id">
                        <input type="hidden" name="time_start" id="time_start">
                        <input type="hidden" name="fare" id="fare">
                        <input type="hidden" name="date" id="date">
                        <input type="hidden" name="name_seat" id="name_seat">

                        <div class="step-arrow-nav mt-n3 mx-n3 mb-3">
                            <ul class="nav nav-pills nav-justified custom-nav" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3 active" id="pills-bill-info-tab"
                                        data-bs-toggle="pill" data-bs-target="#pills-bill-info" type="button"
                                        role="tab" aria-controls="pills-bill-info" aria-selected="true">
                                        <i
                                            class="ri-truck-line fs-16 p-2 bg-primary-subtle text-primary rounded-circle align-middle me-2"></i>
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
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3" id="pills-payment-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-payment" type="button" role="tab"
                                        aria-controls="pills-payment" aria-selected="false">
                                        <i
                                            class="ri-bank-card-line fs-16 p-2 bg-primary-subtle text-primary rounded-circle align-middle me-2"></i>
                                        Thanh toán
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="pills-bill-info" role="tabpanel"
                                aria-labelledby="pills-bill-info-tab">
                                <div>
                                    <h4 class="mb-1" id="route-info">Chiêm hóa - Bến xe Mỹ Đình</h4>
                                    <span class="fs-5" id="time-info">06:50 - 29/10/2024</span>
                                </div>
                                <hr>
                                <div class="mt-4">
                                    <div class="row gy-3">
                                        <div class="col-4">
                                            <p class="fs-5">Ghế đã chọn: </p>
                                            <p class="fs-5">Tổng tiền: </p>
                                            <p class="fs-5">Điểm đi:<span style="color: red">*</span></p>
                                            <br>
                                            <br>
                                            <br>
                                            <p class="fs-5">Điểm đến:<span style="color: red">*</span></p>
                                        </div>
                                        <div class="col">
                                            <p class="fs-5" id="selected-seats">...</p>
                                            <p class="fs-5" id="total-price">...</p>
                                            <select name="location_start" class="form-select"
                                                aria-label="Default select example">
                                                <option value="Tại bến">Tại bến</option>
                                                <option value="Dọc đường">Dọc đường</option>
                                            </select>
                                            <select name="id_start_stop" class="form-select mt-2"
                                                aria-label="Default select example" id="start-stop">
                                                <!-- ID và tên sẽ được cập nhật ở đây -->
                                            </select>
                                            <select name="location_end" class="form-select mt-3"
                                                aria-label="Default select example">
                                                <option value="Tại bến">Tại bến</option>
                                                <option value="Dọc đường">Dọc đường</option>
                                            </select>
                                            <select name="id_end_stop" class="form-select mt-2"
                                                aria-label="Default select example" id="end-stop">
                                                <!-- ID và tên sẽ được cập nhật ở đây -->
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end tab pane -->

                            <div class="tab-pane fade" id="pills-bill-address" role="tabpanel"
                                aria-labelledby="pills-bill-address-tab">
                                <div>
                                    <h5 class="mb-1">Thông tin khách hàng</h5>
                                    <p class="text-muted mb-4">Vui lòng nhập đầy đủ thông tin</p>
                                </div>
                                <div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="billinginfo-phone" class="form-label">Số điện thoại</label>
                                                <input type="text" name="phone" class="form-control"
                                                    id="billinginfo-phone" placeholder="Nhập số điện thoại"
                                                    value="<?php echo e(old('phone')); ?>">
                                                <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="text-danger"><?php echo e($message); ?></span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="billinginfo-name" class="form-label">Họ tên</label>
                                                <input type="text" name="name" class="form-control"
                                                    id="billinginfo-name" placeholder="Nhập họ tên"
                                                    value="<?php echo e(old('name')); ?>">
                                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="text-danger"><?php echo e($message); ?></span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="billinginfo-email" class="form-label">Email <span
                                                        class="text-muted">(Optional)</span></label>
                                                <input type="email" name="email" class="form-control"
                                                    id="billinginfo-email" placeholder="Nhập email">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="billinginfo-address" class="form-label">Ghi chú</label>
                                        <textarea class="form-control" name="note" id="billinginfo-address" placeholder="Nhập ghi chú"
                                            rows="3"><?php echo e(old('note')); ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-payment" role="tabpanel"
                                aria-labelledby="pills-payment-tab">
                                <div>
                                    <h5 class="mb-1">Thông tin thanh toán</h5>
                                    <p class="text-muted mb-4">Vui long nhập đầy đủ thông tin</p>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="billinginfo-thucthu" class="form-label">Thực thu</label>
                                            <input type="text" name="total_price" class="form-control"
                                                id="billinginfo-thucthu" readonly>
                                            <?php $__errorArgs = ['total_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="text-danger"><?php echo e($message); ?></span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="billinginfo-dathu" class="form-label">Đã thu</label>
                                            <input type="text" class="form-control" id="billinginfo-dathu"
                                                oninput="calculateRefund()">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="billinginfo-tralai" class="form-label">Trả lại</label>
                                            <input type="text" class="form-control" id="billinginfo-tralai"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label for="billinginfo-email" class="form-label">Hình thức thanh
                                                toán</label>
                                            <select name="payment_method_id" class="form-select"
                                                aria-label="Default select example">
                                                <?php foreach ($methods as $method) { ?>
                                                <option value="<?php echo $method['id']; ?>"><?php echo $method['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-check mb-3" id="emailCheckboxContainer"
                                            style="display: none;">
                                            <input class="form-check-input" type="checkbox" id="formCheckEmail"
                                                checked>
                                            <label class="form-check-label" for="formCheckEmail">
                                                Gửi vé điện tử qua Email
                                            </label>
                                        </div>
                                    </div>

                                </div>
                                <div class="d-flex align-items-start gap-3 mt-4">

                                    <button type="submit" class="btn btn-primary btn-label right ms-auto nexttab fs-5"
                                        data-nexttab="pills-finish-tab"><i
                                            class="ri-coins-fill label-icon align-middle fs-16 ms-2"></i>Thu tiền</button>

                                </div>
                            </div>

                            <!-- end tab pane -->
                        </div>
                        <!-- end tab content -->
                    </form>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="//js.pusher.com/3.1/pusher.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous">
    </script>
    <script>
        // Giả sử bạn đã nhận được mảng trạng thái ghế từ máy chủ
        const seatStatusArray = <?php echo json_encode($seatsStatus, 15, 512) ?>;

        // Lặp qua từng ghế và cập nhật trạng thái
        document.querySelectorAll('.seat').forEach(function(button) {
            const seatName = button.getAttribute('data-name');

            // Kiểm tra xem ghế có trong mảng trạng thái không
            if (seatStatusArray[seatName]) {
                const status = seatStatusArray[seatName];

                // Cập nhật trạng thái ghế
                button.setAttribute('data-seat-status', status); // Cập nhật thuộc tính status

                // Thay đổi màu sắc dựa trên trạng thái
                if (status === 'booked') {
                    button.classList.add('booked'); // Thêm lớp booked
                    button.classList.remove('selected'); // Bỏ lớp selected nếu có
                } else if (status === 'lock') {
                    button.classList.add('lock'); // Thêm lớp selected
                    button.classList.remove('available'); // Bỏ lớp available nếu có
                    button.classList.remove('booked'); // Bỏ lớp booked nếu có
                    button.classList.remove('selected'); // Xóa lớp selected nếu không phải
                } else {
                    button.classList.remove('booked'); // Xóa lớp booked nếu không phải
                    button.classList.remove('selected'); // Xóa lớp selected nếu không phải
                }

                // Cập nhật màu sắc cho ghế
                if (status === 'booked') {
                    button.style.backgroundColor = '#f5c170'; // Màu cho ghế đã đặt
                } else if (status === 'lock') {
                    button.style.backgroundColor = '#e76966'; // Màu cho ghế bảo trì
                } else if (status === 'selected') {
                    button.style.backgroundColor = '#9dc3fe'; // Màu cho ghế đã chọn
                }
            }
        });


        document.getElementById('billinginfo-email').addEventListener('input', function() {
            const emailCheckboxContainer = document.getElementById('emailCheckboxContainer');
            emailCheckboxContainer.style.display = this.value ? 'block' : 'none';
        });

        function getParameterByName(name, url = window.location.href) {
            name = name.replace(/[\[\]]/g, "\\$&");
            const regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }
        document.getElementById("trip_id").value = getParameterByName("trip_id");
        document.getElementById("bus_id").value = getParameterByName("bus_id");
        document.getElementById("route_id").value = getParameterByName("route_id");
        document.getElementById("time_start").value = getParameterByName("time_start");
        document.getElementById("fare").value = getParameterByName("fare");
        document.getElementById("date").value = getParameterByName("date");

        function calculateRefund() {
            const thucThu = parseInt(document.getElementById('billinginfo-thucthu').value.replace(/\./g, '')) || 0;
            const daThu = parseInt(document.getElementById('billinginfo-dathu').value.replace(/\./g, '')) || 0;
            const traLai = daThu - thucThu;

            document.getElementById('billinginfo-tralai').value = formatVND(Math.max(traLai, 0));
        }

        function formatVND(number) {
            return number.toLocaleString('vi-VN') + ' đ';
        }

        function getUrlParams() {
            const params = new URLSearchParams(window.location.search);
            return {
                bus_id: params.get('bus_id'),
                route_id: params.get('route_id'),
                trip_id: params.get('trip_id'),
                start_stop_id: params.get('start_stop_id'),
                end_stop_id: params.get('end_stop_id'),
                start_name: params.get('start_name'),
                end_name: params.get('end_name'),
                route: params.get('route').replace(/\+/g, ' '),
                bus: params.get('bus').replace(/\+/g, ' '),
                time_start: params.get('time_start').substring(0, 5),
                totalSeats: params.get('totalSeats'),
                fare: parseFloat(params.get('fare')).toLocaleString('vi-VN') + ' VND',
                date: params.get('date').split('-').reverse().join('/')
            };
        }

        function displayInfo() {
            const info = getUrlParams();
            document.getElementById('route-info').textContent = info.route;
            document.getElementById('time-info').textContent = `${info.time_start} - ${info.date}`;

            document.getElementById('start-stop').innerHTML = `
                                        <option value="${info.start_stop_id}">${info.start_name}</option>
                                    `;

            document.getElementById('end-stop').innerHTML = `
                                        <option value="${info.end_stop_id}">${info.end_name}</option>
                                    `;
        }

        displayInfo();

        const params = new URLSearchParams(window.location.search);
        const tripId = params.get('trip_id');

        // Gán trip_id vào các nút ghế
        const seatButtons = document.querySelectorAll('button[data-trip-id]');
        seatButtons.forEach(button => {
            button.setAttribute('data-trip-id', tripId);
        });
        const user_Id = params.get('user_id');

        // Gán trip_id vào các nút ghế
        const userButtons = document.querySelectorAll('button[data-user-id]');
        userButtons.forEach(button => {
            button.setAttribute('data-user-id', user_Id);
        });

        let selectedSeats = []; // Mảng lưu trữ ghế đã chọn
        const fare = parseFloat(new URLSearchParams(window.location.search).get('fare')); // Lấy fare từ URL
        const maxSeats = 8; // Giới hạn số ghế tối đa

        const userId = <?php echo json_encode(Auth::guard('admin')->id(), 15, 512) ?>;

        document.querySelectorAll('.seat').forEach(function(button) {
            button.addEventListener('click', function() {
                const seatName = button.getAttribute('data-name');
                const tripId = button.getAttribute('data-trip-id');
                const seatStatus = button.getAttribute('data-seat-status');
                const seatUserId = button.getAttribute('data-user-id'); // Lấy userId từ ghế


                if (seatStatus === 'selected' && seatUserId && seatUserId !== String(userId)) {
                    // console.log(`Ghế ${seatName} đã được chọn bởi userId ${seatUserId}`);
                    Swal.fire({
                        icon: 'warning',
                        title: 'Thông báo',
                        text: `Ghế này đã được chọn bởi người khác!`,
                        confirmButtonText: 'OK',
                    });
                    return; // Ngăn không cho người dùng thao tác
                }
                if (seatStatus === 'available') {
                    // Kiểm tra số ghế đã chọn
                    if (selectedSeats.length < maxSeats) {
                        // Cập nhật trạng thái giao diện
                        button.classList.add('selected');
                        button.setAttribute('data-seat-status', 'selected');
                        button.style.backgroundColor = '#9dc3fe'; // Màu nền cho ghế đã chọn

                        selectedSeats.push(seatName); // Thêm ghế vào mảng

                        document.getElementById('selected-seats').textContent = selectedSeats.join(', ');
                        document.getElementById('name_seat').value = selectedSeats.join(', ');

                        // Tính tổng tiền
                        const totalPrice = selectedSeats.length * fare; // Tổng tiền
                        document.getElementById('total-price').textContent = totalPrice.toLocaleString(
                            'vi-VN', {
                                style: 'currency',
                                currency: 'VND'
                            });
                        document.getElementById("billinginfo-thucthu").value = totalPrice;
                        // Gửi yêu cầu AJAX để cập nhật trạng thái trên server
                        fetch('/admin/update-seat-status', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>', // Đảm bảo bạn đã cấu hình CSRF token
                                },
                                body: JSON.stringify({
                                    name: seatName,
                                    trip_id: tripId,
                                    status: 'selected',
                                    userId: userId,
                                }),
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    console.log('Cập nhật ghế thành công:', data.seat);
                                } else {
                                    alert('Cập nhật trạng thái thất bại. Vui lòng thử lại.');
                                }
                            })
                            .catch(error => {
                                console.error('Lỗi khi cập nhật ghế:', error);
                            });
                    } else {
                        alert('Bạn chỉ có thể chọn tối đa ' + maxSeats + ' ghế.');
                    }
                } else if (seatStatus === 'selected') {
                    // Nếu ghế đã được chọn, bỏ chọn nó
                    button.classList.remove('selected');
                    button.setAttribute('data-seat-status', 'available');
                    button.style.backgroundColor = '';

                    selectedSeats = selectedSeats.filter(seat => seat !== seatName); // Xóa ghế khỏi mảng

                    document.getElementById('selected-seats').textContent = selectedSeats.join(', ');

                    document.getElementById('name_seat').value = selectedSeats.join(', ');

                    // Tính tổng tiền
                    const totalPrice = selectedSeats.length * fare; // Tổng tiền
                    document.getElementById('total-price').textContent = totalPrice.toLocaleString(
                        'vi-VN', {
                            style: 'currency',
                            currency: 'VND'
                        });
                    document.getElementById("billinginfo-thucthu").value = totalPrice;
                    // Gửi yêu cầu AJAX để cập nhật trạng thái về "available" trên server
                    fetch('/admin/update-seat-status', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                            },
                            body: JSON.stringify({
                                name: seatName,
                                trip_id: tripId,
                                status: 'available',
                                userId: userId,
                            }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                console.log('Ghế được cập nhật lại trạng thái available:', data.seat);
                            } else {
                                alert('Cập nhật trạng thái thất bại. Vui lòng thử lại.');
                            }
                        })
                        .catch(error => {
                            console.error('Lỗi khi cập nhật trạng thái ghế:', error);
                        });
                } else if (seatStatus === 'booked') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Thông báo',
                        text: 'Ghế đã đươc mua. Vui lòng chọn ghế khác!.',
                        confirmButtonText: 'OK'
                    });
                    return;
                } else if (seatStatus === 'lock') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Thông báo',
                        text: 'Ghế đã được đặt. Vui lòng chọn ghế khác!.',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
            });
        });
        var pusher = new Pusher('8579e6baacda80044680', {
            encrypted: true,
            cluster: "ap1"
        });

        // Lắng nghe kênh và sự kiện
        var channel = pusher.subscribe('seat-channel');

        channel.bind('App\\Events\\SeatUpdatedEvent', function(data) {
            const {
                seat
            } = data;
            // console.log(seat);

            // Cập nhật trạng thái ghế
            const button = document.querySelector(`button[data-name="${seat.name}"]`);
            if (button) {
                if (seat.status === 'selected') {
                    button.classList.add(seat.status);
                    button.setAttribute('data-seat-status', seat.status);
                    button.setAttribute('data-user-id', seat.userId);
                    button.style.backgroundColor = '00FF00'; // Màu ghế đã mua
                } else if (seat.status === 'available') {
                    button.classList.remove('selected');
                    button.setAttribute('data-seat-status', seat.status);
                    button.setAttribute('data-user-id', seat.userId);
                    button.style.backgroundColor = '';
                }
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.mater', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH L:\laragon\www\doantotnghiep\resources\views/admin/tickets/create.blade.php ENDPATH**/ ?>