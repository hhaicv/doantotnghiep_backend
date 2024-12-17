<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="index.html" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="<?php echo e(asset('theme/admin/assets/images/logo-sm.png')); ?>" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="<?php echo e(asset('theme/admin/assets/images/logo-dark.png')); ?>" alt=""
                                height="17">
                        </span>
                    </a>

                    <a href="index.html" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="<?php echo e(asset('theme/admin/assets/images/logo-sm.png')); ?>" alt=""
                                height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="<?php echo e(asset('theme/admin/assets/images/logo-light.png')); ?>" alt=""
                                height="17">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                    id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

                <!-- App Search-->
            </div>

            <div class="d-flex align-items-center">
                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user"
                                src=" <?php echo e(asset('theme/admin/assets/images/users/ebe4.j')); ?>" alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">
                                </span>
                                <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">
                                </span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Welcome Anna!</h6>
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i class="ri-user-settings-line align-middle fs-18 text-muted me-2"></i>
                            <span>My account settings</span>
                        </a>

                        <a class="dropdown-item" href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle" data-key="t-logout"><?php echo e(__('Logout')); ?></span>
                        </a>

                        <form id="logout-form" method="POST" action="<?php echo e(route('driver.logout')); ?>" style="display: none;">
                            <?php echo csrf_field(); ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<?php /**PATH D:\laragon\www\doantotnghiep\resources\views/driver/layouts/header.blade.php ENDPATH**/ ?>