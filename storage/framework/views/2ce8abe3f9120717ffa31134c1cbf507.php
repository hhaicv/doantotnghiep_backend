<?php $__env->startSection('title'); ?>
    Thêm mới Chuyến xe
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Thêm mới Chuyến xe </h4>
            </div>
        </div>
    </div>

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

    <div class="card">
        <form action="<?php echo e(route('employee.trips.store')); ?>" method="POST" class="row g-3 p-5">
            <?php echo csrf_field(); ?>
            <div class="col-md-6">
                <label for="fullnameInput" class="form-label">Tuyến đường</label>
                <select class="form-select" aria-label="Default select example" name="route_id">
                    <?php $__currentLoopData = $routes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($route->id); ?>" <?php echo e(old('route_id') == $route->id ? 'selected' : ''); ?>>
                            <?php echo e($route->route_name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3">
                <label for="exampleFormControlTextarea5" class="form-label">Thời gian bắt đầu</label>
                <input type="text" class="form-control" name="start_time" placeholder="hh:mm" id="cleave-time-start"
                    value="<?php echo e(old('start_time')); ?>">
                <?php $__errorArgs = ['start_time'];
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
            <div class="col-md-3">
                <label for="exampleFormControlTextarea5" class="form-label">Thời gian kết thúc</label>
                <input type="text" class="form-control" name="end_time" placeholder="hh:mm" id="cleave-time-end"
                    value="<?php echo e(old('end_time')); ?>">
                <?php $__errorArgs = ['end_time'];
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
                    <a href="<?php echo e(route('employee.trips')); ?>" class="btn btn-success">Quay lại</a>
                </div>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>

    <script>
        // Khởi tạo định dạng thời gian cho daily_start_time
        var cleaveTimeStart = new Cleave("#cleave-time-start", {
            time: true,
            timePattern: ["h", "m"]
        });

        // Khởi tạo định dạng thời gian cho daily_end_time
        var cleaveTimeEnd = new Cleave("#cleave-time-end", {
            time: true,
            timePattern: ["h", "m"]
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('employee.layouts.mater', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH L:\laragon\www\doantotnghiep\resources\views/employee/trips/create.blade.php ENDPATH**/ ?>