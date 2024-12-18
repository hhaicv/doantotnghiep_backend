@extends('employee.layouts.mater')
@section('title', 'Thống kê chuyến đi')

@section('content')
    <div class="page-content-wrapper">
        <div class="container-fluid">
            <div class="card m-b-20">
                <div class="card-body">
                    <h4 class="mt-0 header-title border_b">Thống kê chuyến đi</h4>

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
                                    <input class="form-control" type="search" name="keyword"
                                           placeholder="Tìm theo tài khoản khách"
                                           value="{{ request('keyword') ?: '' }}">
                                </div>

                                <!-- Lọc theo thời gian -->
                                <div class="col-md-2">
                                    <select id="type" class="form-control" name="type" onchange="toggleFilterOptions()">
                                        <option value="">Lọc theo thời gian</option>
                                        <option value="day" {{ request('type') == 'day' ? 'selected' : '' }}>Theo ngày
                                        </option>
                                        <option value="week" {{ request('type') == 'week' ? 'selected' : '' }}>Theo
                                            tuần
                                        </option>
                                        <option value="month" {{ request('type') == 'month' ? 'selected' : '' }}>Theo
                                            tháng
                                        </option>
                                        <option value="option" {{ request('type') == 'option' ? 'selected' : '' }}>
                                            Khoảng thời gian
                                        </option>
                                    </select>
                                </div>

                                <!-- Khu vực hiển thị thêm bộ lọc -->
                                <div class="col-md-4" id="filters">
                                    <!-- Các trường lọc sẽ được JavaScript thêm vào đây -->
                                </div>

                                <!-- Nút lọc -->
                                <div class="col-md-4">
                                    <div class="form-group" style="float: right">
                                        <a href="{{ route('admin.statistics.tripStatistical') }}"
                                           class="btn btn-secondary">Hủy lọc</a>
                                        <button type="submit" class="btn btn-primary">Lọc</button>
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
                                                        Tên chuyến: <b>{{ $trip->route->route_name }}</b>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        Tổng vé: <b>{{ $trip->total_tickets }}</b>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        Tổng doanh thu:
                                                        <b>{{ number_format($trip->total_price, 0, ',', '.') }} VNĐ</b>
                                                    </div>
                                                </div>
                                                <hr>
                                            @endforeach

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    Tổng vé: <strong>{{ $data['total_tickets'] }}</strong>
                                                </div>
                                                <div class="col-sm-4">
                                                    Tổng doanh thu:
                                                    <strong>{{ number_format($data['total_revenue'], 0, ',', '.') }}
                                                        VNĐ</strong>
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
            </div>
        </div>
    </div>
@endsection
<style>
    .filter-row {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
    }

    .filter-row label {
        margin-right: 5px;
        white-space: nowrap;
    }

    .filter-row .form-control {
        flex: 1;
        min-width: 150px;
    }
</style>


<script>
    function toggleFilterOptions() {
        const type = document.getElementById('type').value;
        const filters = document.getElementById('filters');
        filters.innerHTML = '';

        if (type === 'day') {
            // Lọc theo ngày
            filters.innerHTML = `
            <div class="filter-row">
                <label for="from">Ngày:</label>
                <input type="date" class="form-control" name="from" id="from" value="{{ request('from') }}">
            </div>
        `;
        } else if (type === 'week') {
            // Lọc theo tuần
            filters.innerHTML = `
            <div class="filter-row">
                <label for="week">Tuần:</label>
                <input type="number" class="form-control" name="week" id="week" min="1" max="52" value="{{ request('week') }}">
                <label for="year">Năm:</label>
                <input type="number" class="form-control" name="year" id="year" min="2000" max="2100" value="{{ request('year') }}">
            </div>
        `;
        } else if (type === 'month') {
            // Lọc theo tháng
            filters.innerHTML = `
            <div class="filter-row">
                <label for="month">Tháng:</label>
                <input type="number" class="form-control" name="month" id="month" min="1" max="12" value="{{ request('month') }}">
                <label for="year">Năm:</label>
                <input type="number" class="form-control" name="year" id="year" min="2000" max="2100" value="{{ request('year') }}">
            </div>
        `;
        } else if (type === 'option') {
            // Lọc theo khoảng thời gian
            filters.innerHTML = `
            <div class="filter-row">
                <label for="from">Từ ngày:</label>
                <input type="date" class="form-control" name="from" id="from" value="{{ request('from') }}">
                <label for="to">Đến ngày:</label>
                <input type="date" class="form-control" name="to" id="to" value="{{ request('to') }}">
            </div>
        `;
        }
    }

    // Gọi hàm để hiển thị đúng trường khi trang tải lại
    document.addEventListener('DOMContentLoaded', toggleFilterOptions);
</script>
