@extends('admin.layouts.mater')

@section('title')
    Danh sách tin tức
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Danh mục</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                        <li class="breadcrumb-item active">Danh sách tin tức</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">Danh sách tin tức</h5>
                    <a class="btn btn-primary mb-3" href="{{ route('admin.information.create') }}">Thêm mới tin tức</a>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Hình ảnh</th>
                                <th>Tiêu đề</th>
                                <th>Danh mục</th>
                                <th>Lượt xem</th>
                                <th>Ngày tạo</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td><img width="200px" height="140px" src="{{ Storage::url($item->thumbnail_image) }}" alt="">
                                    </td>
                                    <td>{{ \Illuminate\Support\Str::limit($item->title, 30) }}</td>
                                    <td>
                                        @if ($item->newCategories->isEmpty())
                                            <span>No Categories</span>
                                        @else
                                            @foreach ($item->newCategories as $category)
                                                <div class="category-item">{{ $category->name }}</div>
                                                <!-- Use a div for individual styling -->
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>{{ $item->views_count }}</td>
                                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="hstack gap-3 fs-15">
                                            <a href="{{ route('admin.information.show', $item->id) }}"
                                                class="link-primary"><i class="ri-file-paper-2-fill"></i></a>
                                            <a href="{{ route('admin.information.edit', $item->id) }}"
                                                class="link-primary"><i class="ri-settings-4-line"></i></a>
                                            <form id="deleteFormInformation{{ $item->id }}"
                                                action="{{ route('admin.information.destroy', $item->id) }}"
                                                method="post">
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
        function confirmDelete(id) {
            if (confirm('Bạn có muốn xóa không???')) {
                let form = document.getElementById('deleteFormInformation' + id);

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
