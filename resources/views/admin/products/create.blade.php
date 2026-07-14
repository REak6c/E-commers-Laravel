@extends('admin.layouts.admin')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 fw-bold">{{ __('cms.products.title_create') }}</h4>
            <a href="{{ route('admin.products.index') }}" class="btn btn-light shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> {{ __('cms.common.back') }}
            </a>
        </div>
    </div>
</div>

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        {{-- Main Content Column --}}
        <div class="col-lg-8">
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-body p-4">
                    {{-- Product Name --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-dark">{{ __('cms.products.product_name') }}</label>
                        <input type="text" name="name"
                            class="form-control border-0 bg-light @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            placeholder="Electronic device, etc.">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-0">
                        <label class="form-label fw-semibold text-dark">{{ __('cms.products.description') }}</label>
                        <textarea name="description"
                            class="form-control border-0 bg-light ck-editor @error('description') is-invalid @enderror"
                            rows="10">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Variants Card --}}
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">{{ __('cms.products.variants') }}</h6>
                    <div class="btn-group">
                        <button type="button" id="add-variant-btn"
                            class="btn btn-primary d-flex align-items-center btn-sm ms-2">
                            <i class="bi bi-plus-lg me-1"></i> {{ __('cms.products.add_variant') }}
                        </button>
                    </div>
                </div>
                <div class="card-body p-4 pt-2">
                    <div id="variants-wrapper"></div>
                    <div id="no-variants-msg" class="text-center py-5">
                        <div class="mb-3">
                            <i class="bi bi-layers text-light display-1"></i>
                        </div>
                        <p class="text-muted">{{ __('cms.products.no_variants_msg', ['button' => __('cms.products.add_variant')]) }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar Column --}}
        <div class="col-lg-4">
            {{-- Organization Card --}}
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
                    <h6 class="fw-bold mb-0">{{ __('cms.products.section_organization') }}</h6>
                </div>
                <div class="card-body p-4">
                    <x-admin.select
                        name="category_id"
                        wrapper-class="mb-4"
                        :label="__('cms.products.category')"
                        :options="$categories"
                        option-label="name" />

                    <x-admin.select
                        name="brand_id"
                        wrapper-class="mb-4"
                        :label="__('cms.products.brand')"
                        :placeholder="__('cms.products.no_brand')"
                        :options="$brands"
                        option-label="name" />

                    <x-admin.select
                        name="vendor_id"
                        wrapper-class="mb-0"
                        :label="__('cms.products.vendor')"
                        :placeholder="__('cms.products.select_vendor')"
                        :options="$vendors" />
                </div>
            </div>

            {{-- Media Card --}}
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
                    <h6 class="fw-bold mb-0">{{ __('cms.products.images') }}</h6>
                </div>
                <div class="card-body p-4">
                    <div id="image-previews" class="row g-2 mb-3"></div>
                    <label class="btn btn-outline-light border-dashed text-primary w-100 py-4 d-flex flex-column align-items-center">
                        <i class="bi bi-cloud-arrow-up fs-2 mb-2"></i>
                        <span>{{ __('cms.products.upload_images_cta') }}</span>
                        <input type="file" name="images[]" multiple class="d-none" id="product-images">
                    </label>
                </div>
            </div>

            {{-- Submit Card --}}
            <div class="card border-0 shadow-lg" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%)">
                <div class="card-body p-4 text-center">
                    <button type="submit" class="btn btn-light w-100 py-3 fw-bold text-primary">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ __('cms.products.save_product') }}
                    </button>
                    <p class="text-white opacity-75 small mt-3 mb-0">{{ __('cms.products.save_subtext') }}</p>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- Variant Template --}}
