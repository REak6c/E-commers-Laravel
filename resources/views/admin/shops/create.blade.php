@extends('admin.layouts.admin')

@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">{{ __('cms.shops.create_shop') ?? 'Create New Shop' }}</h4>
            <a href="{{ route('admin.shops.index') }}" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> {{ __('cms.common.back') ?? 'Back' }}
            </a>
        </div>
    </div>
</div>

<form action="{{ route('admin.shops.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">{{ __('cms.shops.name') }}</label>
                        <input type="text" name="name" class="form-control border-0 bg-light @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" required placeholder="e.g. My Premium Shop">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-semibold">{{ __('cms.shops.description') ?? 'Description' }}</label>
                        <textarea name="description" class="form-control border-0 bg-light @error('description') is-invalid @enderror" rows="6"
                            placeholder="Tell us about the shop...">{{ old('description') }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Publishing & Status -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">{{ __('cms.shops.shop_visibility') }}</h6>

                    <x-admin.select
                        name="status"
                        wrapper-class="mb-4"
                        :label="__('cms.shops.status')"
                        :options="['active' => __('cms.shops.active'), 'inactive' => __('cms.shops.inactive')]"
                        required />

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary shadow-sm py-2">
                            <i class="bi bi-save me-1"></i> {{ __('cms.common.save') ?? 'Create Shop' }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Logo Upload -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">{{ __('cms.shops.logo') }}</h6>

                    <div class="mb-3 text-center">
                        <div class="image-preview mb-3 bg-light rounded py-4 border-2 border-dashed" id="logo_preview" style="display:none;">
                            <img id="logo_preview_img" src="#" class="img-fluid rounded shadow-sm" style="max-height: 150px;">
                        </div>

                        <div class="placeholder-preview mb-3 text-center bg-light rounded py-4 border-2 border-dashed pointer-cursor"
                             onclick="document.getElementById('logo_input').click()" id="logo_placeholder">
                            <i class="bi bi-shop text-muted" style="font-size: 2rem;"></i>
                            <p class="text-muted small mt-2 mb-0">{{ __('cms.shops.click_to_upload_logo') }}</p>
                        </div>

                        <div class="d-grid">
                            <label class="btn btn-outline-primary btn-sm" for="logo_input">
                                <i class="bi bi-cloud-arrow-up me-1"></i> {{ __('cms.shops.choose_logo') }}
                            </label>
                            <input type="file" name="logo" id="logo_input" class="form-control d-none @error('logo') is-invalid @enderror"
                                   accept="image/*" onchange="previewLogo(this)">
                        </div>
                        <div class="form-text mt-2">{{ __('cms.shops.logo_hint') }}</div>
                        @error('logo') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('js')
<script>
function previewLogo(input) {
    const preview = document.getElementById('logo_preview');
    const previewImg = document.getElementById('logo_preview_img');
    const placeholder = document.getElementById('logo_placeholder');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
            if(placeholder) placeholder.style.display = 'none';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
