<?php $__env->startSection('title'); ?>
    Đặt vé
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Danh sách chuyến xe của bạn</h5>
                <div class="card-header">
                    <form method="GET" action="<?php echo e(route('driver.drivers.seats')); ?>">
                        <label for="date">Chọn ngày:</label>
                        <input type="date" id="date" name="date" value="<?php echo e($date); ?>">
                        <button type="submit" class="btn btn-primary">Lọc</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <style>
        li {
            list-style-type: none;
            /* Bỏ dấu chấm */
        }

        li > button {
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
    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <?php if($trips->isEmpty()): ?>
                    <h2 style="text-align: center">Không có dữ liệu chuyến xe nào.</h2>
                <?php else: ?>
                    <?php $__currentLoopData = $trips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $seatCount = $trip->bus->total_seats;
                        ?>
                        <div class="card-body checkout-tab">

                            <?php if($seatCount == 40): ?>
                                <div class="row">
                                    <div class="col">
                                        <h5 class="pt-3 fw-semibold">Tầng 1</h5>
                                    </div>
                                    <div class="col">
                                        <li>
                                            <button class="seat" data-name="A1" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A2" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A3" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A4" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A5" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A6" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
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
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                    </div>
                                    <div class="col">
                                        <li>
                                            <button class="seat" data-name="A7" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A8" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A9" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A10" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A11" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A12" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
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
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                    </div>
                                    <div class="col">
                                        <li>
                                            <button class="seat" data-name="A13" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A14" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A15" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A16" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A17" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A18" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
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
                                                    data-seat-status="available"
                                                    data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B2" data-trip-id="2"
                                                    data-seat-status="available"
                                                    data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B3" data-trip-id="2"
                                                    data-seat-status="available"
                                                    data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B4" data-trip-id="2"
                                                    data-seat-status="selected"
                                                    data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B5" data-trip-id="2"
                                                    data-seat-status="available"
                                                    data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B6" data-trip-id="2"
                                                    data-seat-status="available"
                                                    data-seat-floor="2" type="submit"></button>
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
                                                    data-seat-status="available"
                                                    data-seat-floor="2" type="submit"></button>
                                        </li>
                                    </div>
                                    <div class="col">
                                        <li>
                                            <button class="seat" data-name="B7" data-trip-id="2"
                                                    data-seat-status="available"
                                                    data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B8" data-trip-id="2"
                                                    data-seat-status="available"
                                                    data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B9" data-trip-id="2"
                                                    data-seat-status="available"
                                                    data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B10" data-trip-id="2"
                                                    data-seat-status="available"
                                                    data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B11" data-trip-id="2"
                                                    data-seat-status="available"
                                                    data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B12" data-trip-id="2"
                                                    data-seat-status="available"
                                                    data-seat-floor="2" type="submit"></button>
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
                                                    data-seat-status="available"
                                                    data-seat-floor="2" type="submit"></button>
                                        </li>
                                    </div>
                                    <div class="col">
                                        <li>
                                            <button class="seat" data-name="B13" data-trip-id="2"
                                                    data-seat-status="available"
                                                    data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B14" data-trip-id="2"
                                                    data-seat-status="available"
                                                    data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B15" data-trip-id="2"
                                                    data-seat-status="available"
                                                    data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B16" data-trip-id="2"
                                                    data-seat-status="available"
                                                    data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B17" data-trip-id="2"
                                                    data-seat-status="available"
                                                    data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B18" data-trip-id="2"
                                                    data-seat-status="available"
                                                    data-seat-floor="2" type="submit"></button>
                                        </li>
                                    </div>
                                </div>
                            <?php elseif($seatCount == 34): ?>
                                <div class="row">
                                    <div class="col">
                                        <h5 class="pt-3 fw-semibold">Tầng 1</h5>
                                    </div>
                                    <div class="col">
                                        <li>
                                            <button class="seat" data-name="A1" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A2" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A3" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A4" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A5" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A6" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
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
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A8" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A9" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A10" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A11" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
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
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A13" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A14" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A15" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A16" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A17" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
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
                                                    data-seat-status="available"
                                                    data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B2" data-trip-id="2"
                                                    data-seat-status="available"
                                                    data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B3" data-trip-id="2"
                                                    data-seat-status="available"
                                                    data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B4" data-trip-id="2"
                                                    data-seat-status="selected"
                                                    data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B5" data-trip-id="2"
                                                    data-seat-status="available"
                                                    data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B6" data-trip-id="2"
                                                    data-seat-status="available"
                                                    data-seat-floor="2" type="submit"></button>
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
                                                    data-seat-status="available"
                                                    data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B8" data-trip-id="2"
                                                    data-seat-status="available"
                                                    data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B9" data-trip-id="2"
                                                    data-seat-status="available"
                                                    data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B10" data-trip-id="2"
                                                    data-seat-status="available"
                                                    data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B11" data-trip-id="2"
                                                    data-seat-status="available"
                                                    data-seat-floor="2" type="submit"></button>
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
                                                    data-seat-status="available"
                                                    data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B13" data-trip-id="2"
                                                    data-seat-status="available"
                                                    data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B14" data-trip-id="2"
                                                    data-seat-status="available"
                                                    data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B15" data-trip-id="2"
                                                    data-seat-status="available"
                                                    data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B16" data-trip-id="2"
                                                    data-seat-status="available"
                                                    data-seat-floor="2" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B17" data-trip-id="2"
                                                    data-seat-status="available"
                                                    data-seat-floor="2" type="submit"></button>
                                        </li>
                                    </div>
                                </div>
                            <?php elseif($seatCount == 45): ?>
                                <div class="row">
                                    <div class="col">
                                        <h5 class="pt-3 fw-semibold">Tầng 1</h5>
                                    </div>
                                    <div class="col">
                                        <li>
                                            <button class="seat" data-name="A1" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A2" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A3" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A4" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A5" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A6" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A7" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A8" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A9" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A10" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="A11" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                    </div>
                                    <div class="col">
                                        <li>
                                            <button class="seat" data-name="B1" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B2" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B3" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B4" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B5" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B6" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B7" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B8" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B9" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B10" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="B11" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
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
                                                    data-seat-status="available"
                                                    data-seat-floor="2" type="submit"></button>
                                        </li>
                                    </div>
                                    <div class="col">
                                        <li>
                                            <button class="seat" data-name="D1" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="D2" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="D3" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="D4" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="D5" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="D6" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="D7" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="D8" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="D9" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="D10" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="D11" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                    </div>
                                    <div class="col">
                                        <li>
                                            <button class="seat" data-name="E1" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="E2" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="E3" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="E4" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="E5" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="E6" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="E7" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="E8" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="E9" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="E10" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                        <li>
                                            <button class="seat" data-name="E11" data-trip-id="1"
                                                    data-seat-status="available"
                                                    data-seat-floor="1" type="submit"></button>
                                        </li>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-warning">Chuyến đi này có số ghế không xác định</div>
                            <?php endif; ?>
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
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
                    <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body checkout-tab">
                    <div class="step-arrow-nav mt-n3 mx-n3 mb-3">
                        <ul class="nav nav-pills nav-justified custom-nav" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fs-15 p-3" id="pills-bill-address-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-bill-address" type="button" role="tab"
                                        aria-controls="pills-bill-address" aria-selected="false">
                                    <i class="ri-user-2-line fs-16 p-2 bg-primary-subtle text-primary rounded-circle align-middle me-2"></i>
                                    Thông tin người đặt
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade" id="pills-bill-address" role="tabpanel"
                             aria-labelledby="pills-bill-address-tab">
                            <div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="billinginfo-phone" class="form-label">Số điện thoại</label>
                                            <input type="text" name="phone" class="form-control"
                                                   id="billinginfo-phone"
                                                   value="<?php echo e(old('phone')); ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="billinginfo-name" class="form-label">Họ tên</label>
                                            <input type="text" name="name" class="form-control"
                                                   id="billinginfo-name"
                                                   value="<?php echo e(old('name')); ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label for="billinginfo-email" class="form-label">Email <span
                                                    class="text-muted">(Optional)</span></label>
                                            <input type="email" name="email" class="form-control"
                                                   id="billinginfo-email" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="billinginfo-address" class="form-label">Ghi chú</label>
                                    <textarea class="form-control" name="note" id="billinginfo-address"
                                              rows="3" disabled><?php echo e(old('note')); ?></textarea>
                                </div>
                                <div class="d-flex align-items-start gap-3 mt-4">
                                    <button id="btn-cancel-ride" data-seat-id="seat-123" class="btn btn-danger" type="button">Bỏ chuyến</button>
                                    <button type="button" class="btn btn-primary btn-label right ms-auto nexttab fs-5" id="btn-up-seat" data-seat-id="1">
                                        Đã Lên Xe
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- end tab pane -->
                    </div>
                    <!-- end tab content -->
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
                        <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
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
                            <?php $__currentLoopData = $groupedTrips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tripId => $trip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($trip['time_start']); ?></td>
                                    <td><?php echo e($trip['route_name']); ?></td>
                                    <td><?php echo e($trip['total_tickets']); ?></td>
                                    <td><?php echo e(number_format($trip['total_price'], 0, ',', '.')); ?> VND</td>
                                    <td>
                                        <a href="<?php echo e(route('driver.drivers.show', ['date' => request()->input('date'), 'trip_id' => $tripId])); ?>">Xem chi tiết</a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Cập nhật mảng trạng thái ghế
        const seatStatusArray = <?php echo json_encode($seatStatusFlat, 15, 512) ?>;
        // Cập nhật trạng thái ghế
        document.querySelectorAll('.seat').forEach(function (button) {
            const seatName = button.getAttribute('data-name');
            // Kiểm tra xem ghế có trong mảng trạng thái không
            if (seatStatusArray[seatName]) {
                const { status, is_active } = seatStatusArray[seatName];
                // Cập nhật trạng thái ghế
                button.setAttribute('data-seat-status', status); // Cập nhật thuộc tính status
                button.setAttribute('data-is-active', is_active); // Cập nhật thuộc tính is_active
                // Thay đổi màu sắc hoặc trạng thái dựa trên is_active
                if (is_active === true) {
                    button.classList.remove('selected'); // Xóa lớp selected nếu không phải
                    button.style.backgroundColor = '#14f80b'; // Màu xanh lá cho ghế đang hoạt động
                    button.classList.add('active'); // Thêm lớp active (nếu cần)
                } else {
                    // Thay đổi màu sắc dựa trên trạng thái `status`
                    if (status === 'booked') {
                        button.classList.add('booked'); // Thêm lớp booked
                        button.classList.remove('selected'); // Bỏ lớp selected nếu có
                        button.style.backgroundColor = '#f5c170'; // Màu cho ghế đã đặt
                    } else if (status === 'lock') {
                        button.classList.add('lock'); // Thêm lớp lock
                        button.classList.remove('available'); // Bỏ lớp available nếu có
                        button.classList.remove('booked'); // Bỏ lớp booked nếu có
                        button.style.backgroundColor = '#ff0000'; // Màu đỏ cho ghế bị khoá
                    } else if (status === 'selected') {
                        button.style.backgroundColor = '#9dc3fe'; // Màu xanh dương nhạt cho ghế đã chọn
                    } else {
                        // Trạng thái mặc định (available)
                        button.classList.remove('booked', 'selected', 'lock', 'active');
                        button.style.backgroundColor = ''; // Màu mặc định
                    }
                }
            }
        });
        // Xử lý click cho ghế
        document.querySelectorAll('.seat').forEach(function (button) {
            button.addEventListener('click', function () {
                const seatStatus = button.getAttribute('data-seat-status');
                const seatName = button.getAttribute('data-name'); // Lấy tên ghế từ data-name
                if (seatStatus === 'available') {
                    // Kiểm tra số ghế đã chọn
                    if (selectedSeats.length < maxSeats) {
                        button.classList.toggle('selected');
                        const isSelected = button.classList.contains('selected');
                        // Cập nhật trạng thái ghế
                        button.setAttribute('data-seat-status', isSelected ? 'selected' : 'available');
                        // Cập nhật màu nền cho ghế đã chọn
                        if (isSelected) {
                            button.style.backgroundColor = '#9dc3fe'; // Màu nền cho ghế đã chọn
                            selectedSeats.push(seatName); // Thêm ghế đã chọn vào mảng
                        } else {
                            button.style.backgroundColor = ''; // Đặt lại màu nền khi bỏ chọn
                            selectedSeats = selectedSeats.filter(seat => seat !== seatName); // Xóa ghế khỏi mảng
                        }
                        // Cập nhật hiển thị ghế đã chọn
                        document.getElementById('selected-seats').textContent = selectedSeats.join(', ');
                        document.getElementById('name_seat').value = selectedSeats.join(', ');
                        // Cập nhật trạng thái "đã lên xe" cho ghế nếu đã chọn
                        selectedSeats.forEach(seat => {
                            const seatButton = document.querySelector(`button[data-name="${seat}"]`);
                            seatButton.setAttribute('data-seat-status', 'selected');

                            // Cập nhật trường is_active trong cơ sở dữ liệu
                            fetch(`/api/seats/${seat}/active`, {
                                method: 'PATCH', // Hoặc 'PUT' tuỳ vào cách bạn thiết kế API
                                headers: {
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify({is_active: 1})
                            }).then(response => {
                                if (!response.ok) {
                                    console.error('Failed to update seat status');
                                }
                            });
                        });
                    } else {
                        alert('Bạn chỉ có thể chọn tối đa ' + maxSeats + ' ghế.');
                    }
                } else if (seatStatus === 'selected') {
                    // Nếu ghế đã được chọn, bỏ chọn nó
                    button.classList.remove('selected'); // Bỏ class 'selected'
                    button.setAttribute('data-seat-status', 'available'); // Đặt lại trạng thái ghế
                    // Đặt lại màu nền khi bỏ chọn
                    button.style.backgroundColor = '';
                    selectedSeats = selectedSeats.filter(seat => seat !== seatName); // Xóa ghế khỏi mảng
                    // Cập nhật hiển thị ghế đã chọn
                    document.getElementById('selected-seats').textContent = selectedSeats.join(', ');
                    document.getElementById('name_seat').value = selectedSeats.join(', ');
                    // Cập nhật trường is_active trong cơ sở dữ liệu
                    fetch(`/api/seats/${seatName}/active`, {
                        method: 'PATCH', // Hoặc 'PUT' tuỳ vào cách bạn thiết kế API
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({is_active: 0})
                    }).then(response => {
                        if (!response.ok) {
                            console.error('Failed to update seat status');
                        }
                    });
                } else if (seatStatus === 'booked') {
                    // Hiển thị thông tin người đặt nếu ghế đã đặt
                    const bookingInfo = seatStatusArray[seatName];
                    console.log(bookingInfo);
                    document.getElementById('billinginfo-name').value = bookingInfo.name;
                    document.getElementById('billinginfo-phone').value = bookingInfo.phone;
                    document.getElementById('billinginfo-email').value = bookingInfo.email;
                    document.getElementById('billinginfo-address').value = bookingInfo.note;
                    document.getElementById('btn-up-seat').value = bookingInfo.id;
                    // Chuyển tab sang thông tin người đặt
                    document.querySelector('#pills-bill-address-tab').click(); // Click vào tab thông tin người đặt
                    return;
                }
            });
        });
        document.getElementById('btn-up-seat').addEventListener('click', function () {
            const seatId = this.getAttribute('value');  // Lấy ID ghế từ thuộc tính value của nút
            if (!seatId) {
                alert('Không tìm thấy ID ghế!');
                return;
            }
            // Gửi yêu cầu cập nhật trạng thái is_active của ghế
            fetch(`/seats/${seatId}/active`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    is_active: 1  // Hoặc 0 tùy theo logic bạn muốn
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        // Hiển thị thông báo thành công
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công',
                            text: data.message,  // Hiển thị thông báo từ API
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Reload trang sau khi bấm OK
                                window.location.reload(); // Tự động reload trang
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Thất bại',
                            text: 'Cập nhật thất bại!',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            // Reload trang nếu cần
                            window.location.reload(); // Tự động reload trang
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
                        // Reload trang sau khi bấm OK
                        window.location.reload(); // Tự động reload trang
                    });
                });
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('driver.layouts.mater', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\doantotnghiep\resources\views/driver/drivers/showDetail.blade.php ENDPATH**/ ?>