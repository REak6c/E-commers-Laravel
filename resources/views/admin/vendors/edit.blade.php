@extends('admin.layouts.admin')

@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1 fw-bold">{{ __('cms.vendors.edit_vendor') }}</h4>
                <p class="text-muted small mb-0">
                    <i class="bi bi-hash me-1"></i>{{ $vendor->id }}
                    &nbsp;&middot;&nbsp;{{ $vendor->name }}
                </p>
            </div>
            <a href="{{ route('admin.vendors.index') }}" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> {{ __('cms.common.back') }}
            </a>
        </div>
    </div>
</div>

<form action="{{ route('admin.vendors.update', $vendor->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row">
        {{-- Main Content --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-semibold">{{ __('cms.vendors.vendor_name') }}</label>
                            <input type="text" name="name"
                                class="form-control border-0 bg-light @error('name') is-invalid @enderror"
                                value="{{ old('name', $vendor->name) }}" placeholder="Full Name" maxlength="255">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-semibold">{{ __('cms.vendors.vendor_email') }}</label>
                            <input type="email" name="email"
                                class="form-control border-0 bg-light @error('email') is-invalid @enderror"
                                value="{{ old('email', $vendor->email) }}" placeholder="email@vendor.com" maxlength="255">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">{{ __('cms.vendors.phone_optional') }}</label>
                        <input type="text" name="phone"
                            class="form-control border-0 bg-light @error('phone') is-invalid @enderror"
                            value="{{ old('phone', $vendor->phone) }}" placeholder="+855..." maxlength="20">
                        @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4">

                    <p class="text-muted small mb-3">{{ __('cms.vendors.password_change_hint') }}</p>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-semibold">{{ __('cms.vendors.new_password') }}</label>
                            <input type="password" name="password"
                                class="form-control border-0 bg-light @error('password') is-invalid @enderror"
                                autocomplete="new-password">
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-semibold">{{ __('cms.vendors.confirm_password') }}</label>
                            <input type="password" name="password_confirmation"
                                class="form-control border-0 bg-light @error('password_confirmation') is-invalid @enderror"
                                autocomplete="new-password">
                            @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">{{ __('cms.vendors.account_settings') }}</h6>

                    <x-admin.select
                        name="status"
                        id="status"
                        wrapper-class="mb-4"
                        :label="__('cms.vendors.status')"
                        :selected="$vendor->status"
                        :options="[
                            'active'   => __('cms.vendors.active'),
                            'inactive' => __('cms.vendors.inactive'),
                            'banned'   => __('cms.vendors.banned'),
                        ]" />

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary shadow-sm py-2">
                            <i class="bi bi-save me-1"></i> {{ __('cms.common.update') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
