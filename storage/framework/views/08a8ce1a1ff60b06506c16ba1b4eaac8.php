<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Thông tin đơn hàng</title>
</head>

<body style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #000000;">
    <div><a><img src="" alt=""
                style="max-height: 60px; width: auto; margin-bottom: 20px; border: none;" /></a>
        <p></p>
        <p style="margin-top: 0px; margin-bottom: 20px;">Chào <?php echo e($data['name']); ?></p>
        <p style="margin-top: 0px; margin-bottom: 20px;">Cảm ơn quý khách đã đặt vé. Vui lòng xem chi tiết vé dưới</p>
        <table
            style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
            <thead>
                <tr>
                    <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;"
                        colspan="2">Chi tiết vé</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td
                        style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;">
                        <b>Mã đơn hàng: </b> <?php echo e($data['order_code']); ?><br />
                        <b>Ngày tạo: </b> <?php echo e($data['booking_date']); ?><br />
                        <b>Phương thức thanh toán: </b> <?php echo e($data['payment_method']); ?><br />
                    <td
                        style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;">
                        <b>Email:</b> <?php echo e($data['email']); ?><br />
                        <b>Số điện thoại:</b> <?php echo e($data['phone']); ?><br />
                        <b>Ghi chú:</b> <?php echo e($data['note']); ?><br />

                </tr>
            </tbody>
        </table>
        <table
            style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
            <thead>
                <tr>
                    <td
                        style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;">
                        Mã vé</td>
                    <td
                        style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;">
                        Điểm khởi hành</td>
                    <td
                        style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;">
                        Điểm đến</td>
                    <td
                        style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: right; padding: 7px; color: #222222;">
                        Tuyến đường</td>
                    <td
                        style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: right; padding: 7px; color: #222222;">
                        Thời gian</td>
                    <td
                        style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: right; padding: 7px; color: #222222;">
                        Thông tin xe</td>
                    <td
                        style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: right; padding: 7px; color: #222222;">
                        Vị trí</td>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $ticketDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticketDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td
                            style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;">
                            <?php echo e($ticketDetail['ticket_code']); ?>

                        </td>
                        <td
                            style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;">
                            <?php echo e($data['start_point']); ?> - <?php echo e($data['point_up']); ?>

                        </td>
                        <td
                            style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;">
                            <?php echo e($data['end_point']); ?> - <?php echo e($data['point_down']); ?>

                        </td>
                        <td
                            style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;">
                            <?php echo e($data['route_name']); ?>

                        </td>
                        <td
                            style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;">
                            <?php echo e($data['time_start']); ?> - <?php echo e($data['date_start']); ?>

                        </td>
                        <td
                            style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;">
                            <p><?php echo e($data['license_plate']); ?></p>
                            <p><?php echo e($data['driver_name']); ?></p>
                            <p><?php echo e($data['driver_phone']); ?></p>
                        </td>
                        <td style="font-size: 12px; text-align: right; padding: 7px;">
                            <?php echo e($ticketDetail['name_seat'] ?? ''); ?>

                        </td>

                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>


        </table>


        <p style="margin-top: 0px; margin-bottom: 20px;color: #222222;">Vui lòng trả lời email này nếu có bất kì câu hỏi
            nào.
            Cảm ơn!</p>
    </div>
</body>

</html>
<?php /**PATH D:\laragon\www\doantotnghiep\resources\views/mail.blade.php ENDPATH**/ ?>