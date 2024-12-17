<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>


    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo e(asset('theme/admin/assets/images/favicon.ico')); ?>">

    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>


    <script src="https://kit.fontawesome.com/24d8b82fa8.js" crossorigin="anonymous"></script>
    <?php echo $__env->yieldContent('style-libs'); ?>
    <!-- Layout config Js -->
    <script src="<?php echo e(asset('theme/admin/assets/js/layout.js')); ?>"></script>
    <!-- Bootstrap Css -->
    <link href="<?php echo e(asset('theme/admin/assets/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?php echo e(asset('theme/admin/assets/css/icons.min.css')); ?>" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?php echo e(asset('theme/admin/assets/css/app.min.css')); ?>" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="<?php echo e(asset('theme/admin/assets/css/custom.min.css')); ?>" rel="stylesheet" type="text/css" />
    <style>
        .choices__list--multiple .choices__item {
            background-color: #405189 !important;
            border: 1px solid #004a5c;
        }

        .category-item {
            display: inline-block;
            /* Allows block-level formatting for each category */
            background-color: #f0f0f0;
            /* Background color for categories */
            color: #333;
            /* Text color */
            padding: 5px 10px;
            /* Padding for spacing */
            margin: 5px;
            /* Space between categories */
            border-radius: 5px;
            /* Rounded corners */
            font-size: 14px;
            /* Font size */
            transition: background-color 0.3s;
            /* Transition effect */
        }

        .category-item:hover {
            background-color: #e0e0e0;
            /* Darker background on hover */
        }

        .filepond-container {
            background: #f8f9fa;
            border-radius: 5px;
            padding: 20px;
            max-width: 600px;
            margin: auto;
        }

        .choices[data-type*=select-multiple] .choices__list--dropdown .choices__list,
        .choices[data-type*=text] .choices__list--dropdown .choices__list {
            padding: 20px;

        }

        .file-drop-area {
            border: 2px dashed #007bff;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
            position: relative;
        }

        .file-drop-area:hover {
            background: #e9ecef;
        }

        .file-drop-message {
            color: #6c757d;
            margin: 10px 0;
            font-size: 16px;
        }

        .browse {
            color: #007bff;
            cursor: pointer;
            text-decoration: underline;
        }



        .file-preview-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 10px;
        }

        .file-preview-item img {
            width: 300px;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .file-remove-btn {
            background: #405189;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            padding: 5px 10px;
        }
    </style>

</head>

<body>


    <div id="layout-wrapper">

        <?php echo $__env->make('admin.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>;



        <?php echo $__env->make('admin.layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="vertical-overlay"></div>

        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </div>

            <?php echo $__env->make('admin.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>

    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <div class="customizer-setting d-none d-md-block">
        <div class="btn-info rounded-pill shadow-lg btn btn-icon btn-lg p-2" data-bs-toggle="offcanvas"
            data-bs-target="#theme-settings-offcanvas" aria-controls="theme-settings-offcanvas">
            <i class='mdi mdi-spin mdi-cog-outline fs-22'></i>
        </div>
    </div>
    <!-- JAVASCRIPT -->
    <script src="<?php echo e(asset('theme/admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('theme/admin/assets/libs/simplebar/simplebar.min.js')); ?>"></script>
    <script src="<?php echo e(asset('theme/admin/assets/libs/node-waves/waves.min.js')); ?>"></script>
    <script src="<?php echo e(asset('theme/admin/assets/libs/feather-icons/feather.min.js')); ?>"></script>
    <script src="<?php echo e(asset('theme/admin/assets/js/pages/plugins/lord-icon-2.1.0.js')); ?>"></script>
    <script src="<?php echo e(asset('theme/admin/assets/js/plugins.js')); ?>"></script>
    <script src="<?php echo e(asset('theme/admin/assets/js/app.js')); ?>"></script>


    <?php echo $__env->yieldContent('script-libs'); ?>

    <!-- App js -->
    <script src="<?php echo e(asset('theme/admin/assets/js/app.js')); ?>"></script>

    <?php echo $__env->yieldContent('scripts'); ?>
</body>

</html>
<?php /**PATH D:\laragon\www\doantotnghiep_master\resources\views/admin/layouts/mater.blade.php ENDPATH**/ ?>