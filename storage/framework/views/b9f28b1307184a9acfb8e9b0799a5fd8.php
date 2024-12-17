<?php $__env->startSection('title'); ?>
    Thêm mới Liên Hệ
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row" style="margin-bottom: 20px">

        <?php if(session('success')): ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công',
                        text: "<?php echo e(session('success')); ?>"
                    });
                });
            </script>
        <?php endif; ?>

        <?php if(session('failes')): ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Thất bại',
                        text: "<?php echo e(session('failes')); ?>"
                    });
                });
            </script>
        <?php endif; ?>

    </div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Thêm Liên Hệ </h4>
            </div>
        </div>
    </div>
    <div class="card">
        <form action="<?php echo e(route('admin.contacts.store')); ?>" method="POST" class="row g-3 p-5">
            <?php echo csrf_field(); ?>
            <div class="col-md-12">
                <label for="fullnameInput" class="form-label">Tên</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Tên"
                    value="<?php echo e(old('name')); ?>">
                <?php $__errorArgs = ['name'];
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
                <label for="fullnameInput" class="form-label">Email</label>
                <input type="email" class="form-control" id="icon" name="email" placeholder="Nhập email"
                    value="<?php echo e(old('email')); ?>">
                <?php $__errorArgs = ['email'];
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
                <label for="fullnameInput" class="form-label">Số điện thoại</label>
                <input type="number" class="form-control" id="icon" name="phone" placeholder="Nhập số điện thoại"
                    value="<?php echo e(old('phone')); ?>">
                <?php $__errorArgs = ['phone'];
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
                <label for="fullnameInput" class="form-label">Tiêu đề</label>
                <input type="text" class="form-control" id="icon" name="title" placeholder="Nhập số tiêu đề"
                    value="<?php echo e(old('title')); ?>">
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
                <label for="exampleFormControlTextarea5" class="form-label">Nội Dung</label>
                <textarea class="form-control" placeholder="Mô tả chi tiết" id="exampleFormControlTextarea5" name="message"
                    rows="2"><?php echo e(old('message')); ?></textarea>
                <?php $__errorArgs = ['message'];
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
            <input type="hidden" name="is_active" value="0">
            <div class="col-12">
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="<?php echo e(route('admin.contacts.index')); ?>" class="btn btn-success">Quay lại</a>
                </div>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.mater', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH L:\laragon\www\doantotnghiep\resources\views/admin/contacts/create.blade.php ENDPATH**/ ?>