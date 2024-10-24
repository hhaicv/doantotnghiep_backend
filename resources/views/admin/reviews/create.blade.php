@extends('admin.layouts.mater')
@section('title')
    Thêm mới đánh giá
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Thêm mới đánh giá </h4>
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
        <form action="{{ route('admin.reviews.store') }}" method="POST" class="row g-3 p-5">
            @csrf
            {{-- <div class="col-md-6">
                <label for="trip_id" class="form-label">Chuyến xe</label>
                <select class="form-select" name="departure_time" aria-label="Default select example">
                    @foreach ($trips as $trip)
                        <option value="{{ $trip->id }}" {{ old('departure_time') == $trip->id ? 'selected' : '' }}>
                            {{ $trip->departure_time }}</option>
                    @endforeach
                </select>
            </div> --}}
            <div class="col-md-6">
                <label for="user_id" class="form-label">Tên người dùng</label>
                <select class="form-select" name="name" aria-label="Default select example">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ old('name') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}</option>
                    @endforeach
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Đánh giá</label>
                <div class="rating" id="rating">
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="star" data-value="{{ $i }}"
                            style="{{ old('rating') == $i ? 'color: gold;' : 'color: grey;' }}">★</span>
                    @endfor
                </div>
                <input type="hidden" id="ratingValue" name="rating" value="{{ old('rating') }}">
                @error('rating')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="comment" class="form-label">Nhận xét</label>
                <input type="text" class="form-control" id="comment" name="comment" placeholder="Nhập nhận xét..."
                    value="{{ old('comment') }}">
                @error('comment')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-12">
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('admin.reviews.index') }}" class="btn btn-success">Quay lại</a>
                </div>
            </div>
        </form>

        <style>
            .star {
                font-size: 24px;
                cursor: pointer;
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const stars = document.querySelectorAll('.star');
                const ratingValueInput = document.getElementById('ratingValue');
                const form = document.querySelector('form'); // Lấy form

                // Cập nhật ngôi sao theo giá trị đã chọn
                const oldRating = ratingValueInput.value;
                updateStars(oldRating);

                stars.forEach(star => {
                    star.addEventListener('click', function() {
                        const selectedRating = this.getAttribute('data-value');
                        updateStars(selectedRating);
                        ratingValueInput.value = selectedRating; // Cập nhật giá trị cho input ẩn
                    });
                });

                function updateStars(rating) {
                    stars.forEach(star => {
                        star.style.color = star.getAttribute('data-value') <= rating ? 'gold' : 'grey';
                    });
                }

                // Ngăn chặn form submit mặc định
                form.addEventListener('submit', function(e) {
                    e.preventDefault(); // Ngăn chặn hành động submit mặc định

                    const formData = $(this).serialize(); // Lấy dữ liệu form

                    $.ajax({
                        type: 'POST',
                        url: form.action, // Đường dẫn action của form
                        data: formData,
                        success: function(response) {
                            // Xử lý phản hồi thành công
                            if (response.success) {
                                alert('Đánh giá đã được gửi thành công!');
                                // Bạn có thể làm gì đó khác, ví dụ: làm mới danh sách đánh giá
                            } else {
                                // Xử lý lỗi nếu có
                                alert('Có lỗi xảy ra: ' + response.message);
                            }
                        },
                        error: function(xhr) {
                            // Xử lý lỗi
                            alert('Có lỗi xảy ra: ' + xhr.status + ' ' + xhr.statusText);
                        }
                    });
                });
            });
        </script>


    </div>
@endsection
