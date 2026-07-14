@extends('themes.xylo.layouts.auth')

@section('content')
<div class="auth-screen">
    <div class="auth-card auth-card--split">
        {{-- Branding panel --}}
        <div class="auth-card__panel">
            <div class="fs-1 fw-bold text-warning mb-4">*</div>
            <h2 class="fw-bold display-6 mb-3 lh-sm">
                {{ __('store.login.hello') }} <br> {{ __('store.login.theme_name') }}
            </h2>
            <p class="fs-6 opacity-75 mb-0">{{ __('store.login.login_description') }}</p>
            <p class="small opacity-50 mt-auto pt-4">{{ __('store.login.copyright') }}</p>
        </div>

        {{-- Form --}}
        <div class="auth-card__form">
            <div class="auth-card__brand">
                <img src="{{ asset('storage/logo_icon/shopping.png') }}" alt="{{ config('app.name') }}">
            </div>
            <h1 class="auth-card__title">{{ __('store.login.welcome_back') }}</h1>
            <p class="auth-card__subtitle">{{ __('store.login.form_subtitle') }}</p>

            <form method="POST" action="{{ route('customer.login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('store.login.email') }}</label>
                    <input type="text" name="email" id="email" value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror" placeholder="{{ __('store.login.email') }}">
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">{{ __('store.login.password') }}</label>
                    <input type="password" name="password" id="password"
                        class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('store.login.password') }}">
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <button type="submit" class="btn btn-primary btn-lg">{{ __('store.login.login_btn') }}</button>
            </form>

            <p class="auth-card__footer">
                {{ __('store.login.dont_have_account') }}
                <a href="{{ route('customer.register') }}" class="fw-semibold text-decoration-none">{{ __('store.login.signup') }}</a>
                <br>
                <a href="{{ route('customer.password.request') }}" class="text-decoration-none">{{ __('store.login.forgot_password') }}</a>
            </p>
        </div>
    </div>
</div>
@endsection
