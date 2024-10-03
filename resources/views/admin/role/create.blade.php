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
        <form action="{{ route('admin.role.store') }}" method="POST" class="row g-3 p-5">
            @csrf
            <div class="col-md-12">
                <label for="fullnameInput" class="form-label">Tên quyền</label>
                <input type="text" class="form-control" id="name_role" name="name_role" placeholder="Nhập tên quyền...">
            </div>
            <div class="col-md-12">
                <label for="exampleFormControlTextarea5" class="form-label">Description</label>
                <textarea class="form-control" placeholder="Mô tả chi tiết về quyền" id="exampleFormControlTextarea5" name="description"
                    rows="2"></textarea>
            </div>

            <div class="col-12">
                <div class="text-end">
                    <a href="{{route("admin.role.index")}}">Trang chủ</a>
                    <button type="submit" class="btn btn-outline-info">Submit</button>
                </div>
            </div>
        </form>
    </div>
@endsection
