@extends('admin.layouts.mater')
@section('title')
    Cập nhật lại phân quyền
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Hóa đơn</h4>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-xxl-9">
            <div class="card" id="demo">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-header border-bottom-dashed p-4">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <img src="{{ asset('theme/admin/assets/images/logo-removebg-preview.png') }}" class="card-logo card-logo-dark" alt="logo dark" height="120">
                                    <img src="{{ asset('theme/admin/assets/images/logo-removebg-preview.png') }}" class="card-logo card-logo-light" alt="logo light" height="120">
                                    <div class="mt-sm-5 mt-4">
                                        <h6 class="text-muted text-uppercase fw-semibold">Địa chỉ</h6>
                                        <p class="text-muted mb-1" id="address-details">Hà Nội , Việt Nam</p>
                                        <p class="text-muted mb-0" id="zip-code"><span>Zip-code:</span> 100000</p>
                                    </div>
                                </div>
                                <div class="flex-shrink-0 mt-sm-0 mt-3">
                                    <h6><span class="text-muted fw-normal">Số đăng kí kinh doanh:</span><span id="legal-register-no">99999</span></h6>
                                    <h6><span class="text-muted fw-normal">Email:</span><span id="email">xekhachhongnhung@gmail.com</span></h6>
                                    <h6><span class="text-muted fw-normal">Website:</span> <a href="#" class="link-primary" target="_blank" id="website">www.xekhachhongnhung.com</a></h6>
                                    <h6 class="mb-0"><span class="text-muted fw-normal">Liên Hệ: </span><span id="contact-no"> +(84) 387 2144 23</span></h6>
                                </div>
                            </div>
                        </div>
                        <!--end card-header-->
                    </div><!--end col-->
                    <div class="col-lg-12">
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-lg-3 col-6">
                                    <p class="text-muted mb-2 text-uppercase fw-semibold">Hóa đơn</p>
                                    <h5 class="fs-14 mb-0">#<span id="invoice-no">{{$showPayment->order_code}}</span></h5>
                                </div>
                                <!--end col-->
                                <div class="col-lg-3 col-6">
                                    <p class="text-muted mb-2 text-uppercase fw-semibold">Thời gian</p>
                                    <h5 class="fs-14 mb-0"><span id="invoice-date">{{$showPayment->created_at}}</span> </h5>
                                </div>
                                <!--end col-->
                                <div class="col-lg-3 col-6">
                                    <p class="text-muted mb-2 text-uppercase fw-semibold">Trạng thái thanh toán</p>
                                    <span class="badge bg-success-subtle text-success fs-11" id="payment-status">{{$showPayment->status}}</span>
                                </div>
                                <!--end col-->
                                <div class="col-lg-3 col-6">
                                    <p class="text-muted mb-2 text-uppercase fw-semibold">Tổng tiền</p>
                                    <h5 class="fs-14 mb-0"><span id="total-amount">{{ number_format($showPayment->total_price, 0, ',', '.') }} VNĐ</span></h5>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </div>
                        <!--end card-body-->
                    </div><!--end col-->
                    <div class="col-lg-12">
                        <div class="card-body p-4 border-top border-top-dashed">
                            <div class="row g-3">
                                <div class="col-6">
                                    <h6 class="text-muted text-uppercase fw-semibold mb-3">Địa chỉ thanh toán</h6>
                                    <p class="fw-medium mb-2" id="billing-name">{{$showPayment->name}}</p>
                                    <p class="text-muted mb-1" id="billing-address-line-1">Hà Nội-Việt Nam</p>
                                    <p class="text-muted mb-1"><span>Số điện thoại: +</span><span id="billing-phone-no">(84) {{$showPayment->phone}}</span></p>
                                    <p class="text-muted mb-0"><span>Tax: </span><span id="billing-tax-no">12-3456789</span> </p>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </div>
                        <!--end card-body-->
                    </div><!--end col-->
                    <div class="col-lg-12">
                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table class="table table-borderless text-center table-nowrap align-middle mb-0">
                                    <thead>
                                        <tr class="table-active">
                                            <th scope="col" style="width: 50px;">#</th>
                                            <th scope="col">Thông tin vé</th>
                                            <th scope="col" class="text-center">Trạng thái</th>
                                            <th scope="col" class="text-end">Giá</th>
                                        </tr>
                                    </thead>
                                    <tbody id="products-list">

                                    @foreach($showPayment->ticketDetails as $ticketDetail)
                                        <tr>
                                            <td class="text-end">{{ $ticketDetail->id }} </td>
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
                                    </tbody>
                                </table><!--end table-->
                            </div>
                            <div class="border-top border-top-dashed mt-2">
                                <table class="table table-borderless table-nowrap align-middle mb-0 ms-auto" style="width:250px">
                                    <tbody>
                                        <tr class="border-top border-top-dashed fs-15">
                                            <th scope="row">Tổng tiền</th>
                                            <th class="text-end">{{ number_format($showPayment->total_price, 0, ',', '.') }} VNĐ</th>
                                        </tr>
                                    </tbody>
                                </table>
                                <!--end table-->
                            </div>
                            <div class="mt-3">
                                <h6 class="text-muted text-uppercase fw-semibold mb-3">Chi tiết thanh toán:</h6>
                                <p class="text-muted mb-1">Phương thức thanh toán: <span class="fw-medium" id="payment-method">
                                        @if($showPayment->payment_method_id == 1)
                                            Tại quầy
                                        @elseif($showPayment->payment_method_id == 2)
                                            MoMoPay
                                        @elseif($showPayment->payment_method_id == 3)
                                            VNPay
                                        @else
                                            Không xác định
                                        @endif</span></p>
                                <p class="text-muted">Tổng tiền: <span id="card-total-amount">{{ number_format($showPayment->total_price, 0, ',', '.') }} VNĐ</span></p>
                            </div>
                            <div class="mt-4">
                                <div class="alert alert-info">
                                    <p class="mb-0"><span class="fw-semibold">LƯU Ý:</span>
                                        <span id="note">Tất cả các tài khoản phải được thanh toán trong vòng 7 ngày kể từ ngày nhận được hóa đơn.
                                            Được thanh toán bằng séc hoặc thẻ tín dụng hoặc thanh toán trực tiếp trực tuyến.
                                            Nếu tài khoản không được thanh toán trong vòng 7 ngày, các chi tiết tín dụng được cung
                                            cấp để xác nhận công việc đã thực hiện sẽ bị tính phí trích dẫn đã thỏa thuận nêu trên.
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                                <a href="javascript:window.print()" class="btn btn-success"><i class="ri-printer-line align-bottom me-1"></i> Print</a>
                                <a href="javascript:void(0);" class="btn btn-primary"><i class="ri-download-2-line align-bottom me-1"></i> Download</a>
                            </div>
                        </div>
                        <!--end card-body-->
                    </div><!--end col-->
                </div><!--end row-->
            </div>
            <!--end card-->
        </div>
        <!--end col-->
@endsection
