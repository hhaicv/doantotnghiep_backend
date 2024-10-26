@extends('admin.layouts.mater')
@section('title')
    Cập nhật lại khuyến mại
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Cập nhật lại khuyến mại</h4>
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
        <form action="{{ route('admin.promotions.update', $data) }}" method="POST" class="row g-3 p-5">
            @csrf
            @method('PUT')
            
            <!-- Mã giảm giá -->
            <div class="col-md-6">
                <label for="codeInput" class="form-label">Mã giảm giá</label>
                <input type="text" class="form-control" name="code" value="{{ $data->code }}">
            </div>
        
            <!-- Mô tả danh mục -->
            <div class="col-md-6">
                <label for="descriptionInput" class="form-label">Mô tả khuyến mãi</label>
                <textarea class="form-control" name="description" rows="2">{{ $data->description }}</textarea>
            </div>
        
            <!-- Giảm giá -->
            <div class="col-md-6">
                <label for="discountInput" class="form-label">Giảm giá</label>
                <input type="number" class="form-control" name="discount" value="{{ $data->discount }}">
            </div>
        
            <!-- Ngày bắt đầu -->
            <div class="col-md-6">
                <label for="startDateInput" class="form-label">Ngày bắt đầu</label>
                <input type="date" class="form-control" name="start_date" placeholder="Ngày bắt đầu" 
                       id="startDateInput" min="{{ date('Y-m-d') }}" value="{{ $data->start_date }}">
            </div>
            
            <div class="col-md-6">
                <label for="endDateInput" class="form-label">Ngày kết thúc</label>
                <input type="date" class="form-control" name="end_date" placeholder="Ngày kết thúc" 
                       id="endDateInput" min="{{ date('Y-m-d') }}" value="{{ $data->end_date }}">
            </div>
            <!-- Tuyến đường (Dropdown) -->
            <div class="col-md-6">
                <label for="routeSelect" class="form-label">Tuyến đường</label>
                <select class="form-control" name="route_id" id="routeSelect">
                    <option value="">Chọn tuyến đường</option>
                    @foreach($routes as $route)
                        <option value="{{ $route->id }}" {{ $data->route_id == $route->id ? 'selected' : '' }}>
                            {{ $route->route_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        
            <!-- Loại xe (Dropdown) -->
            <div class="col-md-6">
                <label for="busTypeSelect" class="form-label">Loại xe</label>
                <select class="form-control" name="bus_type_id" id="busTypeSelect">
                    <option value="">Chọn loại xe</option>
                    @foreach($buses as $bus)
                        <option value="{{ $bus->id }}" {{ $data->bus_type_id == $bus->id ? 'selected' : '' }}>
                            {{ $bus->name_bus }}
                        </option>
                    @endforeach
                </select>
            </div>
            <label for="user_ids">Chọn Người Dùng</label>
            <select name="user_ids[]" id="user_ids" class="form-control" multiple>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ isset($data) && $data->users->contains($user->id) ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
            <!-- Nút submit và quay lại -->
            <div class="col-12">
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.promotions.index') }}" class="btn btn-success">Quay lại</a>
                </div>
            </div>
        </form>
        

    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const startDateInput = document.getElementById('startDateInput');
        const endDateInput = document.getElementById('endDateInput');
        
        // Khi người dùng chọn ngày bắt đầu
        startDateInput.addEventListener('change', function () {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);
            
            // Kiểm tra nếu ngày bắt đầu lớn hơn ngày kết thúc
            if (endDate && startDate > endDate) {
                alert('Ngày bắt đầu không được lớn hơn ngày kết thúc');
                startDateInput.value = ''; // Xóa giá trị không hợp lệ
            }
            
            // Cập nhật giá trị min cho ngày kết thúc
            endDateInput.min = startDateInput.value;
        });

        // Khi người dùng chọn ngày kết thúc
        endDateInput.addEventListener('change', function () {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);

            // Kiểm tra nếu ngày kết thúc nhỏ hơn ngày bắt đầu
            if (startDate && endDate < startDate) {
                alert('Ngày kết thúc không được nhỏ hơn ngày bắt đầu');
                endDateInput.value = ''; // Xóa giá trị không hợp lệ
            }
        });
    });
</script>
