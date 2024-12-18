@extends('employee.layouts.mater')
@section('title')
    Thêm mới điểm dừng
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Thêm mới điểm dừng </h4>
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
        <form action="{{ route('employee.stops') }}" method="POST" class="row g-3 p-5" enctype="multipart/form-data">
            @csrf
            <div class="col-md-6">
                <label for="fullnameInput" class="form-label">Tên điểm dừng</label>
                <input type="text" class="form-control" name="stop_name" value="{{ old('stop_name') }}"
                    placeholder="Nhập tên điểm dừng">
                @error('stop_name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="parent_stop" class="form-label">Chọn điểm dừng cha</label>
                <select class="form-select" name="parent_id" id="parent_stop">
                    <option value="">Điểm dừng cha</option>
                    @foreach ($parents as $stop)
                        <option value="{{ $stop->id }}" {{ old('parent_id') == $stop->id ? 'selected' : '' }}>
                            {{ $stop->stop_name }}
                        </option>
                    @endforeach
                </select>
            </div>


            <div class="col mt-3">
                    <h5>Hình ảnh</h5>
                    <div class="file-drop-area" id="file-drop-area">
                        <input type="file" name="image" id="file-input" value="{{ old('image') }}" accept="image/*"
                            multiple>
                        <div id="file-preview"></div>
                    </div>

                @error('image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-6">
                <div class="col">
                    <label for="exampleFormControlTextarea5" class="form-label">Mô tả</label>
                    <textarea name="description" id="editor" placeholder="Mô tả">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-12 text-end">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('employee.stops') }}" class="btn btn-success">Quay lại</a>
            </div>
        </form>

        {{-- script --}}
        <script>
            document.getElementById('add-child-stop').addEventListener('click', function() {
                const container = document.getElementById('child-stops-container');
                const childStopHtml = `
                    <div class="child-stop">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="child_stop_name[]" class="form-label">Tên điểm dừng con</label>
                                <input type="text" class="form-control" name="child_stop_name[]" placeholder="Tên điểm dừng con" required>
                            </div>
                            <div class="col-md-6">
                                <label for="child_description[]" class="form-label">Mô tả điểm dừng con</label>
                                <input type="text" class="form-control" name="child_description[]" placeholder="Mô tả điểm dừng con">
                            </div>
                        </div>
                        <button type="button" class="btn btn-danger mt-2 remove-child-stop">Remove</button>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', childStopHtml);
            });

            document.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-child-stop')) {
                    event.target.closest('.child-stop').remove();
                }
            });
        </script>
        <script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>

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
    </div>
@endsection