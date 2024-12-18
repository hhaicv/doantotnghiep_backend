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
                            <h5 class="card-title mb-0">Lịch sử đặt vé</h5>
                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex gap-1 flex-wrap">
                                <a href="<?php echo e(route('employee.tickets')); ?>"><button type="button"
                                        class="btn btn-success add-btn" id="create-btn"><i
                                            class="ri-add-line align-bottom me-1"></i> Tạo vé</button></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    <form method="GET" action="<?php echo e(route('employee.ticket_list')); ?>">
                        <?php echo csrf_field(); ?>
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

                            <div class="col-xxl-3 col-sm-4">
                                <div>
                                    <select class="form-control" data-choices data-choices-search-false
                                        name="payment_method_id" id="idStatus">
                                        <option value="">Lọc theo thanh toán</option>
                                        <?php $__currentLoopData = App\Models\PaymentMethod::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($method->id); ?>"
                                                <?php echo e(request('payment_method_id') == $method->id ? 'selected' : ''); ?>>
                                                <?php echo e($method->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <!--end col-->

                            
                            <!--end col-->

                            <div class="col-xxl-2 col-sm-4">
                                <!-- Nút Hủy Lọc -->
                                <div class="row g-3">
                                    <div class="col">

                                        <div class="mb-2">
                                            <a href="<?php echo e(route('employee.ticket_list')); ?>" class="btn btn-primary w-100">Hủy
                                                lọc</a>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <!-- Nút Filters -->
                                        <div>
                                            <button type="submit" class="btn btn-primary w-100">
                                                <i class="ri-equalizer-fill me-1 align-bottom"></i>
                                                Filters
                                            </button>
                                        </div>
                                    </div>
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
                                <a class="nav-link active All py-3" data-bs-toggle="tab" id="tab-all" href="#home1"
                                    role="tab" aria-selected="true">
                                    <i class="ri-store-2-fill me-1 align-bottom"></i> Tổng vé đặt
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-3 Delivered" data-bs-toggle="tab" id="tab-paid" href="#paid"
                                    role="tab" aria-selected="false">
                                    <i class="ri-checkbox-circle-line me-1 align-bottom"></i> Thành công
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-3 Returns" data-bs-toggle="tab" id="tab-failed" href="#failed"
                                    role="tab" aria-selected="false">
                                    <i class="ri-arrow-left-right-fill me-1 align-bottom"></i> Thất bại
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-3 Cancelled" data-bs-toggle="tab" id="tab-refunded" href="#refunded"
                                    role="tab" aria-selected="false">
                                    <i class="ri-close-circle-line me-1 align-bottom"></i> Hủy
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-3 Overdue" data-bs-toggle="tab" id="tab-overdue" href="#overdue"
                                    role="tab" aria-selected="false">
                                    <i class="ri-timer-line me-1 align-bottom"></i> Quá hạn
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-3 Unpaid" data-bs-toggle="tab" id="tab-unpaid" href="#unpaid"
                                    role="tab" aria-selected="false">
                                    <i class="ri-money-dollar-circle-line me-1 align-bottom"></i> Chưa thanh toán
                                </a>
                            </li>
                        </ul>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="orderTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">

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
                                            <td class="id"><?php echo e($ticketBooking->order_code); ?></td>
                                            <td class="date"><?php echo e($ticketBooking->date); ?></td>
                                            <td class="route_name"><?php echo e($ticketBooking->route->route_name); ?></td>
                                            <td class="amount text-center"><?php echo e($ticketBooking->total_tickets); ?> Ghế</td>
                                            <td class="total_price text-center">
                                                <?php echo e(number_format($ticketBooking->total_price, 0, ',', '.')); ?> ₫</td>
                                            <td class="payment"><?php echo e($ticketBooking->paymentMethod->name); ?></td>
                                            <td class="status text-center">
                                                <span
                                                    class="badge
                                                    <?php echo e($ticketBooking->status === 'paid'
                                                        ? 'bg-success-subtle text-success'
                                                        : ($ticketBooking->status === 'unpaid'
                                                            ? 'bg-dark-subtle text-body'
                                                            : ($ticketBooking->status === 'failed'
                                                                ? 'bg-danger-subtle text-danger'
                                                                : ($ticketBooking->status === 'overdue'
                                                                    ? 'bg-primary-subtle text-primary'
                                                                    : ($ticketBooking->status === 'refunded'
                                                                        ? 'bg-secondary-subtle text-secondary'
                                                                        : ''))))); ?>">
                                                    <?php echo e(strtoupper($ticketBooking->status)); ?>

                                                </span>
                                            </td>

                                            <td>
                                                <ul class="list-inline hstack gap-2 mb-0">

                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                        <a href="<?php echo e(route('employee.ticket_list', $ticketBooking->id)); ?>"
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
                                                            <a href="<?php echo e(route('employee.tickets_change', $ticketBooking->id)); ?>"
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
                                            <?php if(isset($ticketBooking)): ?>
                                                <form id="cancelForm"
                                                    action="<?php echo e(route('employee.cancel', ['id' => $ticketBooking->id])); ?>"
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
                                                                class="form-control" placeholder="Tên khách hàng"
                                                                required />
                                                        </div>

                                                        <div class="row gy-4 mb-3">
                                                            <div class="col-md-6">
                                                                <div>
                                                                    <label for="productname-field" class="form-label">Số
                                                                        điện
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
                                            <?php endif; ?>
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
        $(document).ready(function() {
            var allTicketData = <?php echo json_encode($data, 15, 512) ?>;

            // Lắng nghe sự kiện khi người dùng chọn tab
            $('.nav-link').on('click', function() {
                var tabId = $(this).attr('id'); // Lấy id của tab đang được chọn

                var filteredData = [];

                // Dựa trên tabId, bạn sẽ lọc các vé có trạng thái tương ứng
                if (tabId === 'tab-all') {
                    filteredData = allTicketData; // Hiển thị tất cả vé
                } else if (tabId === 'tab-paid') {
                    filteredData = allTicketData.filter(function(ticket) {
                        return ticket.status === 'paid'; // Trạng thái thành công
                    });
                } else if (tabId === 'tab-failed') {
                    filteredData = allTicketData.filter(function(ticket) {
                        return ticket.status === 'failed'; // Trạng thái thất bại
                    });
                } else if (tabId === 'tab-refunded') {
                    filteredData = allTicketData.filter(function(ticket) {
                        return ticket.status === 'refunded'; // Trạng thái hủy
                    });
                } else if (tabId === 'tab-overdue') {
                    filteredData = allTicketData.filter(function(ticket) {
                        return ticket.status === 'overdue'; // Trạng thái quá hạn
                    });
                } else if (tabId === 'tab-unpaid') {
                    filteredData = allTicketData.filter(function(ticket) {
                        return ticket.status === 'unpaid'; // Trạng thái chưa thanh toán
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
            <td>${ticket.route.route_name}</td>
            <td>${ticket.total_tickets} Ghế</td>
        <td class="total_price text-center">
          ${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(ticket.total_price)}
        </td>
        <td>${ticket.payment_method.name}</td>
        <td>
            <span class="badge
             ${ticket.status === 'paid' ? 'bg-success-subtle text-success' :
              (ticket.status === 'unpaid' ? 'bg-dark-subtle text-body' :
              (ticket.status === 'failed' ? 'bg-danger-subtle text-danger' :
              (ticket.status === 'overdue' ? 'bg-primary-subtle text-primary' :
              (ticket.status === 'refunded' ? 'bg-secondary-subtle text-secondary' : ''))))}">
             ${ticket.status.toUpperCase()}
            </span>
        </td>
        <td>
          <ul class="list-inline hstack gap-2 mb-0">
            <!-- View Action -->
            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
              <a href="/admin/tickets/${ticket.id}" class="text-primary d-inline-block">
                <i class="ri-eye-fill fs-16"></i>
              </a>
            </li>

            <!-- Change Action (Conditionally Rendered) -->
            ${new Date(ticket.date) > new Date() && ticket.status === 'paid' ? `
                                      <li class="list-inline-item" data-bs-toggle="tooltip" title="Change">
                                        <a href="/admin/change/${ticket.id}" class="text-primary">
                                          <i class="ri-exchange-fill"></i>
                                        </a>
                                      </li>
                                    ` : ''}

            <!-- Edit Action (Conditionally Rendered) -->
         ${ticket.cancel ? `
                          <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                            <a href="#showModal" data-bs-toggle="modal" class="text-primary d-inline-block edit-item-btn"
                               data-id="${ticket.id}"
                               data-order-code="${ticket.order_code}"
                               data-name="${ticket.cancel.name}"
                               data-phone="${ticket.cancel.phone}"
                               data-email="${ticket.cancel.email}"
                               data-account-number="${ticket.cancel.account_number}"
                               data-bank="${ticket.cancel.bank}"
                               data-reason="${ticket.cancel.reason}">
                              <i class="ri-pencil-fill fs-16"></i>
                            </a>
                          </li>
                        ` : ''}
          </ul>
        </td>

        </tr>
    `;
                tableBody.append(row);

            });
        }
    </script>

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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('employee.layouts.mater', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH L:\laragon\www\doantotnghiep\resources\views/employee/tickets/list.blade.php ENDPATH**/ ?>