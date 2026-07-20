<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Vendor Panel') — {{ config('app.name', 'TVR') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/logo_icon/shopping.png') }}">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,700;1,700&family=Noto+Sans+Khmer:wght@100..900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .exo-2-bold {
            font-family: "Exo 2", sans-serif;
            font-optical-sizing: auto;
            font-weight: 700;
            font-style: normal;
        }
    </style>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    {{-- Design system (tokens → components → admin shell) --}}
    @if (!App::environment('testing'))
        @vite(['resources/sass/app.scss'])
    @endif

    {{-- Tom Select --}}
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.6.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <link href="{{ asset('css/admin-select.css') }}?v=3" rel="stylesheet">
    <link href="{{ asset('css/vendor-panel.css') }}?v=6" rel="stylesheet">

    {{-- Toastr --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    {{-- Global Fade-In Animations --}}
    <style>
        /* ── Keyframes ─────────────────────────────────────────── */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(20px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        /* ── Page-level wrapper ─────────────────────────────────── */
        #content {
            animation: fadeIn 0.45s ease both;
        }

        /* ── Cards & panels ─────────────────────────────────────── */
        .card,
        .table-responsive,
        .dashboard-stat {
            animation: fadeIn 0.45s ease both;
        }

        /* ── Stagger children inside card bodies ─────────────────── */
        .card-body > *,
        .table-responsive > * {
            animation: fadeIn 0.4s ease both;
        }
        .card-body > *:nth-child(1) { animation-delay: 0.05s; }
        .card-body > *:nth-child(2) { animation-delay: 0.10s; }
        .card-body > *:nth-child(3) { animation-delay: 0.15s; }
        .card-body > *:nth-child(4) { animation-delay: 0.20s; }
        .card-body > *:nth-child(5) { animation-delay: 0.25s; }

        /* ── Table rows ──────────────────────────────────────────── */
        tbody tr {
            animation: fadeIn 0.35s ease both;
        }
        tbody tr:nth-child(1)  { animation-delay: 0.04s; }
        tbody tr:nth-child(2)  { animation-delay: 0.08s; }
        tbody tr:nth-child(3)  { animation-delay: 0.12s; }
        tbody tr:nth-child(4)  { animation-delay: 0.16s; }
        tbody tr:nth-child(5)  { animation-delay: 0.20s; }
        tbody tr:nth-child(6)  { animation-delay: 0.24s; }
        tbody tr:nth-child(7)  { animation-delay: 0.28s; }
        tbody tr:nth-child(8)  { animation-delay: 0.32s; }
        tbody tr:nth-child(9)  { animation-delay: 0.36s; }
        tbody tr:nth-child(10) { animation-delay: 0.40s; }

        /* ── Form elements ───────────────────────────────────────── */
        form .mb-3,
        form .form-group {
            animation: fadeIn 0.4s ease both;
        }
        form .mb-3:nth-child(1),
        form .form-group:nth-child(1) { animation-delay: 0.05s; }
        form .mb-3:nth-child(2),
        form .form-group:nth-child(2) { animation-delay: 0.10s; }
        form .mb-3:nth-child(3),
        form .form-group:nth-child(3) { animation-delay: 0.15s; }
        form .mb-3:nth-child(4),
        form .form-group:nth-child(4) { animation-delay: 0.20s; }
        form .mb-3:nth-child(5),
        form .form-group:nth-child(5) { animation-delay: 0.25s; }

        /* ── Page headings ───────────────────────────────────────── */
        h1, h2, h3, h4, h5, h6,
        .page-title {
            animation: fadeIn 0.4s ease both;
            animation-delay: 0.05s;
        }

        /* ── Respect user motion preference ─────────────────────── */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-delay: 0s !important;
            }
        }
    </style>

    @yield('css')
</head>
<body>

{{-- Skip link --}}
<a href="#main-content" class="skip-link">Skip to content</a>

{{-- Sidebar --}}
@include('vendor.layouts.sidebar')

