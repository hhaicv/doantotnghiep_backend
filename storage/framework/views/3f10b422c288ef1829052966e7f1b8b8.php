<?php $__env->startSection('title'); ?>
    Chi tiết Tài xế
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Chi tiết Tài xế</h4>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body">
            <div class="row">
                <!-- Cột bên trái - Hình ảnh và trạng thái -->
                <div class="col-lg-4">
                    <div class="product-img-slider sticky-side-div mb-4">
                        <div class="swiper product-thumbnail-slider p-2 rounded">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="<?php echo e(Storage::url($data->profile_image)); ?>" alt=""
                                        class="img-fluid d-block" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-black">
                        <h4 class="font-weight bold fs-3"><?php echo e($data->name); ?></h4>
                    </div>

                </div>
                <!-- end col-lg-4 -->

                <!-- Cột bên phải - Thông tin chi tiết -->
                <div class="col-lg-8">
                    <div class="mt-xl-0 mt-5">
                        <div class="text-black-30 mt-3 d-flex justify-content-between align-items-cente">
                            <h5 class="fs-15 text-black">Email:</h5>
                            <?php echo e($data->email); ?>

                        </div>
                        <hr>
                        <div class="text-black-30 mt-3 d-flex justify-content-between align-items-center">
                            <h5 class="fs-15 text-black">Ngày sinh:</h5>
                            <?php echo e(\Illuminate\Support\Carbon::parse($data->date_of_birth)->format('d/m/Y')); ?>

                        </div>
                        <hr>
                        <div class="text-black-30 mt-3 d-flex justify-content-between align-items-center">
                            <h5 class="fs-15 text-black">Số điện thoại:</h5>
                            <span><?php echo e($data->phone); ?></span>
                        </div>
                        <hr>

                        <div class="text-black-30 mt-3 d-flex justify-content-between align-items-center">
                            <h5 class="fs-15 text-black">Bằng lái xe:</h5>
                            <span><?php echo e($data->license_number); ?></span>
                        </div>
                        <hr>

                        <div class="text-black-30 mt-3 d-flex justify-content-between align-items-center">
                            <h5 class="fs-15 text-black">Địa chỉ:</h5>
                            <span><?php echo e($data->address); ?></span>
                        </div>
                        <hr>
                    </div>
                </div>
                <!-- end col-lg-8 -->
            </div>
            <!-- end row -->
        </div>
    </div>
    <div class="text-end">
        <a href="<?php echo e(route('admin.drivers.index')); ?>" class="btn btn-outline-primary mb-3">Danh sách</a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.mater', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\doantotnghiep\resources\views/admin/drivers/show.blade.php ENDPATH**/ ?>