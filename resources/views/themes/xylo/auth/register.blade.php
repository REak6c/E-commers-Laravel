@extends('themes.xylo.layouts.auth')

@section('content')
<div class="auth-screen">
    <div class="auth-card auth-card--split">
        {{-- Branding panel --}}
        <div class="auth-card__panel">
            <div class="fs-1 fw-bold text-warning mb-4">*</div>
            <h2 class="fw-bold display-6 mb-3 lh-sm">
                {{ __('store.register.hello') }} <br> {{ __('store.register.theme_name') }}
            </h2>
            <p class="fs-6 opacity-75 mb-0">{{ __('store.register.signup_description') }}</p>
            <p class="small opacity-50 mt-auto pt-4">{{ __('store.register.copyright') }}</p>
        </div>

        {{-- Form --}}
        <div class="auth-card__form">
            <div class="auth-card__brand">
                <img src="{{ asset('storage/logo_icon/shopping.png') }}" alt="{{ config('app.name') }}">
            </div>
            <h1 class="auth-card__title">{{ __('store.register.welcome_back') }}</h1>
            <p class="auth-card__subtitle">{{ __('store.register.form_subtitle') }}</p>

            <form method="POST" action="{{ route('customer.register') }}">
                @csrf
                <div class="mb-3">
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="form-control @error('name') is-invalid @enderror" placeholder="{{ __('store.register.name') }}">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror" placeholder="{{ __('store.register.email') }}">
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <input type="password" name="password"
                        class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('store.register.password') }}">
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-4">
                    <input type="password" name="password_confirmation"
                        class="form-control" placeholder="{{ __('store.register.confirm_password') }}">
                </div>
                <button type="submit" class="btn btn-primary btn-lg">{{ __('store.register.signup_btn') }}</button>
            </form>

            <p class="auth-card__footer">
                {{ __('store.register.already_account') }}
                <a href="{{ route('customer.login') }}" class="fw-semibold text-decoration-none">{{ __('store.register.login_here') }}</a>
            </p>
        </div>
    </div>
</div>
@endsection
