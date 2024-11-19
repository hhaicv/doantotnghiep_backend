@extends('admin.layouts.mater')
@section('title')
    Cập nhật điểm dừng
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Cập nhật lại điểm dừng</h4>
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
        <form action="{{ route('admin.stops.update', $data->id) }}" method="POST" enctype="multipart/form-data" class="row g-3 p-5" >
            @csrf
            @method('PUT')
            <div class="col-md-6">
                <label for="stopNameInput" class="form-label">Tên điểm dừng</label>
                <input type="text" id="stopNameInput" class="form-control" name="stop_name"
                    value="{{ old('stop_name', $data->stop_name) }}" required>
            </div>
            <div class="col-md-3">
                <label for="parent_id" class="form-label">Điểm dừng cha (Tùy chọn):</label>
                <select name="parent_id" id="parent_id" class="form-select" onchange="filterChildStops()">
                    <option value="">Không có</option>
                    @foreach ($parents as $parent)
                        <option value="{{ $parent->id }}"
                            {{ old('parent_id', $data->parent_id) == $parent->id ? 'selected' : '' }}>
                            {{ $parent->stop_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label for="child_id" class="form-label">Điểm dừng con (Tùy chọn):</label>
                <select name="child_id" id="child_id" class="form-select">
                    <option value="">Không có</option>
                    @foreach ($children as $child)
                        <option value="{{ $child->id }}" data-parent-id="{{ $child->parent_id }}"
                            {{ old('child_id', $data->child_id) == $child->id ? 'selected' : '' }}>
                            {{ $child->stop_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mt-3">
                <h5>Hình ảnh</h5>
                <div class="file-drop-area" id="file-drop-area">
                    @if ($data->image)
                        <div class="mb-3" id="current-image">
                            <img src="{{ Storage::url($data->image) }}" alt="Current image" width="200">
                        </div>
                    @endif
                    <input type="file" name="image" id="file-input" accept="image/*" multiple>
                    <div id="file-preview"></div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="col">
                    <label for="exampleFormControlTextarea5" class="form-label">Mô tả</label>
                    <textarea name="description" id="editor">{{ $data->description }}</textarea>
                </div>
            </div>

            <!-- Nút hành động -->
            <div class="col-12">
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="{{ route('admin.stops.index') }}" class="btn btn-success">Quay lại</a>
                </div>
            </div>
        </form>
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
    </div>
@endsection


<script>
    function filterChildStops() {
        const parentId = document.getElementById("parent_id").value;
        const childSelect = document.getElementById("child_id");

        // Show only child stops that match the selected parent ID
        Array.from(childSelect.options).forEach(option => {
            if (option.getAttribute("data-parent-id") === parentId) {
                option.hidden = false;
            } else {
                option.hidden = true;
            }
        });

        // Reset child selection if the parent ID has changed
        if (!parentId) {
            childSelect.value = "";
        }
    }

    // Initialize the child stops field based on preloaded data on page load
    window.onload = function() {
        filterChildStops();
    };
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
