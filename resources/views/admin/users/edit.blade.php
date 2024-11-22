@extends('admin.layouts.mater')

@section('title')
    Chỉnh sửa tài khoản
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Chỉnh sửa tài khoản</h4>
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
        <form action="{{ route('admin.users.update', $model->id) }}" method="POST" class="row g-3 p-5"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="col-md-6">
                <label for="nameInput" class="form-label">Tên tài khoản</label>
                <input type="text" class="form-control" id="name" name="name"
                    value="{{ old('name', $model->name) }}">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-6">
                <h5>Hình ảnh</h5>
                <div class="file-drop-area" id="file-drop-area">
                    <input type="file" name="image" id="file-input" accept="image/*" multiple>
                    <div id="file-preview">
                        @if ($model->image)
                            <img src="{{ Storage::url($model->image) }}" alt="Ảnh đã tải lên" width="200px" height="150px">
                        @endif
                    </div>
                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <label for="emailInput" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" disabled
                    value="{{ old('email', $model->email) }}">

            </div>
            <div class="col-md-6">
                <label for="phoneInput" class="form-label">Số điện thoại</label>
                <input type="text" class="form-control" id="phone" name="phone"
                    value="{{ old('phone', $model->phone) }}">
                @error('phone')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="addressInput" class="form-label">Địa chỉ</label>
                <input type="text" class="form-control" id="address" name="address"
                    value="{{ old('address', $model->address) }}">
                @error('address')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="roleInput" class="form-label">Quyền</label>
                <select class="form-select" id="name_role" name="name_role" required>
                    <option value="">Chọn quyền</option>
                    <option value="employee" {{ old('name_role', $model->type) === 'employee' ? 'selected' : '' }}>Nhân
                        viên
                    </option>
                    <option value="user" {{ old('name_role', $model->type) === 'user' ? 'selected' : '' }}>Người dùng
                    </option>
                </select>
            </div>

            <div class="col-md-6">
                <label for="passwordInput" class="form-label">Mật khẩu (để trống nếu không muốn thay đổi)</label>
                <input type="password" class="form-control" id="password" name="password"
                    placeholder="Nhập mật khẩu mới...">
            </div>

            <div class="col-md-6">
                <label for="passwordConfirmInput" class="form-label">Xác nhận mật khẩu</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                    placeholder="Xác nhận mật khẩu mới...">
            </div>

            <div class="col-12">
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Quay lại</a>
                </div>
            </div>
        </form>
    </div>
@endsection
