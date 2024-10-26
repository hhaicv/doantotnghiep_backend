@extends('admin.layouts.mater')
@section('title')
    Thêm mới Phân quyền
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Thêm mới Phân quyền </h4>
            </div>
        </div>
    </div>
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
        <form action="{{ route('admin.roles.store') }}" method="POST" class="row g-3 p-5">
            @csrf
            <div class="col-md-6">

                <label for="name_role" class="form-label">Tên quyền</label>
                <input type="text" class="form-control" id="name_role" name="name_role" placeholder="Nhập tên quyền..."
                    value="{{ old('name_role') }}">
                @error('name_role')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" placeholder="Mô tả chi tiết về quyền" id="description" name="description" rows="2">{{ old('description') }}</textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-12">
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-success">Quay lại</a>
                </div>
            </div>
        </form>
    </div>
@endsection
