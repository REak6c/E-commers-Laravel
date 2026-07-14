@extends('vendor.layouts.master')

@section('css')
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.css">
@endsection

@section('content')

{{-- Page Header --}}
<div class="vp-page-header">
    <div class="vp-page-header__left">
        <h1 class="vp-page-header__title">
            <i class="fas fa-plus-circle me-2" style="color:var(--vp-primary);font-size:1.1rem;"></i>
            {{ __('cms.products.title_create') }}
        </h1>
        <p class="vp-page-header__sub">Fill in the details below to add a new product to your store.</p>
    </div>
    <div class="vp-page-header__actions">
        <a href="{{ route('vendor.products.index') }}" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-2" style="border-radius:8px;font-size:.82rem;">
            <i class="fas fa-arrow-left"></i> Back to Products
        </a>
    </div>
</div>

<form action="{{ route('vendor.products.store') }}" method="POST" enctype="multipart/form-data" id="create-product-form">
@csrf

<div class="row g-4">

    {{-- ===== LEFT COLUMN: main info ===== --}}
    <div class="col-xl-8">

        {{-- Basic Info Card --}}
        <div class="vp-card mb-4">
            <div class="vp-card-header">
                <h6 class="vp-card-header__title">
                    <span class="vp-card-header__icon"><i class="fas fa-tag"></i></span>
                    Product Information
                </h6>
            </div>
            <div class="vp-card-body">

                <div class="vp-form-group">
                    <label class="vp-label" for="name">
                        {{ __('cms.products.product_name') }} <span class="required">*</span>
                    </label>
                    <input type="text" id="name" name="name"
                           class="vp-input @error('name') is-invalid @enderror"
                           value="{{ old('name') }}"
                           placeholder="e.g. Premium Wireless Headphones">
                    @error('name')
                        <div class="vp-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="vp-form-group" style="margin-bottom:0;">
                    <label class="vp-label" for="description">{{ __('cms.products.description') }}</label>
                    <textarea id="description" name="description"
                              class="vp-input ck-editor @error('description') is-invalid @enderror"
                              rows="5"
                              placeholder="Describe your product…">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="vp-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>

        {{-- Category & Brand Card --}}
        <div class="vp-card mb-4">
            <div class="vp-card-header">
                <h6 class="vp-card-header__title">
                    <span class="vp-card-header__icon"><i class="fas fa-layer-group"></i></span>
                    Classification
                </h6>
            </div>
            <div class="vp-card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="vp-form-group" style="margin-bottom:0;">
                            <label class="vp-label" for="category_id">{{ __('cms.products.category') }}</label>
                            <select id="category_id" name="category_id" class="vp-select">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name ?? '—' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="vp-form-group" style="margin-bottom:0;">
                            <label class="vp-label" for="brand_id">{{ __('cms.products.brand') }}</label>
                            <select id="brand_id" name="brand_id" class="vp-select">
                                <option value="">{{ __('cms.products.no_brand') }}</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name ?? '—' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Variants Card --}}
        <div class="vp-card mb-4">
            <div class="vp-card-header">
                <h6 class="vp-card-header__title">
                    <span class="vp-card-header__icon"><i class="fas fa-cubes"></i></span>
                    Product Variants
                </h6>
                <span class="badge rounded-pill" style="background:var(--vp-primary-bg);color:var(--vp-primary);font-size:.72rem;font-weight:700;" id="variant-count-badge">0 variants</span>
            </div>
            <div class="vp-card-body">

                <div id="variants-wrapper"></div>

                <div class="vp-variant-controls mt-2">
                    <button type="button" id="add-variant-btn" class="vp-icon-btn vp-icon-btn--add" title="{{ __('cms.products.add_variant') }}">
                        <i class="fas fa-plus"></i>
                    </button>
                    <button type="button" id="remove-variant-btn" class="vp-icon-btn vp-icon-btn--remove" title="Remove last variant" disabled>
                        <i class="fas fa-trash"></i>
                    </button>
                    <span style="font-size:.78rem;color:var(--vp-text-muted);">Add or remove variant rows</span>
                </div>

            </div>
        </div>

    </div>

    {{-- ===== RIGHT COLUMN: images + submit ===== --}}
    <div class="col-xl-4">

        {{-- Product Images Card --}}
        <div class="vp-card mb-4">
            <div class="vp-card-header">
                <h6 class="vp-card-header__title">
                    <span class="vp-card-header__icon"><i class="fas fa-images"></i></span>
                    {{ __('cms.products.images') }}
                </h6>
            </div>
            <div class="vp-card-body">
                <div class="vp-upload-zone" id="upload-zone" onclick="document.getElementById('productImages').click();">
                    <div class="vp-upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                    <p class="vp-upload-label">Click to upload images</p>
                    <p class="vp-upload-hint">PNG, JPG, WEBP — multiple allowed</p>
                </div>
                <input type="file" name="images[]" id="productImages" multiple accept="image/*"
                       class="d-none" onchange="previewMultipleImages(this)">
                <div id="productImagesPreview" class="vp-image-grid"></div>
            </div>
        </div>

        {{-- Submit Card --}}
        <div class="vp-card">
            <div class="vp-card-body">
                <button type="submit" class="vp-btn-save w-100 justify-content-center" id="saveProductBtn">
                    <span class="spinner-border spinner-border-sm d-none" id="productLoader" role="status"></span>
                    <i class="fas fa-check-circle" id="saveIcon"></i>
                    {{ __('cms.products.save_product') }}
                </button>
                <a href="{{ route('vendor.products.index') }}"
                   class="btn btn-light w-100 mt-2 d-flex align-items-center justify-content-center gap-2"
                   style="border-radius:10px;font-size:.85rem;font-weight:600;border:1.5px solid var(--vp-border);">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </div>

    </div>
