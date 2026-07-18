@extends('admin.layouts.admin')

@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">{{ 'Create Page' }}</h4>
            <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> {{ 'Back' }}
            </a>
        </div>
    </div>
</div>

<form id="pageForm" action="{{ route('admin.pages.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">{{ 'Title' }}</label>
                        <input type="text" name="title"
                            value="{{ old('title') }}"
                            class="form-control border-0 bg-light @error('title') is-invalid @enderror"
                            placeholder="Enter page title">
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-semibold">{{ 'Content' }}</label>
                        <textarea id="content_en" name="content"
                            class="form-control ck-editor @error('content') is-invalid @enderror">{{ old('content') }}</textarea>
                        @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
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
                    <p class="text-muted small">{{ 'Save to publish this page.' }}</p>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary shadow-sm py-2">
                            <i class="bi bi-save me-1"></i> {{ 'Save Page' }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Image -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">{{ 'Image' }}</h6>
                    <div class="mb-3">
                        <div class="image-upload-wrapper">
                            <div class="image-preview mb-3 text-center bg-light rounded py-4 border-2 border-dashed"
                                 id="image_preview_en"
                                 style="{{ old('image_base64') ? '' : 'display:none;' }}">
                                <img id="image_preview_img_en"
                                    src="{{ old('image_base64') ?: '#' }}"
                                    class="img-fluid rounded shadow-sm" style="max-height: 150px;">
                            </div>

                            @if(!old('image_base64'))
                            <div class="placeholder-preview mb-3 text-center bg-light rounded py-4 border-2 border-dashed pointer-cursor"
                                 onclick="document.getElementById('image_file_en').click()"
                                 id="placeholder_en">
                                <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                                <p class="text-muted small mt-2 mb-0">{{ 'Click to upload' }}</p>
                            </div>
                            @endif

                            <div class="d-grid">
                                <label class="btn btn-outline-primary btn-sm" for="image_file_en">
                                    <i class="bi bi-cloud-arrow-up me-1"></i> {{ 'Choose Image' }}
                                </label>
                                <input type="file" id="image_file_en"
                                    name="image" accept="image/*"
                                    class="form-control d-none @error('image') is-invalid @enderror"
                                    onchange="previewImage(this)">
                            </div>

                            <input type="hidden" id="image_base64_en"
                                name="image_base64"
                                value="{{ old('image_base64') }}">
                        </div>
                        @error('image')
                        <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                        @enderror
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
ClassicEditor.create(document.getElementById('content_en'))
    .then(editor => { ckEditor = editor; })
    .catch(error => { console.error('CKEditor init error', error); });

function previewImage(input) {
    var file = input.files[0];
    var previewElement = document.getElementById('image_preview_en');
    var previewImg = document.getElementById('image_preview_img_en');
    var hiddenInput = document.getElementById('image_base64_en');
    var placeholder = document.getElementById('placeholder_en');
    if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            previewElement.style.display = 'block';
            previewImg.src = e.target.result;
            hiddenInput.value = e.target.result;
            if (placeholder) placeholder.style.display = 'none';
        };
        reader.readAsDataURL(file);
    } else {
        previewElement.style.display = 'none';
        previewImg.src = '';
        hiddenInput.value = '';
        if (placeholder) placeholder.style.display = 'block';
    }
}

function base64ToFile(dataurl, baseName) {
    if (!dataurl || dataurl.indexOf(',') === -1) return null;
    var arr = dataurl.split(',');
    var mimeMatch = arr[0].match(/data:(.*);base64/);
    if (!mimeMatch) return null;
    var mime = mimeMatch[1];
    var ext = mime.split('/')[1].split('+')[0];
    if (ext === 'jpeg') ext = 'jpg';
    var bstr = atob(arr[1]), n = bstr.length, u8arr = new Uint8Array(n);
    for (var i = 0; i < n; i++) { u8arr[i] = bstr.charCodeAt(i); }
    return new File([u8arr], baseName + '.' + ext, { type: mime });
}

document.getElementById('pageForm').addEventListener('submit', function () {
    if (ckEditor) {
        document.getElementById('content_en').value = ckEditor.getData();
    }
    var fileInput = document.getElementById('image_file_en');
    var base64Input = document.getElementById('image_base64_en');
    if (fileInput && fileInput.files.length === 0 && base64Input && base64Input.value) {
        try {
            var f = base64ToFile(base64Input.value, 'image_en');
            if (f) {
                var dt = new DataTransfer();
                dt.items.add(f);
                fileInput.files = dt.files;
            }
        } catch (err) {
            console.error('base64 -> File failed', err);
        }
    }
});
</script>
@endsection
