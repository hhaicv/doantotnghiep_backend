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

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

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

<div class="card">
    <form action="{{ route('admin.users.update', $model->id) }}" method="POST" class="row g-3 p-5">
        @csrf
        @method('PUT')

        <div class="col-md-6">
            <label for="nameInput" class="form-label">Tên tài khoản</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $model->name) }}" required>
        </div>
        <div class="col-md-6">
            <label for="emailInput" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" disabled value="{{ old('email', $model->email) }}" required>
        </div>
        <div class="col-md-6">
            <label for="phoneInput" class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $model->phone) }}" required>
        </div>

        <div class="col-md-6">
            <label for="addressInput" class="form-label">Địa chỉ</label>
            <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $model->address) }}">
        </div>
        <div class="col-md-6">
            <label for="roleInput" class="form-label">Quyền</label>
            <select class="form-select" id="name_role" name="name_role" required>
                <option value="">Chọn quyền</option>
                <option value="employee" {{ $model->type === 'isEmployee' ? 'selected' : '' }}>Nhân viên</option>
                <option value="user" {{ $model->type === 'isUser' ? 'selected' : '' }}>Người dùng</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="passwordInput" class="form-label">Mật khẩu (để trống nếu không muốn thay đổi)</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu mới...">
        </div>

        <div class="col-md-6">
            <label for="passwordConfirmInput" class="form-label">Xác nhận mật khẩu</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Xác nhận mật khẩu mới...">
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
