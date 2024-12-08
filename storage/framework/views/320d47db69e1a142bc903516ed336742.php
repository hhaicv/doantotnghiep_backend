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

    <!-- Hiển thị danh sách vé nếu cần -->
    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                        <thead>
                        <tr>
                            <th>Chuyến</th>
                            <th>Giá vé</th>
                            <th>Ngày đi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($ticket->route->route_name); ?></td>
                                <td><?php echo e(number_format($ticket->total_price)); ?> VNĐ</td>
                                <td><?php echo e(\Carbon\Carbon::parse($ticket->date)->format('d/m/Y')); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('driver.layouts.mater', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH L:\laragon\www\doantotnghiep\resources\views/driver/dashboard.blade.php ENDPATH**/ ?>