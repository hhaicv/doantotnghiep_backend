@extends('admin.layouts.mater')

@section('title')
Dashboard
@endsection

@section('content')
<div class="row">
    <div class="col">
        <div class="h-100">
            <div class="row mb-3 pb-1">
                <div class="col-12">
                    <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                        <div class="flex-grow-1">
                            <h4 id="greeting" class="fs-16 mb-1">Good Morning</h4>
                            <p class="text-muted mb-0">Thống kê của bạn</p>
                        </div>
                    </div><!-- end card header -->
                </div><!-- end col -->
            </div><!-- end row -->

            <div class="row">
                @foreach ([
                ['label' => 'Tổng doanh thu', 'value' => number_format($totalRevenue, 0, ',', '.'), 'icon' => 'bx-dollar-circle', 'route' => route('admin.statistics.tripStatistical')],
                ['label' => 'Tổng vé đặt', 'value' => $totalTickets, 'icon' => 'bx-shopping-bag', 'route' => route('admin.statistics.tripStatistical')],
                ['label' => 'Khách hàng', 'value' => $totalUser, 'icon' => 'bx-user-circle', 'route' => route('admin.users.customers')],
                ['label' => 'Tổng xe', 'value' => $totalBus, 'icon' => 'fas fa-bus', 'route' => route('admin.buses.index')]
                ] as $stat)
                <div class="col-xl-3 col-md-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">{{ $stat['label'] }}</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-end justify-content-between mt-4">
                                <div>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                        <span>
                                            @if($stat['label'] == 'Tổng doanh thu')
                                            {{ $stat['value'] }} VNĐ
                                            @else
                                            {{ $stat['value'] }}
                                            @endif
                                        </span>
                                    </h4>
                                    <a href="{{ $stat['route'] }}" class="text-decoration-underline">Xem chi
                                        tiết</a>
                                </div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-success-subtle rounded fs-3">
                                        <!-- Thêm màu xanh cho icon của "Tổng xe" -->
                                        @if($stat['label'] == 'Tổng xe')
                                        <i class="fas fa-bus text-success"></i> <!-- Màu xanh cho icon xe buýt -->
                                        @else
                                        <i class="bx {{ $stat['icon'] }} text-success"></i>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->
                @endforeach


            </div><!-- end row -->

            <div class="row">
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-header border-0 align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Biểu đồ</h4>
                        </div><!-- end card header -->

                        <div class="card-header p-0 border-0 bg-light-subtle">
                            <div class="row g-0 text-center">
                                <div class="col-6 col-sm-3">
                                    <div class="p-3 border border-dashed border-start-0">
                                        <h5 class="mb-1"><span>{{ $totalTickets }}</span></h5>
                                        <p class="text-muted mb-0">Tổng vé</p>
                                    </div>
                                </div><!-- end col -->
                                <div class="col-6 col-sm-3">
                                    <div class="p-3 border border-dashed border-start-0">
                                        <h5 class="mb-1">
                                            <span>{{ number_format($totalRevenue, 0, ',', '.') }}</span> VNĐ
                                        </h5>
                                        <p class="text-muted mb-0">Doanh thu</p>
                                    </div>
                                </div><!-- end col -->
                                <div class="col-6 col-sm-3">
                                    <div class="p-3 border border-dashed border-start-0">
                                        <h5 class="mb-1"><span class="counter-value" data-target="367">0</span></h5>
                                        <p class="text-muted mb-0">Refunds</p>
                                    </div>
                                </div><!-- end col -->
                            </div>
                        </div><!-- end card header -->

                        <div class="card-body p-0 pb-2">
                            <div class="w-100">
                                <div id="customer_impression_charts" class="apex-charts" dir="ltr"></div>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->

                <div class="col-xl-4">
                    <div class="card card-height-100">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Tuyến Được Đặt Nhiều Nhất</h4>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <div id="top-routes-chart" style="height: 350px;" dir="ltr"></div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->
            </div><!-- end row -->
        </div><!-- end h-100 -->
    </div><!-- end col -->
</div><!-- end row -->
@endsection

@section('script-libs')
<script src="{{ asset('theme/admin/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
<script>
    // Lấy giờ hiện tại
    const currentHour = new Date().getHours();

    // Lấy thẻ h4
    const greetingElement = document.getElementById('greeting');

    // Kiểm tra thời gian để thay đổi nội dung
    if (currentHour >= 6 && currentHour < 18) {
        greetingElement.textContent = 'Chào buổi sáng';
    } else {
        greetingElement.textContent = 'Chào buổi tối';
    }
</script>
<script>
    // Truyền dữ liệu từ controller vào JS
    var monthlyData = @json($monthlyData);

    var months = monthlyData.map(item => item.month);
    var revenue = monthlyData.map(item => item.revenue);
    var totalTickets = monthlyData.map(item => item.total_tickets);

    var options = {
        series: [{
                name: 'Doanh thu',
                type: 'bar', // Doanh thu là biểu đồ cột
                data: revenue
            },
            {
                name: 'Tổng vé',
                type: 'line', // Vé đặt là biểu đồ đường
                data: totalTickets
            }
        ],
        chart: {
            height: 350,
            type: 'line',
        },
        plotOptions: {
            bar: {
                columnWidth: '20%',
            }
        },
        stroke: {
            width: [0, 2],
            curve: 'smooth'
        },
        xaxis: {
            categories: months,
        },
        yaxis: [{
                title: {
                    text: 'Doanh thu (VNĐ)',
                },
                labels: {
                    formatter: function(value) {
                        return value.toLocaleString('vi-VN') + ' VNĐ';
                    }
                }
            },
            {
                opposite: true,
                title: {
                    text: 'Tổng vé',
                },
            }
        ],
        tooltip: {
            shared: true,
            intersect: false,
            y: {
                formatter: function(val) {
                    return val.toLocaleString('vi-VN') + ' Vé';
                }
            }
        },
        legend: {
            offsetY: 7,
            horizontalAlign: 'center'
        }
    };

    var chart = new ApexCharts(document.querySelector("#customer_impression_charts"), options);
    chart.render();

    var topRoutes = @json($topRoutes);

    var routes = topRoutes.map(item => item.route.route_name); // Lấy tên tuyến từ `route_name`
    var tickets = topRoutes.map(item => item.count); // Lấy số vé từ `count`

    var options = {
        series: [{
            name: 'Số vé',
            data: tickets
        }],
        chart: {
            type: 'bar',
            height: 350
        },
        plotOptions: {
            bar: {
                horizontal: true,
                barHeight: '50%',
            }
        },
        xaxis: {
            categories: routes, // Hiển thị tên tuyến trên trục x
        },
        yaxis: {
            title: {
                text: 'Tuyến',
            }
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return val + ' vé';
                }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#top-routes-chart"), options);
    chart.render();
</script>


<script src="{{ asset('theme/admin/assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
<script src="{{ asset('theme/admin/assets/libs/jsvectormap/maps/world-merc.js') }}"></script>

<script src="{{ asset('theme/admin/assets/libs/swiper/swiper-bundle.min.js') }}"></script>

<script src="{{ asset('theme/admin/assets/js/pages/dashboard-ecommerce.init.js') }}"></script>
@endsection