{{-- Content wrapper --}}
<div id="content" class="w-100">

    {{-- ── TOPBAR ───────────────────────────────────────────────── --}}
    <nav class="navbar navbar-expand navbar-light p-0" aria-label="Vendor top navigation">

        <div class="d-flex align-items-center gap-3 ps-3">
            <button class="btn btn-outline-secondary border-0 p-2"
                    id="sidebarToggle"
                    aria-label="Toggle sidebar"
                    aria-expanded="true"
                    aria-controls="sidebar">
                <i class="fas fa-bars" style="font-size:1.1rem;"></i>
            </button>
        </div>

        <div class="d-flex align-items-center gap-2 ms-auto pe-4">
            @php $vendor = Auth::guard('vendor')->user(); @endphp

            {{-- Divider --}}
            <div style="width:1px;height:22px;background:var(--border-color,#ACBCBF);"></div>

            {{-- Profile Dropdown --}}
            <div class="dropdown">
                <button class="btn p-0 d-flex align-items-center gap-2"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                        aria-label="Vendor account menu"
                        style="background:none;border:none;">
                    <img src="{{ $vendor && $vendor->profile_image
                            ? (\Illuminate\Support\Str::startsWith($vendor->profile_image, ['http://', 'https://'])
                                ? $vendor->profile_image
                                : asset('storage/' . $vendor->profile_image))
                            : 'https://ui-avatars.com/api/?name=' . urlencode($vendor ? $vendor->name : 'V') . '&background=5289AD&color=fff&size=40' }}"
                         class="rounded-circle"
                         alt="{{ $vendor ? $vendor->name : 'Vendor' }}"
                         width="34" height="34"
                         style="object-fit:cover;border:2px solid var(--border-color,#ACBCBF);border-radius:50%;transition:all .2s;">
                    <span class="d-none d-md-inline"
                          style="font-size:.82rem;font-weight:600;color:var(--text-secondary,#3d5760);">
                        {{ $vendor ? $vendor->name : 'Vendor' }}
                    </span>
                    <i class="bi bi-chevron-down d-none d-md-inline" style="font-size:.65rem;opacity:.5;"></i>
                </button>

                <ul class="dropdown-menu dropdown-menu-end" style="min-width:210px;">
                    <li>
                        <div class="px-3 py-2 border-bottom" style="border-color:#d0e0e3!important;">
                            <p class="mb-0" style="font-size:.8rem;font-weight:600;color:#1e2e3a;">
                                {{ $vendor ? $vendor->name : 'Vendor' }}
                            </p>
                            <p class="mb-0" style="font-size:.72rem;color:#698696;">
                                {{ $vendor ? $vendor->email : '' }}
                            </p>
                        </div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('vendor.profile.edit') }}">
                            <i class="bi bi-person-circle"></i> My Profile
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('vendor.dashboard') }}">
                            <i class="bi bi-grid"></i> Dashboard
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form id="vendor-logout-form" action="{{ route('vendor.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                        <a class="dropdown-item text-danger" href="#"
                           onclick="event.preventDefault(); document.getElementById('vendor-logout-form').submit();">
                            <i class="bi bi-box-arrow-right"></i> Sign Out
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    {{-- ── END TOPBAR ──────────────────────────────────────────── --}}

    {{-- ── MAIN CONTENT ─────────────────────────────────────────── --}}
    <div class="container-fluid px-4 mt-4" id="main-content">
        @yield('content')
    </div>

</div>
{{-- END CONTENT AREA --}}

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@if (!App::environment('testing'))
    @vite(['resources/js/app.js'])
@endif

{{-- Sidebar toggle --}}
<script>
(function () {
    const sidebar  = document.querySelector('.main-sidebar');
    const toggle   = document.getElementById('sidebarToggle');
    const isDesktop = () => window.innerWidth >= 992;
    if (!sidebar || !toggle) return;
    toggle.addEventListener('click', function () {
        sidebar.classList.toggle('collapsed');
        toggle.setAttribute('aria-expanded', !sidebar.classList.contains('collapsed'));
    });
    document.addEventListener('click', function (e) {
        if (!isDesktop() && sidebar.classList.contains('collapsed') &&
            !sidebar.contains(e.target) && !toggle.contains(e.target)) {
            sidebar.classList.remove('collapsed');
            toggle.setAttribute('aria-expanded', 'false');
        }
    });
})();
</script>

{{-- AdminLTE treeview --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.nav-sidebar > .nav-item > .nav-link').forEach(function (link) {
        const treeview = link.nextElementSibling;
        if (!treeview || !treeview.classList.contains('nav-treeview')) return;
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const item   = link.closest('.nav-item');
            const isOpen = item.classList.contains('menu-open');
            item.closest('ul').querySelectorAll('.nav-item.menu-open').forEach(function (o) {
                if (o !== item) o.classList.remove('menu-open');
            });
            item.classList.toggle('menu-open', !isOpen);
        });
    });
});
</script>

