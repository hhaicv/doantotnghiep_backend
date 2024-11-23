@extends('admin.layouts.mater')

@section('title')
    Thêm mới tài khoản quản trị
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Thêm mới quản trị</h4>
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
        <form action="{{ route('admin.admins.store') }}" method="POST" class="row g-3 p-5">
            @csrf

            <div class="col-md-6">
                <label for="nameInput" class="form-label">Tên tài khoản</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            </div>
            <div class="col-md-6">
                <label for="emailInput" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="col-md-6">
                <label for="roleInput" class="form-label">Quyền</label>
                <select class="form-select" id="name_role" name="name_role">
                    <option disabled>Chọn Quyền</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name_role }}" {{ old('name_role') == $role->name_role ? 'selected' : '' }}>{{ $role->name_role }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="passwordInput" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" id="password" name="password" required placeholder="Nhập mật khẩu...">
            </div>

            <div class="col-md-6">
                <label for="passwordConfirmInput" class="form-label">Xác nhận mật khẩu</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="Xác nhận mật khẩu...">
            </div>

            <div class="col-12">
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                    <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">Quay lại</a>
                </div>
            </div>
        </form>
    </div>
@endsection