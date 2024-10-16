@extends('admin.layouts.mater')
@section('title')
    Cập nhật lại Banner
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Cập nhật lại Banner</h4>
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
        <form action="{{ route('admin.banners.update', $model) }}" method="POST" class="row g-3 p-5" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-md-6">
                <label for="fullnameInput" class="form-label">Hình ảnh</label>
                <input type="file" name="image_url">
                <img src="{{ Storage::url($model->image_url)}}" alt="" width="200px" height="100px">
            </div>
            <div class="col-md-6">
                <label for="fullnameInput" class="form-label">Link banner</label>
                <input type="text" class="form-control" id="link" name="link" value="{{ $model->link }}">
            </div>
            <div class="col-md-6">
                <label for="start_date">Ngày bắt đầu</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $model->start_date}}">
            </div>
            <div class="col-md-6">
                <label for="end_date">Ngày kết thúc</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $model->end_date}}">
            </div>
            <div class="col-12">
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.banners.index') }}" class="btn btn-success">Quay lại</a>
                </div>
            </div>
        </form>
    </div>
@endsection
