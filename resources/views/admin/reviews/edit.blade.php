@extends('admin.layouts.mater')
@section('title')
    Cập nhật lại đánh giá
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Cập nhật lại đánh giá</h4>
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
        <form action="{{ route('admin.reviews.update', $data) }}" method="POST" class="row g-3 p-5">
            @csrf
            @method('PUT')
            <div class="col-md-5">
                <label for="fullnameInput" class="form-label">Tuyến đường</label>
                <select class="form-select" aria-label="Default select example" name="route_id">
                    @foreach ($routes as $route)
                        <option value="{{ $route->id }}" {{ $route->id == $data->route_id ? 'selected' : '' }}>
                            {{ $route->route_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-5">
                <label for="fullnameInput" class="form-label">Xe</label>
                <select class="form-select" aria-label="Default select example" name="bus_id">
                    @foreach ($buses as $bus)
                    <option value="{{ $bus->id }}" {{ $bus->id == $data->bus_id ? 'selected' : '' }}>
                        {{ $bus->name_bus }} - {{ $bus->license_plate }}
                    </option>
                @endforeach
                </select>
            </div>
            
            <div class="col-12">
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.reviews.index') }}" class="btn btn-success">Quay lại</a>
                </div>
            </div>
        </form>
    </div>
@endsection
