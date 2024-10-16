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
        <form action="{{ route('admin.roles.store') }}" method="POST" class="row g-3 p-5">
            @csrf
            <div class="col-md-6">
                <label for="fullnameInput" class="form-label">Tên quyền</label>
                <input type="text" class="form-control" id="name_role" name="name_role" placeholder="Nhập tên quyền...">
            </div>
            <div class="col-md-6">
                <label for="exampleFormControlTextarea5" class="form-label">Description</label>
                <textarea class="form-control" placeholder="Mô tả chi tiết về quyền" id="exampleFormControlTextarea5" name="description"
                    rows="2"></textarea>
            </div>

            {{-- <div class="form-check form-switch form-switch-primary mt-3">
                <input type="hidden" name="is_active" value="0">
                <input class="form-check-input" type="checkbox" role="switch" id="CheckRole" name="is_active"
                    checked value="1">
                <label class="form-check-label" for="CheckRole">On</label>
            </div> --}}
            <div class="col-12">
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-success">Quay lại</a>
                </div>
            </div>
        </form>
    </div>
    {{-- <script>
        const checkbox = document.getElementById('CheckRole');
        const label = document.querySelector('label[for="CheckRole"]');

        // Cập nhật label và giá trị khi checkbox thay đổi
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                this.value = '1'; // Khi bật, giá trị là 1
                label.textContent = 'On';
            } else {
                this.value = '0'; // Khi tắt, giá trị là 0
                label.textContent = 'Off';
            }
        });
    </script> --}}
@endsection
