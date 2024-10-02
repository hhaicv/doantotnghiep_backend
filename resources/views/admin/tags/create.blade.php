@extends('admin.layouts.mater')
@section('title')
    Thêm mới Tiện Ích
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Thêm mới Tiện Ích </h4>
            </div>
        </div>
    </div>
    <div class="card">
    <form action="{{ route('admin.tags.store') }}" method="POST"  class="row g-3 p-5">
        @csrf
        <div class="col-md-12">
            <label for="fullnameInput" class="form-label">Tiện Ích</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tiện ích">
        </div>
        <div class="col-md-6">
            <label for="fullnameInput" class="form-label">Icon</label>
            <input type="text" class="form-control" id="icon" name="icon" placeholder="Nhập icon">
        </div>
        <div class="col-md-6">
            <label for="exampleFormControlTextarea5" class="form-label">Mô tả</label>
            <textarea class="form-control" placeholder="Mô tả chi tiết" id="exampleFormControlTextarea5" name="description" rows="2"></textarea>
        </div>

        <div class="col-12">
            <div class="text-end">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
    </div>
@endsection
