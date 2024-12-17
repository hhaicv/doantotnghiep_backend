<?php $__env->startSection('title'); ?>
    Dashboard
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">Danh sách chuyến xe của bạn</h5>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                           style="width:100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Thời gian khởi hành</th>
                            <th>Ngày khởi hành</th>
                            <th>Tuyến đường</th>
                            <th>Xe</th>
                            <th>Ghế</th>
                            <th>Biển số xe</th>
                            <th>Trạng thái</th>
                            <th>Chi tiết</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $trips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($trip->id); ?></td>
                                <td><?php echo e(\Carbon\Carbon::parse($trip->time_start)->format('H:i')); ?></td>
                                <td><?php echo e($trip->date); ?></td>
                                <td><?php echo e($trip->route->route_name ?? ''); ?></td>
                                <td><?php echo e($trip->bus->name_bus); ?></td>
                                <td><?php echo e($trip->bus->total_seats); ?></td>
                                <td><?php echo e($trip->bus->license_plate); ?></td>
                                <td>
                                    <span class="<?php echo e($trip->is_active ? 'text-success' : 'text-danger'); ?>">
                                        <?php echo e($trip->is_active ? 'Hoạt động' : 'Chờ'); ?>

                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo e(route('drivers.show', $trip->id)); ?>" class="btn btn-primary btn-sm">
                                        Xem chi tiết
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script-libs'); ?>
    <script src="<?php echo e(asset('theme/admin/assets/libs/apexcharts/apexcharts.min.js')); ?>"></script>

    <!-- Vector map-->
    <script src="<?php echo e(asset('theme/admin/assets/libs/jsvectormap/js/jsvectormap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('theme/admin/assets/libs/jsvectormap/maps/world-merc.js')); ?>"></script>

    <!--Swiper slider js-->
    <script src="<?php echo e(asset('theme/admin/assets/libs/swiper/swiper-bundle.min.js')); ?>"></script>

    <!-- Dashboard init -->
    <script src="<?php echo e(asset('theme/admin/assets/js/pages/dashboard-ecommerce.init.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('style-libs'); ?>
    <link href="<?php echo e(asset('theme/admin/assets/libs/jsvectormap/css/jsvectormap.min.css')); ?>" rel="stylesheet"
          type="text/css" />

    <!--Swiper slider css-->
    <link href="<?php echo e(asset('theme/admin/assets/libs/swiper/swiper-bundle.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>

<?php echo $__env->make('driver.layouts.mater', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\doantotnghiep\resources\views/driver/drivers/index.blade.php ENDPATH**/ ?>