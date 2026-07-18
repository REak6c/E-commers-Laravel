@extends('admin.layouts.admin')

@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">{{ 'Edit Page' }}</h4>
            <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> {{ 'Back' }}
            </a>
        </div>
    </div>
</div>

<form action="{{ route('admin.pages.update', $page->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    @php $translation = $page; @endphp

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">{{ 'Title' }}</label>
                        <input type="text" name="title"
                            class="form-control border-0 bg-light @error('title') is-invalid @enderror"
                            value="{{ old('title', $page->title) }}" required>
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-semibold">{{ 'Content' }}</label>
                        <textarea name="content"
                            class="form-control ck-editor @error('content') is-invalid @enderror">{{ old('content', $page->content) }}</textarea>
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
                    <p class="text-muted small">{{ 'Save to update this page.' }}</p>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary shadow-sm py-2">
                            <i class="bi bi-save me-1"></i> {{ 'Update Page' }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Image -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">{{ 'Image' }}</h6>

                    <div class="mb-3 text-center">
                        <div class="image-preview mb-3 bg-light rounded py-4 border-2 border-dashed"
                             id="image_preview_en"
                             style="display:{{ $page->image_url ? 'block' : 'none' }};">
                            <img id="image_preview_img_en"
                                src="{{ $page->image_url ? Storage::url($page->image_url) : '#' }}"
                                class="img-fluid rounded shadow-sm" style="max-height: 150px;">
                        </div>

                        <div class="d-grid">
                            <label class="btn btn-outline-primary btn-sm" for="image_file_en">
                                <i class="bi bi-cloud-arrow-up me-1"></i> {{ 'Change Image' }}
                            </label>
                            <input type="file" id="image_file_en"
                                name="image" accept="image/*"
                                class="form-control d-none @error('image') is-invalid @enderror"
                                onchange="previewImage()">
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
document.querySelectorAll('.ck-editor').forEach(el => {
    ClassicEditor.create(el).catch(console.error);
});

function previewImage() {
    const input = document.getElementById('image_file_en');
    const previewDiv = document.getElementById('image_preview_en');
    const previewImg = document.getElementById('image_preview_img_en');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewDiv.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
