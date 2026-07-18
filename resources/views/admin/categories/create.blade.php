@extends('admin.layouts.admin')

@section('content')

<x-admin.page-header :title="'Category'">
    <x-slot:actions>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-light">
            <i class="bi bi-arrow-left me-1"></i> {{ 'Back' }}
        </a>
    </x-slot:actions>
</x-admin.page-header>

<form id="categoryForm" action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">{{ 'Name' }}</label>
                        <input type="text" name="name"
                            class="form-control border-0 bg-light @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" placeholder="Enter category name...">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">{{ 'Description' }}</label>
                        <textarea id="description_en"
                            name="description"
                            class="form-control ck-editor @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-semibold">{{ 'Image' }}</label>
                        <div class="image-upload-wrapper border rounded-3 p-4 text-center bg-light">
                            <div id="image_preview_en" class="mb-3"
                                style="{{ old('image_base64') ? '' : 'display:none;' }}">
                                <img id="image_preview_img_en"
                                    src="{{ old('image_base64') ?: '#' }}"
                                    alt="Preview" class="img-thumbnail shadow-sm" style="max-height: 150px;">
                            </div>
                            <div class="upload-controls">
                                <label class="btn btn-outline-primary shadow-sm" for="image_file_en">
                                    <i class="bi bi-cloud-arrow-up me-1"></i> {{ 'Choose File' }}
                                </label>
                                <input type="file" id="image_file_en"
                                    name="image" accept="image/*"
                                    class="form-control d-none @error('image') is-invalid @enderror"
                                    onchange="previewImage(this)">
                            </div>
                            <small class="text-muted d-block mt-2">{{ 'JPG, PNG or GIF. Max 10MB' }}</small>
                        </div>
                        <input type="hidden" id="image_base64_en"
                            name="image_base64"
                            value="{{ old('image_base64') }}">
                        @error('image')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">{{ 'Publishing' }}</h6>
                    <x-admin.combobox
                        name="status"
                        :label="'Status'"
                        wrapper-class="mb-3"
                        :options="['active' => 'Active', 'inactive' => 'Inactive']" />
                    <hr class="my-4">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary shadow-sm py-2">
                            <i class="bi bi-save me-1"></i> {{ 'Save Category' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('js')
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>
let ckEditor;

function previewImage(input) {
    var file = input.files[0];
    var previewElement = document.getElementById('image_preview_en');
    var previewImg = document.getElementById('image_preview_img_en');
    var hiddenInput = document.getElementById('image_base64_en');

    if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            previewElement.style.display = 'block';
            previewImg.src = e.target.result;
            hiddenInput.value = e.target.result;
        };
        reader.readAsDataURL(file);
    } else {
        previewElement.style.display = 'none';
        hiddenInput.value = '';
    }
}

function base64ToFile(dataurl, baseName) {
    if (!dataurl || dataurl.indexOf(',') === -1) throw new Error('Invalid base64 data');
    var arr = dataurl.split(',');
    var mimeMatch = arr[0].match(/data:(.*);base64/);
    if (!mimeMatch) throw new Error('Invalid mime');
    var mime = mimeMatch[1];
    var ext = mime.split('/')[1].split('+')[0];
    if (ext === 'jpeg') ext = 'jpg';
    var bstr = atob(arr[1]), n = bstr.length, u8arr = new Uint8Array(n);
    for (var i = 0; i < n; i++) { u8arr[i] = bstr.charCodeAt(i); }
    return new File([u8arr], baseName + '.' + ext, { type: mime });
}

ClassicEditor.create(document.getElementById('description_en'))
    .then(editor => { ckEditor = editor; })
    .catch(error => { console.error('CKEditor init error', error); });

document.getElementById('categoryForm').addEventListener('submit', function () {
    if (ckEditor) {
        document.getElementById('description_en').value = ckEditor.getData();
    }

    var fileInput = document.getElementById('image_file_en');
    var base64Input = document.getElementById('image_base64_en');
    if (fileInput && fileInput.files.length === 0 && base64Input && base64Input.value) {
        try {
            var f = base64ToFile(base64Input.value, 'image_en');
            var dt = new DataTransfer();
            dt.items.add(f);
            fileInput.files = dt.files;
        } catch (err) {
            console.error('base64 -> File failed', err);
        }
    }
});
</script>
@endsection
