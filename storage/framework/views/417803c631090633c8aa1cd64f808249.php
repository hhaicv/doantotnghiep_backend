<?php $__env->startSection('title'); ?>
    Thêm mới Danh mục khuyến mãi
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Thêm mới Danh mục khuyến mãi</h4>
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
        <form action="<?php echo e(route('admin.promotions.store')); ?>" method="POST" class="row g-3 p-5" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="col-md-6">
                <label for="codeInput" class="form-label">Tiêu đề</label>
                <input type="text" class="form-control" name="title" value="<?php echo e(old('title')); ?>" placeholder="Nhập tiêu đề">
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
                <label for="promotion_category_id" class="form-label">Danh mục khuyến mãi</label>
                <select name="promotion_category_id" id="promotion_category_id" class="form-control">
                    <option value="">Chọn danh mục khuyến mãi</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category->id); ?>" <?php echo e(old('promotion_category_id') == $category->id ? 'selected' : ''); ?>>
                            <?php echo e($category->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['promotion_category_id'];
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
                <label for="codeInput" class="form-label">Mã giảm giá</label>
                <input type="text" class="form-control" name="code" value="<?php echo e(old('code')); ?>" placeholder="Nhập mã giảm giá">
                <?php $__errorArgs = ['code'];
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
                <label for="discountInput" class="form-label">Phần trăm giảm</label>
                <input type="number" class="form-control" name="discount" id="discountInput" value="<?php echo e(old('discount')); ?>"
                    placeholder="Nhập % giảm" min="1" max="100" oninput="validateDiscount()">
                <?php $__errorArgs = ['discount'];
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
                <label for="startDateInput" class="form-label">Ngày bắt đầu</label>
                <input type="date" class="form-control" name="start_date" value="<?php echo e(old('start_date')); ?>" placeholder="Ngày bắt đầu"
                    min="<?php echo e(date('Y-m-d')); ?>">
                <?php $__errorArgs = ['start_date'];
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
                <label for="codeInput" class="form-label">Số lượng</label>
                <input type="number" class="form-control" name="count" value="<?php echo e(old('count')); ?>" placeholder="Nhập số lượng">
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
                <input type="date" class="form-control" name="end_date" value="<?php echo e(old('end_date')); ?>" placeholder="Ngày kết thúc"
                    min="<?php echo e(date('Y-m-d')); ?>">
                <?php $__errorArgs = ['end_date'];
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
                <label for="descriptionInput" class="form-label">Mô tả khuyến mãi</label>
                <textarea class="form-control" placeholder="Mô tả khuyến mãi" name="description" rows="2"><?php echo e(old('description')); ?></textarea>
                <?php $__errorArgs = ['description'];
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
                <label for="routeSelect" class="form-label">Tuyến đường</label>
                <select name="routes[]" id="routeSelect" class="form-control" multiple>
                    <?php $__currentLoopData = $routes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($route->id); ?>" <?php echo e(isset($promotionRoute) && in_array($route->id, $promotionRoute) ? 'selected' : ''); ?>>
                            <?php echo e($route->route_name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <button type="button" class="btn btn-secondary btn-sm mt-2" id="selectAllRoutes">Chọn tất cả tuyến đường</button>
            </div>
        
            <div class="col-md-6">
                <label for="userSelect" class="form-label">Người dùng</label>
                <select name="users[]" id="userSelect" class="form-control" multiple>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($user->id); ?>" <?php echo e(in_array($user->id, $promotionUsers ?? []) ? 'selected' : ''); ?>>
                            <?php echo e($user->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <button type="button" class="btn btn-secondary btn-sm mt-2" id="selectAllUsers">Chọn tất cả người dùng</button>
            </div>

            <div class="col-md-6">
                <h5>Hình ảnh</h5>
                <div class="file-drop-area" id="file-drop-area">
                    <input type="file" name="image" id="file-input" accept="image/*" value="<?php echo e(old('image')); ?>">
                    <div id="file-preview"></div>
                </div>
                <?php $__errorArgs = ['image'];
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
                <label for="contentInput" class="form-label">Nội dung</label>
                <textarea class="form-control" placeholder="Nội dung" name="content" rows="2"><?php echo e(old('content')); ?></textarea>
                <?php $__errorArgs = ['content'];
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
    
            <div class="col-12 text-end">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="<?php echo e(route('admin.promotions.index')); ?>" class="btn btn-success">Quay lại</a>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Choices.js for Tuyến đường
        const routeSelect = new Choices('#routeSelect', {
            removeItemButton: true,
            placeholderValue: "Chọn tuyến đường",
            maxItemCount: -1,
        });

        document.getElementById('selectAllRoutes').addEventListener('click', function () {
            const allOptions = Array.from(document.querySelectorAll('#routeSelect option')).map(option => option.value);
            routeSelect.setChoiceByValue(allOptions);
        });

        // Initialize Choices.js for Người dùng
        const userSelect = new Choices('#userSelect', {
            removeItemButton: true,
            placeholderValue: "Chọn người dùng",
            maxItemCount: -1,
        });

        document.getElementById('selectAllUsers').addEventListener('click', function () {
            const allOptions = Array.from(document.querySelectorAll('#userSelect option')).map(option => option.value);
            userSelect.setChoiceByValue(allOptions);
        });
    });
</script>

<?php echo $__env->make('admin.layouts.mater', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\doantotnghiep\resources\views/admin/promotions/create.blade.php ENDPATH**/ ?>