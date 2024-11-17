@extends('admin.layouts.mater')

@section('title')
    Danh sách tuyến đường
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Danh sách vé</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-9">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title flex-grow-1 mb-0">Order #{{$showTicket->order_code}}</h5>
                        <div class="flex-shrink-0">
                            <a href="{{ route('admin.tickets.edit', $showTicket->id) }}" class="btn btn-success btn-sm"><i
                                    class="ri-download-2-fill align-middle me-1"></i> Hóa đơn</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-nowrap align-middle table-borderless mb-0">
                            <thead class="table-light text-muted">
                            <tr>
                                <th scope="col">Thông tin vé</th>
                                <th scope="col" class="text-center">Trạng thái</th>
                                <th scope="col" class="text-end">Giá</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($showTicket->ticketDetails as $ticketDetail)
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                            <div class="flex-grow-1 ms-3">
                                                <h5 class="fs-15">Vị trí ghế: {{$ticketDetail->name_seat}}</h5>
                                                <p class="text-muted mb-0">Mã vé: <span class="fw-medium">{{$ticketDetail->ticket_code}}</span></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="text-warning fs-15">
                                            <p class="text-muted mb-0">{{$ticketDetail->status}}</p>
                                        </div>
                                    </td>
                                    <td class="text-end">{{ number_format($ticketDetail->price, 0, ',', '.') }} VNĐ</td>
                                </tr>
                            @endforeach
                            <tr class="border-top border-top-dashed">
                                <td colspan="2" class="text-end fw-medium">Tổng Tiền (VNĐ):</td>
                                <td class="text-end fw-bold">{{ number_format($showTicket->total_price, 0, ',', '.') }} VNĐ</td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <!--end card-->
        </div>
        <!--end col-->
        <div class="col-xl-3">
            <!--end card-->

            <div class="card">
                <div class="card-header">
                    <div class="d-flex">
                        <h5 class="card-title flex-grow-1 mb-0">Tài xế</h5>
                        <div class="flex-shrink-0">
                            <a href="javascript:void(0);" class="link-secondary">Xem thông tin</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0 vstack gap-3">
                        <li>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img width="100px" height="70px" src="{{ Storage::url($showTicket->profile_image) }}"
                                         alt="Hình tài xế">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-14 mb-1">{{ optional(optional($showTicket->bus)->driver)->name ?? 'Chưa có tài xế' }}</h6>
                                    <p class="text-muted mb-0">Customer</p>
                                </div>
                            </div>
                        </li>
                        <li><i class="ri-mail-line me-2 align-middle text-muted fs-16"></i>{{ optional(optional($showTicket->bus)->driver)->email }}</li>
                        <li><i class="ri-phone-line me-2 align-middle text-muted fs-16"></i>{{ optional(optional($showTicket->bus)->driver)->phone }}</li>
                    </ul>
                </div>
            </div>
            <!--end card-->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="ri-map-pin-line align-middle me-1 text-muted"></i> Thông tin khách hàng</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled vstack gap-2 fs-13 mb-0">
                        <li class="fw-medium fs-14"> {{ $showTicket->name }} </li>
                        <li class="fw-medium fs-14">{{$showTicket->phone}}</li>
                        <li class="fw-medium fs-14">{{$showTicket->email}}</li>
                        <li class="fw-medium fs-14">Điểm đón: {{$showTicket->location_start}}</li>
                        <li class="fw-medium fs-14">Điểm xuống: {{$showTicket->location_end}}</li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="ri-secure-payment-line align-bottom me-1 text-muted"></i>
                        Phương thức thanh toán</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">Chi tiết thanh toán:</p>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0">
                                @if($showTicket->payment_method_id == 1)
                                    Thanh toán tại quầy
                                @elseif($showTicket->payment_method_id == 2)
                                    MoMoPay
                                @elseif($showTicket->payment_method_id == 3)
                                    VNPay
                                @else
                                    Không xác định
                                @endif
                            </h6>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">Total Amount:</p>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0">{{ number_format($showTicket->total_price, 0, ',', '.') }} VNĐ</h6>
                        </div>
                    </div>
                </div>
            </div>
            <!--end card-->
        </div>
        <!--end col-->
    </div>
@endsection

@section('style-libs')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection

@section('script-libs')
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


    <script src="{{ asset('theme/admin/assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/js/plugins.js') }}"></script>

    <!-- list.js min js -->
    <script src="{{ asset('theme/admin/assets/libs/list.js/list.min.js') }}"></script>

    <!--list pagination js-->
    <script src="{{ asset('theme/admin/assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>

    <!-- ecommerce-order init js -->
    <script src="{{ asset('theme/admin/assets/js/pages/ecommerce-order.init.js') }}"></script>

    <script src="{{ asset('theme/admin/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
@endsection
