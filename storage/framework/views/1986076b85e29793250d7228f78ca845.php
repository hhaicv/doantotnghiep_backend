<?php $__env->startSection('title'); ?>
    Đặt vé
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Danh sách chuyến xe của bạn</h5>
                <div class="header" >
                    <form method="GET"  style="display: flex; justify-content-between;" action="<?php echo e(route('driver.drivers.seats')); ?>">
                        <label for="date">Chọn ngày:</label>
                        <input type="date" id="date" name="date" class="form-control" value="<?php echo e($date); ?>">
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
    <?php if($trips->isEmpty()): ?>
        <h2 style="text-align: center">Không có dữ liệu chuyến xe nào.</h2>
    <?php else: ?>
    <div class="row">
        <div class="col-xl-8">
            <div class="card">
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
                                <?php $__currentLoopData = $groupedTrips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tripId => $trip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <h4 class="mb-1" id="route-info"><?php echo e($trip['route_name']); ?></h4>
                                <span class="fs-5" id="time-info"><?php echo e($trip['date']); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                   
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
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="billinginfo-phone" class="form-label">Số điện thoại</label>
                                            <input type="text" name="phone" class="form-control"
                                                   id="billinginfo-phone"
                                                   value="<?php echo e(old('phone')); ?>" >
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="billinginfo-name" class="form-label">Họ tên</label>
                                            <input type="text" name="name" class="form-control"
                                                   id="billinginfo-name"
                                                   value="<?php echo e(old('name')); ?>" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label for="billinginfo-email" class="form-label">Email <span
                                                    class="text-muted">(Optional)</span></label>
                                            <input type="email" name="email" class="form-control"
                                                   id="billinginfo-email" >
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="billinginfo-address" class="form-label">Ghi chú</label>
                                    <textarea class="form-control" name="note" id="billinginfo-address"
                                              rows="3" ><?php echo e(old('note')); ?></textarea>
                                </div>
                                <div class="d-flex align-items-start gap-3 mt-4">
                                 <button type="button" class="btn btn-primary btn-label right ms-auto nexttab fs-5" id="btn-up-seat" data-seat-id="1">
                                        Đã Lên Xe
                                    </button>
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
        <?php endif; ?>
    </div>
    <script>
    // Dữ liệu trạng thái ghế
    const seatStatusArray = <?php echo json_encode($seatStatusFlat, 15, 512) ?>;

    // Hàm cập nhật trạng thái ghế dựa trên dữ liệu ban đầu
    function updateSeatStatus() {
        document.querySelectorAll('.seat').forEach(function (button) {
            const seatName = button.getAttribute('data-name');
            if (seatStatusArray[seatName]) {
                const { status, is_active } = seatStatusArray[seatName];
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
    const maxSeats = 5; // Giới hạn số ghế được chọn
    let totalPrice = 0; // Tổng giá tiền của ghế đã chọn


    // Xử lý sự kiện khi người dùng click vào ghế
    document.querySelectorAll('.seat').forEach(function (button) {
        button.addEventListener('click', function () {
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

                    selectedSeats.forEach(seat => {
                        const seatButton = document.querySelector(`button[data-name="${seat}"]`);
                        seatButton.setAttribute('data-seat-status', 'selected');
                        fetch(`/api/seats/${seat}/active`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ is_active: 1 })
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
                button.classList.remove('selected');
                button.setAttribute('data-seat-status', 'available');
                button.style.backgroundColor = '';
                selectedSeats = selectedSeats.filter(seat => seat !== seatName);
                document.getElementById('selected-seats').textContent = selectedSeats.join(', ');
                document.getElementById('name_seat').value = selectedSeats.join(', ');

                fetch(`/api/seats/${seatName}/active`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ is_active: 0 })
                }).then(response => {
                    if (!response.ok) {
                        console.error('Failed to update seat status');
                    }
                });
            } else if (seatStatus === 'booked') {
                const bookingInfo = seatStatusArray[seatName];
                document.getElementById('billinginfo-name').value = bookingInfo.name;
                document.getElementById('billinginfo-phone').value = bookingInfo.phone;
                document.getElementById('billinginfo-email').value = bookingInfo.email;
                document.getElementById('billinginfo-address').value = bookingInfo.note;
                document.getElementById('btn-up-seat').value = bookingInfo.id;
                document.querySelector('#pills-bill-address-tab').click();
                return;
            }
        });
    });
    function calculateRefund() {
            const thucThu = parseInt(document.getElementById('billinginfo-thucthu').value.replace(/\./g, '')) || 0;
            const daThu = parseInt(document.getElementById('billinginfo-dathu').value.replace(/\./g, '')) || 0;
            const traLai = daThu - thucThu;

            document.getElementById('billinginfo-tralai').value = formatVND(Math.max(traLai, 0));
        }

        function formatVND(number) {
            return number.toLocaleString('vi-VN') + ' đ';
        }

    // Xử lý cập nhật ghế qua nút cập nhật
    document.getElementById('btn-up-seat').addEventListener('click', function () {
        const seatId = this.getAttribute('value');
        if (!seatId) {
            alert('Không tìm thấy ID ghế!');
            return;
        }
        fetch(`/seats/${seatId}/active`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ is_active: 1 })
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
</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('driver.layouts.mater', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\doantotnghiep\resources\views/driver/drivers/showDetail.blade.php ENDPATH**/ ?>