@extends('employee.layouts.mater')

@section('title')
    Danh sách xe
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Loại xe</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                        <li class="breadcrumb-item active">Loại xe</li>
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
                    {{-- <a class="btn btn-primary mb-3" href="{{ route('employee.buses.create') }}">Thêm mới xe</a> --}}
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Hình ảnh</th>
                                <th>Xe</th>
                                <th>Tài xế</th>
                                <th>SĐT</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td><img src="{{ Storage::url($item->image) }}" alt=""
                                            style="width: 170px;height: 100px;object-fit: cover"></td>
                                    <td>
                                        <p> {{ $item->license_plate }} - {{ $item->total_seats }} Chỗ</p>
                                        <p> {{ $item->name_bus }}</p>
                                        <p> {{ $item->model }} </p>
                                    </td>
                                    <td>{{ $item->driver ? $item->driver->name : 'No Driver' }}</td>

                                    <td>{{ $item->driver ? $item->driver->phone : 'No Phone' }}</td>
                                    <td>
                                        <span class="{{ $item->is_active ? 'text-success' : 'text-danger' }}">
                                            {{ $item->is_active ? 'On' : 'Off' }}
                                        </span>
                                    </td>
                                    {{-- <td>
                                        <div class="hstack gap-3 fs-15">
                                            <a href="{{ route('employee.buses.edit', $item->id) }}" class="link-primary"><i
                                                    class="ri-settings-4-line"></i></a>
                                            <form id="deleteFormBuses{{ $item->id }}"
                                                action="{{ route('employee.buses.destroy', $item->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" style="border: none; background: white"
                                                    class="link-danger" onclick="confirmDelete({{ $item->id }})">
                                                    <i class="ri-delete-bin-5-line"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td> --}}
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

                fetch(`/employee/status-buses/${itemId}`, {
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
                let form = document.getElementById('deleteFormBuses' + id);

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
