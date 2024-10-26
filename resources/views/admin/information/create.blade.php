@extends('admin.layouts.mater')
@section('title')
    Thêm mới Tin tức
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Thêm mới Tin tức </h4>
            </div>
        </div>
    </div>
<<<<<<< HEAD
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
=======
>>>>>>> 5e72f5bd298277e513369229af78157ad3271f56
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
<<<<<<< HEAD
        <form action="{{ route('admin.information.store') }}" method="POST" class="row g-3 p-5"
            enctype="multipart/form-data">
=======
        <form action="{{ route('admin.information.store') }}" method="POST" class="row g-3 p-5" enctype="multipart/form-data">
>>>>>>> 5e72f5bd298277e513369229af78157ad3271f56
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="col mb-3">
                        <label for="fullnameInput" class="form-label">Tiêu đề</label>
<<<<<<< HEAD
                        <input type="text" class="form-control" name="title" placeholder="Nhập tiêu đề">
                    </div>
                    <div class="col">
=======
                        <input type="text" class="form-control" name="title" placeholder="Nhập tiêu đề"
                            value="{{ old('title') }}">
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col mb-3">
>>>>>>> 5e72f5bd298277e513369229af78157ad3271f56
                        <label for="choices-multiple-remove-button" class="form-label text-muted">Danh mục tin tức</label>
                        <select id="choices-multiple-remove-button" name="newCategories[]"
                            placeholder="This is a placeholder" multiple>
                            @foreach ($newCategories as $id => $name)
<<<<<<< HEAD
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
=======
                                <option value="{{ $id }}"
                                    {{ in_array($id, old('newCategories', [])) ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

>>>>>>> 5e72f5bd298277e513369229af78157ad3271f56
                    <div class="col mt-3">
                        <div class="filepond-container">
                            <h4>Hình ảnh</h4>
                            <div class="file-drop-area" id="file-drop-area">
<<<<<<< HEAD
                                <input type="file" name="thumbnail_image" id="file-input" accept="image/*" multiple>
                                <div id="file-preview"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col">
                        <label for="exampleFormControlTextarea5" class="form-label">Tóm tắt</label>
                        <textarea name="summary" id="editor" placeholder="Tóm tắt ở đây..."></textarea>
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
                            <textarea name="content" id="editor1" placeholder=" Nội dung ở đây..."></textarea>
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
=======
                                <input type="file" name="thumbnail_image" id="file-input" accept="image/*">
                                <div id="file-preview">
                                    @if (old('thumbnail_image'))
                                        <img src="{{ old('thumbnail_image') }}" class="img-thumbnail mt-2"
                                            style="width: 100px;">
                                    @endif
                                </div>
                            </div>
                        </div>
                        @error('thumbnail_image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="col">
                        <label for="exampleFormControlTextarea5" class="form-label">Tóm tắt</label>
                        <textarea name="summary" id="editor" placeholder="Tóm tắt ở đây...">{{ old('summary') }}</textarea>
                    </div>
                    @error('summary')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="">
                            <div class="card-header align-items-center d-flex">
                                <label for="exampleFormControlTextarea5" class="form-label">Nội dung</label>
                            </div>
                            <div class="card-body">
                                <textarea name="content" id="editor1" placeholder=" Nội dung ở đây...">{{ old('content') }}</textarea>
                            </div>
                            @error('content')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-12">

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('admin.information.index') }}" class="btn btn-success">Quay lại</a>
                    </div>
                </div>
>>>>>>> 5e72f5bd298277e513369229af78157ad3271f56
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
<<<<<<< HEAD



=======
>>>>>>> 5e72f5bd298277e513369229af78157ad3271f56
@endsection
