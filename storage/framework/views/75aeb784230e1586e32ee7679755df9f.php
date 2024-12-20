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

                <li class="nav-item <?php echo e(Request::routeIs('driver.dashboard') ? 'active' : ''); ?>">
                    <a class="nav-link menu-link" href="<?php echo e(route('driver.dashboard')); ?>">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Thống kê</span>
                    </a>
                </li>

                <li class="nav-item <?php echo e(Request::routeIs(['drivers.index','drivers.show']) ? 'active' : 'drivers.show'); ?>">
                    <a class="nav-link menu-link" href="<?php echo e(route('drivers.index')); ?>">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Danh sách chuyến</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="sidebar-background"></div>
</div>


<!-- Left Sidebar End -->
<?php /**PATH L:\laragon\www\doantotnghiep\resources\views/driver/layouts/sidebar.blade.php ENDPATH**/ ?>