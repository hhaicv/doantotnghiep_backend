<?php $__env->startSection('title'); ?>
    Chi tiết Tin tức
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Chi tiết Tin tức </h4>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row gx-lg-5">
                <div class="col-xl-4 col-md-8 mx-auto">
                    <div class="product-img-slider sticky-side-div">
                        <div class="swiper product-thumbnail-slider p-2 rounded bg-light">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="<?php echo e(Storage::url($data->thumbnail_image)); ?>" alt=""
                                        class="img-fluid d-block" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->

                <div class="col-xl-8">
                    <div class="mt-xl-0 mt-5">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h4><?php echo e($data->title); ?></h4>
                                <div class="hstack gap-3 flex-wrap">
                                    <?php $__currentLoopData = $data->newCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="text-muted"><span
                                                class="text-body fw-medium"><?php echo e($category->name); ?></span>
                                        </div>
                                        <div class="vr"></div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                            <a href="<?php echo e(route('admin.information.index')); ?>" class="btn btn-success">Danh sách</a>
                            
                        </div>
                        <div class="d-flex flex-wrap gap-2 align-items-center mt-3">
                            <div class="text-muted">( <?php echo e($data->views_count); ?> lượt xem )</div>
                        </div>
                        <div class="mt-4 text-muted">
                            <h5 class="fs-14">Tóm tắt :</h5>
                            <?php echo $data->summary  ?>

                        </div>
                        <div class="mt-4 text-muted">
                            <h5 class="fs-14">Nội dung :</h5>
                            <?php echo $data->content  ?>
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.mater', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\doantotnghiep\resources\views/admin/information/show.blade.php ENDPATH**/ ?>