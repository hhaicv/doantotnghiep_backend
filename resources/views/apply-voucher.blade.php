<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Áp dụng mã khuyến mãi</title>

    <!-- CSS -->
    @vite(['resources/css/app.css'])

    <!-- Import Bootstrap CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Import Pusher JavaScript -->
    {{-- <script src="https://js.pusher.com/7.2/pusher.min.js"></script> --}}
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Áp dụng mã khuyến mãi</h1>

        <!-- Hiển thị thông báo -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Thành công!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Thất bại!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Form nhập mã khuyến mãi -->
        <div class="card p-4 shadow-sm">
            <form action="{{ route('apply-voucher') }}" method="POST">
                @csrf
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

    @vite(['resources/js/public.js'])
</body>
</html>
