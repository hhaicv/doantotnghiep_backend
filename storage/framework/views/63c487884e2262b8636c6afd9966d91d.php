<?php $__env->startSection('title'); ?>
    Cập nhật tuyến đường
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Cập nhật tuyến đường</h4>
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
    <form id="createproduct-form" autocomplete="off" class="needs-validation" novalidate
        action="<?php echo e(route('admin.routes.update', $data)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body row p-4">
                        <div class="col-md-6">
                            <label for="fullnameInput" class="form-label">Tên tuyến đường</label>
                            <input type="text" class="form-control mt-2" name="route_name"
                                value="<?php echo e($data->route_name); ?>">
                            <?php $__errorArgs = ['route_name'];
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
                            <label for="fullnameInput" class="form-label">Chu Kì</label>
                            <input type="number" class="form-control mt-2" name="cycle" value="<?php echo e($data->cycle); ?>">
                            <?php $__errorArgs = ['cycle'];
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
                            <label for="fullnameInput" class="form-label mt-2">Điểm bắt đầu</label>
                            <select name="start_route_id" class="form-control" id="input-from-stop-1"
                                onchange="updateEndStops()">
                                <option value="">Chọn điểm bắt đầu</option>
                                <?php foreach ($stops as $stop) { ?>
                                <option value="<?php echo $stop['id']; ?>"
                                    <?php echo e(old('start_route_id', $data->start_route_id) == $stop->id ? 'selected' : ''); ?>>
                                    <?php echo $stop['stop_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="fullnameInput" class="form-label mt-2">Điểm kết thúc</label>
                            <select name="end_route_id" class="form-control" id="input-to-stop-1">
                                <option value="">Chọn điểm kết thúc</option>
                                <?php foreach ($stops as $stop) { ?>
                                <option value="<?php echo $stop['id']; ?>"
                                    <?php echo e(old('end_route_id', $data->end_route_id) == $stop->id ? 'selected' : ''); ?>>
                                    <?php echo $stop['stop_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="fullnameInput" class="form-label mt-2">Giá Tuyến</label>
                            <input type="number" class="form-control mt-2" name="route_price"
                                value="<?php echo e($data->route_price); ?>">
                            <?php $__errorArgs = ['route_price'];
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
                            <label for="fullnameInput" class="form-label mt-2">Chiều dài</label>
                            <input type="number" class="form-control mt-2" name="length" value="<?php echo e($data->length); ?>">
                            <?php $__errorArgs = ['length'];
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
                        <div class="col-md-12 mt-2">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <label for="exampleFormControlTextarea5" class="form-label">Mô tả tuyến đường</label>
                                </div>
                                <div class="card-body">
                                    <textarea rows="5" style="width: 100%;border: 1px solid rgb(201, 200, 200); border-radius: 5px; padding: 10px"
                                        name="description"><?php echo $data->description; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs-custom card-header-tabs border-bottom-0">
                            <li class="nav-item">
                                <a class="nav-link active">Chặng đường</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="stops-container">
                                <?php foreach ($stages as $index => $stage) { ?>
                                <div class="stop-item">
                                    <div class="row">
                                        <input type="hidden" name="stage_ids[]" value="<?php echo e($stage->id); ?>" />

                                        <div class="col">
                                            <label class="form-label pb-2" for="input-from-stop-<?php echo e($index + 1); ?>">Điểm
                                                đi <?php echo e($index + 1); ?></label>
                                            <select name="start_stop_id[]" class="form-control from-stop"
                                                style="width: 90%;" id="input-from-stop-<?php echo e($index + 1); ?>"
                                                onchange="filterToStops(this)">
                                                <?php foreach ($stops as $stop) { ?>
                                                <option value="<?php echo $stop['id']; ?>" <?php echo $stop['id'] == $stage->start_stop_id ? 'selected' : ''; ?>>
                                                    <?php echo $stop['stop_name']; ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label class="form-label pb-2" for="input-to-stop-<?php echo e($index + 1); ?>">Điểm
                                                đến
                                                <?php echo e($index + 1); ?></label>
                                            <select name="end_stop_id[]" class="form-control to-stop" style="width: 90%;"
                                                id="input-to-stop-<?php echo e($index + 1); ?>">
                                                <?php foreach ($stops as $stop) { ?>
                                                <option value="<?php echo $stop['id']; ?>" <?php echo $stop['id'] == $stage->end_stop_id ? 'selected' : ''; ?>>
                                                    <?php echo $stop['stop_name']; ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label class="form-label pb-2"
                                                for="input-price-<?php echo e($index + 1); ?>">Giá</label>
                                            <input type="number" name="fare[]" placeholder="Giá vé"
                                                class="form-control" style="width: 90%;"
                                                id="input-price-<?php echo e($index + 1); ?>" value="<?php echo $stage->fare; ?>" />
                                        </div>
                                        <div class="col-1">
                                            <button type="button" style="margin-top: 35px" class="btn btn-danger"
                                                onclick="removeStop(this)">Xóa</button>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="button" class="btn btn-primary" onclick="addStop()">Thêm chặng</button>
                        </div>
                    </div>

                </div>

                <div class="text-end mb-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="<?php echo e(route('admin.routes.index')); ?>" class="btn btn-success">Quay lại</a>
                </div>

                <style>
                    .fade-out {
                        opacity: 0;
                        transition: opacity 0.5s ease-out;
                    }
                </style>

                <script>
                    let stopIndex = 2; // Bắt đầu với điểm dừng thứ 2
                    function addStop() {
                        // Tạo HTML mới cho điểm dừng
                        let stopHtml = `
                            <div class="stop-item">
                                <div class="row mt-3">
                                    <div class="col">
                                        <label class="form-label pb-2" for="input-stop-${stopIndex}">Điểm đi ${stopIndex}</label>
                                        <select name="start_stop_id[]" class="form-control from-stop" style="width: 90%;" id="input-stop-${stopIndex}" onchange="filterToStops(this)">
                                            <?php foreach ($stops as $stop) { ?>
                                                <option value="<?php echo $stop['id']; ?>"><?php echo $stop['stop_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label class="form-label pb-2" for="input-stop-${stopIndex}">Điểm đến ${stopIndex}</label>
                                        <select name="end_stop_id[]" class="form-control to-stop" style="width: 90%;" id="input-stop-${stopIndex}">
                                            <?php foreach ($stops as $stop) { ?>
                                                <option value="<?php echo $stop['id']; ?>"><?php echo $stop['stop_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label class="form-label pb-2" for="input-price-${stopIndex}">Giá</label>
                                        <input type="text" name="fare[]" placeholder="Giá vé" class="form-control" style="width: 90%;" id="input-price-${stopIndex}" />
                                    </div>
                                    <div class="col-1">
                                        <button type="button" class="btn btn-danger" style="margin-top: 35px" onclick="removeStop(this)">Xóa</button>
                                    </div>
                                </div>
                            </div>
                        `;
                        // Thêm HTML vào container
                        document.getElementById('stops-container').insertAdjacentHTML('beforeend', stopHtml);

                        // Tăng chỉ số cho điểm dừng tiếp theo
                        stopIndex++;

                        // Hiển thị nút "Xóa" nếu có nhiều hơn 1 chặng--
                        toggleRemoveButtons();
                    }

                    // Hàm xóa điểm dừng với hiệu ứng mờ dần
                    function removeStop(element) {
                        let stopItem = element.closest('.stop-item');

                        // Thêm lớp fade-out
                        stopItem.classList.add('fade-out');

                        // Đợi 0.5 giây cho hiệu ứng mờ dần hoàn tất rồi xóa phần tử
                        setTimeout(() => {
                            stopItem.remove(); // Xóa phần tử sau khi hiệu ứng kết thúc
                            toggleRemoveButtons(); // Cập nhật hiển thị của nút "Xóa"
                        }, 500); // 500ms tương đương với thời gian của transition trong CSS
                    }

                    // Hàm ẩn/hiện nút "Xóa"
                    function toggleRemoveButtons() {
                        let stopItems = document.querySelectorAll('.stop-item');
                        stopItems.forEach((item, index) => {
                            let removeButton = item.querySelector('.btn-danger');
                            if (stopItems.length > 1) {
                                removeButton.style.display = 'block'; // Hiện nút "Xóa" khi có nhiều hơn 1 chặng
                            } else {
                                removeButton.style.display = 'none'; // Ẩn nút "Xóa" nếu chỉ có 1 chặng
                            }
                        });
                    }

                    // Gọi hàm ẩn nút "Xóa" ban đầu
                    toggleRemoveButtons();
                </script>


            </div>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.mater', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\doantotnghiep\resources\views/admin/routess/edit.blade.php ENDPATH**/ ?>