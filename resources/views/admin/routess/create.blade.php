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
            <div class="col-md-12">
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
                <label for="fullnameInput" class="form-label">Chiều dài</label>
                <input type="text" class="form-control" name="distance_km" placeholder="Nhập chiều dài tuyến đường">
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <label for="exampleFormControlTextarea5" class="form-label">Mô tả xe</label>
                    </div>
                    <div class="card-body">
                        <textarea rows="5" style="width: 100%;border: 1px solid rgb(201, 200, 200); border-radius: 5px; padding: 10px"
                            name="description" placeholder=" Viết mô tả xe ở đây..."></textarea>
                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div>
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
