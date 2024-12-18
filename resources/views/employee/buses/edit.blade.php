@extends('employee.layouts.mater')
@section('title')
    Cập nhật xe
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Cập nhật xe</h4>
            </div>
        </div>
    </div>


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
        <form action="{{ route('employee.buses.update', $model) }}" method="POST" class="row g-3 p-5"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-md-6">
                <label for="fullnameInput" class="form-label">Tên xe</label>
                <input type="text" class="form-control" id="name_bus" name="name_bus" value="{{ $model->name_bus }}">
            </div>
            <div class="col-md-6">
                <label for="fullnameInput" class="form-label">Tên tài xế</label>
                <input type="text" class="form-control" id="model" name="model" value="{{ $model->model }}">
            </div>
            <div class="col-md-6">
                <label for="fullnameInput" class="form-label">Biển số xe</label>
                <input type="text" class="form-control" id="license_plate" name="license_plate"
                    value="{{ $model->license_plate }}">
            </div>
            <div class="col-md-6">
                <label for="fullnameInput" class="form-label">Tài xế</label>
                <select class="form-select" aria-label="Default select example" name="driver_id">
                    @foreach ($drivers as $driver)
                        <option value="{{ $driver->id }}" {{ $model->driver_id == $driver->id ? 'selected' : '' }}>
                            {{ $driver->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col mt-6">
                <div class="filepond-container">
                    <h4>Hình ảnh</h4>
                    <div class="file-drop-area" id="file-drop-area">
                        @if ($model->image)
                            <!-- Kiểm tra nếu hình ảnh đã tồn tại -->
                            <div class="mb-3" id="current-image">
                                <img src="{{ Storage::url($model->image) }}" alt="Current image" width="200">
                            </div>
                        @endif
                        <input type="file" name="image" id="file-input" accept="image/*" multiple>
                        <div id="file-preview"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <label for="start_date">Số lượng ghế</label>
                <input type="number" name="total_seats" id="total_seats" class="form-control"
                    value="{{ $model->total_seats }}">
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <label for="exampleFormControlTextarea5" class="form-label">Mô tả xe</label>
                    </div>
                    <div class="card-body">
                        <textarea rows="5" style="width: 100%;border: 1px solid rgb(201, 200, 200); border-radius: 5px; padding: 10px"
                            name="description">{{ $model->description }}</textarea>
                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div>
            <div class="col-12">
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('employee.buses') }}" class="btn btn-success">Quay lại</a>
                </div>
            </div>
        </form>
    </div>
@endsection
