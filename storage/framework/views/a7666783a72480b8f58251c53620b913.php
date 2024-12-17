<?php $__env->startSection('title'); ?>
    Cập nhật lại phân quyền
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Cập nhật lại phân quyền</h4>
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
        <form action="<?php echo e(route('admin.roles.update', $model)); ?>" method="POST" class="row g-3 p-5">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="col-md-12">
                <label for="fullnameInput" class="form-label">Tên quyền</label>
                <input type="text" class="form-control" id="name_role" name="name_role" value="<?php echo e($model->name_role); ?>">
            </div>
            <div class="col-md-12">
                <label for="exampleFormControlTextarea5" class="form-label">Mô tả</label>
                <textarea class="form-control" id="exampleFormControlTextarea5" name="description" rows="2"><?php echo e($model->description); ?></textarea>
            </div>
            
            <div class="col-12">
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="<?php echo e(route('admin.roles.index')); ?>" class="btn btn-success">Quay lại</a>
                </div>
            </div>
        </form>
    </div>
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.mater', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\doantotnghiep\resources\views/admin/roles/edit.blade.php ENDPATH**/ ?>