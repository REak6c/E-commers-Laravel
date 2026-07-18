<!-- Sidebar -->
<nav id="sidebar" class="d-flex flex-column">
    <!-- Brand / Logo Area -->
    <div class="sidebar-brand" id="sidebarBrand">
        <div class="brand-logo">
            <img src="{{ asset('storage/logo_icon/shopping.png') }}" alt="{{ 'Logo' }}" class="logo-img">
        </div>
        <div class="brand-text">
            <span class="brand-name">TVR Vendor</span>
            <span class="brand-sub">Management</span>
        </div>
    </div>

    <!-- Search -->
    <div class="sidebar-search" id="sidebarSearch">
        <div class="search-wrapper">
            <i class="fas fa-search search-icon"></i>
            <input type="text" placeholder="{{ 'Search...' }}" id="searchInput" autocomplete="off">
        </div>
    </div>

    <!-- Navigation -->
    <div class="sidebar-nav-wrapper">
        <ul class="sidebar-menu" id="sidebarMenu">

            <!-- Dashboard -->
            <li class="menu-item">
                <a class="menu-link {{ Route::currentRouteName() == 'vendor.dashboard' ? 'active' : '' }}"
                   href="{{ route('vendor.dashboard') }}">
                    <span class="menu-icon"><i class="fas fa-gauge-high"></i></span>
                    <span class="menu-text">{{ 'Dashboard' }}</span>
                    @if(Route::currentRouteName() == 'vendor.dashboard')
                        <span class="active-indicator"></span>
                    @endif
                </a>
            </li>

            <!-- Section: Catalog -->
            <li class="menu-section">
                <span class="section-label">Catalog</span>
            </li>

            <!-- Products -->
            <li class="menu-item has-submenu {{ in_array(Route::currentRouteName(), ['vendor.products.create','vendor.products.index','vendor.products.edit']) ? 'open' : '' }}">
                <a class="menu-link submenu-toggle {{ in_array(Route::currentRouteName(), ['vendor.products.create','vendor.products.index','vendor.products.edit']) ? 'active' : '' }}"
                   data-bs-toggle="collapse" href="#productMenu" role="button"
                   aria-expanded="{{ in_array(Route::currentRouteName(), ['vendor.products.create','vendor.products.index','vendor.products.edit']) ? 'true' : 'false' }}">
                    <span class="menu-icon"><i class="fas fa-box-open"></i></span>
                    <span class="menu-text">{{ 'Products' }}</span>
                    <span class="menu-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <div class="collapse submenu {{ in_array(Route::currentRouteName(), ['vendor.products.create','vendor.products.index','vendor.products.edit']) ? 'show' : '' }}" id="productMenu">
                    <ul class="submenu-list">
                        <li><a class="submenu-link {{ Route::currentRouteName() == 'vendor.products.create' ? 'active' : '' }}" href="{{ route('vendor.products.create') }}"><i class="fas fa-plus-circle me-2"></i>{{ 'Add New' }}</a></li>
                        <li><a class="submenu-link {{ Route::currentRouteName() == 'vendor.products.index' ? 'active' : '' }}" href="{{ route('vendor.products.index') }}"><i class="fas fa-list me-2"></i>{{ 'All Products' }}</a></li>
                    </ul>
                </div>
            </li>

            <!-- Section: Commerce -->
            <li class="menu-section">
                <span class="section-label">Commerce</span>
            </li>

            <!-- Orders -->
            <li class="menu-item has-submenu {{ Route::is('vendor.orders.*') ? 'open' : '' }}">
                <a class="menu-link submenu-toggle {{ Route::is('vendor.orders.*') ? 'active' : '' }}"
                   data-bs-toggle="collapse" href="#orderMenu" role="button"
                   aria-expanded="{{ Route::is('vendor.orders.*') ? 'true' : 'false' }}">
                    <span class="menu-icon"><i class="fas fa-shopping-bag"></i></span>
                    <span class="menu-text">{{ 'Orders' }}</span>
                    <span class="menu-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <div class="collapse submenu {{ Route::is('vendor.orders.*') ? 'show' : '' }}" id="orderMenu">
                    <ul class="submenu-list">
                        <li><a class="submenu-link {{ Route::currentRouteName() == 'vendor.orders.index' ? 'active' : '' }}" href="{{ route('vendor.orders.index') }}"><i class="fas fa-inbox me-2"></i>{{ 'All Orders' }}</a></li>
                    </ul>
                </div>
            </li>

            <!-- Reviews -->
            <li class="menu-item has-submenu {{ in_array(Route::currentRouteName(), ['vendor.reviews.index']) ? 'open' : '' }}">
                <a class="menu-link submenu-toggle {{ in_array(Route::currentRouteName(), ['vendor.reviews.index']) ? 'active' : '' }}"
                   data-bs-toggle="collapse" href="#vendorProductReviewMenu" role="button"
                   aria-expanded="{{ in_array(Route::currentRouteName(), ['vendor.reviews.index']) ? 'true' : 'false' }}">
                    <span class="menu-icon"><i class="fas fa-star"></i></span>
                    <span class="menu-text">{{ 'Reviews' }}</span>
                    <span class="menu-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <div class="collapse submenu {{ in_array(Route::currentRouteName(), ['vendor.reviews.index']) ? 'show' : '' }}" id="vendorProductReviewMenu">
                    <ul class="submenu-list">
                        <li><a class="submenu-link {{ Route::currentRouteName() == 'vendor.reviews.index' ? 'active' : '' }}" href="{{ route('vendor.reviews.index') }}"><i class="fas fa-list me-2"></i>{{ 'All Reviews' }}</a></li>
                    </ul>
                </div>
            </li>

        </ul>
    </div>

    <!-- Sidebar Footer: Vendor Info -->
    <div class="sidebar-footer" id="sidebarFooter">
        @php $vendor = Auth::guard('vendor')->user(); @endphp
        <div class="footer-user">
            <div class="user-avatar">
                <img src="{{ $vendor && $vendor->profile_image
                    ? (\Illuminate\Support\Str::startsWith($vendor->profile_image, ['http://', 'https://'])
                        ? $vendor->profile_image
                        : asset('storage/' . $vendor->profile_image))
                    : 'https://ui-avatars.com/api/?name=' . urlencode($vendor ? $vendor->name : 'V') . '&background=5a8dee&color=fff&size=40' }}"
                    alt="Vendor" class="footer-avatar">
            </div>
            <div class="user-info">
                <span class="user-name">{{ $vendor ? $vendor->name : 'Vendor' }}</span>
                <span class="user-role">Vendor</span>
            </div>
        </div>
    </div>
</nav>