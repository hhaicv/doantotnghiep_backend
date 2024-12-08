<?php $__env->startSection('title'); ?>
    Chi tiết Tin tức
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Chi tiết Tin tức</h4>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body">
            <div class="row gx-lg-5">
                <!-- Cột bên trái - Hình ảnh -->
                <div class="col-xl-4 col-md-8 mx-auto">
                    <div class="product-img-slider sticky-side-div">
                        <div class="swiper product-thumbnail-slider p-2 rounded bg-light">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide d-flex justify-content-center">
                                    <img src="<?php echo e(Storage::url($data->thumbnail_image)); ?>" alt="" width="300px"
                                        class="img-fluid d-block" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->

                <!-- Cột bên phải - Chi tiết tin tức -->
                <div class="col-xl-8">
                    <div class="mt-xl-0 mt-5">
                        <!-- Tiêu đề -->
                        <div class="d-flex justify-content-between align-items-center">
                            <h4><?php echo e($data->title); ?></h4>
                            
                            <a href="<?php echo e(route('admin.information.index')); ?>" class="btn btn-primary mb-3">Danh sách</a>
                            
                        </div>
                        
                        <div class="ms-3">
                            <?php $__currentLoopData = $data->newCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="badge bg-primary"><?php echo e($category->name); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                       

                        <!-- Lượt xem -->
                        <div class="text-black-30 mt-3 d-flex justify-content-between align-items-center">
                            <h5 class="fs-15 text-black mb-0">Lượt xem:</h5>
                            <span><?php echo e($data->views_count); ?> lượt xem</span>
                        </div>
                        <hr>

                        <!-- Tóm tắt -->
                        <div class="text-black-30 mt-3 d-flex justify-content-between align-items-center">
                            <h5 class="fs-15 text-black mb-0">Tóm tắt:</h5>
                            <span class="text-muted"><?php echo $data->summary; ?></span>
                        </div>
                        <hr>

                        <!-- Nội dung -->
                        <div class="text-black-30 mt-3 d-flex justify-content-between align-items-center">
                            <h5 class="fs-15 text-black mb-0">Nội dung:</h5>
                            <span class="text-muted"><?php echo $data->content; ?></span>
                        </div>
                       
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.mater', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH L:\laragon\www\doantotnghiep\resources\views/admin/information/show.blade.php ENDPATH**/ ?>