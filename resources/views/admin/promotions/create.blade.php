@extends('admin.layouts.mater')
@section('title')
    Thêm mới Danh mục khuyến mãi
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Thêm mới Danh mục khuyến mãi </h4>
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
        <form action="{{ route('admin.promotions.store') }}" method="POST" class="row g-3 p-5">
            @csrf
            <div class="col-md-6">
                <label for="codeInput" class="form-label">Code</label>
                <input type="text" class="form-control" name="code" placeholder="Nhập code">
            </div>
            <div class="col-md-6">
                <label for="discountInput" class="form-label">Discount (%)</label>
                <input type="text" class="form-control" name="discount" placeholder="Nhập %">
            </div>
            <div class="col-md-6">
                <label for="startDateInput" class="form-label">Ngày bắt đầu</label>
                <input type="date" class="form-control" name="start_date" placeholder="Ngày bắt đầu" 
                       min="{{ date('Y-m-d') }}">
            </div>
            
            <div class="col-md-6">
                <label for="endDateInput" class="form-label">Ngày kết thúc</label>
                <input type="date" class="form-control" name="end_date" placeholder="Ngày kết thúc" 
                       min="{{ date('Y-m-d') }}">
            </div>
            <div class="col-md-6">
                <label for="userSelect" class="form-label">Người dùng</label>
                <select name="user_id" id="userSelect" class="form-control" required>
                    <option value="">Chọn người dùng</option> <!-- Option mặc định -->
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} <!-- Hoặc bất kỳ thuộc tính nào bạn muốn hiển thị -->
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="descriptionInput" class="form-label">Mô tả danh mục</label>
                <textarea class="form-control" placeholder="Mô tả danh mục" name="description" rows="2"></textarea>
            </div>
            <!-- Tuyến đường -->
            <div class="col-md-6">
                <label for="routeSelect" class="form-label">Tuyến đường</label>
                <select class="form-control" name="route_id" id="routeSelect">
                    <option value="">Chọn tuyến đường</option>
                    @foreach($routes as $route)
                        <option value="{{ $route->id }}">{{ $route->route_name }}</option>
                    @endforeach
                </select>
            </div>
        
            <!-- Loại xe -->
            <div class="col-md-6">
                <label for="busTypeSelect" class="form-label">Loại xe</label>
                <select class="form-control" name="bus_type_id" id="busTypeSelect">
                    <option value="">Chọn xe</option>
                    @foreach($buses as $bus)
                        <option value="{{ $bus->id }}">{{ $bus->name_bus }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="new_customer_only" id="newCustomerOnly" value="1">
                <label class="form-check-label" for="newCustomerOnly">Chỉ áp dụng cho khách hàng mới</label>
            </div>
            <input type="hidden" name="new_customer_only" value="0">
        
            <div class="col-12">
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
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
