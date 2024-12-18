@extends('employee.layouts.mater')
@section('title')
    Thêm mới Danh mục khuyến mãi
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Thêm mới Danh mục khuyến mãi</h4>
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
        <form action="{{ route('admin.promotions.store') }}" method="POST" class="row g-3 p-5" enctype="multipart/form-data">
            @csrf
            <div class="col-md-6">
                <label for="codeInput" class="form-label">Tiêu đề</label>
                <input type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="Nhập tiêu đề">
                @error('title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="promotion_category_id" class="form-label">Danh mục khuyến mãi</label>
                <select name="promotion_category_id" id="promotion_category_id" class="form-control">
                    <option value="">Chọn danh mục khuyến mãi</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('promotion_category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('promotion_category_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="codeInput" class="form-label">Mã giảm giá</label>
                <input type="text" class="form-control" name="code" value="{{ old('code') }}" placeholder="Nhập mã giảm giá">
                @error('code')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="col-md-6">
                <label for="discountInput" class="form-label">Phần trăm giảm</label>
                <input type="number" class="form-control" name="discount" id="discountInput" value="{{ old('discount') }}"
                    placeholder="Nhập % giảm" min="1" max="100" oninput="validateDiscount()">
                @error('discount')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="startDateInput" class="form-label">Ngày bắt đầu</label>
                <input type="date" class="form-control" name="start_date" value="{{ old('start_date') }}" placeholder="Ngày bắt đầu"
                    min="{{ date('Y-m-d') }}">
                @error('start_date')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="codeInput" class="form-label">Số lượng</label>
                <input type="number" class="form-control" name="count" value="{{ old('count') }}" placeholder="Nhập số lượng">
                @error('count')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="col-md-6">
                <label for="endDateInput" class="form-label">Ngày kết thúc</label>
                <input type="date" class="form-control" name="end_date" value="{{ old('end_date') }}" placeholder="Ngày kết thúc"
                    min="{{ date('Y-m-d') }}">
                @error('end_date')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="descriptionInput" class="form-label">Mô tả khuyến mãi</label>
                <textarea class="form-control" placeholder="Mô tả khuyến mãi" name="description" rows="2">{{ old('description') }}</textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="routeSelect" class="form-label">Tuyến đường</label>
                <select name="routes[]" id="routeSelect" class="form-control" multiple>
                    @foreach ($routes as $route)
                        <option value="{{ $route->id }}" {{ isset($promotionRoute) && in_array($route->id, $promotionRoute) ? 'selected' : '' }}>
                            {{ $route->route_name }}
                        </option>
                    @endforeach
                </select>
                <button type="button" class="btn btn-secondary btn-sm mt-2" id="selectAllRoutes">Chọn tất cả tuyến đường</button>
            </div>
        
            <div class="col-md-6">
                <label for="userSelect" class="form-label">Người dùng</label>
                <select name="users[]" id="userSelect" class="form-control" multiple>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ in_array($user->id, $promotionUsers ?? []) ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
                <button type="button" class="btn btn-secondary btn-sm mt-2" id="selectAllUsers">Chọn tất cả người dùng</button>
            </div>

            <div class="col-md-6">
                <h5>Hình ảnh</h5>
                <div class="file-drop-area" id="file-drop-area">
                    <input type="file" name="image" id="file-input" accept="image/*" value="{{ old('image') }}">
                    <div id="file-preview"></div>
                </div>
                @error('image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="contentInput" class="form-label">Nội dung</label>
                <textarea class="form-control" placeholder="Nội dung" name="content" rows="2">{{ old('content') }}</textarea>
                @error('content')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
    
            <div class="col-12 text-end">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('employee.promotions') }}" class="btn btn-success">Quay lại</a>
            </div>
        </form>
    </div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Choices.js for Tuyến đường
        const routeSelect = new Choices('#routeSelect', {
            removeItemButton: true,
            placeholderValue: "Chọn tuyến đường",
            maxItemCount: -1,
        });

        document.getElementById('selectAllRoutes').addEventListener('click', function () {
            const allOptions = Array.from(document.querySelectorAll('#routeSelect option')).map(option => option.value);
            routeSelect.setChoiceByValue(allOptions);
        });

        // Initialize Choices.js for Người dùng
        const userSelect = new Choices('#userSelect', {
            removeItemButton: true,
            placeholderValue: "Chọn người dùng",
            maxItemCount: -1,
        });

        document.getElementById('selectAllUsers').addEventListener('click', function () {
            const allOptions = Array.from(document.querySelectorAll('#userSelect option')).map(option => option.value);
            userSelect.setChoiceByValue(allOptions);
        });
    });
</script>
