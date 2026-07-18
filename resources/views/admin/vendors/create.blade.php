@extends('admin.layouts.admin')

@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">{{ 'Register New Vendor' }}</h4>
            <a href="{{ route('admin.vendors.index') }}" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> {{ 'Back' }}
            </a>
        </div>
    </div>
</div>

<form action="{{ route('admin.vendors.store') }}" method="POST">
    @csrf
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="name" class="form-label fw-semibold">{{ 'Vendor Name' }}</label>
                            <input type="text" name="name"
                                class="form-control border-0 bg-light @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" placeholder="Full Name" maxlength="255">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="email" class="form-label fw-semibold">{{ 'Email'
                                }}</label>
                            <input type="email" name="email"
                                class="form-control border-0 bg-light @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" placeholder="email@vendor.com" maxlength="255">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="phone" class="form-label fw-semibold">{{ 'Phone (Optional)' }}</label>
                        <input type="text" name="phone"
                            class="form-control border-0 bg-light @error('phone') is-invalid @enderror"
                            value="{{ old('phone') }}" placeholder="+855..." maxlength="20">
                        @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4">

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="password" class="form-label fw-semibold">{{ 'Password'
                                }}</label>
                            <input type="password" name="password"
                                class="form-control border-0 bg-light @error('password') is-invalid @enderror"
                                autocomplete="new-password">
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="password_confirmation" class="form-label fw-semibold">{{
                                'Confirm Password' }}</label>
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

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">Account Settings</h6>

                    <x-admin.combobox
                        name="status"
                        id="status"
                        wrapper-class="mb-4"
                        :label="'Status'"
                        :options="[
                            'active' => 'Active',
                            'inactive' => 'Inactive',
                            'banned' => 'Banned',
                        ]" />

                    <p class="text-muted small mb-4">New vendors will receive an email to verify their account once
                        registered.</p>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary shadow-sm py-2">
                            <i class="bi bi-person-plus me-1"></i> {{ 'Register Vendor' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection