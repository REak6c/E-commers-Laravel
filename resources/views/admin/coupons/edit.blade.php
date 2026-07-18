@extends('admin.layouts.admin')

@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">{{ 'Edit Coupon' }}</h4>
            <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> {{ 'Back' }}
            </a>
        </div>
    </div>
</div>

<form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">{{ 'Code' }}</label>
                            <input type="text" name="code" class="form-control border-0 bg-light @error('code') is-invalid @enderror"
                                value="{{ old('code', $coupon->code) }}" required placeholder="e.g. SUMMER2024">
                            @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row">
                        <x-admin.combobox
                            name="type"
                            wrapper-class="col-md-6 mb-4"
                            :label="'Type'"
                            :selected="$coupon->type"
                            :options="[
                                'percentage' => 'Percentage',
                                'fixed' => 'Fixed',
                            ]"
                            required />
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-semibold">{{ 'Discount' }}</label>
                            <div class="input-group">
                                <input type="number" step="0.01" name="discount"
                                    class="form-control border-0 bg-light @error('discount') is-invalid @enderror"
                                    value="{{ old('discount', $coupon->discount) }}" required placeholder="0.00">
                                <span class="input-group-text border-0 bg-light"><i class="bi bi-tag"></i></span>
                            </div>
                            @error('discount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">{{ 'Settings' }}</h6>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ 'Expires At' }}</label>
                        <input type="date" name="expires_at" class="form-control border-0 bg-light @error('expires_at') is-invalid @enderror"
                            value="{{ old('expires_at', $coupon->expires_at ? $coupon->expires_at->format('Y-m-d') : '') }}">
                        @error('expires_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <hr class="my-4">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary shadow-sm py-2">
                            <i class="bi bi-save me-1"></i> {{ 'Update' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
