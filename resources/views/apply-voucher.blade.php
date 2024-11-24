<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Áp dụng mã khuyến mãi</title>

    <!-- CSS -->
    @vite(['resources/css/app.css'])

    <!-- Import Pusher JavaScript -->
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
</head>
<body>

    <div class="container">
        <h1>Áp dụng mã khuyến mãi</h1>

        <!-- Hiển thị thông báo -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Form nhập mã khuyến mãi -->
        <form action="{{ route('apply-voucher') }}" method="POST">
            @csrf
            <label for="code">Nhập mã khuyến mãi:</label>
            <input type="text" id="code" name="code" required>
            <button type="submit">Áp dụng</button>
        </form>

        <!-- Thông báo realtime -->
        <div id="realtime-alert" style="display: none; margin-top: 20px; padding: 10px; background-color: #dff0d8; color: #3c763d; border: 1px solid #d6e9c6;">
            <strong>Thông báo:</strong> <span id="promotion-message"></span>
        </div>
    </div>

    <!-- JavaScript -->
    @vite(['resources/js/public.js'])
</body>
</html>
