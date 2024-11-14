@extends('admin.layouts.mater')

@section('title')
    Danh sách điểm dừng
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Danh mục</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Bảng</a></li>
                        <li class="breadcrumb-item active">Danh mục điểm dừng</li>
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
                    <a class="btn btn-primary mb-3" href="{{ route('admin.stops.create') }}">Thêm mới điểm dừng</a>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Hình ảnh</th>
                                <th>Tên điểm dừng</th>
                                <th>Mô tả</th>
                                <th>Trạng Thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $parent)
                                <tr class="table-primary">
                                    <td>{{ $parent->id }}</td>
                                    <td><img src="{{ Storage::url($parent->image) }}" alt="" width="120px"
                                            height="80px"></td>
                                    <td><strong>{{ $parent->stop_name }}</strong></td>
                                    <td>{{ \Illuminate\Support\Str::limit(strip_tags($parent->description), 50) }}</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="SwitchCheck{{ $parent->id }}" data-id="{{ $parent->id }}"
                                                {{ $parent->is_active ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="SwitchCheck{{ $parent->id }}">{{ $parent->is_active ? 'On' : 'Off' }}</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="hstack gap-3 fs-15">
                                            <a href="{{ route('admin.stops.edit', $parent->id) }}" class="link-primary"><i
                                                    class="ri-settings-4-line"></i></a>
                                            <form id="deleteFormStop{{ $parent->id }}"
                                                action="{{ route('admin.stops.destroy', $parent->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" style="border: none; background: #d5d8e2"
                                                    class="link-danger" onclick="confirmDelete({{ $parent->id }})">
                                                    <i class="ri-delete-bin-5-line"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                @if ($parent->children->count())
                                    @foreach ($parent->children as $child)
                                        <tr class="child-row">
                                            <td>{{ $child->id }}</td>
                                            <td><img src="{{ Storage::url($child->image) }}" alt="" width="120px"
                                                    height="80px"></td>
                                            <td><span style="margin-left: 20px;">↳ {{ $child->stop_name }}</span></td>

                                            <td>{{ \Illuminate\Support\Str::limit(strip_tags($child->description), 50) }}
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        id="SwitchCheck{{ $child->id }}" data-id="{{ $child->id }}"
                                                        {{ $child->is_active ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="SwitchCheck{{ $child->id }}">{{ $child->is_active ? 'On' : 'Off' }}</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="hstack gap-3 fs-15">
                                                    <a href="{{ route('admin.stops.edit', $child->id) }}"
                                                        class="link-primary"><i class="ri-settings-4-line"></i></a>
                                                    <form id="deleteFormStop{{ $child->id }}"
                                                        action="{{ route('admin.stops.destroy', $child->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" style="border: none; background: white"
                                                            class="link-danger"
                                                            onclick="confirmDelete({{ $child->id }})">
                                                            <i class="ri-delete-bin-5-line"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!--end col-->
    </div>
@endsection

@section('style-libs')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
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

    {{-- <script>
        new DataTable("#example", {
            order: [
                [0, 'asc']
            ]
        });
    </script> --}}
    <script>

        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('form-check-input')) {
                var checkbox = e.target;
                var isChecked = checkbox.checked ? 1 : 0;
                var itemId = checkbox.getAttribute('data-id');

                fetch(`/admin/status-stop/${itemId}`, {
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
                let form = document.getElementById('deleteFormStop' + id);

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

                            // Tìm và xóa dòng cha
                            const parentRow = form.closest('tr');
                            parentRow.remove();

                            // Xóa tất cả các dòng con liên quan đến dòng cha này
                            let nextRow = parentRow.nextElementSibling;
                            while (nextRow && nextRow.classList.contains('child-row')) {
                                nextRow.remove();
                                nextRow = parentRow.nextElementSibling; // Chuyển đến dòng tiếp theo
                            }
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
