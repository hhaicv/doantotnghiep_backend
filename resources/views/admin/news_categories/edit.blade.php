@extends('admin.layouts.mater')
@section('title')
    Update Tiện Ích
@endsection
@section('content')
    <div class="row" style="margin-bottom: 20px">
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
    </div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                {{-- <h4 class="mb-sm-0">Thêm Danh mục tin tức </h4> --}}
            </div>
        </div>
    </div>
    <div class="card">
        <form action="{{ route('admin.newcategories.update',$data->id) }}" method="POST"  class="row g-3 p-5">
            @csrf
            @method('PUT')
            <div class="col-md-12">
                <label for="fullnameInput" class="form-label">Tên Danh mục</label>
                <input type="text" class="form-control"  name="category_name" placeholder="category_name" value="{{ $data ->category_name }}">
            </div>
            <div class="col-12">
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.newcategories.index') }}" class="btn btn-success">Quay lại</a>
                </div>

            </div>
        </form>
    </div>
@endsection
