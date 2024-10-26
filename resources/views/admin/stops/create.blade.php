@extends('admin.layouts.mater')
@section('title')
    Thêm mới Danh mục điểm dừng
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Thêm mới Danh mục điểm dừng </h4>
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
        <form action="{{ route('admin.stops.store') }}" method="POST" class="row g-3 p-5">
            @csrf
            <div class="col-md-6">
                <label for="fullnameInput" class="form-label">Tên điểm dừng</label>
                <input type="text" class="form-control" name="stop_name" placeholder="Nhập tên điểm dừng" value="{{ old('stop_name')}}">
                @error('stop_name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="exampleFormControlTextarea5" class="form-label">Mô tả </label>
                <textarea class="form-control" placeholder="Mô tả điểm dừng" name="description" rows="2">{{ old('description')}}</textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-12">
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('admin.stops.index') }}" class="btn btn-success">Quay lại</a>
                </div>
            </div>
        </form>
    </div>
@endsection
