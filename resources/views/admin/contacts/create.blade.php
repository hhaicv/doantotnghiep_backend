@extends('admin.layouts.mater')
@section('title')
    Thêm mới Tiện Ích
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
                <h4 class="mb-sm-0">Thêm Liên Hệ </h4>
            </div>
        </div>
    </div>
    <div class="card">
        <form action="{{ route('admin.contacts.store') }}" method="POST"  class="row g-3 p-5">
            @csrf
            <div class="col-md-12">
                <label for="fullnameInput" class="form-label">Tên</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Tên">
            </div>
            <div class="col-md-6">
                <label for="fullnameInput" class="form-label">Email</label>
                <input type="email" class="form-control" id="icon" name="email" placeholder="Nhập email">
            </div>
            <div class="col-md-6">
                <label for="fullnameInput" class="form-label">Phone</label>
                <input type="number" class="form-control" id="icon" name="phone" placeholder="Nhập số điện thoại">
            </div>
            <div class="col">
                <label for="exampleFormControlTextarea5" class="form-label">Mô tả</label>
                <textarea class="form-control" placeholder="Mô tả chi tiết" id="exampleFormControlTextarea5" name="message" rows="2"></textarea>
            </div>

            <div class="col-12">
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('admin.contacts.index') }}" class="btn btn-success">Quay lại</a>
                </div>
            </div>
        </form>
    </div>
@endsection
