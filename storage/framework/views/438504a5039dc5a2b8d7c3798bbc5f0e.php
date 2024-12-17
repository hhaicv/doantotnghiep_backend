<?php $__env->startSection('title'); ?>
    Thêm mới điểm dừng
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Thêm mới điểm dừng </h4>
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
        <form action="<?php echo e(route('employee.stops')); ?>" method="POST" class="row g-3 p-5" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="col-md-6">
                <label for="fullnameInput" class="form-label">Tên điểm dừng</label>
                <input type="text" class="form-control" name="stop_name" value="<?php echo e(old('stop_name')); ?>"
                    placeholder="Nhập tên điểm dừng">
                <?php $__errorArgs = ['stop_name'];
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
                <label for="parent_stop" class="form-label">Chọn điểm dừng cha</label>
                <select class="form-select" name="parent_id" id="parent_stop">
                    <option value="">Điểm dừng cha</option>
                    <?php $__currentLoopData = $parents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($stop->id); ?>" <?php echo e(old('parent_id') == $stop->id ? 'selected' : ''); ?>>
                            <?php echo e($stop->stop_name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>


            <div class="col mt-3">
                    <h5>Hình ảnh</h5>
                    <div class="file-drop-area" id="file-drop-area">
                        <input type="file" name="image" id="file-input" value="<?php echo e(old('image')); ?>" accept="image/*"
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
                <div class="col">
                    <label for="exampleFormControlTextarea5" class="form-label">Mô tả</label>
                    <textarea name="description" id="editor" placeholder="Mô tả"><?php echo e(old('description')); ?></textarea>
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
            </div>

            <div class="col-12 text-end">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="<?php echo e(route('employee.stops')); ?>" class="btn btn-success">Quay lại</a>
            </div>
        </form>

        
        <script>
            document.getElementById('add-child-stop').addEventListener('click', function() {
                const container = document.getElementById('child-stops-container');
                const childStopHtml = `
                    <div class="child-stop">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="child_stop_name[]" class="form-label">Tên điểm dừng con</label>
                                <input type="text" class="form-control" name="child_stop_name[]" placeholder="Tên điểm dừng con" required>
                            </div>
                            <div class="col-md-6">
                                <label for="child_description[]" class="form-label">Mô tả điểm dừng con</label>
                                <input type="text" class="form-control" name="child_description[]" placeholder="Mô tả điểm dừng con">
                            </div>
                        </div>
                        <button type="button" class="btn btn-danger mt-2 remove-child-stop">Remove</button>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', childStopHtml);
            });

            document.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-child-stop')) {
                    event.target.closest('.child-stop').remove();
                }
            });
        </script>
        <script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>

        <script>
            ClassicEditor
                .create(document.querySelector('#editor'), {
                    htmlSupport: {
                        allow: [{
                            name: /.*/,
                            attributes: true,
                            classes: true,
                            styles: true
                        }]
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        </script>
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

            const multipleCancelButton = new Choices('#choices-multiple-remove-button', {
                removeItemButton: true,
                maxItemCount: 5,
                searchResultLimit: 5,
                renderChoiceLimit: 5
            });
        </script>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('employee.layouts.mater', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH L:\laragon\www\doantotnghiep\resources\views/employee/stops/create.blade.php ENDPATH**/ ?>