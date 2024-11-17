<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Thông tin đơn hàng</title>
</head>

<body style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #000000;">
    <div><a><img src="" alt=""
                style="max-height: 60px; width: auto; margin-bottom: 20px; border: none;" /></a>
        <p></p>
        <p style="margin-top: 0px; margin-bottom: 20px;">Chào {{ $name }}</p>
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
                        <b>Mã đơn hàng: </b> {{ $order_code }}<br />
                        <b>Ngày tạo: </b> {{ $booking_date }}<br />
                        <b>Phương thức thanh toán: </b> {{ $payment_method }}<br />
                    <td
                        style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;">
                        <b>Email:</b> {{ $email }}<br />
                        <b>Số điện thoại:</b> {{ $phone }}<br />
                        <b>Ghi chú:</b> {{ $note }}<br />

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
                @foreach ($ticket_codes as $index => $ticket_code)
                    <tr>
                        <td
                            style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;">
                            {{ $ticket_code }}
                        </td>
                        <td
                            style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;">
                            {{ $start_point }} - {{ $point_up }}
                        </td>
                        <td
                            style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;">
                            {{ $end_point }} - {{ $point_down }}
                        </td>
                        <td
                            style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;">
                            {{ $route_name }}
                        </td>
                        <td
                            style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;">
                            {{ $time_start }} - {{ $date_start }}
                        </td>
                        <td
                            style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;">
                            <p>{{ $license_plate }}</p>
                            <p>{{ $driver_name }}</p>
                            <p>{{ $driver_phone }}</p>
                        </td>
                        <td
                            style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;">
                            {{ $name_seat[$index] ?? '' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>


        <p style="margin-top: 0px; margin-bottom: 20px;color: #222222;">Vui lòng trả lời email này nếu có bất kì câu hỏi
            nào.
            Cảm ơn!</p>
    </div>
</body>

</html>
