@extends('admin.layouts.admin')

@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">{{ 'Add New Currency' }}</h4>
            <a href="{{ route('admin.currencies.index') }}" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> {{ 'Back' }}
            </a>
        </div>
    </div>
</div>

<form action="{{ route('admin.currencies.store') }}" method="POST">
    @csrf
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">{{ 'Name' }}</label>
                            <input type="text" name="name" class="form-control border-0 bg-light @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" required placeholder="e.g. US Dollar">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">{{ 'Code' }}</label>
                            <input type="text" name="code" class="form-control border-0 bg-light @error('code') is-invalid @enderror"
                                value="{{ old('code') }}" required placeholder="e.g. USD">
                            @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">{{ 'Symbol' }}</label>
                            <input type="text" name="symbol" class="form-control border-0 bg-light @error('symbol') is-invalid @enderror"
                                value="{{ old('symbol') }}" required placeholder="e.g. $">
                            @error('symbol') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">{{ 'Exchange Rate' }}</label>
                            <div class="input-group">
                                <input type="number" step="0.0001" name="exchange_rate"
                                    class="form-control border-0 bg-light @error('exchange_rate') is-invalid @enderror"
                                    value="{{ old('exchange_rate') }}" required placeholder="1.0000">
                                <span class="input-group-text border-0 bg-light"><i class="bi bi-currency-exchange"></i></span>
                            </div>
                            @error('exchange_rate') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="text-end pt-3">
                        <button type="submit" class="btn btn-primary px-5 shadow-sm">
                            <i class="bi bi-save me-1"></i> {{ 'Save' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
