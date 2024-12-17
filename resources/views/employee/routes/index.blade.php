@extends('employee.layouts.mater')

@section('title')
    Danh sách tuyến đường
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Tuyến đường</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                        <li class="breadcrumb-item active">Tuyến đường</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">Danh sách</h5>
                    <a class="btn btn-primary mb-3" href="{{ route('employee.routes.create') }}">Thêm mới</a>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên tuyến đường</th>
                                <th>Các Chặng</th>
                                <th>Chu Kỳ</th>
                                <th>Giá Tuyến</th>
                                <th>Chiều Dài</th>
                                <th>Mô tả</th>
                                <th>Trạng thái</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($item->route_name, 30) }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#modal{{ $item->id }}">
                                            Xem chi tiết
                                        </button>
                                    </td>
                                    <div class="modal fade" id="modal{{ $item->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Danh sách điểm dừng
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="map-container">
                                                        @php
                                                            $firstStop = true; // Biến đánh dấu để không hiển thị mũi tên trước điểm đầu tiên
                                                        @endphp
                                                        @foreach ($item->stages as $stopId)
                                                            @php
                                                                // Tìm điểm dừng tương ứng với stopId
                                                                $stop = $stops->firstWhere('id', $stopId);
                                                            @endphp
                                                            @if ($stop)
                                                                @if (!$firstStop)
                                                                    <div class="arrow">→</div>
                                                                @endif
                                                                <div class="stop">
                                                                    {{ $stop->stop_name ?? 'N/A' }}
                                                                </div>
                                                                @php $firstStop = false; @endphp
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <style>
                                         .modal-dialog {
                                            margin-top: 70px; 
                                            max-width: 70%;
                                        }
                                        .map-container {
                                            display: flex;
                                            align-items: center;
                                            gap: 10px;
                                            flex-wrap: wrap;
                                        }
                                        .stop {
                                            background-color: #f0f8ff;
                                            border: 1px solid #007bff;
                                            border-radius: 5px;
                                            padding: 10px;
                                            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                                            flex: 0 1 auto;
                                            min-width: 150px;
                                            text-align: center;
                                        }
                                        .arrow {
                                            font-size: 24px;
                                            line-height: 1;
                                        }
                                    </style>



                                    <td>{{ $item->cycle }} phút</td>
                                    <td>{{ number_format($item->route_price, 0, ',', '.') }} VND</td>
                                    <td>{{ number_format($item->length, 0, ',', '.') }} KM</td>
                                    <td>{{ $item->description }}</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="SwitchCheck{{ $item->id }}" data-id="{{ $item->id }}"
                                                {{ $item->is_active ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="SwitchCheck{{ $item->id }}">{{ $item->is_active ? 'On' : 'Off' }}</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="hstack gap-3 fs-15">
                                            <a href="{{ route('employee.routes.edit', $item->id) }}" class="link-primary"><i
                                                    class="ri-settings-4-line"></i></a>
                                            <form id="deleteFormRoute{{ $item->id }}"
                                                action="{{ route('employee.routes.destroy', $item->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" style="border: none; background: white"
                                                    class="link-danger" onclick="confirmDelete({{ $item->id }})">
                                                    <i class="ri-delete-bin-5-line"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div><!--end col-->
    </div><!--end row-->
@endsection

@section('style-libs')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection

@section('script-libs')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script>
        new DataTable("#example", {
            order: [
                [0, 'desc']
            ]
        });
    </script>
    <script>
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('form-check-input')) {
                var checkbox = e.target;
                var isChecked = checkbox.checked ? 1 : 0;
                var itemId = checkbox.getAttribute('data-id');

                fetch(`/employee/status-route/${itemId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            is_active: isChecked
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            var label = checkbox.nextElementSibling;
                            label.textContent = isChecked ? 'On' : 'Off';
                        } else {
                            alert('Cập nhật trạng thái thất bại.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        });

        function confirmDelete(id) {
            if (confirm('Bạn có muốn xóa không???')) {
                let form = document.getElementById('deleteFormRoute' + id);

                // Dùng AJAX để gửi yêu cầu xóa mà không reload trang
                fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: new URLSearchParams(new FormData(form))
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Đã xóa thành công!');
                            // Nếu muốn, có thể xóa dòng hiện tại trong bảng mà không cần reload trang
                            form.closest('tr').remove();
                        } else {
                            alert('Có lỗi xảy ra. Vui lòng thử lại.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Có lỗi xảy ra. Vui lòng thử lại.');
                    });
            }
        }
    </script>
@endsection