</div>

</form>

{{-- Variant Template --}}
<template id="variant-template">
    <div class="vp-variant-block" data-index="__INDEX__">
        <div class="vp-variant-header">
            <div class="vp-variant-title">
                <i class="fas fa-cube"></i>
                {{ __('cms.products.variants') }}
                <span class="vp-variant-badge">#__NUMBER__</span>
            </div>
        </div>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="vp-label">{{ __('cms.products.variant_name_en') }}</label>
                <input type="text" name="variants[__INDEX__][name]" class="vp-input" value="__NAME__" placeholder="e.g. Standard">
            </div>
            <div class="col-md-4">
                <label class="vp-label">{{ __('cms.products.price') }} <span class="required">*</span></label>
                <input type="number" step="0.01" name="variants[__INDEX__][price]" class="vp-input" value="__PRICE__" placeholder="0.00">
            </div>
            <div class="col-md-4">
                <label class="vp-label">{{ __('cms.products.discount_price') }}</label>
                <input type="number" step="0.01" name="variants[__INDEX__][discount_price]" class="vp-input" value="__DISCOUNT__" placeholder="0.00">
            </div>
            <div class="col-md-4">
                <label class="vp-label">{{ __('cms.products.stock') }}</label>
                <input type="number" name="variants[__INDEX__][stock]" class="vp-input" value="__STOCK__" placeholder="0">
            </div>
            <div class="col-md-4">
                <label class="vp-label">{{ __('cms.products.sku') }}</label>
                <input type="text" name="variants[__INDEX__][SKU]" class="vp-input" value="__SKU__" placeholder="SKU-001">
            </div>
            <div class="col-md-4">
                <label class="vp-label">{{ __('cms.products.barcode') }}</label>
                <input type="text" name="variants[__INDEX__][barcode]" class="vp-input" value="__BARCODE__">
            </div>
            <div class="col-md-6">
                <label class="vp-label">{{ __('cms.products.weight') }}</label>
                <input type="text" name="variants[__INDEX__][weight]" class="vp-input" value="__WEIGHT__" placeholder="e.g. 0.5kg">
            </div>
            <div class="col-md-6">
                <label class="vp-label">{{ __('cms.products.dimension') }}</label>
                <input type="text" name="variants[__INDEX__][dimension]" class="vp-input" value="__DIMENSION__" placeholder="e.g. 10x5x3cm">
            </div>
            <div class="col-md-6">
                <label class="vp-label">{{ __('cms.products.size') }}</label>
                <select name="variants[__INDEX__][size_id]" class="vp-select">
                    @foreach($sizes as $size)
                        <option value="{{ $size->id }}">{{ $size->value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="vp-label">{{ __('cms.products.color') }}</label>
                <select name="variants[__INDEX__][color_id]" class="vp-select">
                    @foreach($colors as $color)
                        <option value="{{ $color->id }}">{{ $color->value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</template>

@endsection

@section('js')
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>
document.querySelectorAll('.ck-editor').forEach(el => {
    ClassicEditor.create(el).catch(console.error);
});
</script>

<script>
let variantIndex = 0;

function updateVariantBadge() {
    const count = document.querySelectorAll('#variants-wrapper .vp-variant-block').length;
    document.getElementById('variant-count-badge').textContent = count + (count === 1 ? ' variant' : ' variants');
    document.getElementById('remove-variant-btn').disabled = count === 0;
}

function addVariant(variant = {}, index = variantIndex) {
    let tpl = document.getElementById('variant-template').innerHTML;
    tpl = tpl
        .replaceAll('__INDEX__',    index)
        .replaceAll('__NUMBER__',   index + 1)
        .replaceAll('__NAME__',     variant.name || '')
        .replaceAll('__PRICE__',    variant.price || '')
        .replaceAll('__DISCOUNT__', variant.discount_price || '')
        .replaceAll('__STOCK__',    variant.stock || '')
        .replaceAll('__SKU__',      variant.SKU || '')
        .replaceAll('__BARCODE__',  variant.barcode || '')
        .replaceAll('__WEIGHT__',   variant.weight || '')
        .replaceAll('__DIMENSION__',variant.dimension || '');

    const wrap = document.createElement('div');
    wrap.innerHTML = tpl;
    document.getElementById('variants-wrapper').appendChild(wrap.firstElementChild);
    variantIndex++;
    updateVariantBadge();
}

document.addEventListener('DOMContentLoaded', function () {
    @if(old('variants'))
        let oldVariants = @json(old('variants'));
        oldVariants.forEach((v, i) => addVariant(v, i));
    @else
        addVariant();
    @endif

    document.getElementById('add-variant-btn').addEventListener('click', () => addVariant());

    document.getElementById('remove-variant-btn').addEventListener('click', () => {
        const items = document.querySelectorAll('#variants-wrapper .vp-variant-block');
        if (items.length > 0) {
            items[items.length - 1].remove();
            variantIndex--;
            updateVariantBadge();
        }
    });

    // Submit loader
    document.getElementById('create-product-form').addEventListener('submit', function () {
        const btn = document.getElementById('saveProductBtn');
        btn.disabled = true;
        document.getElementById('productLoader').classList.remove('d-none');
        document.getElementById('saveIcon').classList.add('d-none');
    });

    // Drag-over highlight on upload zone
    const zone = document.getElementById('upload-zone');
    zone.addEventListener('dragover', e => { e.preventDefault(); zone.classList.add('drag-over'); });
    zone.addEventListener('dragleave', () => zone.classList.remove('drag-over'));
    zone.addEventListener('drop', e => {
        e.preventDefault();
        zone.classList.remove('drag-over');
        const input = document.getElementById('productImages');
        const dt = new DataTransfer();
        [...e.dataTransfer.files].forEach(f => dt.items.add(f));
        input.files = dt.files;
        previewMultipleImages(input);
    });
});

let selectedFiles = [];

function previewMultipleImages(input) {
    const files = Array.from(input.files);
    files.forEach(file => {
        if (!selectedFiles.some(f => f.name === file.name && f.size === file.size)) {
            selectedFiles.push(file);
        }
    });

    const preview = document.getElementById('productImagesPreview');
    preview.innerHTML = '';
    selectedFiles.forEach((file, idx) => {
        const reader = new FileReader();
        reader.onload = e => {
            const thumb = document.createElement('div');
            thumb.className = 'vp-image-thumb';
            thumb.innerHTML = `<img src="${e.target.result}" alt="">
                <button type="button" class="vp-image-thumb__remove" onclick="removePreviewImage(${idx})">
                    <i class="fas fa-times"></i>
                </button>`;
            preview.appendChild(thumb);
        };
        reader.readAsDataURL(file);
    });

    syncFiles(input);
}

function removePreviewImage(idx) {
    selectedFiles.splice(idx, 1);
    const input = document.getElementById('productImages');
    syncFiles(input);
    previewMultipleImages({ files: [] });
}

function syncFiles(input) {
    const dt = new DataTransfer();
    selectedFiles.forEach(f => dt.items.add(f));
    input.files = dt.files;
}
</script>

@if (session('success'))
<script>
    toastr.success("{{ session('success') }}", "{{ __('cms.products.success') }}", {
        closeButton: true, progressBar: true, positionClass: "toast-top-right", timeOut: 5000
    });
</script>
@endif
@endsection
