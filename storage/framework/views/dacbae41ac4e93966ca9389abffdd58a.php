<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="" class="logo logo-dark">
            <span class="logo-sm">
                <img src="<?php echo e(asset('theme/admin/assets/images/logo-removebg-preview.png')); ?>" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="<?php echo e(asset('theme/admin/assets/images/logo-removebg-preview.png')); ?>" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="" class="logo logo-light">
            <span class="logo-sm">
                <img src="<?php echo e(asset('theme/admin/assets/images/logo-removebg-preview.png')); ?>" alt="" height="50">
            </span>
            <span class="logo-lg">
                <img src="<?php echo e(asset('theme/admin/assets/images/logo-removebg-preview.png')); ?>" alt="" height="100">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            
            <div id="two-column-menu">

            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="<?php echo e(route('admin.dashboard')); ?>">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboard</span>
                    </a>
                </li>
                <hr>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarExecutive" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarExecutive">
                        <i data-feather="trello"></i>
                        <span data-key="t-executive">Điều Hành</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarExecutive">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.buses.index')); ?>" class="nav-link" data-key="t-buses">Danh
                                    sách xe</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.drivers.index')); ?>" class="nav-link" data-key="t-buses">Tài xế</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.stops.index')); ?>" class="nav-link" data-key="t-stops">Điểm
                                    dừng</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.routes.index')); ?>" class="nav-link" data-key="t-routes">Tuyến
                                    đường</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.trips.index')); ?>" class="nav-link" data-key="t-trips">Danh sách chuyến</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarTickets" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarTickets">
                        <i class="ri-ticket-2-fill"></i>
                        <span data-key="t-layouts">Đơn Hàng</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarTickets">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.tickets.index')); ?>" class="nav-link"
                                    data-key="t-horizontal">Tạo vé</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.ticket_list')); ?>" class="nav-link"
                                    data-key="t-horizontal">Danh sách vé</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarNewCategory" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarNewCategory">
                        <i class="ri-layout-3-line"></i>
                        <span data-key="t-layouts">Danh mục tin tức</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarNewCategory">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.new_categories.index')); ?>" class="nav-link"
                                    data-key="t-horizontal">Danh sách danh mục</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.information.index')); ?>" class="nav-link"
                                    data-key="t-horizontal">Danh
                                    sách tin tức</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarBanners" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarBanners">
                        <i class="ri-layout-3-line"></i>
                        <span data-key="t-layouts">Banner</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarBanners">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.banners.index')); ?>" class="nav-link"
                                    data-key="t-horizontal">Danh sách</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.banners.create')); ?>" class="nav-link"
                                    data-key="t-horizontal">Thêm mới</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarPromotion" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarPromotion">
                        <i class="ri-layout-3-line"></i>
                        <span data-key="t-layouts">Danh mục khuyến mãi</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarPromotion">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.promotion_categories.index')); ?>" class="nav-link"
                                    data-key="t-horizontal">Danh sách danh mục</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.promotions.index')); ?>" class="nav-link"
                                    data-key="t-horizontal">Danh sách khuyến mãi</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarReviews" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarReviews">
                        <i class="ri-layout-3-line"></i>
                        <span data-key="t-layouts">Đánh giá</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarReviews">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.reviews.index')); ?>" class="nav-link"
                                    data-key="t-horizontal">Danh sách</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.reviews.create')); ?>" class="nav-link"
                                    data-key="t-horizontal">Thêm mới</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarContacts" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarContacts">
                        <i class="ri-layout-3-line"></i>
                        <span data-key="t-layouts">Liên Hệ</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarContacts">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.contacts.index')); ?>" class="nav-link"
                                    data-key="t-horizontal">Danh sách</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.contacts.create')); ?>" class="nav-link"
                                    data-key="t-horizontal">Thêm mới</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarUsers" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarUsers">
                        <i class="ri-layout-3-line"></i>
                        <span data-key="t-layouts">Tài khoản</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarUsers">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.users.employees')); ?>" class="nav-link" data-key="t-horizontal">Danh sách Nhân viên</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.users.customers')); ?>" class="nav-link" data-key="t-horizontal">Danh sách Khách Hàng</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.users.index')); ?>" class="nav-link" data-key="t-horizontal">Danh sách Tất cả Người dùng</a>
                            </li>

                        </ul>
                    </div>
                </li>
                <hr>
                <li class="menu-title"><span data-key="t-menu">Thống kê</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarStatistical" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarAdmins">
                        <i class="ri-layout-3-line"></i>
                        <span data-key="t-layouts">Thống kê</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarStatistical">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.statistics.tripStatistical')); ?>" class="nav-link" data-key="t-horizontal">Thống kê vé đặt</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <hr>
                <li class="menu-title"><span data-key="t-menu">Quản trị</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarAdmins" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarAdmins">
                        <i class="ri-layout-3-line"></i>
                        <span data-key="t-layouts">Tài khoản quản trị</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarAdmins">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.admins.index')); ?>" class="nav-link" data-key="t-horizontal">Tài khoản quản trị</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.roles.index')); ?>" class="nav-link"
                                    data-key="t-horizontal">Danh sách phân quyền</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <hr>
            </ul>
        </div>
    </div>
</div>

<div class="sidebar-background"></div>
</div>


<!-- Left Sidebar End --><?php /**PATH L:\laragon\www\doantotnghiep\resources\views/admin/layouts/sidebar.blade.php ENDPATH**/ ?>