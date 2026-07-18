@extends('admin.layouts.admin')

@section('content')

{{-- Page Title --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-bold">{{ 'Edit Product' }}</h4>
        <p class="text-muted small mb-0">
            <i class="bi bi-hash me-1"></i>{{ $product->id }}
            &nbsp;&middot;&nbsp;
            {{ $product->getTranslation('name', 'en') }}
        </p>
    </div>
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm">
        <i class="bi bi-arrow-left me-1"></i>{{ 'Back' }}
    </a>
</div>

<form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">

        {{-- ── Left: main content ── --}}
        <div class="col-lg-8">

            {{-- Product Info --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4 pb-2 border-bottom">
                        <i class="bi bi-box-seam text-primary me-2"></i>{{ 'Product Info' }}
                    </h6>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ 'Product Name' }}</label>
                        <input type="text"
                            name="name"
                            class="form-control bg-light border-0 @error('name') is-invalid @enderror"
                            value="{{ old('name', $product->name) }}"
                            placeholder="e.g. Wireless Headphones">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ 'Description' }}</label>
                        <textarea
                            name="description"
                            class="form-control bg-light border-0 ck-editor @error('description') is-invalid @enderror"
                            rows="8">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-semibold">{{ 'Short Description' }}</label>
                        <textarea
                            name="short_description"
                            class="form-control bg-light border-0"
                            rows="3"
                            placeholder="{{ 'Brief product summary...' }}">{{ old('short_description', $product->short_description) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Variants --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                        <h6 class="fw-bold mb-0">
                            <i class="bi bi-layers text-warning me-2"></i>{{ 'Variants' }}
                            <span class="badge bg-light text-secondary fw-semibold ms-1" id="variant-count">{{ count($product->variants) }}</span>
                        </h6>
                        <button type="button" id="add-variant-btn" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-lg me-1"></i>{{ 'Add Variant' }}
                        </button>
                    </div>

                    <div id="variants-wrapper">
                        @foreach ($product->variants as $index => $variant)
                        @php $enTranslation = $variant; @endphp

                        <div class="variant-block bg-light rounded-3 p-3 mb-3" data-index="{{ $index }}">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <span class="badge bg-primary">
                                    <i class="bi bi-tag-fill me-1"></i>{{ 'Variant #' . $index + 1 }}
                                </span>
                                <button type="button" class="btn btn-sm btn-outline-danger remove-variant-item"
                                    onclick="removeVariant({{ $variant->id ?? 'null' }}, this)">
                                    <i class="bi bi-trash3 me-1"></i>{{ 'Remove' }}
                                </button>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small">{{ 'Variant Name' }}</label>
                                    <input type="text" name="variants[{{ $index }}][name]"
                                        class="form-control bg-white border-0"
                                        value="{{ old("variants.{$index}.name", $variant->name) }}"
                                        placeholder="e.g. XL / Red" />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold small">{{ 'Price' }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-0 text-muted">$</span>
                                        <input type="number" step="0.01" name="variants[{{ $index }}][price]"
                                            class="form-control bg-white border-0"
                                            value="{{ old("variants.{$index}.price", $variant->price) }}" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold small">{{ 'Discount Price' }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-0 text-muted">$</span>
                                        <input type="number" step="0.01" name="variants[{{ $index }}][discount_price]"
                                            class="form-control bg-white border-0"
                                            value="{{ old("variants.{$index}.discount_price", $variant->discount_price) }}" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold small">{{ 'Stock' }}</label>
                                    <input type="number" name="variants[{{ $index }}][stock]"
                                        class="form-control bg-white border-0"
                                        value="{{ old("variants.{$index}.stock", $variant->stock) }}" />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold small">{{ 'SKU' }}</label>
                                    <input type="text" name="variants[{{ $index }}][SKU]"
                                        class="form-control bg-white border-0"
                                        value="{{ old("variants.{$index}.SKU", $variant->SKU) }}" />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold small">{{ 'Barcode' }}</label>
                                    <input type="text" name="variants[{{ $index }}][barcode]"
                                        class="form-control bg-white border-0"
                                        value="{{ old("variants.{$index}.barcode", $variant->barcode) }}" />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold small">{{ 'Weight' }}</label>
                                    <input type="text" name="variants[{{ $index }}][weight]"
                                        class="form-control bg-white border-0"
                                        value="{{ old("variants.{$index}.weight", $variant->weight) }}" />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold small">{{ 'Dimensions' }}</label>
                                    <input type="text" name="variants[{{ $index }}][dimensions]"
                                        class="form-control bg-white border-0"
                                        value="{{ old("variants.{$index}.dimensions", $variant->dimensions) }}" />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold small">{{ 'Size' }}</label>
                                    <select name="variants[{{ $index }}][size_id]" class="form-select bg-white border-0">
                                        <option value="">{{ 'No Size' }}</option>
                                        @foreach($sizes as $size)
                                        <option value="{{ $size->id }}" {{ old("variants.{$index}.size_id", $variant->size_id) == $size->id ? 'selected' : '' }}>{{ $size->value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold small">{{ 'Color' }}</label>
                                    <select name="variants[{{ $index }}][color_id]" class="form-select bg-white border-0">
                                        <option value="">{{ 'No Color' }}</option>
                                        @foreach($colors as $color)
                                        <option value="{{ $color->id }}" {{ old("variants.{$index}.color_id", $variant->color_id) == $color->id ? 'selected' : '' }}>{{ $color->value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <div class="form-check form-switch mb-1">
                                        <input class="form-check-input" type="radio" name="primary_variant"
                                            value="{{ $index }}" id="primary_{{ $index }}"
                                            {{ $variant->is_primary ? 'checked' : '' }}>
                                        <label class="form-check-label small fw-semibold" for="primary_{{ $index }}">
                                            {{ 'Primary' }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div id="no-variants-msg" class="text-center py-5" style="{{ count($product->variants) > 0 ? 'display:none' : '' }}">
                        <i class="bi bi-layers text-muted opacity-25" style="font-size:2.5rem;"></i>
                        <p class="text-muted small mt-2 mb-0">{{ 'Click \'Add Variant\' to add product variants.' }}</p>
                    </div>
                </div>
            </div>

        </div>{{-- /col-lg-8 --}}

        {{-- ── Right: sidebar ── --}}
        <div class="col-lg-4">

            {{-- Organization --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 pb-2 border-bottom">
                        <i class="bi bi-diagram-3 text-success me-2"></i>{{ 'Organization' }}
                    </h6>

                    <x-admin.combobox
                        name="category_id"
                        wrapper-class="mb-3"
                        :label="'Category'"
                        :selected="$product->category_id"
                        :options="$categories"
                        option-label="name" />

                    <x-admin.combobox
                        name="brand_id"
                        wrapper-class="mb-3"
                        :label="'Brand'"
                        :selected="$product->brand_id"
                        :placeholder="'No Brand'"
                        :options="$brands"
                        option-label="name" />

                    <x-admin.combobox
                        name="vendor_id"
                        wrapper-class="mb-0"
                        :label="'Vendor'"
                        :selected="$product->vendor_id"
                        :placeholder="'Select Vendor'"
                        :options="$vendors" />
                </div>
            </div>

            {{-- Images --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 pb-2 border-bottom">
                        <i class="bi bi-images text-info me-2"></i>{{ 'Images' }}
                    </h6>

                    @if ($product->images->count())
                    <div class="row g-2 mb-3">
                        @foreach ($product->images as $image)
                        <div class="col-4" id="existing_image_{{ $image->id }}">
                            <div class="position-relative">
                                <img src="{{ asset('storage/' . $image->image_url) }}"
                                    class="img-fluid rounded border"
                                    style="height:72px; width:100%; object-fit:cover;"
                                    alt="product image">
                                <button type="button"
                                    class="btn btn-danger btn-sm rounded-circle position-absolute top-0 end-0 m-1 p-0 d-flex align-items-center justify-content-center"
                                    style="width:20px; height:20px; font-size:.6rem;"
                                    onclick="removeExistingImage({{ $image->id }})">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <div id="image-previews" class="row g-2 mb-3"></div>

                    <label class="btn btn-outline-light border-dashed text-primary w-100 py-3 d-flex flex-column align-items-center gap-1"
                        for="product-images"
                        style="border-style:dashed !important; border-color:#cbd5e1 !important; background:#f8fafc; border-radius:10px; cursor:pointer;">
                        <i class="bi bi-cloud-arrow-up fs-4"></i>
                        <span class="fw-semibold small">{{ 'Upload Images' }}</span>
                        <span class="text-muted" style="font-size:.72rem;">{{ 'PNG, JPG, GIF up to 10MB' }}</span>
                        <input type="file" name="images[]" multiple class="d-none" id="product-images">
                    </label>

                    <div id="removedImagesInputs"></div>
                </div>
            </div>

            {{-- Save --}}
            <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #1d4ed8, #3b82f6);">
                <div class="card-body p-4">
                    <button type="submit" class="btn btn-light w-100 py-2 fw-bold text-primary shadow-sm">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ 'Save Product' }}
                    </button>
                    <p class="text-white opacity-75 small text-center mt-2 mb-0">
                        {{ 'Changes will be saved immediately.' }}
                    </p>
                </div>
            </div>

        </div>{{-- /col-lg-4 --}}
    </div>{{-- /row --}}
</form>

{{-- Variant template --}}
<template id="variant-template">
    <div class="variant-block bg-light rounded-3 p-3 mb-3" data-index="__INDEX__">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <span class="badge bg-primary">
                <i class="bi bi-tag-fill me-1"></i>{{ 'Variant #' . '__NUM__' }}
            </span>
            <button type="button" class="btn btn-sm btn-outline-danger remove-variant-item">
                <i class="bi bi-trash3 me-1"></i>{{ 'Remove' }}
            </button>
        </div>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold small">{{ 'Variant Name' }}</label>
                <input type="text" name="variants[__INDEX__][name]" class="form-control bg-white border-0" placeholder="e.g. XL / Red" />
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold small">{{ 'Price' }}</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-0 text-muted">$</span>
                    <input type="number" step="0.01" name="variants[__INDEX__][price]" class="form-control bg-white border-0" value="0.00" />
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold small">{{ 'Discount Price' }}</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-0 text-muted">$</span>
                    <input type="number" step="0.01" name="variants[__INDEX__][discount_price]" class="form-control bg-white border-0" />
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold small">{{ 'Stock' }}</label>
                <input type="number" name="variants[__INDEX__][stock]" class="form-control bg-white border-0" value="0" />
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold small">{{ 'SKU' }}</label>
                <input type="text" name="variants[__INDEX__][SKU]" class="form-control bg-white border-0" />
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold small">{{ 'Barcode' }}</label>
                <input type="text" name="variants[__INDEX__][barcode]" class="form-control bg-white border-0" />
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold small">{{ 'Weight' }}</label>
                <input type="text" name="variants[__INDEX__][weight]" class="form-control bg-white border-0" />
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold small">{{ 'Dimensions' }}</label>
                <input type="text" name="variants[__INDEX__][dimensions]" class="form-control bg-white border-0" />
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold small">{{ 'Size' }}</label>
                <select name="variants[__INDEX__][size_id]" class="form-select bg-white border-0">
                    <option value="">{{ 'No Size' }}</option>
                    @foreach($sizes as $size)
                    <option value="{{ $size->id }}">{{ $size->value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold small">{{ 'Color' }}</label>
                <select name="variants[__INDEX__][color_id]" class="form-select bg-white border-0">
                    <option value="">{{ 'No Color' }}</option>
                    @foreach($colors as $color)
                    <option value="{{ $color->id }}">{{ $color->value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <div class="form-check form-switch mb-1">
                    <input class="form-check-input" type="radio" name="primary_variant" value="__INDEX__" id="primary___INDEX__">
                    <label class="form-check-label small fw-semibold" for="primary___INDEX__">{{ 'Primary' }}</label>
                </div>
            </div>
        </div>
    </div>
</template>

@endsection

@section('js')
<script>
$(document).ready(function () {
    const template = $('#variant-template').html();
    let variantIndex = {{ count($product->variants) }};

    function updateCount() {
        const n = $('#variants-wrapper .variant-block').length;
        $('#variant-count').text(n);
        n > 0 ? $('#no-variants-msg').hide() : $('#no-variants-msg').show();
    }

    function addVariant(data = {}) {
        const index = variantIndex++;
        let html = template
            .replace(/__INDEX__/g, index)
            .replace(/__NUM__/g, index + 1);
        const $v = $(html);
        if (data.size_id)    $v.find(`select[name="variants[${index}][size_id]"]`).val(data.size_id);
        if (data.color_id)   $v.find(`select[name="variants[${index}][color_id]"]`).val(data.color_id);
        if (data.is_primary) $v.find('input[name="primary_variant"]').prop('checked', true);
        $('#variants-wrapper').append($v);
        updateCount();
    }

    $('#add-variant-btn').on('click', () => addVariant());

    $(document).on('click', '.remove-variant-item', function () {
        $(this).closest('.variant-block').remove();
        reindex();
        updateCount();
    });

    window.removeVariant = (id, btn) => {
        $(btn).closest('.variant-block').remove();
        reindex();
        updateCount();
    };

    function reindex() {
        $('#variants-wrapper .variant-block').each(function (i) {
            $(this).find('.variant-number').text(i + 1);
        });
    }

    $('#product-images').on('change', function () {
        const container = $('#image-previews').empty();
        Array.from(this.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = e => container.append(`
                <div class="col-4">
                    <img src="${e.target.result}" class="img-fluid rounded border" style="height:72px;width:100%;object-fit:cover;">
                </div>`);
            reader.readAsDataURL(file);
        });
    });

    window.removeExistingImage = id => {
        if (!confirm('Remove this image?')) return;
        $(`#existing_image_${id}`).remove();
        $('#removedImagesInputs').append(`<input type="hidden" name="remove_images[]" value="${id}">`);
    };

    updateCount();
});
</script>

<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>
const ckEditors = [];
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.ck-editor').forEach(el => {
        ClassicEditor.create(el, {
            toolbar: ['heading','|','bold','italic','link','bulletedList','numberedList','blockQuote'],
        }).then(editor => ckEditors.push({ editor, el }))
          .catch(err => console.error(err));
    });

    document.querySelector('form').addEventListener('submit', () => {
        ckEditors.forEach(({ editor, el }) => { el.value = editor.getData(); });
    });
});
</script>
@endsection
