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
                    <a class="nav-link menu-link" href="<?php echo e(route('employee.dashboard')); ?>">
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
                                <a href="<?php echo e(route('employee.buses')); ?>" class="nav-link" data-key="t-buses">Danh
                                    sách xe</a>
                            </li>
                            
                            <li class="nav-item">
                                <a href="<?php echo e(route('employee.stops')); ?>" class="nav-link" data-key="t-stops">Điểm
                                    dừng</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('employee.routes')); ?>" class="nav-link" data-key="t-routes">Tuyến
                                    đường</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('employee.trips')); ?>" class="nav-link" data-key="t-trips">Danh sách chuyến</a>
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
                                <a href="<?php echo e(route('employee.tickets')); ?>" class="nav-link"
                                    data-key="t-horizontal">Tạo vé</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('employee.ticket_list')); ?>" class="nav-link"
                                    data-key="t-horizontal">Danh sách vé</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarPromotion" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarPromotion">
                        <i class="ri-layout-3-line"></i>
                        <span data-key="t-layouts">Khuyến mại</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarPromotion">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(route('employee.promotions')); ?>" class="nav-link"
                                    data-key="t-horizontal">Danh sách</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('employee.promotions')); ?>" class="nav-link"
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
                                <a href="<?php echo e(route('employee.contacts')); ?>" class="nav-link"
                                    data-key="t-horizontal">Danh sách</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarBanner" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarBanner">
                        <i class="ri-layout-3-line"></i>
                        <span data-key="t-layouts">Banner</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarBanner">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(route('employee.banners' )); ?>" class="nav-link"
                                    data-key="t-horizontal">Danh sách</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="sidebar-background"></div>
</div>


<!-- Left Sidebar End --><?php /**PATH L:\laragon\www\doantotnghiep\resources\views/employee/layouts/sidebar.blade.php ENDPATH**/ ?>