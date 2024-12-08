
<?php $__env->startSection('title'); ?>
    Cập nhật lại khuyến mại
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Cập nhật lại khuyến mại</h4>
            </div>
        </div>
    </div>
   
    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <div class="card"> 
        <form action="<?php echo e(route('admin.promotion_categories.update', $data)); ?>" method="POST" class="row g-3 p-5"  enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="col-md-6">
                <label for="codeInput" class="form-label">Tên danh mục:</label>
                <input type="text" class="form-control" name="name" value="<?php echo e($data->name); ?>">
                <?php $__errorArgs = ['title'];
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
            <div class="col-md-6">
                <label for="exampleFormControlTextarea5" class="form-label">Mô tả danh mục</label>
                <textarea class="form-control" name="description" rows="2"><?php echo e($data->description); ?></textarea>
                <?php $__errorArgs = ['title'];
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
            <div class="col-12">
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="<?php echo e(route('admin.promotion_categories.index')); ?>" class="btn btn-success">Quay lại</a>
                </div>
            </div>
        </form>
        

    </div>
<?php $__env->stopSection(); ?>



<script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>


<?php echo $__env->make('admin.layouts.mater', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH L:\laragon\www\doantotnghiep\resources\views/admin/promotion_categories/edit.blade.php ENDPATH**/ ?>