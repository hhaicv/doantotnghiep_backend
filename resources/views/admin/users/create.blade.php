@extends('admin.layouts.mater')

@section('title')
    Thêm mới tài khoản người dùng
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Thêm mới tài khoản người dùng</h4>
            </div>
        </div>
    </div>


    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công',
                    text: "{{ session('success') }}"
                });
            });
        </script>
    @endif

    @if (session('failes'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Thất bại',
                    text: "{{ session('failes') }}"
                });
            });
        </script>
    @endif

    <div class="card">
        <form action="{{ route('admin.users.store') }}" method="POST" class="row g-3 p-5" enctype="multipart/form-data">
            @csrf

            <div class="col-md-6">
                <label for="nameInput" class="form-label">Tên tài khoản</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                    placeholder="Nhập tên tài khoản">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col md-6">
                <h5>Hình ảnh</h5>
                <div class="file-drop-area" id="file-drop-area">
                    <input type="file" name="image" id="file-input" accept="image/*" value="{{ old('image') }}"
                        multiple>
                    <div id="file-preview"></div>
                </div>
                @error('image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="emailInput" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                    placeholder="Nhập email của bạn">
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="phoneInput" class="form-label">Số điện thoại</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}"
                    placeholder="Nhập số điện thoại">
                @error('phone')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="addressInput" class="form-label">Địa chỉ</label>
                <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}"
                    placeholder="Nhập địa chỉ ">
                @error('address')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="typeInput" class="form-label">Người dùng</label>
                <select class="form-select" id="type" name="type" required>
                    <option value="{{ \App\Models\User::TYPE_EMPLOYEE }}">Employee</option>
                </select>
                @error('type')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="passwordInput" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu">
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="passwordConfirmInput" class="form-label">Xác nhận mật khẩu</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                    placeholder="Xác nhận lại mật khẩu">
                @error('password_confirmation')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="isActiveInput" class="form-label">Kích hoạt</label>
                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
                    {{ old('is_active') ? 'checked' : '' }}>
                @error('is_active')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-12">
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Tạo tài khoản</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Quay lại</a>
                </div>
            </div>
        </form>
    </div>
@endsection
