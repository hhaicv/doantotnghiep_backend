<?php $__env->startSection('title'); ?>
    Danh sách chuyến xe
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Chuyến xe</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                        <li class="breadcrumb-item active">Chuyến xe</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
<<<<<<< HEAD:storage/framework/views/af9fbe24871f22bde758048ee14e12a9.php
                    <h5 class="card-title mb-0">Danh sách</h5>
                    <a class="btn btn-primary mb-3" href="<?php echo e(route('employee.trips.create')); ?>">Thêm mới</a>
=======
                    <h5 class="card-title mb-0">Danh sách phân quyền</h5>
                    <a class="btn btn-primary mb-3" href="<?php echo e(route('admin.roles.create')); ?>">Thêm mới phân quyền</a>
>>>>>>> 678c797cb3952a46f01e1dac2a954d2a43c78350:storage/framework/views/f2bc9e9b61b1d90b806f7c1577dfa576.php
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Thời gian khởi hành</th>
                                <th>Tuyến đường</th>
                                <th>Xe</th>
                                <th>Ghế</th>
                                <th>Biển số xe</th>
                                <th>Trạng thái</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($item->id); ?></td>
                                    <td><?php echo e(\Carbon\Carbon::parse($item->time_start)->format('H:i')); ?></td>
                                    <td><?php echo e($item->route->route_name); ?></td>
                                    <td><?php echo e($item->bus->name_bus); ?></td>
                                    <td><?php echo e($item->bus->total_seats); ?></td>
                                    <td><?php echo e($item->bus->license_plate); ?></td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="SwitchCheck<?php echo e($item->id); ?>" data-id="<?php echo e($item->id); ?>"
                                                <?php echo e($item->is_active ? 'checked' : ''); ?>>
                                            <label class="form-check-label" for="SwitchCheck<?php echo e($item->id); ?>">
                                                <?php echo e($item->is_active ? 'On' : 'Off'); ?>

                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="hstack gap-3 fs-15">
                                            <a href="<?php echo e(route('employee.trips.edit', $item->id)); ?>" class="link-primary"><i
                                                    class="ri-settings-4-line"></i></a>
                                            <form id="deleteFormTrip<?php echo e($item->id); ?>"
                                                action="<?php echo e(route('employee.trips.destroy', $item->id)); ?>" method="post">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="button" style="border: none; background: white"
                                                    class="link-danger" onclick="confirmDelete(<?php echo e($item->id); ?>)">
                                                    <i class="ri-delete-bin-5-line"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!--end col-->
    </div><!--end row-->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('style-libs'); ?>
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">


<?php $__env->stopSection(); ?>

<?php $__env->startSection('script-libs'); ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script>
        new DataTable("#example", {
            order: [
                [0, 'desc']
            ]
        });
    </script>
    <script>
        document.querySelectorAll('.form-check-input').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                var isChecked = this.checked ? 1 : 0;
                var itemId = this.getAttribute('data-id'); // Lấy ID từ thuộc tính data-id
                console.log(itemId);


                fetch(`/admin/status-trip/${itemId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                        },
                        body: JSON.stringify({
                            is_active: isChecked
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Cập nhật label hoặc badge sau khi thay đổi trạng thái
                            var label = this.nextElementSibling; // Lấy label kế tiếp checkbox
                            label.textContent = isChecked ? 'On' : 'Off'; // Cập nhật nội dung
                        } else {
                            alert('Cập nhật trạng thái thất bại.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
        function confirmDelete(id) {
            if (confirm('Bạn có muốn xóa không???')) {
                let form = document.getElementById('deleteFormTrip' + id);

                // Dùng AJAX để gửi yêu cầu xóa mà không reload trang
                fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: new URLSearchParams(new FormData(form))
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Đã xóa thành công!');
                            // Nếu muốn, có thể xóa dòng hiện tại trong bảng mà không cần reload trang
                            form.closest('tr').remove();
                        } else {
                            alert('Có lỗi xảy ra. Vui lòng thử lại.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Có lỗi xảy ra. Vui lòng thử lại.');
                    });
            }
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('employee.layouts.mater', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH L:\laragon\www\doantotnghiep\resources\views/employee/trips/index.blade.php ENDPATH**/ ?>