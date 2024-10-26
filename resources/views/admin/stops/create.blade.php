@extends('admin.layouts.mater')
@section('title')
    Thêm mới Danh mục điểm dừng
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Thêm mới Danh mục điểm dừng </h4>
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
        <form action="{{ route('admin.stops.store') }}" method="POST" class="row g-3 p-5">
            @csrf

            <div class="col-md-6">
                <label for="fullnameInput" class="form-label">Tên điểm dừng</label>
                <input type="text" class="form-control" name="stop_name" placeholder="Nhập tên điểm dừng" required>
            </div>


            <div class="col-md-6">
                <label for="exampleFormControlTextarea5" class="form-label">Mô tả</label>
                <textarea class="form-control" placeholder="Mô tả điểm dừng" name="description" rows="2"></textarea>
            </div>


            <div class="col-md-6">
                <label for="parent_stop" class="form-label">Chọn điểm dừng cha (Optional)</label>
                <select class="form-select" name="parent_id" id="parent_stop">
                    <option value="">None (This is a Parent Stop)</option>
                    @foreach($parents as $stop)
                        <option value="{{ $stop->id }}">{{ $stop->stop_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 text-end">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('admin.stops.index') }}" class="btn btn-success">Quay lại</a>
            </div>
        </form>


        <script>
            document.getElementById('add-child-stop').addEventListener('click', function () {
                const container = document.getElementById('child-stops-container');
                const childStopHtml = `
                    <div class="child-stop">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="child_stop_name[]" class="form-label">Tên điểm dừng con</label>
                                <input type="text" class="form-control" name="child_stop_name[]" placeholder="Tên điểm dừng con" required>
                            </div>
                            <div class="col-md-6">
                                <label for="child_description[]" class="form-label">Mô tả điểm dừng con</label>
                                <input type="text" class="form-control" name="child_description[]" placeholder="Mô tả điểm dừng con">
                            </div>
                        </div>
                        <button type="button" class="btn btn-danger mt-2 remove-child-stop">Remove</button>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', childStopHtml);
            });

            document.addEventListener('click', function (event) {
                if (event.target.classList.contains('remove-child-stop')) {
                    event.target.closest('.child-stop').remove();
                }
            });
        </script>
