<?php $__env->startSection('title'); ?>
    Thêm mới Danh mục khuyến mãi
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Thêm mới Danh mục khuyến mãi </h4>
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
        <form action="<?php echo e(route('admin.promotions.store')); ?>" method="POST" class="row g-3 p-5">
            <?php echo csrf_field(); ?>
            <div class="col-md-6">

                <label for="codeInput" class="form-label">Code: </label>
                <input type="text" class="form-control" name="code" placeholder="Nhập code">

                <label for="codeInput" class="form-label">Code</label>
                <input type="text" class="form-control" name="code" value="<?php echo e(old('code')); ?>"
                    placeholder="Nhập code">
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
                <label for="discountInput" class="form-label">Discount (%)</label>
                <input type="number" class="form-control" name="discount" id="discountInput" value="<?php echo e(old('discount')); ?>"
                    placeholder="Nhập %" min="1" max="100" oninput="validateDiscount()">
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
                <input type="date" class="form-control" name="start_date" value="<?php echo e(old('start_date')); ?>"
                    placeholder="Ngày bắt đầu" min="<?php echo e(date('Y-m-d')); ?>">
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
                <label for="routeSelect" class="form-label">Tuyến đường</label>
                <select name="route_id" id="routeSelect" class="form-control" multiple>
                    <option value="">Chọn tuyến đường</option>
                    <?php $__currentLoopData = $routes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($route->id); ?>"
                            <?php echo e(isset($promotionRoute) && in_array($route->id, $promotionRoute) ? 'selected' : ''); ?>>
                            <?php echo e($route->route_name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>


            <div class="col-md-6">
                <label for="endDateInput" class="form-label">Ngày kết thúc</label>
                <input type="date" class="form-control" name="end_date" placeholder="Ngày kết thúc"
                    min="<?php echo e(date('Y-m-d')); ?>">
            </div>
            <div class="col-md-6">
                <label for="userSelect" class="form-label text-muted">Người dùng:</label>
                <select name="users[]" id="userSelect" class="form-control" multiple>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($user->id); ?>"
                            <?php echo e(in_array($user->id, $promotionUsers ?? []) ? 'selected' : ''); ?>>
                            <?php echo e($user->name); ?>



                            <div class="col-md-6">
                                <label for="endDateInput" class="form-label">Ngày kết thúc</label>
                                <input type="date" class="form-control" name="end_date" value="<?php echo e(old('end_date')); ?>"
                                    placeholder="Ngày kết thúc" min="<?php echo e(date('Y-m-d')); ?>">
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
                                <label for="userSelect" class="form-label">Người dùng</label>
                                <select name="user_id" id="userSelect" class="form-control">
                                    <option value="">Chọn người dùng</option> <!-- Option mặc định -->
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($user->id); ?>"
                                            <?php echo e(old('user_id') == $user->id ? 'selected' : ''); ?>>
                                            <?php echo e($user->name); ?> <!-- Hoặc bất kỳ thuộc tính nào bạn muốn hiển thị -->

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="descriptionInput" class="form-label">Mô tả danh mục</label>
                                <textarea class="form-control" placeholder="Mô tả danh mục" name="description" rows="2"><?php echo e(old('description')); ?></textarea>
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

                                <label for="newCustomerOnly" class="form-label">Chỉ áp dụng cho khách hàng mới</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="newCustomerOnly"
                                        name="new_customer_only" value="1">
                                    <label class="form-check-label" for="newCustomerOnly">On</label>
                                </div>
                            </div>


                            <label for="routeSelect" class="form-label">Tuyến đường</label>
                            <select class="form-control" name="route_id" id="routeSelect">
                                <option value="">Chọn tuyến đường</option>
                                <?php $__currentLoopData = $routes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($route->id); ?>"
                                        <?php echo e(old('route_id') == $route->id ? 'selected' : ''); ?>>
                                        <?php echo e($route->route_name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
            </div>

            <!-- Loại xe -->
            <div class="col-md-6">
                <label for="busTypeSelect" class="form-label">Loại xe</label>
                <select class="form-control" name="bus_type_id" id="busTypeSelect">
                    <option value="">Chọn xe</option>
                    <?php $__currentLoopData = $buses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($bus->id); ?>" <?php echo e(old('bus_type_id') == $bus->id ? 'selected' : ''); ?>>
                            <?php echo e($bus->name_bus); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="new_customer_only" id="newCustomerOnly"
                    value="1">
                <label class="form-check-label" for="newCustomerOnly">Chỉ áp dụng cho khách hàng mới</label>
            </div>
            <input type="hidden" name="new_customer_only" value="0">

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
    document.addEventListener('DOMContentLoaded', function() {
        const userSelect = document.getElementById('userSelect');
        const choices = new Choices(userSelect, {
            removeItemButton: true, // Thêm nút xóa cho mỗi mục đã chọn
            placeholderValue: "Chọn người dùng", // Placeholder
            maxItemCount: 5, // Giới hạn số người dùng có thể chọn, nếu cần
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        const userSelect = document.getElementById('routeSelect');
        const choices = new Choices(userSelect, {
            removeItemButton: true, // Thêm nút xóa cho mỗi mục đã chọn
            placeholderValue: "Chọn tuyến đường", // Placeholder
            maxItemCount: 5, // Giới hạn số người dùng có thể chọn, nếu cần
        });
    });
    document.addEventListener('DOMContentLoaded', function() {

        function validateDiscount() {
            const discountInput = document.getElementById('discountInput');
            let value = parseInt(discountInput.value);

            // Kiểm tra giá trị nếu nằm ngoài khoảng 1-100
            if (value < 1) {
                discountInput.value = 1;
            } else if (value > 100) {
                discountInput.value = 100;
            }
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const startDateInput = document.getElementById('startDateInput');
        const endDateInput = document.getElementById('endDateInput');

        // Khi người dùng chọn ngày bắt đầu
        startDateInput.addEventListener('change', function() {
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
        endDateInput.addEventListener('change', function() {
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

<?php echo $__env->make('admin.layouts.mater', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\doantotnghiep\resources\views/admin/promotions/create.blade.php ENDPATH**/ ?>