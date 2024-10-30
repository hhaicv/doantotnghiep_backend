@extends('admin.layouts.mater')
@section('title')
    Đặt vé
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Chọn chỗ</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body checkout-tab">

                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->

        <div class="col-xl-4">
            <div class="card">
                <div class="card-body checkout-tab">

                    <form action="#">
                        <div class="step-arrow-nav mt-n3 mx-n3 mb-3">

                            <ul class="nav nav-pills nav-justified custom-nav" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3 active" id="pills-bill-info-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-bill-info" type="button" role="tab"
                                        aria-controls="pills-bill-info" aria-selected="true">
                                        <i
                                            class="ri-truck-line fs-16 p-2 bg-primary-subtle text-primary rounded-circle align-middle me-2"></i>
                                        Thông tin chuyến
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3" id="pills-bill-address-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-bill-address" type="button" role="tab"
                                        aria-controls="pills-bill-address" aria-selected="false">

                                        <i
                                            class="ri-user-2-line fs-16 p-2 bg-primary-subtle text-primary rounded-circle align-middle me-2"></i>
                                        Thông tin người đặt
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3" id="pills-payment-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-payment" type="button" role="tab"
                                        aria-controls="pills-payment" aria-selected="false">
                                        <i
                                            class="ri-bank-card-line fs-16 p-2 bg-primary-subtle text-primary rounded-circle align-middle me-2"></i>
                                        Payment Info
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fs-15 p-3" id="pills-finish-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-finish" type="button" role="tab"
                                        aria-controls="pills-finish" aria-selected="false">
                                        <i
                                            class="ri-checkbox-circle-line fs-16 p-2 bg-primary-subtle text-primary rounded-circle align-middle me-2"></i>
                                        Finish
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="pills-bill-info" role="tabpanel"
                                aria-labelledby="pills-bill-info-tab">
                                <div>
                                    <h4 class="mb-1">Chiêm hóa - Bến xe Mỹ Đình</h4>
                                    <span class="fs-5">06:50 - 29/10/2024</span>
                                </div>
                                <hr>
                                <div class="mt-4">
                                    <div class="row gy-3">
                                        <div class="col-4">
                                            <p class="fs-5">Ghế đã chọn: </p>
                                            <p class="fs-5">Tổng tiền: </p>
                                            <p class="fs-5">Điểm đi:<span style="color: red">*</span></p>
                                            <br>
                                            <br>
                                            <br>
                                            <p class="fs-5">Điểm đến:<span style="color: red">*</span></p>
                                        </div>
                                        <div class="col">
                                            <p class="fs-5">A3, A5</p>
                                            <p class="fs-5">360.000 VND</p>
                                            <select class="form-select" aria-label="Default select example">
                                                <option value="1">Tại bến</option>
                                                <option value="2">Dọc đường</option>
                                            </select>
                                            <select class="form-select mt-2" aria-label="Default select example">
                                                <option value="1">Chiêm Hóa</option>
                                            </select>
                                            <select class="form-select mt-3" aria-label="Default select example">
                                                <option value="1">Tại bến</option>
                                                <option value="2">Dọc đường</option>
                                            </select>
                                            <select class="form-select mt-2" aria-label="Default select example">
                                                <option value="1">Mỹ Đình</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex align-items-start gap-3 mt-3">
                                    <button type="button"
                                        class="btn btn-primary btn-label right ms-auto nexttab fs-5 ps-4 pe-5"
                                        data-nexttab="pills-bill-address-tab">
                                        <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Tiếp tục
                                    </button>
                                </div>

                            </div>
                            <!-- end tab pane -->

                            <div class="tab-pane fade" id="pills-bill-address" role="tabpanel"
                                aria-labelledby="pills-bill-address-tab">
                                <div>
                                    <h5 class="mb-1">Thông tin khách hàng</h5>
                                    <p class="text-muted mb-4">Vui lòng nhập đầy đủ thông tin</p>
                                </div>

                                <div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="billinginfo-firstName" class="form-label">Họ tên</label>
                                                <input type="text" class="form-control" id="billinginfo-firstName"
                                                    placeholder="Nhập họ tên" value="">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="billinginfo-lastName" class="form-label">Số điện thoại</label>
                                                <input type="text" class="form-control" id="billinginfo-lastName"
                                                    placeholder="Nhập số điện thoại" value="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label for="billinginfo-email" class="form-label">Email <span
                                                        class="text-muted">(Optional)</span></label>
                                                <input type="email" class="form-control" id="billinginfo-email"
                                                    placeholder="Nhập email">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="billinginfo-address" class="form-label">Ghi chú</label>
                                        <textarea class="form-control" id="billinginfo-address" placeholder="Nhập ghi chú" rows="3"></textarea>
                                    </div>
                                    <div class="d-flex align-items-start gap-3 mt-4">
                                        <button type="button"
                                            class="btn btn-primary btn-label right ms-auto nexttab fs-5"
                                            data-nexttab="pills-payment-tab"><i
                                                class="ri-bank-card-line label-icon align-middle fs-16 ms-2"></i>Thanh
                                            toán</button>
                                    </div>

                                </div>
                            </div>
                            <!-- end tab pane -->

                            <div class="tab-pane fade" id="pills-payment" role="tabpanel"
                                aria-labelledby="pills-payment-tab">
                                <div>
                                    <h5 class="mb-1">Thông tin thanh toán</h5>
                                    <p class="text-muted mb-4">Vui long nhập đầy đủ thông tin</p>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="billinginfo-firstName" class="form-label">Thực thu</label>
                                            <input type="text" class="form-control" id="billinginfo-firstName"
                                                value="360.000">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="billinginfo-lastName" class="form-label">Đã thu</label>
                                            <input type="text" class="form-control" id="billinginfo-lastName">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="billinginfo-firstName" class="form-label">Thực thu</label>
                                            <input type="text" class="form-control" id="billinginfo-firstName"
                                                value="360.000">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label for="billinginfo-email" class="form-label">Email <span
                                                    class="text-muted">(Optional)</span></label>
                                            <input type="email" class="form-control" id="billinginfo-email"
                                                placeholder="Nhập email">
                                        </div>
                                    </div>
                                </div>

                                <div class="collapse show" id="paymentmethodCollapse">
                                    <div class="card p-4 border shadow-none mb-0 mt-4">
                                        <div class="row gy-3">
                                            <div class="col-md-12">
                                                <label for="cc-name" class="form-label">Name on card</label>
                                                <input type="text" class="form-control" id="cc-name"
                                                    placeholder="Enter name">
                                                <small class="text-muted">Full name as displayed on card</small>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="cc-number" class="form-label">Credit card number</label>
                                                <input type="text" class="form-control" id="cc-number"
                                                    placeholder="xxxx xxxx xxxx xxxx">
                                            </div>

                                            <div class="col-md-3">
                                                <label for="cc-expiration" class="form-label">Expiration</label>
                                                <input type="text" class="form-control" id="cc-expiration"
                                                    placeholder="MM/YY">
                                            </div>

                                            <div class="col-md-3">
                                                <label for="cc-cvv" class="form-label">CVV</label>
                                                <input type="text" class="form-control" id="cc-cvv"
                                                    placeholder="xxx">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-muted mt-2 fst-italic">
                                        <i data-feather="lock" class="text-muted icon-xs"></i> Your transaction is secured
                                        with SSL encryption
                                    </div>
                                </div>

                                <div class="d-flex align-items-start gap-3 mt-4">
                                    <button type="button" class="btn btn-light btn-label previestab"
                                        data-previous="pills-bill-address-tab"><i
                                            class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Back to
                                        Shipping</button>
                                    <button type="button" class="btn btn-primary btn-label right ms-auto nexttab"
                                        data-nexttab="pills-finish-tab"><i
                                            class="ri-shopping-basket-line label-icon align-middle fs-16 ms-2"></i>Complete
                                        Order</button>
                                </div>
                            </div>
                            <!-- end tab pane -->

                            <div class="tab-pane fade" id="pills-finish" role="tabpanel"
                                aria-labelledby="pills-finish-tab">
                                <div class="text-center py-5">

                                    <div class="mb-4">
                                        <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop"
                                            colors="primary:#0ab39c,secondary:#405189"
                                            style="width:120px;height:120px"></lord-icon>
                                    </div>
                                    <h5>Thank you ! Your Order is Completed !</h5>
                                    <p class="text-muted">You will receive an order confirmation email with details of your
                                        order.</p>

                                    <h3 class="fw-semibold">Order ID: <a href="apps-ecommerce-order-details.html"
                                            class="text-decoration-underline">VZ2451</a></h3>
                                </div>
                            </div>
                            <!-- end tab pane -->
                        </div>
                        <!-- end tab content -->
                    </form>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
@endsection
