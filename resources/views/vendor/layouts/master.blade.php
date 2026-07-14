<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'TVR') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/logo_icon/shopping.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Khmer:wght@100..900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @if (!App::environment('testing'))
        @vite(['resources/sass/app.scss', 'resources/sass/admin.scss'])
    @endif
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    {{-- Tom Select — themed, searchable dropdowns for <select class="admin-select|form-select|form-control"> --}}
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.6.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <link href="{{ asset('css/admin-select.css') }}?v=3" rel="stylesheet">
    <link href="{{ asset('css/vendor-panel.css') }}?v=6" rel="stylesheet">
    @yield('css')
</head>
<body>
    <a href="#main-content" class="skip-link">Skip to content</a>
    @include('vendor.layouts.sidebar')

    <!-- Content Area -->
    <div id="content" class="w-100">
        {{-- ===== TOPBAR ===== --}}
        <nav class="navbar navbar-expand navbar-light bg-light p-3">
            <button class="btn" id="sidebarToggle" title="Toggle sidebar">
                <i class="fas fa-bars"></i>
            </button>

            <div class="d-flex align-items-center gap-2 ms-auto">
                @php $vendor = Auth::guard('vendor')->user(); @endphp

                {{-- Profile dropdown --}}
                <div class="dropdown">
                    <button class="btn p-0 border-0 topbar-avatar-btn dropdown-toggle"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                            title="{{ $vendor ? $vendor->name : 'Account' }}">
                        <img src="{{ $vendor && $vendor->profile_image
                            ? (\Illuminate\Support\Str::startsWith($vendor->profile_image, ['http://', 'https://'])
                                ? $vendor->profile_image
                                : asset('storage/' . $vendor->profile_image))
                            : 'https://ui-avatars.com/api/?name=' . urlencode($vendor ? $vendor->name : 'V') . '&background=6366f1&color=fff&size=40' }}"
                            alt="Profile"
                            class="rounded-circle"
                            style="width:36px;height:36px;object-fit:cover;">
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" style="min-width:210px;">
                        {{-- Profile header --}}
                        <li>
                            <div class="vp-topbar-profile">
                                <p class="vp-topbar-profile__name">{{ $vendor ? $vendor->name : 'Vendor' }}</p>
                                <p class="vp-topbar-profile__role">
                                    <i class="fas fa-store" style="font-size:0.65rem;"></i>
                                    Vendor Account
                                </p>
                            </div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('vendor.profile.edit') }}">
                                <i class="fas fa-user-circle"></i> My Profile
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form id="vendor-logout-form" action="{{ route('vendor.logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            <a class="dropdown-item text-danger" href="#"
                               onclick="event.preventDefault(); document.getElementById('vendor-logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i> Sign Out
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid px-4 mt-4" id="main-content">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @if (!App::environment('testing'))
        @vite(['resources/js/app.js'])
    @endif
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const searchInput = document.getElementById("searchInput");
            const menuItems = document.querySelectorAll(".menu-item");
            if (searchInput) {
                searchInput.addEventListener("input", function () {
                    const searchTerm = searchInput.value.toLowerCase();
                    menuItems.forEach((item) => {
                        if (item.classList.contains('menu-section')) return;
                        let links = item.querySelectorAll(".menu-link, .submenu-link");
                        let matchFound = false;
                        links.forEach((link) => {
                            if (link.textContent.toLowerCase().includes(searchTerm)) matchFound = true;
                        });
                        item.style.display = matchFound ? "block" : "none";
                        let submenu = item.querySelector(".submenu");
                        if (submenu && matchFound) submenu.classList.add("show");
                        else if (submenu) submenu.classList.remove("show");
                    });
                });
            }
        });
    </script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Tom Select — themed, searchable dropdowns -->
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.6.1/dist/js/tom-select.complete.min.js"></script>
    <script src="{{ asset('js/admin-select.js') }}?v=3"></script>
    @yield('js')
</body>
</html>
