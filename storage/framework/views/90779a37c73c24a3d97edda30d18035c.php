<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Áp dụng mã khuyến mãi</title>

    <!-- CSS -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css']); ?>

    <!-- Import Bootstrap CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Import Pusher JavaScript -->
    
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Áp dụng mã khuyến mãi</h1>

        <!-- Hiển thị thông báo -->
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Thành công!</strong> <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Thất bại!</strong> <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Form nhập mã khuyến mãi -->
        <div class="card p-4 shadow-sm">
            <form action="<?php echo e(route('apply-voucher')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label for="code" class="form-label">Nhập mã khuyến mãi:</label>
                    <input type="text" id="code" name="code" class="form-control" required>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary w-100">Áp dụng</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS for modal, alerts, etc. -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/public.js']); ?>
</body>
</html>
<?php /**PATH L:\laragon\www\doantotnghiep\resources\views/apply-voucher.blade.php ENDPATH**/ ?>