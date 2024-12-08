@extends('driver.layouts.mater')

@section('title')
    Cập nhật Tài xế
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Cập nhật Tài xế</h4>
            </div>
        </div>
    </div>

    {{-- Thông báo thành công/thất bại --}}
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

    <div class="card">
        <form action="{{ route('drivers.update', $driver->id) }}" method="POST" class="row g-3 p-5" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="col-md-6">
                <!-- Tên tài xế -->
                <div class="mb-3">
                    <label for="name" class="form-label">Tên tài xế</label>
                    <input type="text" class="form-control" id="name" name="name"
                           value="{{ old('name', $driver->name) }}">
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Ngày sinh -->
                <div class="mb-3">
                    <label for="date_of_birth" class="form-label">Ngày/Tháng/Năm</label>
                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                           value="{{ old('date_of_birth', $driver->date_of_birth ? \Carbon\Carbon::parse($driver->date_of_birth)->format('Y-m-d') : '') }}">
                    @error('date_of_birth')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email"
                           value="{{ old('email', $driver->email) }}">
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Mật khẩu -->
                <div class="mb-3 position-relative">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password"
                               placeholder="Nhập mật khẩu mới (để trống nếu không đổi)">
                        <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                            <i class="fa fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                    @error('password')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Số bằng lái -->
                <div class="mb-3">
                    <label for="license_number" class="form-label">Số bằng lái xe</label>
                    <input type="text" class="form-control" id="license_number" name="license_number"
                           value="{{ old('license_number', $driver->license_number) }}">
                    @error('license_number')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <!-- Số điện thoại -->
                <div class="mb-3">
                    <label for="phone" class="form-label">Số điện thoại</label>
                    <input type="text" class="form-control" id="phone" name="phone"
                           value="{{ old('phone', $driver->phone) }}">
                    @error('phone')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Địa chỉ -->
                <div class="mb-3">
                    <label for="address" class="form-label">Địa chỉ</label>
                    <input type="text" class="form-control" id="address" name="address"
                           value="{{ old('address', $driver->address) }}">
                    @error('address')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Ảnh đại diện -->
                <div class="mb-3">
                    <label for="profile_image" class="form-label">Ảnh đại diện</label>
                    <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*">
                    @if ($driver->profile_image)
                        <img src="{{ Storage::url($driver->profile_image) }}" alt="Ảnh đại diện" class="mt-3" width="200px">
                    @endif
                    @error('profile_image')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="col-12 text-end">
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="{{ route('drivers.index') }}" class="btn btn-secondary">Quay lại</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#editor'), {
                htmlSupport: {
                    allow: [{
                        name: /.*/,
                        attributes: true,
                        classes: true,
                        styles: true
                    }]
                }
            })
            .catch(error => {
                console.error(error);
            });

        ClassicEditor
            .create(document.querySelector('#editor1'), {
                htmlSupport: {
                    allow: [{
                        name: /.*/,
                        attributes: true,
                        classes: true,
                        styles: true
                    }]
                }
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>
        const fileInput = document.getElementById('file-input');
        const fileDropArea = document.getElementById('file-drop-area');
        const filePreview = document.getElementById('file-preview');

        fileInput.addEventListener('change', handleFiles);
        fileDropArea.addEventListener('dragover', (event) => {
            event.preventDefault();
            fileDropArea.classList.add('dragging');
        });

        fileDropArea.addEventListener('dragleave', () => {
            fileDropArea.classList.remove('dragging');
        });

        fileDropArea.addEventListener('drop', (event) => {
            event.preventDefault();
            fileDropArea.classList.remove('dragging');
            const files = event.dataTransfer.files;
            handleFiles({
                target: {
                    files
                }
            });
        });

        function handleFiles(event) {
            const files = event.target.files;
            filePreview.innerHTML = ''; // Clear previous previews

            for (const file of files) {
                const fileReader = new FileReader();

                fileReader.onload = function(e) {
                    const previewItem = document.createElement('div');
                    previewItem.classList.add('file-preview-item');

                    const img = document.createElement('img');
                    img.src = e.target.result;

                    const removeBtn = document.createElement('button');
                    removeBtn.classList.add('file-remove-btn');
                    removeBtn.textContent = 'Remove';
                    removeBtn.onclick = () => {
                        previewItem.remove();
                        // Optionally reset file input (not recommended if allowing multiple uploads)
                    };

                    previewItem.appendChild(img);
                    previewItem.appendChild(removeBtn);
                    filePreview.appendChild(previewItem);
                };

                fileReader.readAsDataURL(file);
            }
        }

        const multipleCancelButton = new Choices('#choices-multiple-remove-button', {
            removeItemButton: true,
            maxItemCount: 5,
            searchResultLimit: 5,
            renderChoiceLimit: 5
        });
    </script>
    <script>
        const passwordInput = document.getElementById('password');
        const togglePasswordButton = document.getElementById('togglePassword');
        const toggleIcon = document.getElementById('toggleIcon');

        togglePasswordButton.addEventListener('click', function() {
            // Kiểm tra và thay đổi kiểu của trường input
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');

            // Đổi icon mắt khi thay đổi trạng thái
            toggleIcon.classList.toggle('fa-eye');
            toggleIcon.classList.toggle('fa-eye-slash');
        });
    </script>
@endsection
