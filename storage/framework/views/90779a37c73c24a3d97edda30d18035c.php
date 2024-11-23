<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <h1>Áp dụng mã khuyến mãi</h1>
        
        <!-- Hiển thị thông báo -->
        <?php if(session('success')): ?>
            <div class="alert alert-success">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <!-- Form nhập mã khuyến mãi -->
        <form action="<?php echo e(route('apply-voucher')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <label for="code">Nhập mã khuyến mãi:</label>
            <input type="text" id="code" name="code" required>
            <button type="submit">Áp dụng</button>
        </form>
    </div>
</body>
</html><?php /**PATH L:\laragon\www\doantotnghiep\resources\views/apply-voucher.blade.php ENDPATH**/ ?>