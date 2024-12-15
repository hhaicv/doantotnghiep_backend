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
                                                            data-bs-trigger="hover" data-bs-placement="top"
                                                            title="View">
                                                            <a href="<?php echo e(route('admin.tickets.show', $ticketBooking->id)); ?>"
                                                                class="text-primary d-inline-block">
                                                                <i class="ri-eye-fill fs-16"></i>
                                                            </a>
                                                        </li>


                                                    <?php
                                                        $bookingDate = \Carbon\Carbon::parse($ticketBooking->date);
                                                        $currentDate = \Carbon\Carbon::now();
                                                    ?>

                                                    <?php if($bookingDate->greaterThan($currentDate) && $ticketBooking->status == App\Models\TicketBooking::PAYMENT_STATUS_PAID): ?>
                                                        <li class="list-inline-item" data-bs-toggle="tooltip">
                                                            <a href="<?php echo e(route('admin.change', $ticketBooking->id)); ?>"
                                                                class="text-primary">
                                                                <i class="ri-exchange-fill"></i>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>

                                                    <?php if($ticketBooking->cancel): ?>
                                                        <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top"
                                                            title="Edit">
                                                            <a href="#showModal" data-bs-toggle="modal"
                                                                class="text-primary d-inline-block edit-item-btn"
                                                                data-id="<?php echo e($ticketBooking->id); ?>"
                                                                data-order-code="<?php echo e($ticketBooking->order_code); ?>"
                                                                data-name="<?php echo e($ticketBooking->cancel->name ?? ''); ?>"
                                                                data-phone="<?php echo e($ticketBooking->cancel->phone ?? ''); ?>"
                                                                data-email="<?php echo e($ticketBooking->cancel->email ?? ''); ?>"
                                                                data-account-number="<?php echo e($ticketBooking->cancel->account_number ?? ''); ?>"
                                                                data-bank="<?php echo e($ticketBooking->cancel->bank ?? ''); ?>"
                                                                data-reason="<?php echo e($ticketBooking->cancel->reason ?? ''); ?>">
                                                                <i class="ri-pencil-fill fs-16"></i>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                </ul>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <!-- Modal -->
                                <div class="modal fade" id="showModal" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-light p-3">
                                                <h5 class="modal-title" id="exampleModalLabel">Đơn xác nhận hủy
                                                    đơn hàng</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close" id="close-modal"></button>
                                            </div>
                                            <form id="cancelForm"
                                                action="<?php echo e(route('admin.cancel.store', ['id' => $ticketBooking->id])); ?>"
                                                method="POST">
                                                <?php echo csrf_field(); ?>
                                                <div class="modal-body">
                                                    <input type="hidden" id="id-field" name="ticket_booking_id" />

                                                    <!-- Mã đơn hàng -->
                                                    <div class="mb-3" id="modal-id">
                                                        <label for="order_code" class="form-label">Mã đơn
                                                            hàng</label>
                                                        <input type="text" id="order_code" name="order_code"
                                                            class="form-control" placeholder="Mã đơn hàng" readonly />
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="customername-field" class="form-label">Tên
                                                            khách hàng</label>
                                                        <input type="text" id="customername-field" name="name"
                                                            class="form-control" placeholder="Tên khách hàng" required />
                                                    </div>

                                                    <div class="row gy-4 mb-3">
                                                        <div class="col-md-6">
                                                            <div>
                                                                <label for="productname-field" class="form-label">Số điện
                                                                    thoại</label>
                                                                <input type="text" id="customername-field"
                                                                    name="phone" class="form-control"
                                                                    placeholder="Số điện thoại" required />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div>
                                                                <label for="productname-field"
                                                                    class="form-label">Email</label>
                                                                <input type="email" id="customername-field"
                                                                    name="email" class="form-control"
                                                                    placeholder="Email" required />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row gy-4 mb-3">
                                                        <div class="col-md-6">
                                                            <div>
                                                                <label for="amount-field" class="form-label">Số
                                                                    tài khoản</label>
                                                                <input type="text" id="amount-field"
                                                                    name="account_number" class="form-control"
                                                                    placeholder="Số tài khoản" required />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div>
                                                                <label for="amount-field" class="form-label">Ngân
                                                                    hàng</label>
                                                                <input type="text" id="amount-field"
                                                                    name="bank"class="form-control"
                                                                    placeholder="Ngân hàng" required />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="date-field" class="form-label">Lý do
                                                            hủy</label>
                                                        <div class="form-floating mb-3">
                                                            <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2Disabled" name="reason"
                                                                style="height: 100px"></textarea>
                                                            <label for="floatingTextarea2Disabled">Nội dung</label>
                                                        </div>
                                                    </div>


                                                </div>
                                                <div class="modal-footer">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="button" class="btn btn-light"
                                                            data-bs-dismiss="modal">Hủy</button>
                                                        <button type="submit" class="btn btn-success">Xác
                                                            nhận</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!--end modal -->
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

                </div>
            </div>

        </div>
        <!--end col-->
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('style-libs'); ?>
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
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
        document.addEventListener("DOMContentLoaded", function() {
            const editButtons = document.querySelectorAll(".edit-item-btn");

            const cancelRoute = "<?php echo e(route('admin.cancel', ['id' => '__id__'])); ?>"; // Chứa URL tạm thời

            editButtons.forEach(button => {
                button.addEventListener("click", function() {
                    const id = this.getAttribute("data-id");
                    const orderCode = this.getAttribute("data-order-code");
                    const name = this.getAttribute("data-name");
                    const phone = this.getAttribute("data-phone");
                    const email = this.getAttribute("data-email");
                    const accountNumber = this.getAttribute("data-account-number");
                    const bank = this.getAttribute("data-bank");
                    const reason = this.getAttribute("data-reason");

                    // Gán giá trị vào modal
                    document.getElementById("id-field").value = id;
                    document.getElementById("order_code").value = orderCode;
                    document.getElementById("customername-field").value = name;
                    document.querySelector("input[name='phone']").value = phone;
                    document.querySelector("input[name='email']").value = email;
                    document.querySelector("input[name='account_number']").value = accountNumber;
                    document.querySelector("input[name='bank']").value = bank;
                    document.querySelector("textarea[name='reason']").value = reason;

                    // Cập nhật lại URL của action của form
                    const form = document.getElementById('cancelForm');
                    form.action = cancelRoute.replace('__id__', id);
                });
            });
        });
    </script>



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
        $(document).ready(function() {
            // Lắng nghe sự kiện khi người dùng chọn tab
            $('.nav-link').on('click', function() {
                var tabId = $(this).attr('id'); // Lấy id của tab đang được chọn

                var filteredData = [];

                // Dựa trên tabId, bạn sẽ lọc các vé có trạng thái tương ứng
                if (tabId === 'tab-all') {
                    filteredData = allTicketData; // Hiển thị tất cả vé
                } else if (tabId === 'tab-delivered') {
                    filteredData = allTicketData.filter(function(ticket) {
                        return ticket.status === 'paid'; // Trạng thái thành công
                    });
                } else if (tabId === 'tab-returns') {
                    filteredData = allTicketData.filter(function(ticket) {
                        return ticket.status === 'refunded'; // Trạng thái hoàn vé
                    });
                } else if (tabId === 'tab-cancelled') {
                    filteredData = allTicketData.filter(function(ticket) {
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
            data.forEach(function(ticket) {
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