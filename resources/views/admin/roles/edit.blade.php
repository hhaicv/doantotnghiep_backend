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
        <form action="{{ route('admin.roles.update', $model) }}" method="POST" class="row g-3 p-5">
            @csrf
            @method('PUT')
            <div class="col-md-12">
                <label for="fullnameInput" class="form-label">Tên quyền</label>
                <input type="text" class="form-control" id="name_role" name="name_role" value="{{ $model->name_role }}">
            </div>
            <div class="col-md-12">
                <label for="exampleFormControlTextarea5" class="form-label">Mô tả</label>
                <textarea class="form-control" id="exampleFormControlTextarea5" name="description" rows="2">{{ $model->description }}</textarea>
            </div>
            {{-- <div class="form-check form-switch form-switch-primary mt-3">
                <input type="hidden" name="is_active" value="0">
                <input class="form-check-input" type="checkbox" role="switch" id="CheckRoles" name="is_active"
                    {{ $model->is_active ? 'checked' : '' }} value="1" onchange="toggleLabel()">
                <label class="form-check-label" id="statusLabel" for="CheckRoles">
                    {{ $model->is_active ? 'On' : 'Off' }}
                </label>
            </div> --}}
            <div class="col-12">
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-success">Quay lại</a>
                </div>
            </div>
        </form>
    </div>
    {{-- <script>
        // JavaScript để cập nhật nhãn khi bật/tắt checkbox
        function toggleLabel() {
            var checkbox = document.getElementById('CheckRoles');
            var label = document.getElementById('statusLabel');

            if (checkbox.checked) {
                label.textContent = 'On';
            } else {
                label.textContent = 'Off';
            }
        }
    </script> --}}
@endsection
