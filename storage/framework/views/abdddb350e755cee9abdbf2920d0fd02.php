<?php $__env->startSection('title'); ?>
    Thêm mới đánh giá
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Thêm mới đánh giá </h4>
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
        <form action="<?php echo e(route('admin.reviews.store')); ?>" method="POST" class="row g-3 p-5">
            <?php echo csrf_field(); ?>
            <div class="col-md-6">
                <label for="departure_time" class="form-label">Chuyến xe</label>
                <select class="form-select" name="departure_time" aria-label="Default select example">
                    <?php $__currentLoopData = $trips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($trip->id); ?>" <?php echo e(old('departure_time') == $trip->id ? 'selected' : ''); ?>>
                            <?php echo e($trip->time_start); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="user_id" class="form-label">Tên người dùng</label>
                <select class="form-select" name="name" aria-label="Default select example">
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($user->id); ?>" <?php echo e(old('name') == $user->id ? 'selected' : ''); ?>>
                            <?php echo e($user->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Đánh giá</label>
                <div class="rating" id="rating">
                    <?php for($i = 1; $i <= 5; $i++): ?>
                        <span class="star" data-value="<?php echo e($i); ?>"
                            style="<?php echo e(old('rating') == $i ? 'color: gold;' : 'color: grey;'); ?>">★</span>
                    <?php endfor; ?>
                </div>
                <input type="hidden" id="ratingValue" name="rating" value="<?php echo e(old('rating')); ?>">
                <?php $__errorArgs = ['rating'];
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
                <label for="comment" class="form-label">Nhận xét</label>
                <input type="text" class="form-control" id="comment" name="comment" placeholder="Nhập nhận xét..."
                    value="<?php echo e(old('comment')); ?>">
                <?php $__errorArgs = ['comment'];
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
                    <a href="<?php echo e(route('admin.reviews.index')); ?>" class="btn btn-success">Quay lại</a>
                </div>
            </div>
        </form>

        <style>
            .star {
                font-size: 24px;
                cursor: pointer;
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const stars = document.querySelectorAll('.star');
                const ratingValueInput = document.getElementById('ratingValue');
                const form = document.querySelector('form'); // Lấy form

                // Cập nhật ngôi sao theo giá trị đã chọn
                const oldRating = ratingValueInput.value;
                updateStars(oldRating);

                stars.forEach(star => {
                    star.addEventListener('click', function() {
                        const selectedRating = this.getAttribute('data-value');
                        updateStars(selectedRating);
                        ratingValueInput.value = selectedRating; // Cập nhật giá trị cho input ẩn
                    });
                });

                function updateStars(rating) {
                    stars.forEach(star => {
                        star.style.color = star.getAttribute('data-value') <= rating ? 'gold' : 'grey';
                    });
                }

                // Ngăn chặn form submit mặc định
                form.addEventListener('submit', function(e) {
                    e.preventDefault(); // Ngăn chặn hành động submit mặc định

                    const formData = $(this).serialize(); // Lấy dữ liệu form

                    $.ajax({
                        type: 'POST',
                        url: form.action, // Đường dẫn action của form
                        data: formData,
                        success: function(response) {
                            // Xử lý phản hồi thành công
                            if (response.success) {
                                alert('Đánh giá đã được gửi thành công!');
                                // Bạn có thể làm gì đó khác, ví dụ: làm mới danh sách đánh giá
                            } else {
                                // Xử lý lỗi nếu có
                                alert('Có lỗi xảy ra: ' + response.message);
                            }
                        },
                        error: function(xhr) {
                            // Xử lý lỗi
                            alert('Có lỗi xảy ra: ' + xhr.status + ' ' + xhr.statusText);
                        }
                    });
                });
            });
        </script>


    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.mater', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH L:\laragon\www\doantotnghiep\resources\views/admin/reviews/create.blade.php ENDPATH**/ ?>