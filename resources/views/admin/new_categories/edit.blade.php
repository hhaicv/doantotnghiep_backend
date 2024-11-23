@extends('admin.layouts.mater')
@section('title')
    Cập nhật lại phân quyền
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Cập nhật lại phân quyền</h4>
            </div>
        </div>
    </div>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công',
                    text: "{{ session('success') }}"
                });
            });
        </script>
    @endif

    @if (session('failes'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Thất bại',
                    text: "{{ session('failes') }}"
                });
            });
        </script>
    @endif

    <div class="card">
        <form action="{{ route('admin.new_categories.update', $data) }}" method="POST" class="row g-3 p-5">
            @csrf
            @method('PUT')
            <div class="col-md-6">
                <label for="fullnameInput" class="form-label">Tên danh mục</label>
                <input type="text" class="form-control" name="name" value="{{ $data->name }}">
            </div>
            <div class="col-md-6">
                <label for="exampleFormControlTextarea5" class="form-label">Mô tả danh mục</label>
                <textarea class="form-control" name="description" rows="2">{{ $data->description }}</textarea>
            </div>
            <div class="col-12">
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.new_categories.index') }}" class="btn btn-success">Quay lại</a>
                </div>
            </div>
        </form>
    </div>
@endsection
