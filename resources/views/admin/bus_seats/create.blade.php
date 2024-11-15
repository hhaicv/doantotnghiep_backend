@extends('admin.layouts.mater')
@section('title')
    Thêm mới Ghế xe
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Thêm mới Ghế xe </h4>
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
        <form action="{{ route('admin.bus_seats.store') }}" method="POST" class="row g-3 p-5">
            @csrf
            <div class="col-md-5">
                <label for="fullnameInput" class="form-label">Tên xe</label>
                <select class="form-select" aria-label="Default select example" name="bus_id">
                    @foreach ($buses as $bus)
                        <option value="{{ $bus->id }}" {{ old('bus_id') == $bus->id ? 'selected' : '' }}>{{ $bus->name_bus }} - {{ $bus->license_plate }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="fullnameInput" class="form-label">Tên ghế</label>
                <input type="text" class="form-control" name="seat_name" placeholder="Nhập tên ghế xe">
            </div>
            <div class="col-12">
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('admin.bus_seats.index') }}" class="btn btn-success">Quay lại</a>
                </div>
            </div>
        </form>
    </div>
@endsection
