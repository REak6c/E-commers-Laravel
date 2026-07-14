@extends('admin.layouts.admin')

@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">{{ __('cms.product_variants.title_create') }}</h4>
            <a href="{{ route('admin.product_variants.index') }}" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> {{ __('cms.common.back') }}
            </a>
        </div>
    </div>
</div>

<form action="{{ route('admin.product_variants.store') }}" method="POST">
    @csrf

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4">{{ __('cms.product_variants.section_details') }}</h6>

                    <x-admin.select
                        name="product_id"
                        id="product_id"
                        wrapper-class="mb-4"
                        select-class="form-select border-0 bg-light shadow-sm"
                        :label="__('cms.product_variants.product')"
                        :placeholder="__('cms.product_variants.select_product')"
                        :options="$products"
                        option-label="name"
                        :option-label-fallback="__('cms.product_variants.unknown_product')"
                        required />

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="name" class="form-label fw-semibold">{{ __('cms.product_variants.variant_name') }}</label>
                            <input type="text" name="name" id="name" class="form-control border-0 bg-light shadow-sm"
                                value="{{ old('name') }}" required placeholder="{{ __('cms.product_variants.placeholder_name') }}">
                            @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="value" class="form-label fw-semibold">{{ __('cms.product_variants.variant_value') }}</label>
                            <input type="text" name="value" id="value" class="form-control border-0 bg-light shadow-sm"
                                value="{{ old('value') }}" required placeholder="{{ __('cms.product_variants.placeholder_value') }}">
                            @error('value') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="price" class="form-label fw-semibold">{{ __('cms.products.price') }}</label>
                            <div class="input-group">
                                <span class="input-group-text border-0 bg-light">$</span>
                                <input type="number" step="0.01" name="price" id="price"
                                    class="form-control border-0 bg-light shadow-sm" value="{{ old('price') }}"
                                    required>
                            </div>
                            @error('price') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="discount_price" class="form-label fw-semibold">{{ __('cms.products.discount_price') }}</label>
                            <div class="input-group">
                                <span class="input-group-text border-0 bg-light">$</span>
                                <input type="number" step="0.01" name="discount_price" id="discount_price"
                                    class="form-control border-0 bg-light shadow-sm"
                                    value="{{ old('discount_price') }}">
                            </div>
                            @error('discount_price') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4">{{ __('cms.product_variants.section_inventory') }}</h6>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="stock" class="form-label fw-semibold">{{ __('cms.product_variants.stock_quantity') }}</label>
                            <input type="number" name="stock" id="stock"
                                class="form-control border-0 bg-light shadow-sm" value="{{ old('stock') }}" required>
                            @error('stock') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="SKU" class="form-label fw-semibold">{{ __('cms.products.sku') }}</label>
                            <input type="text" name="SKU" id="SKU" class="form-control border-0 bg-light shadow-sm"
                                value="{{ old('SKU') }}" required placeholder="{{ __('cms.product_variants.placeholder_sku') }}">
                            @error('SKU') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="weight" class="form-label fw-semibold">{{ __('cms.product_variants.weight') }}</label>
                            <input type="text" name="weight" id="weight"
                                class="form-control border-0 bg-light shadow-sm" value="{{ old('weight') }}">
                            @error('weight') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">{{ __('cms.product_variants.actions') }}</h6>

                    <div class="mb-4">
                        <label for="variant_slug" class="form-label fw-semibold">{{ __('cms.product_variants.variant_slug') }}</label>
                        <input type="text" name="variant_slug" id="variant_slug"
                            class="form-control border-0 bg-light shadow-sm" value="{{ old('variant_slug') }}" required
                            placeholder="e.g. storage-size">
                        @error('variant_slug') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary shadow-sm py-2">
                            <i class="bi bi-plus-lg me-1"></i> {{ __('cms.product_variants.create_button') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
