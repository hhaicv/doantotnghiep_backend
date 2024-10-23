<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập Admin</title>
</head>
<body>
    <h1>Đăng nhập Admin</h1>
    <form action="{{ route('admin.login') }}" method="POST">
        @csrf
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            @error('email')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="password">Mật khẩu:</label>
            <input type="password" name="password" id="password" required>
        </div>
        <button type="submit">Đăng nhập</button>
    </form>
</body>
</html>