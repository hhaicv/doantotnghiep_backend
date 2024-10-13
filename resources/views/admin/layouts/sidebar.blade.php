<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('theme/admin/assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('theme/admin/assets/images/logo-dark.png') }}" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('theme/admin/assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('theme/admin/assets/images/logo-light.png') }}" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            {{-- // div cấm xóa --}}
            <div id="two-column-menu">

            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('admin.dashboard') }}">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboard</span>
                    </a>
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
                                <a href="{{ route('admin.new_categories.index') }}" class="nav-link"
                                    data-key="t-horizontal">Danh
                                    sách</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.new_categories.create') }}" class="nav-link"
                                    data-key="t-horizontal">Thêm mới</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarInformation" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarInformation">
                        <i class="ri-layout-3-line"></i>
                        <span data-key="t-layouts">Tin tức</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarInformation">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.information.index') }}" class="nav-link"
                                    data-key="t-horizontal">Danh
                                    sách</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.information.create') }}" class="nav-link"
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
                                <a href="{{ route('admin.contacts.index') }}" class="nav-link"
                                    data-key="t-horizontal">Danh
                                    sách</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.contacts.create') }}" class="nav-link"
                                    data-key="t-horizontal">Thêm mới</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarRoles" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarRoles">
                        <i class="ri-layout-3-line"></i>
                        <span data-key="t-layouts">Chức Vụ</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarRoles">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.roles.index') }}" class="nav-link"
                                    data-key="t-horizontal">Danh
                                    sách</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.roles.create') }}" class="nav-link"
                                    data-key="t-horizontal">Thêm mới</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
