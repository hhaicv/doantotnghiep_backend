@extends('admin.layouts.mater')
@section('title')
    Cập nhật điểm dừng
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Cập nhật lại điểm dừng</h4>
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
        <form action="{{ route('admin.stops.update', $data->id) }}" method="POST" class="row g-3 p-5">
            @csrf
            @method('PUT')
        
            <!-- Tên điểm dừng -->
            <div class="col-md-6">
                <label for="stopNameInput" class="form-label">Tên điểm dừng</label>
                <input type="text" id="stopNameInput" class="form-control" name="stop_name" value="{{ old('stop_name', $data->stop_name) }}" required>
            </div>
        
            <!-- Chọn Điểm Dừng Cha -->
            <div class="col-md-6">
                <label for="parent_id" class="form-label">Điểm dừng cha (Tùy chọn):</label>
                <select name="parent_id" id="parent_id" class="form-select" onchange="filterChildStops()">
                    <option value="">Không có</option>
                    @foreach($parents as $parent)
                        <option value="{{ $parent->id }}" {{ old('parent_id', $data->parent_id) == $parent->id ? 'selected' : '' }}>
                            {{ $parent->stop_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        
            <!-- Chọn hoặc Chỉnh sửa Điểm Dừng Con -->
            <div class="col-md-6">
                <label for="child_id" class="form-label">Điểm dừng con (Tùy chọn):</label>
                <select name="child_id" id="child_id" class="form-select">
                    <option value="">Không có</option>
                    @foreach($children as $child)
                        <option value="{{ $child->id }}" data-parent-id="{{ $child->parent_id }}" 
                                {{ old('child_id', $data->child_id) == $child->id ? 'selected' : '' }}>
                            {{ $child->stop_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        
            <!-- Mô tả -->
            <div class="col-md-12">
                <label for="description" class="form-label">Mô tả</label>
                <textarea id="description" class="form-control" name="description" rows="3" required>{{ old('description', $data->description) }}</textarea>
            </div>
        
            <!-- Nút hành động -->
            <div class="col-12">
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="{{ route('admin.stops.index') }}" class="btn btn-success">Quay lại</a>
                </div>
            </div>
        </form>
        
    </div>
@endsection


<script>
    function filterChildStops() {
        const parentId = document.getElementById("parent_id").value;
        const childSelect = document.getElementById("child_id");

        // Show only child stops that match the selected parent ID
        Array.from(childSelect.options).forEach(option => {
            if (option.getAttribute("data-parent-id") === parentId) {
                option.hidden = false;
            } else {
                option.hidden = true;
            }
        });

        // Reset child selection if the parent ID has changed
        if (!parentId) {
            childSelect.value = "";
        }
    }

    // Initialize the child stops field based on preloaded data on page load
    window.onload = function() {
        filterChildStops();
    };
</script>