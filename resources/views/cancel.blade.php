<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo hủy chuyến</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background-color: #405187;
            color: white;
            padding: 20px;
            text-align: center;
            position: relative;
        }

        .header img {
            max-width: 120px;
            margin-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 20px;
            font-size: 16px;
        }

        .promotion-info {
            margin: 20px 0;
            border-top: 2px solid #405187;
            border-bottom: 2px solid #405187;
            padding: 10px 0;
        }

        .promotion-info p {
            margin: 10px 0;
            line-height: 1.5;
        }

        .footer {
            background-color: #f1f1f1;
            text-align: center;
            padding: 15px;
            font-size: 14px;
            color: #555;
        }

        .button {
            background-color: #dedee0;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #405187;
        }

        .promotion-code {
            font-weight: bold;
            font-size: 18px;
            color: #405187;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1> Thông báo hủy đơn hàng thành công</h1>
        </div>
        <div class="content">
            <p>Kính gửi Quý khách hàng: </p>
            <p>Chúng tôi xin thông báo rằng đơn hàng của bạn với mã <strong>{{ $data['order_code'] }}</strong> đã được
                hủy thành công.</p>
            <div class="promotion-info">
                <p class="promotion-code">Thông tin đơn hàng</p>
                <p><strong>Mã đơn hàng:</strong> {{ $data['order_code'] }}</p>
                <p><strong>Tên khách hàng:</strong> {{ $data['name'] }}</p>
                <p><strong>Số điện thoại:</strong> {{ $data['phone'] }}</p>
                <p><strong>Email:</strong> {{ $data['email'] }}</p>
                <p><strong>Số tài khoản:</strong> {{ $data['account_number'] }}</p>
                <p><strong>Ngân hàng:</strong> {{ $data['bank'] }}</p>
                <p><strong>Lý do hủy:</strong> {{ $data['reason'] }}</p>
            </div>
            <p>Chúng tôi rất tiếc về sự bất tiện này và hy vọng sẽ tiếp tục phục vụ bạn trong những lần đặt hàng tiếp
                theo.</p>
        </div>

        <div class="footer">
            <p>Cảm ơn bạn đã sử dụng dịch vụ cảu chúng tôi!</p>
            <p>&copy; Xe khách Hồng Nhung. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
