<?php $__env->startSection('title'); ?>
    Thống kê Dashboard
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Tổng số chuyến đã đi</h5>
                </div>
                <div class="card-body">
                    <p>Số chuyến đã đi: <strong><?php echo e($totalTrips); ?></strong></p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Doanh thu</h5>
                </div>
                <div class="card-body">
                    <p>Tổng doanh thu: <strong><?php echo e(number_format($totalRevenue)); ?> VNĐ</strong></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Hiển thị danh sách các chuyến đi theo ngày -->
    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Tỷ lệ lấp đầy các chuyến xe theo ngày</h5>





                </div>
                <div class="card-body">
                    <?php if($tripStatsByDate->isEmpty()): ?>
                        <p>Không có dữ liệu chuyến đi nào.</p>
                    <?php else: ?>
                        <?php $__currentLoopData = $tripStatsByDate; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $routes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <h5>Ngày: <strong><?php echo e($date); ?></strong></h5>
                            <table class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                <thead>
                                <tr>
                                    <th>Tuyến</th>
                                    <th>Số ghế</th>
                                    <th>Số ghế đã bán</th>
                                    <th>Tỷ lệ lấp đầy (%)</th>
                                    <th>Doanh thu chuyến</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $routes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($route['route']); ?></td>
                                        <td><?php echo e($route['total_seats']); ?></td>
                                        <td><?php echo e($route['soldSeats']); ?></td>
                                        <td><?php echo e($route['fillRate']); ?>%</td>
                                        <td><?php echo e(number_format($route['totalRevenue'], 0, ',', '.')); ?> VNĐ</td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <!-- Hiển thị liên kết phân trang -->
                        <div class="mt-3">
                            <?php echo e($tickets->links('pagination::bootstrap-4')); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('driver.layouts.mater', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\doantotnghiep\resources\views/driver/dashboard.blade.php ENDPATH**/ ?>