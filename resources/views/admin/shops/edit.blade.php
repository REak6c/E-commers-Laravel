@extends('admin.layouts.admin')

@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">{{ __('cms.shops.edit_shop') ?? 'Edit Shop' }}</h4>
            <a href="{{ route('admin.shops.index') }}" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> {{ __('cms.common.back') ?? 'Back' }}
            </a>
        </div>
    </div>
</div>

<form action="{{ route('admin.shops.update', $shop->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">{{ __('cms.shops.name') }}</label>
                        <input type="text" name="name" class="form-control border-0 bg-light @error('name') is-invalid @enderror"
                            value="{{ old('name', $shop->name) }}" required placeholder="Enter shop name">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-semibold">{{ __('cms.shops.description') ?? 'Description' }}</label>
                        <textarea name="description" class="form-control border-0 bg-light @error('description') is-invalid @enderror" rows="6"
                            placeholder="Enter shop description">{{ old('description', $shop->description) }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Visibility & Status -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">{{ __('cms.shops.shop_visibility') }}</h6>

                    <x-admin.select
                        name="status"
                        wrapper-class="mb-4"
                        :label="__('cms.shops.status')"
                        :selected="$shop->status"
                        :options="[__('cms.shops.active') => __('cms.shops.active'), __('cms.shops.inactive') => __('cms.shops.inactive')]"
                        required />

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary shadow-sm py-2">
                            <i class="bi bi-save me-1"></i> {{ __('cms.common.update') ?? 'Update Shop' }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Logo Upload -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4 text-center">
                    <h6 class="fw-bold mb-3 text-start">{{ __('cms.shops.logo') }}</h6>

                    <div class="image-preview mb-3 bg-light rounded py-4 border-2 border-dashed" id="logo_preview">
                        <img id="logo_preview_img"
                             src="{{ $shop->logo ? asset('storage/'.$shop->logo) : '#' }}"
                             class="img-fluid rounded shadow-sm"
                             style="max-height: 150px; display: {{ $shop->logo ? 'block' : 'none' }}; margin: 0 auto;">

                        @if(!$shop->logo)
                        <div id="logo_placeholder">
                            <i class="bi bi-shop text-muted" style="font-size: 2rem;"></i>
                            <p class="text-muted small mt-2 mb-0">{{ __('cms.shops.no_logo_uploaded') }}</p>
                        </div>
                        @endif
                    </div>

                    <div class="d-grid">
                        <label class="btn btn-outline-primary btn-sm" for="logo_input">
                            <i class="bi bi-cloud-arrow-up me-1"></i> {{ __('cms.shops.change_logo') }}
                        </label>
                        <input type="file" name="logo" id="logo_input" class="form-control d-none @error('logo') is-invalid @enderror"
                               accept="image/*" onchange="previewLogo(this)">
                    </div>
                    @error('logo') <div class="invalid-feedback d-block mt-2">{{ $message }}</div> @enderror
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
            previewImg.style.display = 'block';
            if(placeholder) placeholder.style.display = 'none';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
