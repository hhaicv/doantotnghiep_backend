<?php $__env->startSection('title'); ?>
    Cập nhật xe
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Cập nhật xe</h4>
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
        <form action="<?php echo e(route('admin.buses.update', $model)); ?>" method="POST" class="row g-3 p-5"
            enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="col-md-6">
                <label for="fullnameInput" class="form-label">Tên xe</label>
                <input type="text" class="form-control" id="name_bus" name="name_bus" value="<?php echo e($model->name_bus); ?>">
            </div>
            <div class="col-md-6">
                <label for="fullnameInput" class="form-label">Tên tài xế</label>
                <input type="text" class="form-control" id="model" name="model" value="<?php echo e($model->model); ?>">
            </div>
            <div class="col-md-6">
                <label for="fullnameInput" class="form-label">Biển số xe</label>
                <input type="text" class="form-control" id="license_plate" name="license_plate"
                    value="<?php echo e($model->license_plate); ?>">
            </div>
            <div class="col-md-6">
                <label for="fullnameInput" class="form-label">Tài xế</label>
                <select class="form-select" aria-label="Default select example" name="driver_id">
                    <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($driver->id); ?>" <?php echo e($model->driver_id == $driver->id ? 'selected' : ''); ?>>
                            <?php echo e($driver->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col mt-6">
                <div class="filepond-container">
                    <h4>Hình ảnh</h4>
                    <div class="file-drop-area" id="file-drop-area">
                        <?php if($model->image): ?>
                            <!-- Kiểm tra nếu hình ảnh đã tồn tại -->
                            <div class="mb-3" id="current-image">
                                <img src="<?php echo e(Storage::url($model->image)); ?>" alt="Current image" width="200">
                            </div>
                        <?php endif; ?>
                        <input type="file" name="image" id="file-input" accept="image/*" multiple>
                        <div id="file-preview"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <label for="start_date">Số lượng ghế</label>
                <input type="number" name="total_seats" id="total_seats" class="form-control"
                    value="<?php echo e($model->total_seats); ?>">
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <label for="exampleFormControlTextarea5" class="form-label">Mô tả xe</label>
                    </div>
                    <div class="card-body">
                        <textarea rows="5" style="width: 100%;border: 1px solid rgb(201, 200, 200); border-radius: 5px; padding: 10px"
                            name="description"><?php echo e($model->description); ?></textarea>
                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div>
            <div class="col-12">
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="<?php echo e(route('admin.buses.index')); ?>" class="btn btn-success">Quay lại</a>
                </div>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.mater', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\doantotnghiep\resources\views/admin/buses/edit.blade.php ENDPATH**/ ?>