<template id="variant-template">
    <div class="variant-item border-0 rounded-3 p-4 mb-3 position-relative bg-light" data-index="__INDEX__">
        <button type="button"
            class="btn btn-link link-danger p-0 position-absolute top-0 end-0 mt-3 me-3 remove-variant-item">
            <i class="bi bi-x-circle fs-5"></i>
        </button>
        <div class="row g-3">
            <div class="col-12">
                <h6 class="fw-bold text-primary mb-3"><i class="bi bi-tag-fill me-2"></i>{{ __('cms.products.variant_label', ['num' => '']) }}<span class="variant-number">__INDEX__</span></h6>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold text-dark">{{ __('cms.products.variant_name_en') }}</label>
                <input type="text" name="variants[__INDEX__][name]" class="form-control border-0 bg-white" value="__NAME__" placeholder="e.g. XL - Red" />
                <div class="invalid-feedback variant-name-error"></div>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold text-dark">{{ __('cms.products.price') }}</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-0">$</span>
                    <input type="number" step="0.01" name="variants[__INDEX__][price]" class="form-control border-0 bg-white" value="__PRICE__" />
                </div>
                <div class="invalid-feedback variant-price-error"></div>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold text-dark">{{ __('cms.products.discount_price') }}</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-0">$</span>
                    <input type="number" step="0.01" name="variants[__INDEX__][discount_price]" class="form-control border-0 bg-white" value="__DISCOUNT__" />
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold text-dark">{{ __('cms.products.stock') }}</label>
                <input type="number" name="variants[__INDEX__][stock]" class="form-control border-0 bg-white" value="__STOCK__" />
                <div class="invalid-feedback variant-stock-error"></div>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold text-dark">{{ __('cms.products.sku') }}</label>
                <input type="text" name="variants[__INDEX__][SKU]" class="form-control border-0 bg-white" value="__SKU__" />
                <div class="invalid-feedback variant-sku-error"></div>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold text-dark">{{ __('cms.products.barcode') }}</label>
                <input type="text" name="variants[__INDEX__][barcode]" class="form-control border-0 bg-white" value="__BARCODE__" />
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold text-dark">{{ __('cms.products.size') }}</label>
                <select name="variants[__INDEX__][size_id]" class="form-select border-0 bg-white">
                    <option value="">{{ __('cms.products.no_size') }}</option>
                    @foreach($sizes as $size)
                    <option value="{{ $size->id }}">{{ $size->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold text-dark">{{ __('cms.products.color') }}</label>
                <select name="variants[__INDEX__][color_id]" class="form-select border-0 bg-white">
                    <option value="">{{ __('cms.products.no_color') }}</option>
                    @foreach($colors as $color)
                    <option value="{{ $color->id }}">{{ $color->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="radio" name="primary_variant" value="__INDEX__" id="primary__INDEX__">
                    <label class="form-check-label" for="primary__INDEX__">{{ __('cms.products.is_primary') }}</label>
                </div>
            </div>
        </div>
    </div>
</template>

@endsection

@section('js')
<script>
$(document).ready(function() {
    const template = $('#variant-template').html();

    function updateNoVariantsMsg() {
        if ($('#variants-wrapper .variant-item').length > 0) {
            $('#no-variants-msg').hide();
        } else {
            $('#no-variants-msg').show();
        }
    }

    function addVariant(variant = {}) {
        const index = $('#variants-wrapper .variant-item').length;
        let html = template
            .replace(/__INDEX__/g, index)
            .replace(/__NAME__/g, variant.name || '')
            .replace(/__PRICE__/g, variant.price || '0.00')
            .replace(/__DISCOUNT__/g, variant.discount_price || '')
            .replace(/__STOCK__/g, variant.stock || '0')
            .replace(/__SKU__/g, variant.SKU || '')
            .replace(/__BARCODE__/g, variant.barcode || '');

        const $variant = $(html);
        if (variant.size_id)  $variant.find(`select[name="variants[${index}][size_id]"]`).val(variant.size_id);
        if (variant.color_id) $variant.find(`select[name="variants[${index}][color_id]"]`).val(variant.color_id);
        if (variant.is_primary) $variant.find(`input[name="primary_variant"]`).prop('checked', true);

        $('#variants-wrapper').append($variant);
        updateNoVariantsMsg();
    }

    $('#add-variant-btn').click(function() { addVariant(); });

    $(document).on('click', '.remove-variant-item', function() {
        $(this).closest('.variant-item').remove();
        $('#variants-wrapper .variant-item').each(function(idx) {
            $(this).find('.variant-number').text(idx);
        });
        updateNoVariantsMsg();
    });

    $('#product-images').change(function() {
        const container = $('#image-previews').empty();
        const files = this.files;
        for (let i = 0; i < files.length; i++) {
            const reader = new FileReader();
            reader.onload = function(e) {
                container.append(`<div class="col-4"><div class="position-relative"><img src="${e.target.result}" class="img-fluid rounded border" style="height: 80px; width: 100%; object-fit: cover;"></div></div>`);
            };
            reader.readAsDataURL(files[i]);
        }
    });

    @if(old('variants'))
        const oldVariants = @json(old('variants'));
        const primaryIndex = {{ old('primary_variant', 0) }};
        Object.keys(oldVariants).forEach(key => {
            let v = oldVariants[key];
            v.is_primary = (key == primaryIndex);
            addVariant(v);
        });
    @endif

    updateNoVariantsMsg();
});
</script>
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>
let ckEditor;
document.querySelectorAll('.ck-editor').forEach(el => {
    ClassicEditor.create(el)
        .then(editor => { ckEditor = editor; })
        .catch(error => { console.error('CKEditor init error', error); });
});
document.querySelector('form').addEventListener('submit', function() {
    if (ckEditor) {
        document.querySelector('.ck-editor').value = ckEditor.getData();
    }
});
</script>
@endsection
