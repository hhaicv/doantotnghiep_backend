<?php $__env->startSection('title'); ?>
    Thêm mới xe
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Thêm mới xe </h4>
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
        <form action="<?php echo e(route('admin.buses.store')); ?>" method="POST" class="row g-3 p-5" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="col-md-6">
                <label for="fullnameInput" class="form-label">Tên xe</label>

                <input type="text" class="form-control" id="name_bus" name="name_bus" placeholder="Nhập tên xe "
                    value="<?php echo e(old('name_bus')); ?>">
                <?php $__errorArgs = ['name_bus'];
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
                <label for="fullnameInput" class="form-label">Hãng xe</label>
                <input type="text" class="form-control" id="model" name="model" placeholder="Nhập tên hãng xe"
                    value="<?php echo e(old('model')); ?>">
                <?php $__errorArgs = ['model'];
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
                <label for="fullnameInput" class="form-label">Biển số xe</label>
                <input type="text" class="form-control" id="license_plate" name="license_plate"
                    placeholder="Nhập biển số xe " value="<?php echo e(old('license_plate')); ?>">
                <?php $__errorArgs = ['license_plate'];
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
                <label for="fullnameInput" class="form-label">Tài xế</label>
                <select class="form-select" aria-label="Default select example" name="driver_id">
                    <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($driver->id); ?>" <?php echo e(old('driver_id') == $driver->id ? 'selected' : ''); ?>>
                            <?php echo e($driver->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col mt-6">
                <h5>Image</h5>
                <div class="file-drop-area" id="file-drop-area">
                    <input type="file" name="image" id="file-input" accept="image/*" value="<?php echo e(old('imgae')); ?>"
                        multiple>

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
                <div class="col-mt-3">
                    <label for="start_date">Số lượng ghế</label>
                    <input type="number" name="total_seats" id="total_seats" class="form-control"
                        value="<?php echo e(old('total_seats')); ?>" placeholder="Nhập số lượng ghế">
                    <?php $__errorArgs = ['total_seats'];
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
                
            </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <label for="exampleFormControlTextarea5" class="form-label">Mô tả xe</label>
            </div>
            <div class="card-body">
                <textarea rows="5" style="width: 100%;border: 1px solid rgb(201, 200, 200); border-radius: 5px; padding: 10px"
                    name="description" placeholder=" Viết mô tả xe ở đây..."><?php echo e(old('description')); ?></textarea>
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
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
    <input type="hidden" name="is_active" value="0">
    <div class="col-12">
        <div class="text-end">
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="<?php echo e(route('admin.buses.index')); ?>" class="btn btn-success">Quay lại</a>
        </div>
    </div>
    </form>
    </div>

    <script>
        const fileInput = document.getElementById('file-input');
        const fileDropArea = document.getElementById('file-drop-area');
        const filePreview = document.getElementById('file-preview');

        fileInput.addEventListener('change', handleFiles);
        fileDropArea.addEventListener('dragover', (event) => {
            event.preventDefault();
            fileDropArea.classList.add('dragging');
        });

        fileDropArea.addEventListener('dragleave', () => {
            fileDropArea.classList.remove('dragging');
        });

        fileDropArea.addEventListener('drop', (event) => {
            event.preventDefault();
            fileDropArea.classList.remove('dragging');
            const files = event.dataTransfer.files;
            handleFiles({
                target: {
                    files
                }
            });
        });

        function handleFiles(event) {
            const files = event.target.files;
            filePreview.innerHTML = ''; // Clear previous previews

            for (const file of files) {
                const fileReader = new FileReader();

                fileReader.onload = function(e) {
                    const previewItem = document.createElement('div');
                    previewItem.classList.add('file-preview-item');

                    const img = document.createElement('img');
                    img.src = e.target.result;

                    const removeBtn = document.createElement('button');
                    removeBtn.classList.add('file-remove-btn');
                    removeBtn.textContent = 'Remove';
                    removeBtn.onclick = () => {
                        previewItem.remove();
                        // Optionally reset file input (not recommended if allowing multiple uploads)
                    };

                    previewItem.appendChild(img);
                    previewItem.appendChild(removeBtn);
                    filePreview.appendChild(previewItem);
                };

                fileReader.readAsDataURL(file);
            }
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.mater', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\doantotnghiep\resources\views/admin/buses/create.blade.php ENDPATH**/ ?>