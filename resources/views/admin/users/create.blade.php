@extends('admin.layouts.mater')
@section('title')
Thêm mới tài khoản
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Thêm mới tài khoản</h4>
        </div>
    </div>
</div>



{{-- Thông báo thành công --}}
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

{{-- Thông báo lỗi --}}
@if (session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

<div class="card">
    <form action="{{ route('admin.users.store') }}" method="POST" class="row g-3 p-5">
        @csrf
        <div class="col-md-6">
            <label for="name" class="form-label">Tên tài khoản <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên tài khoản..." >
            @error('name')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email..." >
            @error('email')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Nhập số điện thoại..." >
            @error('phone')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="password" class="form-label">Mật khẩu <span class="text-danger">*</span></label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu..." >
            @error('password')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="col-md-6">
            <label for="password_confirmation" class="form-label">Xác nhận mật khẩu <span class="text-danger">*</span></label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Xác nhận mật khẩu..." >
            @error('password_confirmation')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="address" class="form-label">Địa chỉ</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Nhập địa chỉ...">
        </div>

        <div class="col-md-6">
            <label for="role" class="form-label">Quyền <span class="text-danger">*</span></label>
            <select class="form-select" id="role" name="name_role" >
                <option value="">Chọn quyền</option> 
                @foreach($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name_role }}</option>
                @endforeach
            </select>
            @error('role')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-12">
            <div class="text-end">
                <button type="submit" class="btn btn-primary">Thêm mới</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Quay lại</a>
            </div>
        </div>
    </form>
</div>
@endsection
