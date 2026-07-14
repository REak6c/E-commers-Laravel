@extends('admin.layouts.login')

@section('title', config('app.name', 'Admin') . ' — Sign In')

@section('content')
<div class="auth-wrap">
    <div class="auth-card">

        {{-- Logo --}}
        <div class="auth-logo-wrap">
            @php $logoPath = \App\Models\SiteSetting::first()?->logo ?? null; @endphp
            @if($logoPath)
                <img src="{{ \Illuminate\Support\Str::startsWith($logoPath, ['http://','https://']) ? $logoPath : asset('storage/' . $logoPath) }}"
                     alt="{{ config('app.name') }}" class="auth-logo-img">
            @else
                <img src="{{ asset('storage/logo_icon/shopping.png') }}"
                     alt="{{ config('app.name') }}" class="auth-logo-img">
            @endif
        </div>

        {{-- Heading --}}
        <h1 class="auth-heading">Welcome back</h1>
        <p class="auth-subheading">Sign in to <strong>{{ config('app.name', 'Admin Panel') }}</strong></p>

        {{-- Alerts --}}
        @error('email')
            <div class="auth-alert mb-3">
                <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
            </div>
        @enderror
        @error('password')
            <div class="auth-alert mb-3">
                <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
            </div>
        @enderror

        {{-- Form --}}
        <form method="POST" action="{{ route('login') }}" autocomplete="off" class="auth-form">
            @csrf

            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label">{{ cms_translate('auth.email') }}</label>
                <div class="input-icon-wrap">
                    <i class="bi bi-envelope input-icon"></i>
                    <input type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           name="email"
                           id="email"
                           value="{{ old('email') }}"
                           placeholder="you@example.com"
                           required
                           autofocus>
                </div>
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <label for="password" class="form-label">{{ cms_translate('auth.password') }}</label>
                <div class="input-icon-wrap">
                    <i class="bi bi-lock input-icon"></i>
                    <input type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           name="password"
                           id="password"
                           placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;"
                           required>
                    <button type="button" class="input-icon-right toggle-password" data-target="password" aria-label="Toggle password visibility">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            {{-- Remember me --}}
            <div class="mb-4 form-check">
                <input type="checkbox" class="form-check-input" id="rememberMe" name="remember">
                <label class="form-check-label" for="rememberMe">{{ cms_translate('auth.remember_me') }}</label>
            </div>

            {{-- Submit --}}
            <button type="submit" class="auth-btn" id="login-submit">
                <i class="bi bi-box-arrow-in-right me-2"></i>
                {{ cms_translate('auth.login') }}
            </button>
        </form>

        <p class="auth-footer-note mt-3">
            <i class="bi bi-shield-lock me-1"></i>
            Your connection is encrypted and secure.
        </p>
    </div>
</div>
@endsection
