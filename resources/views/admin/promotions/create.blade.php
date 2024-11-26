@extends('admin.layouts.mater')
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
                <label for="codeInput" class="form-label">Tiêu đề</label>
                <input type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="Nhập tiêu đề">
                @error('title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col md-6">
                <h5>Hình ảnh</h5>
                <div class="file-drop-area" id="file-drop-area">
                    <input type="file" name="image" id="file-input" accept="image/*" value="{{ old('image') }}"
                        multiple>
                    <div id="file-preview"></div>
                </div>
                @error('image')
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
                <label for="routeSelect" class="form-label">Tuyến đường</label>
                <select name="routes[]" id="routeSelect" class="form-control" multiple>
                    <option value="">Chọn tuyến đường</option>
                    @foreach ($routes as $route)
                        <option value="{{ $route->id }}" {{ isset($promotionRoute) && in_array($route->id, $promotionRoute) ? 'selected' : '' }}>
                            {{ $route->route_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="descriptionInput" class="form-label">Mô tả khuyến mãi</label>
                <textarea class="form-control" placeholder="Mô tả khuyến mãi" name="description" rows="2">{{ old('description') }}</textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
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
            </div>

            {{-- <div class="col-md-6">
                <label for="newCustomerOnly" class="form-label">Chỉ áp dụng cho khách hàng mới</label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="newCustomerOnly" name="new_customer_only" value="1">
                    <label class="form-check-label" for="newCustomerOnly">On</label>
                </div>
            </div> --}}

            <div class="col-12 text-end">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('admin.promotions.index') }}" class="btn btn-success">Quay lại</a>
            </div>
        </form>
    </div>
@endsection

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const userSelect = new Choices('#userSelect', {
            removeItemButton: true,
            placeholderValue: "Chọn người dùng",
            maxItemCount: 5,
        });

        const routeSelect = new Choices('#routeSelect', {
            removeItemButton: true,
            placeholderValue: "Chọn tuyến đường",
            maxItemCount: 5,
        });
    });
</script>
