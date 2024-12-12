<?php $__env->startSection('title'); ?>
    Chi tiết danh sách
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <?php if($tickets->isEmpty()): ?>
                    <div class="card-header">
                        <h6 class="card-title mb-0" style="text-align: center">Không có chuyến đi nào được tìm thấy.</h6>
                    </div>
                <?php else: ?>
                    <?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="card-header">
                            <h6 class="card-title mb-0" style="text-align: center">Chuyến đi - <?php echo e($ticket->route->route_name ?? ''); ?></h6>
                            <hr>
                            <section class="p-3" style="width: 100%;">
                                <div class="row">
                                    <!-- Cột bên trái -->
                                    <div class="col-lg-6">
                                        <ul class="list-group list-group-flush rounded-3">
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Tuyến Đường: <span><?php echo e($ticket->route->name); ?></span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Thời gian: <span><?php echo e(\Carbon\Carbon::parse($ticket->time_start)->format('H:i d/m/Y')); ?></span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Biển số: <span><?php echo e($ticket->bus->license_plate); ?></span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Tổng tiền: <span><?php echo e(number_format($ticket->total_price)); ?> VNĐ</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- Cột bên phải -->
                                    <div class="col-lg-6">
                                        <ul class="list-group list-group-flush rounded-3">
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Tài xế: <span><?php echo e($ticket->bus->driver->name); ?></span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Phụ xe: <span><?php echo e($ticket->bus->driver->assistant_name ?? 'N/A'); ?></span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Số vé: <span><?php echo e($ticket->total_tickets); ?></span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                PV đã thu: <span><?php echo e(number_format($ticket->total_price / 2)); ?> VNĐ</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="card-body">
                            <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                <thead>
                                <tr>
                                    <th>Điểm lên</th>
                                    <th>Điểm xuống</th>
                                    <th>Tên</th>
                                    <th>Số điện thoại</th>
                                    <th>Vị trí</th>
                                    <th>Giá vé</th>
                                    <th>Ghi chú</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $ticket->ticketDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticketDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($ticket->location_start); ?></td>
                                        <td><?php echo e($ticket->location_end); ?></td>
                                        <td><?php echo e($ticket->name); ?></td>
                                        <td><?php echo e($ticket->phone); ?></td>
                                        <td><?php echo e($ticketDetail->name_seat); ?></td>
                                        <td><?php echo e(number_format($ticketDetail->price)); ?> VNĐ</td>
                                        <td><?php echo e($ticket->note); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            <a href="javascript:window.print()" class="btn btn-success"><i class="ri-printer-line align-bottom me-1"></i> Print</a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script-libs'); ?>
    <script src="<?php echo e(asset('theme/admin/assets/libs/apexcharts/apexcharts.min.js')); ?>"></script>
    <script src="<?php echo e(asset('theme/admin/assets/libs/jsvectormap/js/jsvectormap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('theme/admin/assets/libs/jsvectormap/maps/world-merc.js')); ?>"></script>
    <script src="<?php echo e(asset('theme/admin/assets/libs/swiper/swiper-bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('theme/admin/assets/js/pages/dashboard-ecommerce.init.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('style-libs'); ?>
    <link href="<?php echo e(asset('theme/admin/assets/libs/jsvectormap/css/jsvectormap.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('theme/admin/assets/libs/swiper/swiper-bundle.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>

<?php echo $__env->make('driver.layouts.mater', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\doantotnghiep\resources\views/driver/drivers/show.blade.php ENDPATH**/ ?>