@extends('admin.layouts.admin')
@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">{{ 'Brands' }}</h4>
            <a href="{{ route('admin.brands.index') }}" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> {{ 'Back' }}
            </a>
        </div>
    </div>
</div>

<form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data" id="brandForm">
    @csrf
    <input type="hidden" name="logo_preview_base64" id="logo_preview_base64" value="{{ old('logo_preview_base64') }}">

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">{{ 'Name' }}</label>
                        <input type="text" name="name"
                            class="form-control border-0 bg-light @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" placeholder="Enter brand name...">
                        @error('name')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-semibold">{{ 'Description' }}</label>
                        <textarea name="description"
                            class="form-control ck-editor @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                        @error('description')
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
                    <h6 class="fw-bold mb-3">Logo</h6>
                    <div class="image-upload-wrapper border rounded-3 p-4 text-center bg-light mb-3">
                        <div class="mt-2 mb-3" id="logo_preview" style="{{ old('logo_preview_base64') ? 'display:block;' : 'display:none;' }}">
                            <img id="logo_preview_img" src="{{ old('logo_preview_base64') }}" class="img-thumbnail shadow-sm" style="max-height: 150px;">
                        </div>
                        <div class="upload-controls">
                            <label class="btn btn-outline-primary shadow-sm" for="logo_file">
                                <i class="bi bi-cloud-arrow-up me-1"></i> {{ 'Choose File' }}
                            </label>
                            <input type="file" name="logo_url" accept="image/*" class="form-control d-none" id="logo_file">
                        </div>
                    </div>
                    @error('logo_url')
                    <div class="alert alert-danger p-2 small mb-3">{{ $message }}</div>
                    @enderror

                    <hr class="my-4">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary shadow-sm py-2">
                            <i class="bi bi-save me-1"></i> {{ 'Save Brand' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('js')
<script>
document.getElementById('logo_file').addEventListener('change', function(event) {
    var file = event.target.files[0];
    var previewElement = document.getElementById('logo_preview');
    var previewImage = document.getElementById('logo_preview_img');
    var hiddenInput = document.getElementById('logo_preview_base64');

    if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            previewElement.style.display = 'block';
            previewImage.src = e.target.result;
            hiddenInput.value = e.target.result;
        };
        reader.readAsDataURL(file);
    } else {
        previewElement.style.display = 'none';
        hiddenInput.value = '';
    }
});

document.getElementById('brandForm').addEventListener('submit', function() {
    var logoBase64 = document.getElementById('logo_preview_base64').value;
    if (logoBase64) {
        function dataURLtoBlob(dataurl) {
            var arr = dataurl.split(','), mime = arr[0].match(/:(.*?);/)[1],
                bstr = atob(arr[1]), n = bstr.length, u8arr = new Uint8Array(n);
            while(n--){ u8arr[n] = bstr.charCodeAt(n); }
            return new Blob([u8arr], {type:mime});
        }
        var fileInput = document.getElementById('logo_file');
        var blob = dataURLtoBlob(logoBase64);
        var file = new File([blob], "logo.png", {type: blob.type});
        var dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        fileInput.files = dataTransfer.files;
    }
});
</script>
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>
document.querySelectorAll('.ck-editor').forEach((element) => {
    ClassicEditor.create(element).catch(error => console.error(error));
});
</script>
@endsection
