@extends('admin.layouts.mater')
@section('title')
    Cập nhật Tin tức
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Cập nhật Tin tức </h4>
            </div>
        </div>
    </div>

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
        <form action="{{ route('admin.information.update', $data) }}" method="POST" class="row g-3 p-5"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="col mb-3">
                        <label for="fullnameInput" class="form-label">Tiêu đề</label>
                        <input type="text" class="form-control" name="title" placeholder="Nhập tiêu đề"
                            value="{{ $data->title }}">
                    </div>
                    <div class="col">
                        <label for="choices-multiple-remove-button" class="form-label text-muted">Danh mục tin tức</label>
                        <select id="choices-multiple-remove-button" name="newCategories[]"
                            placeholder="This is a placeholder" multiple>
                            @foreach ($allCategories as $category)
                                <option value="{{ $category->id }}" @if (in_array($category->id, $newCategories)) selected @endif>
                                    {{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col mt-3">
                        <div class="file-drop-area" id="file-drop-area">
                            @if ($data->thumbnail_image)
                                <!-- Kiểm tra nếu hình ảnh đã tồn tại -->
                                <div class="mb-3" id="current-image">
                                    <img src="{{ Storage::url($data->thumbnail_image) }}" alt="Current image"
                                        width="200">
                                </div>
                            @endif
                            <input type="file" name="thumbnail_image" id="file-input" accept="image/*" multiple>
                            <div id="file-preview"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col">
                        <label for="exampleFormControlTextarea5" class="form-label">Tóm tắt</label>
                        <textarea name="summary" id="editor" placeholder="Tóm tắt ở đây...">{{ $data->summary }}</textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="">
                        <div class="card-header align-items-center d-flex">
                            <label for="exampleFormControlTextarea5" class="form-label">Nội dung</label>
                        </div>
                        <div class="card-body">
                            <textarea name="content" id="editor1" placeholder=" Nội dung ở đây...">{{ $data->content }}</textarea>
                        </div><!-- end card-body -->
                    </div><!-- end card -->
                </div>
            </div>
            <div class="col-12">

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('admin.information.index') }}" class="btn btn-success">Quay lại</a>
                </div>
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
        const currentImage = document.getElementById('current-image'); // Lấy hình ảnh hiện tại

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
            filePreview.innerHTML = ''; // Xóa ảnh preview trước đó

            // Ẩn hoặc xóa ảnh hiện tại nếu có ảnh mới
            if (currentImage) {
                currentImage.style.display = 'none'; // Ẩn hình ảnh hiện tại
            }

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
                        // Nếu muốn cho phép hiển thị lại ảnh cũ khi xóa ảnh mới
                        if (filePreview.children.length === 0 && currentImage) {
                            currentImage.style.display = 'block';
                        }
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
@endsection