{{-- Sidebar search --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    if (!searchInput) return;
    searchInput.addEventListener('input', function () {
        const q = this.value.toLowerCase().trim();
        document.querySelectorAll('.nav-sidebar > .nav-item').forEach(function (item) {
            if (item.classList.contains('nav-header')) { item.style.display = ''; return; }
            let match = false;
            item.querySelectorAll('.nav-link p, .nav-treeview .nav-link p').forEach(function (t) {
                if (t.textContent.toLowerCase().includes(q)) match = true;
            });
            item.style.display = (q === '' || match) ? '' : 'none';
            if (q !== '' && match) item.classList.add('menu-open');
            else if (q === '' && !item.dataset.defaultOpen) item.classList.remove('menu-open');
        });
    });
    document.querySelectorAll('.nav-sidebar > .nav-item.menu-open').forEach(function (item) {
        item.dataset.defaultOpen = '1';
    });
});
</script>

{{-- Toast system (matches admin panel) --}}
<script>
(function () {
    const ICONS = {
        success : 'bi bi-check-circle-fill',
        error   : 'bi bi-x-circle-fill',
        warning : 'bi bi-exclamation-triangle-fill',
        info    : 'bi bi-info-circle-fill',
    };
    const TITLES   = { success: 'Success', error: 'Error', warning: 'Warning', info: 'Info' };
    const DURATION = 4500;

    window.showToast = function (type, message) {
        let container = document.getElementById('toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toast-container';
            container.setAttribute('aria-live', 'polite');
            container.setAttribute('aria-atomic', 'true');
            container.style.cssText = 'position:fixed;top:20px;right:20px;z-index:9999;display:flex;flex-direction:column;gap:10px;pointer-events:none;';
            document.body.appendChild(container);
        }
        const toast = document.createElement('div');
        toast.className = 'adm-toast ' + type;
        toast.setAttribute('role', 'alert');
        toast.style.cssText = 'pointer-events:all;display:flex;align-items:flex-start;gap:12px;min-width:300px;max-width:380px;padding:14px 16px;border-radius:12px;background:#fff;box-shadow:0 8px 24px rgba(0,0,0,.10),0 2px 6px rgba(0,0,0,.06);border-left:4px solid transparent;opacity:0;transform:translateX(32px);transition:opacity .28s ease,transform .28s ease;position:relative;overflow:hidden;';
        const accentColors = { success:'#22c55e', error:'#ef4444', warning:'#f59e0b', info:'#6366f1' };
        const iconBg = { success:'#f0fdf4', error:'#fef2f2', warning:'#fffbeb', info:'#eef2ff' };
        const iconColor = { success:'#16a34a', error:'#dc2626', warning:'#d97706', info:'#4f46e5' };
        toast.style.borderLeftColor = accentColors[type] || '#6366f1';
        toast.innerHTML = `
            <div style="flex-shrink:0;width:34px;height:34px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1rem;background:${iconBg[type]||'#eef2ff'};color:${iconColor[type]||'#4f46e5'};">
                <i class="${ICONS[type]||'bi bi-info-circle-fill'}"></i>
            </div>
            <div style="flex:1;min-width:0;">
                <div style="font-size:.78rem;font-weight:700;text-transform:uppercase;letter-spacing:.02em;margin-bottom:2px;color:${iconColor[type]||'#4f46e5'};">${TITLES[type]||'Info'}</div>
                <div style="font-size:.85rem;color:#374151;font-weight:500;line-height:1.4;">${message}</div>
            </div>
            <button style="flex-shrink:0;background:none;border:none;padding:0;color:#9ca3af;font-size:.75rem;cursor:pointer;line-height:1;margin-top:1px;" aria-label="Close"><i class="bi bi-x-lg"></i></button>
            <div style="position:absolute;bottom:0;left:0;height:3px;border-radius:0 0 12px 12px;width:100%;background:${accentColors[type]};animation:t-shrink ${DURATION}ms linear forwards;"></div>
        `;
        if (!document.getElementById('t-shrink-style')) {
            const s = document.createElement('style');
            s.id = 't-shrink-style';
            s.textContent = '@keyframes t-shrink{from{transform:scaleX(1)}to{transform:scaleX(0)}}';
            document.head.appendChild(s);
        }
        container.appendChild(toast);
        requestAnimationFrame(() => requestAnimationFrame(() => {
            toast.style.opacity = '1';
            toast.style.transform = 'translateX(0)';
        }));
        toast.querySelector('button').addEventListener('click', () => dismiss(toast));
        setTimeout(() => dismiss(toast), DURATION);
    };

    function dismiss(toast) {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(32px)';
        toast.addEventListener('transitionend', () => toast.remove(), { once: true });
    }

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

{{-- Toastr JS (for DataTable pages) --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

{{-- Tom Select --}}
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.6.1/dist/js/tom-select.complete.min.js"></script>
<script src="{{ asset('js/admin-select.js') }}?v=3"></script>
<script src="{{ asset('js/admin-combobox.js') }}?v=3"></script>

@yield('js')
</body>
</html>
