<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('storage/logo_icon/shopping.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Admin'))</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Khmer:wght@100..900&family=Plus+Jakarta+Sans:wght@600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Compiled design system (tokens → components → admin shell) --}}
    @if (!App::environment('testing'))
        @vite(['resources/sass/app.scss'])
    @endif

    {{-- Bootstrap 5 (CDN, after vite so our overrides win) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    {{-- Custom Toast --}}
    <style>
        #toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            pointer-events: none;
        }
        .adm-toast {
            pointer-events: all;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            min-width: 300px;
            max-width: 380px;
            padding: 14px 16px;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 8px 24px rgba(0,0,0,.10), 0 2px 6px rgba(0,0,0,.06);
            border-left: 4px solid transparent;
            opacity: 0;
            transform: translateX(32px);
            transition: opacity .28s ease, transform .28s ease;
            position: relative;
            overflow: hidden;
        }
        .adm-toast.show {
            opacity: 1;
            transform: translateX(0);
        }
        .adm-toast.hide {
            opacity: 0;
            transform: translateX(32px);
        }
        /* type colours */
        .adm-toast.success { border-left-color: #22c55e; }
        .adm-toast.error   { border-left-color: #ef4444; }
        .adm-toast.warning { border-left-color: #f59e0b; }
        .adm-toast.info    { border-left-color: #3b82f6; }

        .adm-toast .t-icon {
            flex-shrink: 0;
            width: 34px; height: 34px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
        }
        .adm-toast.success .t-icon { background: #f0fdf4; color: #16a34a; }
        .adm-toast.error   .t-icon { background: #fef2f2; color: #dc2626; }
        .adm-toast.warning .t-icon { background: #fffbeb; color: #d97706; }
        .adm-toast.info    .t-icon { background: #eff6ff; color: #2563eb; }

        .adm-toast .t-body { flex: 1; min-width: 0; }
        .adm-toast .t-title {
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: .02em;
            text-transform: uppercase;
            margin-bottom: 2px;
        }
        .adm-toast.success .t-title { color: #16a34a; }
        .adm-toast.error   .t-title { color: #dc2626; }
        .adm-toast.warning .t-title { color: #d97706; }
        .adm-toast.info    .t-title { color: #2563eb; }

        .adm-toast .t-msg {
            font-size: .85rem;
            color: #374151;
            font-weight: 500;
            line-height: 1.4;
        }
        .adm-toast .t-close {
            flex-shrink: 0;
            background: none; border: none; padding: 0;
            color: #9ca3af; font-size: .75rem;
            cursor: pointer; line-height: 1;
            margin-top: 1px;
            transition: color .15s;
        }
        .adm-toast .t-close:hover { color: #374151; }
        /* progress bar */
        .adm-toast .t-progress {
            position: absolute;
            bottom: 0; left: 0;
            height: 3px;
            border-radius: 0 0 12px 12px;
            width: 100%;
            transform-origin: left;
            animation: t-shrink linear forwards;
        }
        .adm-toast.success .t-progress { background: #22c55e; }
        .adm-toast.error   .t-progress { background: #ef4444; }
        .adm-toast.warning .t-progress { background: #f59e0b; }
        .adm-toast.info    .t-progress { background: #3b82f6; }
        @keyframes t-shrink {
            from { transform: scaleX(1); }
            to   { transform: scaleX(0); }
        }
    </style>

    {{-- Tom Select --}}
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.6.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <link href="{{ asset('css/admin-select.css') }}?v=3" rel="stylesheet">

    @yield('css')
</head>

<body>

{{-- ─────────────────────────────────────────────────────────────────
     TOAST CONTAINER
──────────────────────────────────────────────────────────────────── --}}
<div id="toast-container" aria-live="polite" aria-atomic="true"></div>

{{-- ─────────────────────────────────────────────────────────────────
     SKIP LINK  (a11y)
──────────────────────────────────────────────────────────────────── --}}
<a href="#main-content" class="skip-link">{{ __('cms.layout.skip_to_content') }}</a>

{{-- ─────────────────────────────────────────────────────────────────
     SIDEBAR
──────────────────────────────────────────────────────────────────── --}}
@include('admin.layouts.sidebar')

{{-- ─────────────────────────────────────────────────────────────────
     CONTENT AREA
──────────────────────────────────────────────────────────────────── --}}
<div id="content" class="w-100">

    {{-- ── TOPBAR ────────────────────────────────────────────────── --}}
    <nav class="navbar navbar-expand navbar-light p-0" aria-label="Top navigation">

        {{-- Left: sidebar toggle + breadcrumb/page title slot --}}
        <div class="d-flex align-items-center gap-3 ps-3">
            <button class="btn btn-outline-secondary border-0 p-2" id="sidebarToggle" aria-label="Toggle sidebar" aria-expanded="true" aria-controls="sidebar">
                <i class="fas fa-bars" style="font-size:1.1rem;"></i>
            </button>
        </div>

        {{-- Right: notifications + profile --}}
        <div class="d-flex align-items-center gap-2 ms-auto pe-4">

            {{-- Notifications --}}
            <button class="btn btn-light position-relative p-2" aria-label="Notifications">
                <i class="bi bi-bell" style="font-size: 1.1rem;"></i>
                <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                    <span class="visually-hidden">{{ __('cms.layout.new_alerts') }}</span>
                </span>
            </button>

            {{-- Divider --}}
            <div style="width:1px; height:22px; background:var(--border-color);"></div>

            {{-- Profile Dropdown --}}
            <div class="dropdown">
                <button class="btn p-0 d-flex align-items-center gap-2"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                        aria-label="Account menu"
                        style="background:none; border:none;">
                    <img src="{{ auth()->user()->profile_image
                            ? (\Illuminate\Support\Str::startsWith(auth()->user()->profile_image, ['http://', 'https://'])
                                ? auth()->user()->profile_image
                                : asset('storage/' . auth()->user()->profile_image))
                            : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=6366f1&color=fff&size=40' }}"
                         class="rounded-circle"
                         alt="{{ auth()->user()->name }}"
                         width="34" height="34"
                         style="object-fit:cover; border:2px solid var(--border-color); border-radius:50%; transition:all .2s;">
                    <span class="d-none d-md-inline" style="font-size:.82rem; font-weight:600; color:var(--text-secondary);">
                        {{ auth()->user()->name }}
                    </span>
                    <i class="bi bi-chevron-down d-none d-md-inline" style="font-size:.65rem; opacity:.5;"></i>
                </button>

                <ul class="dropdown-menu dropdown-menu-end" style="min-width:200px;">
                    <li>
                        <div class="px-3 py-2 border-bottom" style="border-color:var(--border-subtle) !important;">
                            <p class="mb-0" style="font-size:.8rem; font-weight:600; color:var(--text-primary);">
                                {{ auth()->user()->name }}
                            </p>
                            <p class="mb-0" style="font-size:.72rem; color:var(--text-muted);">
                                {{ auth()->user()->email }}
                            </p>
                        </div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.profile.edit') }}">
                            <i class="bi bi-person-circle"></i>
                            {{ __('cms.messages.profile') }}
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-grid"></i>
                            {{ __('cms.messages.dashboard') }}
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form id="admin-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                        <a class="dropdown-item text-danger"
                           href="#"
                           onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                            <i class="bi bi-box-arrow-right"></i>
                            {{ __('Logout') }}
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>
    {{-- ── END TOPBAR ───────────────────────────────────────────── --}}

    {{-- ── MAIN CONTENT ─────────────────────────────────────────── --}}
    <div class="container-fluid px-4 mt-4" id="main-content">
        @yield('content')
    </div>

</div>
{{-- ── END CONTENT AREA ─────────────────────────────────────────── --}}

{{-- ─────────────────────────────────────────────────────────────────
     SCRIPTS
──────────────────────────────────────────────────────────────────── --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@if (!App::environment('testing'))
    @vite(['resources/js/app.js'])
@endif

{{-- Sidebar toggle --}}
<script>
(function () {
    const sidebar  = document.getElementById('sidebar');
    const toggle   = document.getElementById('sidebarToggle');
    const isDesktop = () => window.innerWidth >= 992;

    if (!sidebar || !toggle) return;

    toggle.addEventListener('click', function () {
        sidebar.classList.toggle('collapsed');
        toggle.setAttribute('aria-expanded', !sidebar.classList.contains('collapsed'));
    });

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function (e) {
        if (!isDesktop() && sidebar.classList.contains('collapsed') &&
            !sidebar.contains(e.target) && !toggle.contains(e.target)) {
            sidebar.classList.remove('collapsed');
            toggle.setAttribute('aria-expanded', 'false');
        }
    });
})();
</script>

{{-- Sidebar search filter --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    if (!searchInput) return;

    searchInput.addEventListener('input', function () {
        const q = this.value.toLowerCase().trim();
        const menuItems = document.querySelectorAll('#sidebarMenu > .menu-item');

        menuItems.forEach(function (item) {
            // Section labels — always show
            if (item.classList.contains('menu-section')) {
                item.style.display = '';
                return;
            }

            const links = item.querySelectorAll('.menu-link, .submenu-link');
            let match   = false;

            links.forEach(function (link) {
                if (link.textContent.toLowerCase().includes(q)) match = true;
            });

            item.style.display = (q === '' || match) ? '' : 'none';

            // Auto-expand submenus that contain a match
            const submenu = item.querySelector('.collapse');
            if (submenu && q !== '' && match) {
                submenu.classList.add('show');
            } else if (submenu && q === '') {
                // Restore collapsed state based on active class
                if (!item.classList.contains('open')) {
                    submenu.classList.remove('show');
                }
            }
        });
    });
});
</script>

{{-- Notifications --}}
<script>
(function () {
    const ICONS = {
        success : 'bi bi-check-circle-fill',
        error   : 'bi bi-x-circle-fill',
        warning : 'bi bi-exclamation-triangle-fill',
        info    : 'bi bi-info-circle-fill',
    };
    const TITLES = {
        success : '{{ __('cms.layout.toast_success') }}',
        error   : '{{ __('cms.layout.toast_error') }}',
        warning : '{{ __('cms.layout.toast_warning') }}',
        info    : '{{ __('cms.layout.toast_info') }}',
    };
    const DURATION = 4500; // ms

    window.showToast = function (type, message) {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        toast.className = 'adm-toast ' + type;
        toast.setAttribute('role', 'alert');
        toast.innerHTML = `
            <div class="t-icon"><i class="${ICONS[type]}"></i></div>
            <div class="t-body">
                <div class="t-title">${TITLES[type]}</div>
                <div class="t-msg">${message}</div>
            </div>
            <button class="t-close" aria-label="Close"><i class="bi bi-x-lg"></i></button>
            <div class="t-progress" style="animation-duration:${DURATION}ms;"></div>
        `;

        container.appendChild(toast);

        // trigger enter animation
        requestAnimationFrame(() => {
            requestAnimationFrame(() => toast.classList.add('show'));
        });

        // close button
        toast.querySelector('.t-close').addEventListener('click', () => dismiss(toast));

        // auto-dismiss
        const timer = setTimeout(() => dismiss(toast), DURATION);
        toast.addEventListener('mouseenter', () => {
            clearTimeout(timer);
            toast.querySelector('.t-progress').style.animationPlayState = 'paused';
        });
        toast.addEventListener('mouseleave', () => {
            toast.querySelector('.t-progress').style.animationPlayState = 'running';
            setTimeout(() => dismiss(toast), 800);
        });
    };

    function dismiss(toast) {
        toast.classList.remove('show');
        toast.classList.add('hide');
        toast.addEventListener('transitionend', () => toast.remove(), { once: true });
    }

    // fire on page load from Laravel session
    @if (session('success'))
        window.addEventListener('DOMContentLoaded', () => showToast('success', '{{ addslashes(session('success')) }}'));
    @elseif (session('error'))
        window.addEventListener('DOMContentLoaded', () => showToast('error', '{{ addslashes(session('error')) }}'));
    @elseif (session('warning'))
        window.addEventListener('DOMContentLoaded', () => showToast('warning', '{{ addslashes(session('warning')) }}'));
    @elseif (session('info'))
        window.addEventListener('DOMContentLoaded', () => showToast('info', '{{ addslashes(session('info')) }}'));
    @endif
})();
</script>

{{-- Tom Select --}}
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.6.1/dist/js/tom-select.complete.min.js"></script>
<script src="{{ asset('js/admin-select.js') }}?v=3"></script>

@yield('js')
</body>

</html>
