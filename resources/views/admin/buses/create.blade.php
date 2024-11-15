@extends('admin.layouts.mater')
@section('title')
    Thêm mới xe
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Thêm mới xe </h4>
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
        <form action="{{ route('admin.buses.store') }}" method="POST" class="row g-3 p-5" enctype="multipart/form-data">
            @csrf
            <div class="col-md-6">
                <label for="fullnameInput" class="form-label">Tên xe</label>

                <input type="text" class="form-control" id="name_bus" name="name_bus" placeholder="Nhập tên xe "
                    value="{{ old('name_bus') }}">
                @error('name_bus')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="fullnameInput" class="form-label">Hãng xe</label>
                <input type="text" class="form-control" id="model" name="model" placeholder="Nhập tên hãng xe"
                    value="{{ old('model') }}">
                @error('model')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="fullnameInput" class="form-label">Biển số xe</label>
                <input type="text" class="form-control" id="license_plate" name="license_plate"
                    placeholder="Nhập biển số xe " value="{{ old('license_plate') }}">
                @error('license_plate')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="fullnameInput" class="form-label">Số điện thoại</label>
                <input type="number" class="form-control" id="icon" name="phone" placeholder="Nhập số điện thoại"
                    value="{{ old('phone') }}">
                @error('phone')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

            </div>
            <div class="col mt-6">
                <h5>Image</h5>
                <div class="file-drop-area" id="file-drop-area">
                    <input type="file" name="image" id="file-input" accept="image/*" value="{{ old('imgae') }}"
                        multiple>

                    <div id="file-preview"></div>
                </div>
                @error('image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-6">
                <div class="col-mt-3">
                    <label for="start_date">Số lượng ghế</label>
                    <input type="number" name="total_seats" id="total_seats" class="form-control"
                        value="{{ old('total_seats') }}" placeholder="Nhập số lượng ghế">
                    @error('total_seats')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-mt-3">
                    <br>
                    <label class="form-label" for="fare_multiplier">Mã GPS</label>
                    <input type="text" class="form-control" name="gps_code" value="{{ old('gps_code') }}"
                        placeholder="Nhập mã GPS">
                    @error('gps_code')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <label for="exampleFormControlTextarea5" class="form-label">Mô tả xe</label>
            </div>
            <div class="card-body">
                <textarea rows="5" style="width: 100%;border: 1px solid rgb(201, 200, 200); border-radius: 5px; padding: 10px"
                    name="description" placeholder=" Viết mô tả xe ở đây...">{{ old('description') }}</textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
    <input type="hidden" name="is_active" value="0">
    <div class="col-12">
        <div class="text-end">
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="{{ route('admin.buses.index') }}" class="btn btn-success">Quay lại</a>
        </div>
    </div>
    </form>
    </div>

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
    </script>
@endsection
