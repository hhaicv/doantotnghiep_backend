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
        <form action="<?php echo e(route('admin.promotions.update', $data)); ?>" method="POST" class="row g-3 p-5"  enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="col-md-6">
                <label for="codeInput" class="form-label">Tiêu đề:</label>
                <input type="text" class="form-control" name="title" value="<?php echo e($data->title); ?>">
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
                <h5>Hình ảnh</h5>
                <div class="file-drop-area" id="file-drop-area">
                    <input type="file" name="image" id="file-input" accept="image/*" multiple>
                    <div id="file-preview">
                        <?php if($data->image): ?>
                            <img src="<?php echo e(Storage::url($data->image)); ?>" alt="Ảnh đã tải lên" width="200px" height="150px">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <label for="codeInput" class="form-label">Mã khuyến mãi:</label>
                <input type="text" class="form-control" name="code" value="<?php echo e($data->code); ?>">
            </div>
            <div class="col-md-6">
                <label for="discountInput" class="form-label">Phần trăm giảm(%):</label>
                <input type="text" class="form-control" name="discount" value="<?php echo e($data->discount); ?>">
            </div>
            <div class="col-md-6">
                <label for="startDateInput" class="form-label">Ngày bắt đầu:</label>
                <input type="date" class="form-control" name="start_date"value="<?php echo e($data->start_date); ?>"
                       min="<?php echo e(date('Y-m-d')); ?>">
            </div>
            <div class="col-md-6">
                <label for="codeInput" class="form-label">Số lượng</label>
                <input type="number" class="form-control" name="count" value="<?php echo e($data->count); ?>">
                <?php $__errorArgs = ['count'];
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
                <label for="endDateInput" class="form-label">Ngày kết thúc</label>
                <input type="date" class="form-control" name="end_date" placeholder="Ngày kết thúc" 
                       id="endDateInput" min="<?php echo e(date('Y-m-d')); ?>" value="<?php echo e($data->end_date); ?>">
            </div>
            <div class="col-md-6">
                <label for="routeSelect" class="form-label">Tuyến đường</label>
                <select name="routes[]" id="routeSelect" class="form-control" multiple>
                    <?php $__currentLoopData = $routes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($route->id); ?>" <?php echo e(in_array($route->id, $promotionRoutes ?? []) ? 'selected' : ''); ?>>
                            <?php echo e($route->route_name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="descriptionInput" class="form-label">Mô tả khuyến mãi</label>
                <textarea class="form-control" name="description" rows="2"><?php echo e($data->description); ?></textarea>
            </div>
            <div class="col-md-6">
                <label for="userSelect" class="form-label text-muted">Người dùng</label>
                <select name="users[]" id="userSelect" class="form-control" multiple>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($user->id); ?>" <?php echo e(in_array($user->id, $promotionUsers ?? []) ? 'selected' : ''); ?>>
                            <?php echo e($user->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-12">
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="<?php echo e(route('admin.promotions.index')); ?>" class="btn btn-success">Quay lại</a>
                </div>
            </div>
        </form>
        

    </div>
<?php $__env->stopSection(); ?>



<script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

<script>
       document.addEventListener('DOMContentLoaded', function () {
        const userSelect = document.getElementById('userSelect');
        const choices = new Choices(userSelect, {
            removeItemButton: true, // Thêm nút xóa cho mỗi mục đã chọn
            placeholderValue: "Chọn người dùng", // Placeholder
            maxItemCount: 5, // Giới hạn số người dùng có thể chọn, nếu cần
        });
    });
    document.addEventListener('DOMContentLoaded', function () {
        const userSelect = document.getElementById('routeSelect');
        const choices = new Choices(userSelect, {
            removeItemButton: true, // Thêm nút xóa cho mỗi mục đã chọn
            placeholderValue: "Chọn tuyến đường", // Placeholder
            maxItemCount: 5, // Giới hạn số người dùng có thể chọn, nếu cần
        });
    });
    document.addEventListener('DOMContentLoaded', function () {
        const startDateInput = document.getElementById('startDateInput');
        const endDateInput = document.getElementById('endDateInput');
        
        // Khi người dùng chọn ngày bắt đầu
        startDateInput.addEventListener('change', function () {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);
            
            // Kiểm tra nếu ngày bắt đầu lớn hơn ngày kết thúc
            if (endDate && startDate > endDate) {
                alert('Ngày bắt đầu không được lớn hơn ngày kết thúc');
                startDateInput.value = ''; // Xóa giá trị không hợp lệ
            }
            
            // Cập nhật giá trị min cho ngày kết thúc
            endDateInput.min = startDateInput.value;
        });

        // Khi người dùng chọn ngày kết thúc
        endDateInput.addEventListener('change', function () {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);

            // Kiểm tra nếu ngày kết thúc nhỏ hơn ngày bắt đầu
            if (startDate && endDate < startDate) {
                alert('Ngày kết thúc không được nhỏ hơn ngày bắt đầu');
                endDateInput.value = ''; // Xóa giá trị không hợp lệ
            }
        });
    });
</script>

<?php echo $__env->make('admin.layouts.mater', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH L:\laragon\www\doantotnghiep\resources\views/admin/promotions/edit.blade.php ENDPATH**/ ?>