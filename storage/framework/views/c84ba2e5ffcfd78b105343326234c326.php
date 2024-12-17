<?php $__env->startSection('title'); ?>
    Thêm mới tài khoản người dùng
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Thêm mới tài khoản người dùng</h4>
            </div>
        </div>
    </div>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

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
        <form action="<?php echo e(route('admin.users.store')); ?>" method="POST" class="row g-3 p-5">
            <?php echo csrf_field(); ?>

            <div class="col-md-6">
                <label for="nameInput" class="form-label">Tên tài khoản</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo e(old('name')); ?>" required>
            </div>

            <div class="col-md-6">
                <label for="emailInput" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo e(old('email')); ?>" required>
            </div>

            <div class="col-md-6">
                <label for="phoneInput" class="form-label">Số điện thoại</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo e(old('phone')); ?>" required>
            </div>

            <div class="col-md-6">
                <label for="addressInput" class="form-label">Địa chỉ</label>
                <input type="text" class="form-control" id="address" name="address" value="<?php echo e(old('address')); ?>">
            </div>

            <div class="col-md-6">
                <label for="typeInput" class="form-label">Loại người dùng</label>
                <select class="form-select" id="type" name="type" required>
                    <option value="<?php echo e(\App\Models\User::TYPE_EMPLOYEE); ?>">Employee</option>
                </select>
            </div>

            <div class="col-md-6">
                <label for="passwordInput" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <div class="col-md-6">
                <label for="passwordConfirmInput" class="form-label">Xác nhận mật khẩu</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>

            <div class="col-md-6">
                <label for="isActiveInput" class="form-label">Kích hoạt</label>
                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" <?php echo e(old('is_active') ? 'checked' : ''); ?>>
            </div>

            <div class="col-12">
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Tạo tài khoản</button>
                    <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-secondary">Quay lại</a>
                </div>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.mater', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\doantotnghiep\resources\views/admin/users/create.blade.php ENDPATH**/ ?>