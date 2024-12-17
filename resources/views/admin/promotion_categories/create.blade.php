@extends('admin.layouts.mater')
@section('title')
    Thêm mới Danh mục khuyến mãi
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Thêm mới Danh mục khuyến mãi</h4>
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
        <form action="{{ route('admin.promotion_categories.store') }}" method="POST" class="row g-3 p-5">
            @csrf
            <div class="col-md-6">
                <label for="codeInput" class="form-label">Tên tiêu đề</label>
                <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Nhập tên tiêu đề">
                @error('title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="codeInput" class="form-label">Mô tả</label>
                <input type="text" class="form-control" name="description" value="{{ old('description') }}" placeholder="Nhập mô tả">
                @error('title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-12 text-end">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('admin.promotion_categories.index') }}" class="btn btn-success">Quay lại</a>
            </div>
        </form>
    </div>
@endsection

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

