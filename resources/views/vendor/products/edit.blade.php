@extends('vendor.layouts.master')

@section('css')
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.css">
@endsection

@section('content')

{{-- Page Header --}}
<div class="vp-page-header">
    <div class="vp-page-header__left">
        <h1 class="vp-page-header__title">
            <i class="fas fa-edit me-2" style="color:var(--vp-primary);font-size:1.1rem;"></i>
            {{ 'Edit Product' }}
        </h1>
        <p class="vp-page-header__sub">Update the details for <strong>{{ $product->name }}</strong>.</p>
    </div>
    <div class="vp-page-header__actions">
        <a href="{{ route('vendor.products.index') }}"
           class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-2"
           style="border-radius:8px;font-size:.82rem;">
            <i class="fas fa-arrow-left"></i> Back to Products
        </a>
    </div>
</div>

<form action="{{ route('vendor.products.update', $product->id) }}" method="POST"
      enctype="multipart/form-data" id="edit-product-form">
@csrf
@method('PUT')

<div class="row g-4">

    {{-- ===== LEFT COLUMN ===== --}}
    <div class="col-xl-8">

        {{-- Basic Info --}}
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
                        {{ 'Product Name' }} <span class="required">*</span>
                    </label>
                    <input type="text" id="name" name="name"
                           class="vp-input @error('name') is-invalid @enderror"
                           value="{{ old('name', $product->name) }}"
                           placeholder="e.g. Premium Wireless Headphones">
                    @error('name')
                        <div class="vp-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="vp-form-group" style="margin-bottom:0;">
                    <label class="vp-label" for="description">{{ 'Description' }}</label>
                    <textarea id="description" name="description"
                              class="vp-input ck-editor @error('description') is-invalid @enderror"
                              rows="5">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <div class="vp-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>

        {{-- Classification --}}
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
                        <x-admin.combobox
                            name="category_id"
                            wrapper-class=""
                            :label="'Category'"
                            :options="$categories"
                            option-label="name"
                            :selected="old('category_id', $product->category_id)" />
                    </div>
                    <div class="col-md-6">
                        <x-admin.combobox
                            name="brand_id"
                            wrapper-class=""
                            :label="'Brand'"
                            :placeholder="'No Brand'"
                            :options="$brands"
                            option-label="name"
                            :selected="old('brand_id', $product->brand_id)" />
                    </div>
                </div>
            </div>
        </div>

        {{-- Variants --}}
        <div class="vp-card mb-4">
            <div class="vp-card-header">
                <h6 class="vp-card-header__title">
                    <span class="vp-card-header__icon"><i class="fas fa-cubes"></i></span>
                    Product Variants
                </h6>
                <span class="badge rounded-pill" id="variant-count-badge"
                      style="background:var(--vp-primary-bg);color:var(--vp-primary);font-size:.72rem;font-weight:700;">
                    {{ count($product->variants) }} {{ count($product->variants) === 1 ? 'variant' : 'variants' }}
                </span>
            </div>
            <div class="vp-card-body">

                <div id="variants-wrapper">
                    @foreach($product->variants as $index => $variant)
                        @php
                            $sizeId  = $variant->attributeValues->firstWhere('attribute.name', 'Size')?->id;
                            $colorId = $variant->attributeValues->firstWhere('attribute.name', 'Color')?->id;
                        @endphp
                        <div class="vp-variant-block" data-variant-id="{{ $variant->id }}">
                            <div class="vp-variant-header">
                                <div class="vp-variant-title">
                                    <i class="fas fa-cube"></i>
                                    {{ 'Variant' }}
                                    <span class="vp-variant-badge">#{{ $index + 1 }}</span>
                                </div>
                                <button type="button"
                                        class="vp-variant-remove"
                                        onclick="removeExistingVariant(this, {{ $variant->id }})"
                                        title="{{ 'Remove' }}">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="vp-label">{{ 'Variant Name' }}</label>
                                    <input type="text" name="variants[{{ $index }}][name]"
                                           class="vp-input" value="{{ $variant->name }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="vp-label">{{ 'Price' }} <span class="required">*</span></label>
                                    <input type="number" step="0.01" name="variants[{{ $index }}][price]"
                                           class="vp-input" value="{{ $variant->price }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="vp-label">{{ 'Discount Price' }}</label>
                                    <input type="number" step="0.01" name="variants[{{ $index }}][discount_price]"
                                           class="vp-input" value="{{ $variant->discount_price }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="vp-label">{{ 'Stock' }}</label>
                                    <input type="number" name="variants[{{ $index }}][stock]"
                                           class="vp-input" value="{{ $variant->stock }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="vp-label">{{ 'SKU' }}</label>
                                    <input type="text" name="variants[{{ $index }}][SKU]"
                                           class="vp-input" value="{{ $variant->SKU }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="vp-label">{{ 'Barcode' }}</label>
                                    <input type="text" name="variants[{{ $index }}][barcode]"
                                           class="vp-input" value="{{ $variant->barcode }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="vp-label">{{ 'Weight' }}</label>
                                    <input type="text" name="variants[{{ $index }}][weight]"
                                           class="vp-input" value="{{ $variant->weight }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="vp-label">{{ 'Dimensions' }}</label>
                                    <input type="text" name="variants[{{ $index }}][dimensions]"
                                           class="vp-input" value="{{ $variant->dimensions }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="vp-label">{{ 'Size' }}</label>
                                    <select name="variants[{{ $index }}][size_id]" class="vp-select">
                                        @foreach($sizes as $size)
                                            <option value="{{ $size->id }}"
                                                {{ $sizeId == $size->id ? 'selected' : '' }}>
                                                {{ $size->value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="vp-label">{{ 'Color' }}</label>
                                    <select name="variants[{{ $index }}][color_id]" class="vp-select">
                                        @foreach($colors as $color)
                                            <option value="{{ $color->id }}"
                                                {{ $colorId == $color->id ? 'selected' : '' }}>
                                                {{ $color->value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="vp-variant-controls mt-2">
                    <button type="button" id="add-variant-btn"
                            class="vp-icon-btn vp-icon-btn--add"
                            title="{{ 'Add Variant' }}">
                        <i class="fas fa-plus"></i>
                    </button>
                    <span style="font-size:.78rem;color:var(--vp-text-muted);">Add a new variant row</span>
                </div>

            </div>
        </div>

    </div>

    {{-- ===== RIGHT COLUMN ===== --}}
    <div class="col-xl-4">

        {{-- Existing Images --}}
        @if ($product->images && $product->images->count())
        <div class="vp-card mb-4">
            <div class="vp-card-header">
                <h6 class="vp-card-header__title">
                    <span class="vp-card-header__icon"><i class="fas fa-photo-film"></i></span>
                    Current Images
                </h6>
                <span class="badge rounded-pill"
                      style="background:#f0fdf4;color:#16a34a;font-size:.72rem;font-weight:700;">
                    {{ $product->images->count() }} image{{ $product->images->count() > 1 ? 's' : '' }}
                </span>
            </div>
            <div class="vp-card-body">
                <div class="vp-image-grid">
                    @foreach ($product->images as $image)
                        <div class="vp-image-thumb" id="image_{{ $image->id }}">
                            <img src="{{ asset('storage/' . $image->image_url) }}" alt="{{ $image->name }}">
                            <button type="button" class="vp-image-thumb__remove"
                                    onclick="removeExistingImage({{ $image->id }})"
                                    title="{{ 'Remove' }}">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- Upload New Images --}}
        <div class="vp-card mb-4">
            <div class="vp-card-header">
                <h6 class="vp-card-header__title">
                    <span class="vp-card-header__icon"><i class="fas fa-cloud-upload-alt"></i></span>
                    Add New Images
                </h6>
            </div>
            <div class="vp-card-body">
                <div class="vp-upload-zone" id="upload-zone"
                     onclick="document.getElementById('productImages').click();">
                    <div class="vp-upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                    <p class="vp-upload-label">Click to upload images</p>
                    <p class="vp-upload-hint">PNG, JPG, WEBP — multiple allowed</p>
                </div>
                <input type="file" name="images[]" id="productImages" multiple accept="image/*"
                       class="d-none" onchange="previewMultipleImages(this)">
                <div id="productImagesPreview" class="vp-image-grid"></div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="vp-card">
            <div class="vp-card-body">
                <button type="submit" class="vp-btn-save w-100 justify-content-center" id="updateProductBtn">
                    <span class="spinner-border spinner-border-sm d-none" id="productLoader" role="status"></span>
                    <i class="fas fa-save" id="saveIcon"></i>
                    {{ 'Update Product' }}
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

{{-- Hidden inputs for removed images / variants --}}
<div id="removedImagesInputs"></div>
<div id="removedVariantsInputs"></div>

</form>

{{-- New variant template --}}
<template id="variant-template">
    <div class="vp-variant-block" data-new="1">
        <div class="vp-variant-header">
            <div class="vp-variant-title">
                <i class="fas fa-cube"></i>
                {{ 'Variant' }}
                <span class="vp-variant-badge">#__NUMBER__</span>
            </div>
            <button type="button" class="vp-variant-remove"
                    onclick="this.closest('.vp-variant-block').remove(); updateVariantBadge();"
                    title="{{ 'Remove' }}">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="vp-label">{{ 'Variant Name' }}</label>
                <input type="text" name="variants[__INDEX__][name]" class="vp-input" placeholder="e.g. Standard">
            </div>
            <div class="col-md-4">
                <label class="vp-label">{{ 'Price' }} <span class="required">*</span></label>
                <input type="number" step="0.01" name="variants[__INDEX__][price]" class="vp-input" placeholder="0.00">
            </div>
            <div class="col-md-4">
                <label class="vp-label">{{ 'Discount Price' }}</label>
                <input type="number" step="0.01" name="variants[__INDEX__][discount_price]" class="vp-input" placeholder="0.00">
            </div>
            <div class="col-md-4">
                <label class="vp-label">{{ 'Stock' }}</label>
                <input type="number" name="variants[__INDEX__][stock]" class="vp-input" placeholder="0">
            </div>
            <div class="col-md-4">
                <label class="vp-label">{{ 'SKU' }}</label>
                <input type="text" name="variants[__INDEX__][SKU]" class="vp-input" placeholder="SKU-001">
            </div>
            <div class="col-md-4">
                <label class="vp-label">{{ 'Barcode' }}</label>
                <input type="text" name="variants[__INDEX__][barcode]" class="vp-input">
            </div>
            <div class="col-md-6">
                <label class="vp-label">{{ 'Weight' }}</label>
                <input type="text" name="variants[__INDEX__][weight]" class="vp-input" placeholder="e.g. 0.5kg">
            </div>
            <div class="col-md-6">
                <label class="vp-label">{{ 'Dimensions' }}</label>
                <input type="text" name="variants[__INDEX__][dimensions]" class="vp-input" placeholder="e.g. 10x5x3cm">
            </div>
            <div class="col-md-6">
                <label class="vp-label">{{ 'Size' }}</label>
                <select name="variants[__INDEX__][size_id]" class="vp-select">
                    @foreach($sizes as $size)
                        <option value="{{ $size->id }}">{{ $size->value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="vp-label">{{ 'Color' }}</label>
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
let variantIndex = {{ count($product->variants) }};

function updateVariantBadge() {
    const count = document.querySelectorAll('#variants-wrapper .vp-variant-block').length;
    document.getElementById('variant-count-badge').textContent =
        count + (count === 1 ? ' variant' : ' variants');
}

document.getElementById('add-variant-btn').addEventListener('click', function () {
    const number = document.querySelectorAll('#variants-wrapper .vp-variant-block').length + 1;
    let tpl = document.getElementById('variant-template').innerHTML;
    tpl = tpl
        .replaceAll('__INDEX__',  variantIndex)
        .replaceAll('__NUMBER__', number);
    const wrap = document.createElement('div');
    wrap.innerHTML = tpl;
    document.getElementById('variants-wrapper').appendChild(wrap.firstElementChild);
    variantIndex++;
    updateVariantBadge();
});

function removeExistingVariant(btn, variantId) {
    btn.closest('.vp-variant-block').remove();
    const input = document.createElement('input');
    input.type  = 'hidden';
    input.name  = 'remove_variants[]';
    input.value = variantId;
    document.getElementById('removedVariantsInputs').appendChild(input);
    updateVariantBadge();
}

// Submit loader
document.getElementById('edit-product-form').addEventListener('submit', function () {
    const btn = document.getElementById('updateProductBtn');
    btn.disabled = true;
    document.getElementById('productLoader').classList.remove('d-none');
    document.getElementById('saveIcon').classList.add('d-none');
});

// Drag-over upload zone
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

let selectedFiles = [];

function previewMultipleImages(input) {
    const files = Array.from(input.files);
    files.forEach(file => {
        if (!selectedFiles.some(f => f.name === file.name && f.size === file.size)) {
            selectedFiles.push(file);
        }
    });
    renderPreviews();
    syncFiles(input);
}

function renderPreviews() {
    const preview = document.getElementById('productImagesPreview');
    preview.innerHTML = '';
    selectedFiles.forEach((file, idx) => {
        const reader = new FileReader();
        reader.onload = e => {
            const thumb = document.createElement('div');
            thumb.className = 'vp-image-thumb';
            thumb.innerHTML = `<img src="${e.target.result}" alt="">
                <button type="button" class="vp-image-thumb__remove" onclick="removeNewImage(${idx})">
                    <i class="fas fa-times"></i>
                </button>`;
            preview.appendChild(thumb);
        };
        reader.readAsDataURL(file);
    });
}

function removeNewImage(idx) {
    selectedFiles.splice(idx, 1);
    syncFiles(document.getElementById('productImages'));
    renderPreviews();
}

function syncFiles(input) {
    const dt = new DataTransfer();
    selectedFiles.forEach(f => dt.items.add(f));
    input.files = dt.files;
}

function removeExistingImage(imageId) {
    const el = document.getElementById('image_' + imageId);
    if (el) el.remove();
    const input = document.createElement('input');
    input.type  = 'hidden';
    input.name  = 'remove_images[]';
    input.value = imageId;
    document.getElementById('removedImagesInputs').appendChild(input);
}
</script>

@if (session('success'))
<script>
    toastr.success("{{ session('success') }}", "{{ 'Success' }}", {
        closeButton: true, progressBar: true, positionClass: "toast-top-right", timeOut: 5000
    });
</script>
@endif
@endsection
