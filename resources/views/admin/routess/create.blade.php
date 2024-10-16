@extends('admin.layouts.mater')
@section('title')
    Thêm mới tuyến đường
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Thêm mới tuyến đường</h4>
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
        <form action="{{ route('admin.routes.store') }}" method="POST" class="row g-3 p-5">
            @csrf
            <div class="col-md-6">
                <label for="fullnameInput" class="form-label">Tên tuyến đường</label>
                <input type="text" class="form-control" name="route_name" placeholder="Nhập tên tuyến đường">
            </div>
            <div class="col-md-6">
                <label for="fullnameInput" class="form-label">Điểm bắt đầu</label>
                <input type="text" class="form-control" name="start_route" placeholder="Nhập điểm bắt đầu">
            </div>
            <div class="col-md-6">
                <label for="fullnameInput" class="form-label">Điểm kết thúc</label>
                <input type="text" class="form-control" name="end_route" placeholder="Nhập điểm kết thúc">
            </div>
            <div class="col-md-6">
                <label for="fullnameInput" class="form-label">Thời gian</label>
                <input type="text" class="form-control" name="execution_time" placeholder="Nhập thời gian">
            </div>
            <div class="col-md-6">
                <label for="fullnameInput" class="form-label">Hệ số</label>
                <input type="text" class="form-control" name="base_fare_per_km" placeholder="Nhập hệ số">
            </div>
            <div class="col-md-6">
                <label for="fullnameInput" class="form-label">Chiều dài</label>
                <input type="text" class="form-control" name="distance_km" placeholder="Nhập chiều dài tuyến đường">
            </div>
            {{-- <div class="col-md-6">
                <label for="exampleFormControlTextarea5" class="form-label">Mô tả danh mục</label>
                <textarea class="form-control" placeholder="Mô tả danh mục" name="description" rows="2"></textarea>
            </div> --}}
            {{-- <div class="form-check form-switch form-switch-primary mt-3">
                <input type="hidden" name="is_active" value="0">
                <input class="form-check-input" type="checkbox" role="switch" id="CheckNewCategory" name="is_active"
                    checked value="1">
                <label class="form-check-label" for="CheckNewCategory">On</label>
            </div> --}}
            <div class="col-12">
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('admin.routes.index') }}" class="btn btn-success">Quay lại</a>
                </div>
            </div>
        </form>
    </div>


    <script>
        const checkbox = document.getElementById('CheckRoute');
        const label = document.querySelector('label[for="CheckRoute"]');

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
    </script>

@endsection
