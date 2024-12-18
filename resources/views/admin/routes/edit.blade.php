@extends('admin.layouts.mater')
@section('title')
    Cập nhật tuyến đường
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Cập nhật tuyến đường</h4>
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
    <form id="createproduct-form" autocomplete="off" class="needs-validation" novalidate
        action="{{ route('admin.routes.update', $data) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body row p-4">
                        <div class="col-md-6">
                            <label for="fullnameInput" class="form-label">Tên tuyến đường</label>
                            <input type="text" class="form-control mt-2" name="route_name"
                                value="{{ $data->route_name }}">
                            @error('route_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="fullnameInput" class="form-label">Chu Kì</label>
                            <input type="number" class="form-control mt-2" name="cycle" value="{{ $data->cycle }}">
                            @error('cycle')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="fullnameInput" class="form-label mt-2">Điểm bắt đầu</label>
                            <select name="start_route_id" class="form-control" id="input-from-stop-1"
                                onchange="updateEndStops()">
                                <option value="">Chọn điểm bắt đầu</option>
                                <?php foreach ($stops as $stop) { ?>
                                <option value="<?php echo $stop['id']; ?>"
                                    {{ old('start_route_id', $data->start_route_id) == $stop->id ? 'selected' : '' }}>
                                    <?php echo $stop['stop_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="fullnameInput" class="form-label mt-2">Điểm kết thúc</label>
                            <select name="end_route_id" class="form-control" id="input-to-stop-1">
                                <option value="">Chọn điểm kết thúc</option>
                                <?php foreach ($stops as $stop) { ?>
                                <option value="<?php echo $stop['id']; ?>"
                                    {{ old('end_route_id', $data->end_route_id) == $stop->id ? 'selected' : '' }}>
                                    <?php echo $stop['stop_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="fullnameInput" class="form-label mt-2">Giá Tuyến</label>
                            <input type="number" class="form-control mt-2" name="route_price"
                                value="{{ $data->route_price }}">
                            @error('route_price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="fullnameInput" class="form-label mt-2">Chiều dài</label>
                            <input type="number" class="form-control mt-2" name="length" value="{{ $data->length }}">
                            @error('length')
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
                                        name="description"><?php echo $data->description; ?></textarea>
                                </div>
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
                                <?php foreach ($stages as $index => $stage) { ?>
                                <div class="stop-item">
                                    <div class="row">
                                        <input type="hidden" name="stage_ids[]" value="{{ $stage->id }}" />

                                        <div class="col">
                                            <label class="form-label pb-2" for="input-from-stop-{{ $index + 1 }}">Điểm
                                                đi {{ $index + 1 }}</label>
                                            <select name="start_stop_id[]" class="form-control from-stop"
                                                style="width: 90%;" id="input-from-stop-{{ $index + 1 }}"
                                                onchange="filterToStops(this)">
                                                <?php foreach ($stops as $stop) { ?>
                                                <option value="<?php echo $stop['id']; ?>" <?php echo $stop['id'] == $stage->start_stop_id ? 'selected' : ''; ?>>
                                                    <?php echo $stop['stop_name']; ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label class="form-label pb-2" for="input-to-stop-{{ $index + 1 }}">Điểm
                                                đến
                                                {{ $index + 1 }}</label>
                                            <select name="end_stop_id[]" class="form-control to-stop" style="width: 90%;"
                                                id="input-to-stop-{{ $index + 1 }}">
                                                <?php foreach ($stops as $stop) { ?>
                                                <option value="<?php echo $stop['id']; ?>" <?php echo $stop['id'] == $stage->end_stop_id ? 'selected' : ''; ?>>
                                                    <?php echo $stop['stop_name']; ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label class="form-label pb-2"
                                                for="input-price-{{ $index + 1 }}">Giá</label>
                                            <input type="number" name="fare[]" placeholder="Giá vé"
                                                class="form-control" style="width: 90%;"
                                                id="input-price-{{ $index + 1 }}" value="<?php echo $stage->fare; ?>" />
                                        </div>
                                        <div class="col-1">
                                            <button type="button" style="margin-top: 35px" class="btn btn-danger"
                                                onclick="removeStop(this)">Xóa</button>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
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
                    let stopIndex = 2; // Mặc định bắt đầu với chỉ số 2

                    // Tính toán giá trị stopIndex dựa trên các phần tử hiện có
                    document.querySelectorAll('[id^="input-from-stop-"]').forEach((element) => {
                        const currentIndex = parseInt(element.id.replace('input-from-stop-', ''));
                        if (currentIndex >= stopIndex) {
                            stopIndex = currentIndex + 1; // Tăng chỉ số stopIndex lên 1
                        }
                    });

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
