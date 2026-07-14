@extends('vendor.layouts.login')

@section('content')
<div class="vl-root">

    {{-- ===== MOBILE HEADER (visible only on small screens) ===== --}}
    <div class="vl-mobile-header">
        <div class="vl-mobile-header-inner">
            <div class="vl-mobile-logo">
                <img src="{{ asset('storage/logo_icon/shopping.png') }}" alt="{{ config('app.name') }}">
            </div>
            <div>
                <div class="vl-mobile-brand-name">TVR Vendor</div>
                <div class="vl-mobile-brand-sub">Vendor Portal</div>
            </div>
        </div>
    </div>

    {{-- ===== LEFT PANEL ===== --}}
    <div class="vl-left">
        <div class="vl-dots"></div>

        <div class="vl-left-inner">

            <div class="vl-logo-badge">
                <img src="{{ asset('storage/logo_icon/shopping.png') }}"
                     alt="{{ config('app.name') }}">
            </div>

            <div class="vl-brand-pill">
                <span class="vl-brand-pill-dot"></span>
                <span>Vendor Portal</span>
            </div>

            <h1 class="vl-left-title">
                Your store,<br>
                <span>fully in control.</span>
            </h1>

            <p class="vl-left-sub">
                Manage products, track orders, and grow your business
                from one powerful vendor dashboard.
            </p>

            <div class="vl-features">
                <div class="vl-feature-card">
                    <div class="vl-feature-icon">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <div class="vl-feature-text">Product &amp; inventory management</div>
                </div>

                <div class="vl-feature-card">
                    <div class="vl-feature-icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="vl-feature-text">Real-time order tracking</div>
                </div>

                <div class="vl-feature-card">
                    <div class="vl-feature-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="vl-feature-text">Customer reviews &amp; feedback</div>
                </div>

                <div class="vl-feature-card">
                    <div class="vl-feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="vl-feature-text">Sales analytics &amp; insights</div>
                </div>
            </div>

        </div>

        <div class="vl-watermark">
            <span class="vl-watermark-text">{{ config('app.name', 'TVR') }} &copy; {{ date('Y') }}</span>
        </div>
    </div>

    {{-- ===== RIGHT FORM PANEL ===== --}}
    <div class="vl-right">
        <div class="vl-form-box">

            <p class="vl-form-eyebrow">Vendor Portal</p>
            <h2 class="vl-form-title">{{ cms_translate('auth.login') }}</h2>
            <p class="vl-form-desc">Sign in to access your vendor dashboard.</p>

            <div class="vl-divider"></div>

            {{-- Alerts --}}
            @error('email')
                <div class="vl-alert">
                    <i class="fas fa-circle-exclamation"></i>
                    <span>{{ $message }}</span>
                </div>
            @enderror
            @error('password')
                <div class="vl-alert">
                    <i class="fas fa-circle-exclamation"></i>
                    <span>{{ $message }}</span>
                </div>
            @enderror

            <form method="POST" action="{{ route('vendor.login.submit') }}" autocomplete="off" id="vendor-login-form">
                @csrf

                {{-- Email --}}
                <div class="vl-field">
                    <label class="vl-label" for="email">
                        {{ cms_translate('auth.email') }}
                    </label>
                    <div class="vl-input-wrap">
                        <i class="fas fa-envelope vl-input-icon"></i>
                        <input type="email"
                               id="email"
                               name="email"
                               class="vl-input @error('email') is-invalid @enderror"
                               value="{{ old('email') }}"
                               placeholder="you@example.com"
                               required
                               autofocus>
                    </div>
                </div>

                {{-- Password --}}
                <div class="vl-field">
                    <label class="vl-label" for="password">
                        {{ cms_translate('auth.password') }}
                    </label>
                    <div class="vl-input-wrap">
                        <i class="fas fa-lock vl-input-icon"></i>
                        <input type="password"
                               id="password"
                               name="password"
                               class="vl-input @error('password') is-invalid @enderror"
                               placeholder="Enter your password"
                               required>
                        <button type="button"
                                class="vl-toggle-pw"
                                id="togglePw"
                                tabindex="-1"
                                aria-label="Toggle password visibility">
                            <i class="fas fa-eye" id="togglePwIcon"></i>
                        </button>
                    </div>
                </div>

                {{-- Remember me --}}
                <div class="vl-bottom-row">
                    <div class="vl-check">
                        <input type="checkbox" id="rememberMe" name="remember">
                        <label for="rememberMe">{{ cms_translate('auth.remember_me') }}</label>
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit" class="vl-submit" id="loginBtn">
                    <span class="spinner-border spinner-border-sm d-none"
                          id="loginLoader"
                          role="status"
                          aria-hidden="true"></span>
                    <i class="fas fa-arrow-right-to-bracket" id="loginIcon"></i>
                    {{ cms_translate('auth.login') }}
                </button>

            </form>

            <p class="vl-form-footer">
                Protected by TVR &mdash; Unauthorized access is prohibited.
            </p>

        </div>
    </div>

</div>
@endsection

@section('js')
<script>
    // Password toggle
    document.getElementById('togglePw').addEventListener('click', function () {
        const pw   = document.getElementById('password');
        const icon = document.getElementById('togglePwIcon');
        if (pw.type === 'password') {
            pw.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            pw.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    });

    // Submit loader
    document.getElementById('vendor-login-form').addEventListener('submit', function () {
        const btn = document.getElementById('loginBtn');
        btn.disabled = true;
        document.getElementById('loginLoader').classList.remove('d-none');
        document.getElementById('loginIcon').classList.add('d-none');
    });
</script>
@endsection
