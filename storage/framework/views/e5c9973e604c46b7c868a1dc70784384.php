<?php $__env->startSection('title'); ?>
    Danh sách tuyến đường
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Danh sách vé</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header border-0">
                    <div class="row align-items-center gy-3">
                        <div class="col-sm">
                            <h5 class="card-title mb-0">Order History</h5>
                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex gap-1 flex-wrap">
                                <a href="<?php echo e(route('admin.tickets.index')); ?>"><button type="button"
                                        class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn"
                                        data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Create
                                        Order</button></a>
                                <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()"><i
                                        class="ri-delete-bin-2-line"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form method="GET" action="<?php echo e(route('admin.ticket_list')); ?>">
                        <div class="row g-3">
                            <div class="col-xxl-5 col-sm-6">
                                <div class="search-box">
                                    <input type="text" class="form-control search" placeholder="Tìm theo mã đơn hàng"
                                           name="order_code" value="<?php echo e(request('order_code')); ?>">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <!--end col-->

                            <div class="col-xxl-2 col-sm-6">
                                <div>
                                    <input type="date" name="date" class="form-control" value="<?php echo e(request('date')); ?>">
                                </div>
                            </div>
                            <!--end col-->

                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-control" data-choices data-choices-search-false
                                            name="payment_method_id" id="idStatus">
                                        <option value="">Lọc theo thanh toán</option>
                                        <?php $__currentLoopData = App\Models\PaymentMethod::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option
                                                value="<?php echo e($method->id); ?>" <?php echo e(request('payment_method_id') == $method->id ? 'selected' : ''); ?>>
                                                <?php echo e($method->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <!--end col-->

                            <div class="col-xxl-2 col-sm-4">
                                <div>
                                    <select class="form-control" data-choices data-choices-search-false
                                            name="payment_status" id="idPayment">
                                        <option value="">Lọc theo trạng thái</option>
                                        <?php $__currentLoopData = App\Models\TicketBooking::PAYMENT_STATUSES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option
                                                value="<?php echo e($key); ?>" <?php echo e(request('payment_status') == $key ? 'selected' : ''); ?>>
                                                <?php echo e($status); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <!--end col-->

                            <div class="col-xxl-1 col-sm-4">
                                <!-- Nút Hủy Lọc -->
                                <div class="mb-2">
                                    <a href="<?php echo e(route('admin.ticket_list')); ?>" class="btn btn-primary w-100">Hủy lọc</a>
                                </div>

                                <!-- Nút Filters -->
                                <div>
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="ri-equalizer-fill me-1 align-bottom"></i>
                                        Filters
                                    </button>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </form>
                </div>
                <div class="card-body pt-0">
                    <div>
                        <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active All py-3" data-bs-toggle="tab" id="All" href="#home1"
                                   role="tab" aria-selected="true">
                                    <i class="ri-store-2-fill me-1 align-bottom"></i> Tổng vé đặt
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-3 Delivered" data-bs-toggle="tab" id="Delivered" href="#delivered"
                                   role="tab" aria-selected="false">
                                    <i class="ri-checkbox-circle-line me-1 align-bottom"></i> Thành công
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-3 Returns" data-bs-toggle="tab" id="Returns" href="#returns"
                                   role="tab" aria-selected="false">
                                    <i class="ri-arrow-left-right-fill me-1 align-bottom"></i> Hoàn vé
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-3 Cancelled" data-bs-toggle="tab" id="Cancelled" href="#cancelled"
                                    role="tab" aria-selected="false">
                                    <i class="ri-close-circle-line me-1 align-bottom"></i> Hủy
                                </a>
                            </li>
                        </ul>

                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="orderTable">
                                <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <th scope="col" style="width: 25px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="checkAll"
                                                   value="option">
                                        </div>
                                    </th>
                                    <th class="sort" data-sort="id">Mã Đơn Hàng</th>
                                    <th class="sort" data-sort="date">Ngày khởi hành</th>
                                    <th class="sort" data-sort="route_name">Tuyến đường</th>
                                    <th class="sort" data-sort="amount">Số lượng</th>
                                    <th class="sort" data-sort="total_price">Tổng giá</th>
                                    <th class="sort" data-sort="payment">Phương thức</th>
                                    <th class="sort" data-sort="status">Trạng thái</th>
                                    <th class="sort" data-sort="city">Xem chi tiết</th>
                                </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticketBooking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <th scope="row">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="checkAll"
                                                        value="option1">
                                                </div>
                                            </th>
                                            <td class="id"><?php echo e($ticketBooking->order_code); ?></td>
                                            <td class="date"><?php echo e($ticketBooking->date); ?></td>
                                            <td class="route_name"><?php echo e($ticketBooking->route->route_name); ?></td>
                                            <td class="amount text-center"><?php echo e($ticketBooking->total_tickets); ?> Ghế</td>
                                            <td class="total_price text-center">
                                                <?php echo e(number_format($ticketBooking->total_price, 0, ',', '.')); ?> ₫</td>
                                            <td class="payment"><?php echo e($ticketBooking->paymentMethod->name); ?></td>
                                            <td class="status text-center">
                                                <span
                                                    class="badge bg-warning-subtle text-warning text-uppercase"><?php echo e($ticketBooking->status); ?></span>
                                            </td>
                                            <td>
                                                <ul class="list-inline hstack gap-2 mb-0">
                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                        <a href="<?php echo e(route('admin.tickets.show', $ticketBooking->id)); ?>"
                                                            class="text-primary d-inline-block">
                                                            <i class="ri-eye-fill fs-16"></i>
                                                        </a>
                                                    </li>
                                                    <?php
                                                        $bookingDate = \Carbon\Carbon::parse($ticketBooking->date);
                                                        $currentDate = \Carbon\Carbon::now();
                                                    ?>

                                                    <?php if($bookingDate->greaterThan($currentDate)): ?>
                                                        <li class="list-inline-item" data-bs-toggle="tooltip">
                                                            <a href="<?php echo e(route('admin.change', $ticketBooking->id)); ?>"
                                                                class="text-primary">
                                                                <i class="ri-exchange-fill"></i>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>


                                                </ul>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>

                            </table>

                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="pagination-wrap hstack gap-2">
                                <a class="page-item pagination-prev disabled" href="#">
                                    Previous
                                </a>
                                <ul class="pagination listjs-pagination mb-0"></ul>
                                <a class="page-item pagination-next" href="#">
                                    Next
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade flip" id="deleteOrder" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body p-5 text-center">
                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                               colors="primary:#405189,secondary:#f06548"
                                               style="width:90px;height:90px"></lord-icon>
                                    <div class="mt-4 text-center">
                                        <h4>You are about to delete a order ?</h4>
                                        <p class="text-muted fs-15 mb-4">Deleting your order will remove all of your
                                            information from our database.</p>
                                        <div class="hstack gap-2 justify-content-center remove">
                                            <button class="btn btn-link link-success fw-medium text-decoration-none"
                                                    id="deleteRecord-close" data-bs-dismiss="modal"><i
                                                    class="ri-close-line me-1 align-middle"></i> Close
                                            </button>
                                            <button class="btn btn-danger" id="delete-record">Yes, Delete It</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end modal -->
                </div>
            </div>

        </div>
        <!--end col-->
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('style-libs'); ?>
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"/>
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">

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
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>


    <script src="<?php echo e(asset('theme/admin/assets/js/pages/plugins/lord-icon-2.1.0.js')); ?>"></script>
    <script src="<?php echo e(asset('theme/admin/assets/js/plugins.js')); ?>"></script>

    <!-- list.js min js -->
    <script src="<?php echo e(asset('theme/admin/assets/libs/list.js/list.min.js')); ?>"></script>

    <!--list pagination js-->
    <script src="<?php echo e(asset('theme/admin/assets/libs/list.pagination.js/list.pagination.min.js')); ?>"></script>

    <!-- ecommerce-order init js -->
    <script src="<?php echo e(asset('theme/admin/assets/js/pages/ecommerce-order.init.js')); ?>"></script>
    <script>
        $(document).ready(function() {
            // Lắng nghe sự kiện click nút xóa
            $('.remove-item-btn').on('click', function() {
                const itemId = $(this).data('id'); // Lấy ID từ data-id

                // Hiển thị modal xác nhận
                $('#deleteOrder').modal('show');

                // Xử lý khi nhấn nút "Yes, Delete It" trong modal
                $('#delete-record').off('click').on('click', function() {
                    $.ajax({
                        url: `/admin/tickets/${itemId}`, // URL DELETE
                        type: 'DELETE',
                        data: {
                            _token: '<?php echo e(csrf_token()); ?>', // Laravel CSRF token
                        },
                        success: function(response) {
                            // Xóa hàng khỏi bảng nếu thành công
                            $(`tr:has(td:contains(${itemId}))`).remove();
                            $('#deleteOrder').modal('hide');
                            alert('Đã xóa thành công vé!');
                        },
                        error: function(xhr, status, error) {
                            // Hiển thị thông báo lỗi nếu thất bại
                            $('#deleteOrder').modal('hide');
                            alert('Có lỗi xảy ra. Không thể xóa vé!');
                            console.error(error);
                        }
                    });
                });
            });
        });
        $(document).ready(function () {
            // Lắng nghe sự kiện khi người dùng chọn tab
            $('.nav-link').on('click', function () {
                var tabId = $(this).attr('id');  // Lấy id của tab đang được chọn

                var filteredData = [];

                // Dựa trên tabId, bạn sẽ lọc các vé có trạng thái tương ứng
                if (tabId === 'tab-all') {
                    filteredData = allTicketData; // Hiển thị tất cả vé
                } else if (tabId === 'tab-delivered') {
                    filteredData = allTicketData.filter(function (ticket) {
                        return ticket.status === 'paid'; // Trạng thái thành công
                    });
                } else if (tabId === 'tab-returns') {
                    filteredData = allTicketData.filter(function (ticket) {
                        return ticket.status === 'refunded'; // Trạng thái hoàn vé
                    });
                } else if (tabId === 'tab-cancelled') {
                    filteredData = allTicketData.filter(function (ticket) {
                        return ticket.status === 'cancelled'; // Trạng thái hủy
                    });
                }

                // Cập nhật lại bảng dữ liệu theo trạng thái đã lọc
                updateTable(filteredData);
            });
        });

        function updateTable(data) {
            var tableBody = $('#orderTable tbody');
            tableBody.empty(); // Xóa dữ liệu cũ trong bảng

            // Thêm dữ liệu mới vào bảng
            data.forEach(function (ticket) {
                var row = `
            <tr>
                <td>${ticket.order_code}</td>
                <td>${ticket.date}</td>
                <td>${ticket.route_name}</td>
                <td>${ticket.total_tickets} Ghế</td>
                <td>${ticket.total_price}</td>
                <td>${ticket.paymentMethod}</td>
                <td><span class="badge bg-${ticket.status === 'paid' ? 'success' : 'danger'}">${ticket.status}</span></td>
                <td><a href="/tickets/${ticket.id}">Chi tiết</a></td>
            </tr>
        `;
                tableBody.append(row);
            });
        }

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.mater', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\doantotnghiep\resources\views/admin/tickets/list.blade.php ENDPATH**/ ?>