@extends('admin.layouts.mater')
@section('title')
    Thêm mới tuyến đường
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Thêm mới tuyến đường</h4>
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
    <form id="createproduct-form" autocomplete="off" class="needs-validation" novalidate
        action="{{ route('admin.routes.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body row p-4">
                        <div class="col-md-12">
                            <label for="fullnameInput" class="form-label">Tên tuyến đường</label>
                            <input type="text" class="form-control mt-2" name="route_name"
                                placeholder="Nhập tên tuyến đường" value="{{ old('route_name') }}">
                            @error('route_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="fullnameInput" class="form-label mt-2">Điểm bắt đầu</label>
                            <input type="text" class="form-control mt-2" name="start_route"
                                placeholder="Nhập điểm bắt đầu" value="{{ old('start_route') }}">
                            @error('start_route')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="fullnameInput" class="form-label mt-2">Điểm kết thúc</label>
                            <input type="text" class="form-control mt-2" name="end_route"
                                placeholder="Nhập điểm kết thúc" value="{{ old('end_route') }}">
                            @error('end_route')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="fullnameInput" class="form-label mt-2">Thời gian</label>
                            <input type="text" class="form-control mt-2" name="execution_time"
                                placeholder="Nhập thời gian" value="{{ old('execution_time') }}">
                            @error('execution_time')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="fullnameInput" class="form-label mt-2">Chiều dài</label>
                            <input type="text" class="form-control mt-2" name="distance_km"
                                placeholder="Nhập chiều dài tuyến đường" value="{{ old('distance_km') }}">
                            @error('distance_km')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12 mt-2">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <label for="exampleFormControlTextarea5" class="form-label">Mô tả tuyến đường</label>
                                </div>
                                <div class="card-body">
                                    <textarea rows="5" style="width: 100%;border: 1px solid rgb(201, 200, 200); border-radius: 5px; padding: 10px"
                                        name="description" placeholder=" Viết mô tả xe ở đây...">{{ old('description') }}</textarea>
                                </div>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs-custom card-header-tabs border-bottom-0">
                            <li class="nav-item">
                                <a class="nav-link active">Chặng đường</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="stops-container">
                                <div class="stop-item">
                                    <div class="row">
                                        <div class="col">
                                            <label class="form-label pb-2" for="input-from-stop-1">Điểm đi 1</label>
                                            <select name="start_stop_id[]" class="form-control from-stop"
                                                style="width: 90%;" id="input-from-stop-1" onchange="filterToStops(this)">
                                                <?php foreach ($stops as $stop) { ?>
                                                <option value="<?php echo $stop['id']; ?>"><?php echo $stop['stop_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label class="form-label pb-2" for="input-to-stop-1">Điểm đến 1</label>
                                            <select name="end_stop_id[]" class="form-control to-stop" style="width: 90%;"
                                                id="input-to-stop-1">
                                                <?php foreach ($stops as $stop) { ?>
                                                <option value="<?php echo $stop['id']; ?>"><?php echo $stop['stop_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label class="form-label pb-2" for="input-price-1">Giá</label>
                                            <input type="text" name="fare[]" placeholder="Giá vé"
                                                class="form-control" style="width: 90%;" id="input-price-1" />
                                        </div>
                                        <div class="col">
                                            <label class="form-label pb-2" for="input-order-1">Thứ tự</label>
                                            <input type="text" name="stage_order[]" placeholder="Thứ tự dừng"
                                                class="form-control" style="width: 90%;" id="input-order-1" />
                                        </div>
                                        <div class="col-1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="button" class="btn btn-primary" onclick="addStop()">Thêm chặng</button>
                        </div>
                    </div>
                </div>

                <div class="text-end mb-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('admin.routes.index') }}" class="btn btn-success">Quay lại</a>
                </div>

                <style>
                    .fade-out {
                        opacity: 0;
                        transition: opacity 0.5s ease-out;
                    }
                </style>

                <script>
                    let stopIndex = 2; // Bắt đầu với điểm dừng thứ 2
                    function addStop() {
                        // Tạo HTML mới cho điểm dừng
                        let stopHtml = `
                            <div class="stop-item">
                                <div class="row mt-3">
                                    <div class="col">
                                        <label class="form-label pb-2" for="input-stop-${stopIndex}">Điểm đi ${stopIndex}</label>
                                        <select name="start_stop_id[]" class="form-control from-stop" style="width: 90%;" id="input-stop-${stopIndex}" onchange="filterToStops(this)">
                                            <?php foreach ($stops as $stop) { ?>
                                                <option value="<?php echo $stop['id']; ?>"><?php echo $stop['stop_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label class="form-label pb-2" for="input-stop-${stopIndex}">Điểm đến ${stopIndex}</label>
                                        <select name="end_stop_id[]" class="form-control to-stop" style="width: 90%;" id="input-stop-${stopIndex}">
                                            <?php foreach ($stops as $stop) { ?>
                                                <option value="<?php echo $stop['id']; ?>"><?php echo $stop['stop_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label class="form-label pb-2" for="input-price-${stopIndex}">Giá</label>
                                        <input type="text" name="fare[]" placeholder="Giá vé" class="form-control" style="width: 90%;" id="input-price-${stopIndex}" />
                                    </div>
                                    <div class="col">
                                        <label class="form-label pb-2" for="input-order-${stopIndex}">Thứ tự</label>
                                        <input type="text" name="stage_order[]" placeholder="Thứ tự dừng" class="form-control" style="width: 90%;" id="input-order-${stopIndex}" />
                                    </div>
                                    <div class="col-1">
                                        <button type="button" class="btn btn-danger" style="margin-top: 35px" onclick="removeStop(this)">Xóa</button>
                                    </div>
                                </div>
                            </div>
                        `;
                        // Thêm HTML vào container
                        document.getElementById('stops-container').insertAdjacentHTML('beforeend', stopHtml);

                        // Tăng chỉ số cho điểm dừng tiếp theo
                        stopIndex++;

                        // Hiển thị nút "Xóa" nếu có nhiều hơn 1 chặng--
                        toggleRemoveButtons();
                    }

                    // Hàm xóa điểm dừng với hiệu ứng mờ dần
                    function removeStop(element) {
                        let stopItem = element.closest('.stop-item');

                        // Thêm lớp fade-out
                        stopItem.classList.add('fade-out');

                        // Đợi 0.5 giây cho hiệu ứng mờ dần hoàn tất rồi xóa phần tử
                        setTimeout(() => {
                            stopItem.remove(); // Xóa phần tử sau khi hiệu ứng kết thúc
                            toggleRemoveButtons(); // Cập nhật hiển thị của nút "Xóa"
                        }, 500); // 500ms tương đương với thời gian của transition trong CSS
                    }

                    // Hàm ẩn/hiện nút "Xóa"
                    function toggleRemoveButtons() {
                        let stopItems = document.querySelectorAll('.stop-item');
                        stopItems.forEach((item, index) => {
                            let removeButton = item.querySelector('.btn-danger');
                            if (stopItems.length > 1) {
                                removeButton.style.display = 'block'; // Hiện nút "Xóa" khi có nhiều hơn 1 chặng
                            } else {
                                removeButton.style.display = 'none'; // Ẩn nút "Xóa" nếu chỉ có 1 chặng
                            }
                        });
                    }

                    // Gọi hàm ẩn nút "Xóa" ban đầu
                    toggleRemoveButtons();
                </script>


            </div>
    </form>
@endsection
