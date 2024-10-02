@extends('admin.layouts.mater')
@section('title')
    Cập nhật Tiện Ích
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Cập nhật Tiện Ích</h4>
            </div>
        </div>
    </div>
    <div class="card">
        <form action="{{ route('admin.tags.update' , $data) }}" method="POST" class="row g-3 p-5">
            @csrf
            @method('PUT')
            <div class="col-md-12">
                <label for="fullnameInput" class="form-label">Tiện Ích</label>
                <input type="text" class="form-control" id="name" name="name" value="{{$data->name}}">
            </div>
            <div class="col-md-6">
                <label for="fullnameInput" class="form-label">Icon</label>
                <input type="text" class="form-control" id="icon" name="icon" value="{{$data->icon}}">
            </div>
            <div class="col-md-6">
                <label for="exampleFormControlTextarea5" class="form-label">Mô tả</label>
                <textarea class="form-control" id="exampleFormControlTextarea5" name="description" rows="2">{{$data->description}}</textarea>
            </div>
            <div class="col-12">
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
@endsection
