@extends('admin.layouts.mater')

@section('title')
    Danh sách điểm dừng
@endsection

@section('content')
    <h1>Thống kê doanh thu</h1>
    <h2>Doanh thu hôm nay: {{ $revenue['today'] }}</h2>
    <h2>Doanh thu tuần này: {{ $revenue['week'] }}</h2>
    <h2>Doanh thu tháng này: {{ $revenue['month'] }}</h2>
    <h2>Doanh thu năm này: {{ $revenue['year'] }}</h2>

    <h3>Doanh thu theo tuyến đường</h3>
    <ul>
        @foreach($routes as $route)
            <li>{{ $route->name }}: {{ $route->payment_sum_amount }}</li>
        @endforeach
    </ul>

    <h3>Doanh thu theo loại xe</h3>
    <ul>
        @foreach($buses as $bus)
            <li>{{ $bus->type }}: {{ $bus->payment_sum_amount }}</li>
        @endforeach
    </ul>
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
