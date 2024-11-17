@extends('admin.layouts.mater')
@section('title', 'Thống kê chuyến đi')

@section('content')
    <div class="page-content-wrapper">
        <div class="container-fluid">
            <div class="card m-b-20">
                <div class="card-body">
                    <h4 class="mt-0 header-title border_b">
                        Thống kê chuyến đi
                    </h4>
                    <!-- Thông báo thành công -->
                    @if(session()->has('success'))
                        <div class="alert alert-success">
                            {!! session('success') !!}
                        </div>
                    @endif
                    <!-- Thông báo lỗi -->
                    @if(session()->has('error'))
                        <div class="alert alert-danger">
                            {!! session('error') !!}
                        </div>
                    @endif

                    <!-- Form lọc chuyến đi -->
                    <div class="find_wap mb-3">
                        <form id="filter_form" action="{{ route('admin.statistics.tripStatistical') }}" method="get">
                            <div class="row">
                                <!-- Tìm kiếm theo tài khoản khách -->
                                <div class="col-md-2">
                                    <div class="d-inline-flex w-100">
                                        <div style=" width: calc(100% - 8px);">
                                            <input class="form-control" type="search" name="keyword"
                                                   placeholder="Tìm theo tài khoản khách"
                                                   value="{{ request('keyword') ?: '' }}">
                                        </div>
                                    </div>
                                </div>

                                <!-- Lọc theo thời gian -->
                                <div class="col-md-2">
                                    <div class="d-inline-flex w-100">
                                        <div style="margin-left: 8px; width: calc(100% - 8px);">
                                            <select id="type_filter" class="form-control" name="type">
                                                <option value="">Lọc theo thời gian</option>
                                                <option value="day" {{ request('type') == 'day' ? 'selected' : '' }}>Theo ngày</option>
                                                <option value="week" {{ request('type') == 'week' ? 'selected' : '' }}>Theo tuần</option>
                                                <option value="month" {{ request('type') == 'month' ? 'selected' : '' }}>Theo tháng</option>
                                                <option value="option" {{ request('type') == 'option' ? 'selected' : '' }}>Khoảng thời gian</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Phần hiển thị thêm bộ lọc theo thời gian -->
                                <div class="col-md-6">
                                    <div class="row" id="filter_area"></div>
                                </div>

                                <!-- Nút lọc -->
                                <div class="col-md-2">
                                    <div class="form-group pull-right">
                                        <a href="{{ route('admin.statistics.tripStatistical') }}" class="btn btn-blue-grey mr-2">Hủy lọc</a>
                                        <button id="submit_filter" type="submit" class="btn btn-primary">Lọc</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Thống kê chuyến đi -->
                    <section class="p-3" style="background-color: #eee;">
                        <div class="row">
                            <div class="col-lg-8 offset-2">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="mt-0 header-title border_b">Thống kê chuyến đi</h5>
                                        @if($trips->count() > 0)
                                            @foreach($trips as $trip)
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        Tên chuyến: <b>{{ $trip->route->route_name}}</b>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        Tổng vé: <b>{{ $trip->total_tickets }}</b>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        Tổng doanh thu: <b>{{ number_format($trip->total_price, 0, ',', '.') }} VNĐ</b>
                                                    </div>
                                                </div>
                                                <hr>
                                            @endforeach

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    Tổng vé: <strong>{{ $data['total_tickets'] }}</strong>
                                                </div>
                                                <div class="col-sm-4">
                                                    Tổng doanh thu: <strong>{{ number_format($data['total_revenue'], 0, ',', '.') }} VNĐ</strong>
                                                </div>
                                            </div>

                                        @else
                                            <p class="dataTables_empty">Không có dữ liệu</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                </div>
            </div> <!-- end card -->
        </div><!-- container -->
    </div> <!-- Page content Wrapper -->

@endsection

@section('bottom_script')
    <script src="{{ asset('theme/admin/assets/js/parsley.min.js') }}"></script>
    <script src="{{asset('theme/admin/assets/js/statistical.js')}}"></script>

    <script type="text/javascript">
        const type_request = '{{request('type')}}';
        const quarter_request = '{{request('quarter')}}';
        const year_request = '{{request('year')}}';
        const month_request = '{{request('month')}}';
        const week_request = '{{request('week')}}';
        const from_request = '{{request('from')}}';
        const to_request = '{{request('to')}}';
        $(document).ready(function () {
            $('#submit_filter').on('click', function (e) {
                let form = $('#filter_form');
                form.parsley().validate();
                if (form.parsley().isValid()) {
                    form.submit();
                }
            });

            let typeFilter = '{{request('type') }}';
            if (typeFilter || type_request) {
                render_filter(typeFilter);
                $('.datepicker').datepicker({
                    language: 'vi',
                    autoclose: true,
                    clearBtn: true,
                    todayHighlight: true,
                    format: 'dd-mm-yyyy',
                    endDate: new Date()
                });
            }

            $('#type_filter').on("change", function () {
                let type = $(this).val();
                render_filter(type, false);
            });
        });
    </script>
    <script type="text/javascript" src="{{ asset('theme/admin/assets/js/date_time_filter.js') }}"></script>
@endsection
