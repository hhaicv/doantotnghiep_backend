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
                <label for="codeInput" class="form-label">Code: </label>
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
                <label for="routeSelect" class="form-label">Tuyến đường</label>
                <select name="route_id" id="routeSelect" class="form-control" multiple>
                    <option value="">Chọn tuyến đường</option>
                    @foreach($routes as $route)
                        <option value="{{ $route->id }}" 
                            {{ isset($promotionRoute) && in_array($route->id, $promotionRoute) ? 'selected' : '' }}>
                            {{ $route->route_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            
            <div class="col-md-6">
                <label for="endDateInput" class="form-label">Ngày kết thúc</label>
                <input type="date" class="form-control" name="end_date" placeholder="Ngày kết thúc" 
                       min="{{ date('Y-m-d') }}">
            </div> 
            <div class="col-md-6">
                <label for="userSelect" class="form-label text-muted">Người dùng:</label>
                <select name="users[]" id="userSelect" class="form-control" multiple>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ in_array($user->id, $promotionUsers ?? []) ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="descriptionInput" class="form-label">Mô tả danh mục</label>
                <textarea class="form-control" placeholder="Mô tả danh mục" name="description" rows="2"></textarea>
            </div>
            <div class="col-md-6">
                <label for="newCustomerOnly" class="form-label">Chỉ áp dụng cho khách hàng mới</label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="newCustomerOnly" name="new_customer_only" value="1">
                    <label class="form-check-label" for="newCustomerOnly">On</label>
                </div>
            </div>
            
            <div class="col-12">
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('admin.promotions.index') }}" class="btn btn-success">Quay lại</a>
                </div>
            </div>
        </form>
        
    </div>
@endsection
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const userSelect = document.getElementById('userSelect');
        const choices = new Choices(userSelect, {
            removeItemButton: true, // Thêm nút xóa cho mỗi mục đã chọn
            placeholderValue: "Chọn người dùng", // Placeholder
            maxItemCount: 5, // Giới hạn số người dùng có thể chọn, nếu cần
        });
    });
    document.addEventListener('DOMContentLoaded', function () {
        const userSelect = document.getElementById('routeSelect');
        const choices = new Choices(userSelect, {
            removeItemButton: true, // Thêm nút xóa cho mỗi mục đã chọn
            placeholderValue: "Chọn tuyến đường", // Placeholder
            maxItemCount: 5, // Giới hạn số người dùng có thể chọn, nếu cần
        });
    });
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
