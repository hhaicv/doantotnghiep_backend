@extends('admin.layout.master')
@section('title')
    Danh sách sản phẩm
@endsection
@section('style-libs')
    <!-- Custom styles for this page -->
    <link href="{{asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection
@section('script-libs')
    <script src="{{asset('theme/admin/vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{asset('theme/admin/js/demo/datatables-demo.js')}}"></script>
@endsection
@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Danh sách sản phẩm</h1>

        <div style="padding-bottom: 10px">
            <a href="{{route('admin.products.create')}}" style="padding-bottom: 50px">
                <button class="btn btn-success">Thêm mới</button>
            </a>
        </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Mã </th>
                            <th>Ảnh </th>
                            <th>Danh mục</th>
                            <th>Giá niêm yết</th>
                            <th>Giá Sale</th>
                            <th>Trạng thái</th>
                            <th>Hành Động</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Mã </th>
                            <th>Ảnh </th>
                            <th>Danh mục</th>
                            <th>Giá niêm yết</th>
                            <th>Giá Sale</th>
                            <th>Trạng thái</th>
                            <th>Hành Động</th>
                        </tr>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($data as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->sku}}</td>
                                <td>
                                    <div style="width: 100px; height: 100px;">
                                        <img src="{{Storage::url($item->img_thumb)}}"
                                             style="max-width: 100%; max-height: 100%;" alt="">
                                    </div>
                                </td>
                                <td>{{$item->category->name}}</td>
                                <td>{{$item->price}}</td>
                                <td>{{$item->price_sale}}</td>
                                <td>
                                    {!! $item->is_active ? '<span class="badge bg-success"> Hoạt động </span>' :
            ' <span class="badge bg-danger"> Không hoạt động </span>'!!}
                                </td>
                                <td>
                                    <a href="{{route('admin.products.show', $item)}}" style="padding-right: 5px">
                                        <button class="btn btn-success ">Xem</button>
                                    </a>
                                    <a href="{{route('admin.products.edit', $item)}}">
                                        <button class="btn btn-warning">Sửa</button>
                                    </a>
                                    <form action="{{route('admin.products.destroy', $item)}}" method="POST"
                                          style="padding-top: 5px">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
