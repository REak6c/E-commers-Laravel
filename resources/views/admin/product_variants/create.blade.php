@extends('admin.layouts.admin')

@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">{{ 'Create Product Variant' }}</h4>
            <a href="{{ route('admin.product_variants.index') }}" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> {{ 'Back' }}
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
                    <h6 class="fw-bold mb-4">{{ 'Variant Details' }}</h6>

                    <x-admin.combobox
                        name="product_id"
                        id="product_id"
                        wrapper-class="mb-4"
                        select-class="form-select border-0 bg-light shadow-sm"
                        :label="'Product'"
                        :placeholder="'Select Product'"
                        :options="$products"
                        option-label="name"
                        :option-label-fallback="'Unknown Product'"
                        required />

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="name" class="form-label fw-semibold">{{ 'Variant Name' }}</label>
                            <input type="text" name="name" id="name" class="form-control border-0 bg-light shadow-sm"
                                value="{{ old('name') }}" required placeholder="{{ 'e.g. Size' }}">
                            @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="value" class="form-label fw-semibold">{{ 'Variant Value' }}</label>
                            <input type="text" name="value" id="value" class="form-control border-0 bg-light shadow-sm"
                                value="{{ old('value') }}" required placeholder="{{ 'e.g. XL' }}">
                            @error('value') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="price" class="form-label fw-semibold">{{ 'Price' }}</label>
                            <div class="input-group">
                                <span class="input-group-text border-0 bg-light">$</span>
                                <input type="number" step="0.01" name="price" id="price"
                                    class="form-control border-0 bg-light shadow-sm" value="{{ old('price') }}"
                                    required>
                            </div>
                            @error('price') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="discount_price" class="form-label fw-semibold">{{ 'Discount Price' }}</label>
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
                    <h6 class="fw-bold mb-4">{{ 'Inventory' }}</h6>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="stock" class="form-label fw-semibold">{{ 'Stock Quantity' }}</label>
                            <input type="number" name="stock" id="stock"
                                class="form-control border-0 bg-light shadow-sm" value="{{ old('stock') }}" required>
                            @error('stock') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="SKU" class="form-label fw-semibold">{{ 'SKU' }}</label>
                            <input type="text" name="SKU" id="SKU" class="form-control border-0 bg-light shadow-sm"
                                value="{{ old('SKU') }}" required placeholder="{{ 'e.g. SKU-001' }}">
                            @error('SKU') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="weight" class="form-label fw-semibold">{{ 'Weight' }}</label>
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
                    <h6 class="fw-bold mb-3">{{ 'Actions' }}</h6>

                    <div class="mb-4">
                        <label for="variant_slug" class="form-label fw-semibold">{{ 'Variant Slug' }}</label>
                        <input type="text" name="variant_slug" id="variant_slug"
                            class="form-control border-0 bg-light shadow-sm" value="{{ old('variant_slug') }}" required
                            placeholder="e.g. storage-size">
                        @error('variant_slug') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary shadow-sm py-2">
                            <i class="bi bi-plus-lg me-1"></i> {{ 'Create Variant' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
