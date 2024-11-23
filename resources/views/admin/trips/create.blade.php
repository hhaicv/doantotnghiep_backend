@extends('admin.layouts.mater')
@section('title')
    Thêm mới Chuyến xe
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Thêm mới Chuyến xe </h4>
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
        <form action="{{ route('admin.trips.store') }}" method="POST" class="row g-3 p-5">
            @csrf
            <div class="col-md-6">
                <label for="fullnameInput" class="form-label">Tuyến đường</label>
                <select class="form-select" aria-label="Default select example" name="route_id">
                    @foreach ($routes as $route)
                        <option value="{{ $route->id }}" {{ old('route_id') == $route->id ? 'selected' : '' }}>
                            {{ $route->route_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="exampleFormControlTextarea5" class="form-label">Thời gian bắt đầu</label>
                <input type="text" class="form-control" name="start_time" placeholder="hh:mm" id="cleave-time-start"
                    value="{{ old('start_time') }}">
                @error('start_time')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-3">
                <label for="exampleFormControlTextarea5" class="form-label">Thời gian kết thúc</label>
                <input type="text" class="form-control" name="end_time" placeholder="hh:mm" id="cleave-time-end"
                    value="{{ old('end_time') }}">
                @error('end_time')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-12">
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('admin.trips.index') }}" class="btn btn-success">Quay lại</a>
                </div>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>

    <script>
        // Khởi tạo định dạng thời gian cho daily_start_time
        var cleaveTimeStart = new Cleave("#cleave-time-start", {
            time: true,
            timePattern: ["h", "m"]
        });

        // Khởi tạo định dạng thời gian cho daily_end_time
        var cleaveTimeEnd = new Cleave("#cleave-time-end", {
            time: true,
            timePattern: ["h", "m"]
        });
    </script>
@endsection
