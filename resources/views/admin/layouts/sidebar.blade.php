<!-- Sidebar -->
<nav id="sidebar" class="d-flex flex-column" aria-label="Main navigation">
    <!-- Brand / Logo Area -->
    <a class="sidebar-brand" id="sidebarBrand" href="{{ route('admin.dashboard') }}">
        <div class="brand-logo">
            @php
                $logoPath = \App\Models\SiteSetting::first()?->logo ?? null;
            @endphp
            @if($logoPath)
                <img src="{{ \Illuminate\Support\Str::startsWith($logoPath, ['http://', 'https://']) ? $logoPath : asset('storage/' . $logoPath) }}"
                     alt="{{ config('app.name') }}"
                     class="logo-img">
            @else
                <img src="{{ asset('storage/logo_icon/shopping.png') }}"
                     alt="{{ config('app.name') }}"
                     class="logo-img">
            @endif
        </div>
        <div class="brand-text">
            <span class="brand-name">{{ config('app.name', 'Admin Panel') }}</span>
            <span class="brand-sub">{{ __('cms.sidebar.management') }}</span>
        </div>
    </a>

    <!-- Search -->
    <div class="sidebar-search" id="sidebarSearch">
        <div class="search-wrapper">
            <i class="fas fa-search search-icon"></i>
            <input type="text" placeholder="{{ __('cms.sidebar.search_placeholder') }}" id="searchInput"
                autocomplete="off">
        </div>
    </div>

    <!-- Navigation -->
    <div class="sidebar-nav-wrapper">
        <ul class="sidebar-menu" id="sidebarMenu">

            <!-- Dashboard -->
            <li class="menu-item">
                <a class="menu-link {{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}"
                    href="{{ route('admin.dashboard') }}">
                    <span class="menu-icon"><i class="fas fa-gauge-high"></i></span>
                    <span class="menu-text">{{ __('cms.sidebar.dashboard') }}</span>
                    @if(Route::currentRouteName() == 'admin.dashboard')
                    <span class="active-indicator"></span>
                    @endif
                </a>
            </li>

            <!-- Section Divider: Catalog -->
            <li class="menu-section">
                <span class="section-label">{{ __('cms.sidebar.sections.catalog') }}</span>
            </li>

            <!-- Products -->
            <li
                class="menu-item has-submenu {{ in_array(Route::currentRouteName(), ['admin.products.create','admin.products.index','admin.products.edit']) ? 'open' : '' }}">
                <a class="menu-link submenu-toggle {{ in_array(Route::currentRouteName(), ['admin.products.create','admin.products.index','admin.products.edit']) ? 'active' : '' }}"
                    data-bs-toggle="collapse" href="#productMenu" role="button"
                    aria-expanded="{{ in_array(Route::currentRouteName(), ['admin.products.create','admin.products.index']) ? 'true' : 'false' }}">
                    <span class="menu-icon"><i class="fas fa-box-open"></i></span>
                    <span class="menu-text">{{ __('cms.sidebar.products.title') }}</span>
                    <span class="menu-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <div class="collapse submenu {{ in_array(Route::currentRouteName(), ['admin.products.create','admin.products.index','admin.products.edit']) ? 'show' : '' }}"
                    id="productMenu">
                    <ul class="submenu-list">
                        <li><a class="submenu-link {{ Route::currentRouteName() == 'admin.products.create' ? 'active' : '' }}"
                                href="{{ route('admin.products.create') }}"><i class="fas fa-plus-circle me-2"></i>{{
                                __('cms.sidebar.products.add_new') }}</a></li>
                        <li><a class="submenu-link {{ Route::currentRouteName() == 'admin.products.index' ? 'active' : '' }}"
                                href="{{ route('admin.products.index') }}"><i class="fas fa-list me-2"></i>{{
                                __('cms.sidebar.products.list') }}</a></li>
                    </ul>
                </div>
            </li>

            <!-- Categories -->
            <li
                class="menu-item has-submenu {{ in_array(Route::currentRouteName(), ['admin.categories.create','admin.categories.index']) ? 'open' : '' }}">
                <a class="menu-link submenu-toggle {{ in_array(Route::currentRouteName(), ['admin.categories.create','admin.categories.index']) ? 'active' : '' }}"
                    data-bs-toggle="collapse" href="#categoryMenu" role="button"
                    aria-expanded="{{ in_array(Route::currentRouteName(), ['admin.categories.create','admin.categories.index']) ? 'true' : 'false' }}">
                    <span class="menu-icon"><i class="fas fa-layer-group"></i></span>
                    <span class="menu-text">{{ __('cms.sidebar.categories.title') }}</span>
                    <span class="menu-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <div class="collapse submenu {{ in_array(Route::currentRouteName(), ['admin.categories.create','admin.categories.index']) ? 'show' : '' }}"
                    id="categoryMenu">
                    <ul class="submenu-list">
                        <li><a class="submenu-link {{ Route::currentRouteName() == 'admin.categories.create' ? 'active' : '' }}"
                                href="{{ route('admin.categories.create') }}"><i class="fas fa-plus-circle me-2"></i>{{
                                __('cms.sidebar.categories.add_new') }}</a></li>
                        <li><a class="submenu-link {{ Route::currentRouteName() == 'admin.categories.index' ? 'active' : '' }}"
                                href="{{ route('admin.categories.index') }}"><i class="fas fa-list me-2"></i>{{
                                __('cms.sidebar.categories.list') }}</a></li>
                    </ul>
                </div>
            </li>

            <!-- Brands -->
            <li
                class="menu-item has-submenu {{ in_array(Route::currentRouteName(), ['admin.brands.create','admin.brands.index']) ? 'open' : '' }}">
                <a class="menu-link submenu-toggle {{ in_array(Route::currentRouteName(), ['admin.brands.create','admin.brands.index']) ? 'active' : '' }}"
                    data-bs-toggle="collapse" href="#brandMenu" role="button"
                    aria-expanded="{{ in_array(Route::currentRouteName(), ['admin.brands.create','admin.brands.index']) ? 'true' : 'false' }}">
                    <span class="menu-icon"><i class="fas fa-tags"></i></span>
                    <span class="menu-text">{{ __('cms.sidebar.brands.title') }}</span>
                    <span class="menu-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <div class="collapse submenu {{ in_array(Route::currentRouteName(), ['admin.brands.create','admin.brands.index']) ? 'show' : '' }}"
                    id="brandMenu">
                    <ul class="submenu-list">
                        <li><a class="submenu-link {{ Route::currentRouteName() == 'admin.brands.create' ? 'active' : '' }}"
                                href="{{ route('admin.brands.create') }}"><i class="fas fa-plus-circle me-2"></i>{{
                                __('cms.sidebar.brands.add_new') }}</a></li>
                        <li><a class="submenu-link {{ Route::currentRouteName() == 'admin.brands.index' ? 'active' : '' }}"
                                href="{{ route('admin.brands.index') }}"><i class="fas fa-list me-2"></i>{{
                                __('cms.sidebar.brands.list') }}</a></li>
                    </ul>
                </div>
            </li>

            <!-- Coupons -->
            <li class="menu-item {{ Route::currentRouteName() == 'admin.coupons.index' ? 'active' : '' }}">
                <a class="menu-link {{ Route::currentRouteName() == 'admin.coupons.index' ? 'active' : '' }}"
                    href="{{ route('admin.coupons.index') }}">
                    <span class="menu-icon"><i class="fas fa-ticket-alt"></i></span>
                    <span class="menu-text">{{ __('cms.coupons.title') }}</span>
                </a>
            </li>

            <!-- Attributes -->
            <li
                class="menu-item has-submenu {{ in_array(Route::currentRouteName(), ['admin.attributes.create','admin.attributes.index']) ? 'open' : '' }}">
                <a class="menu-link submenu-toggle {{ in_array(Route::currentRouteName(), ['admin.attributes.create','admin.attributes.index']) ? 'active' : '' }}"
                    data-bs-toggle="collapse" href="#attributeMenu" role="button"
                    aria-expanded="{{ in_array(Route::currentRouteName(), ['admin.attributes.create','admin.attributes.index']) ? 'true' : 'false' }}">
                    <span class="menu-icon"><i class="fas fa-sliders"></i></span>
                    <span class="menu-text">{{ __('cms.sidebar.attributes.title') }}</span>
                    <span class="menu-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <div class="collapse submenu {{ in_array(Route::currentRouteName(), ['admin.attributes.create','admin.attributes.index']) ? 'show' : '' }}"
                    id="attributeMenu">
                    <ul class="submenu-list">
                        <li><a class="submenu-link {{ Route::currentRouteName() == 'admin.attributes.create' ? 'active' : '' }}"
                                href="{{ route('admin.attributes.create') }}"><i class="fas fa-plus-circle me-2"></i>{{
                                __('cms.sidebar.attributes.add_new') }}</a></li>
                        <li><a class="submenu-link {{ Route::currentRouteName() == 'admin.attributes.index' ? 'active' : '' }}"
                                href="{{ route('admin.attributes.index') }}"><i class="fas fa-list me-2"></i>{{
                                __('cms.sidebar.attributes.list') }}</a></li>
                    </ul>
                </div>
            </li>

            <!-- Section Divider: Users -->
            <li class="menu-section">
                <span class="section-label">{{ __('cms.sidebar.sections.users') }}</span>
            </li>

            <!-- Customers -->
            <li
                class="menu-item has-submenu {{ in_array(Route::currentRouteName(), ['admin.customers.create','admin.customers.index']) ? 'open' : '' }}">
                <a class="menu-link submenu-toggle {{ in_array(Route::currentRouteName(), ['admin.customers.create','admin.customers.index']) ? 'active' : '' }}"
                    data-bs-toggle="collapse" href="#customerMenu" role="button"
                    aria-expanded="{{ in_array(Route::currentRouteName(), ['admin.customers.create','admin.customers.index']) ? 'true' : 'false' }}">
                    <span class="menu-icon"><i class="fas fa-users"></i></span>
                    <span class="menu-text">{{ __('cms.sidebar.customers.title') }}</span>
                    <span class="menu-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <div class="collapse submenu {{ in_array(Route::currentRouteName(), ['admin.customers.create','admin.customers.index']) ? 'show' : '' }}"
                    id="customerMenu">
                    <ul class="submenu-list">
                        <li><a class="submenu-link {{ Route::currentRouteName() == 'admin.customers.index' ? 'active' : '' }}"
                                href="{{ route('admin.customers.index') }}"><i class="fas fa-list me-2"></i>{{
                                __('cms.sidebar.brands.list') }}</a></li>
                    </ul>
                </div>
            </li>

            <!-- Vendors -->
            <li
                class="menu-item has-submenu {{ in_array(Route::currentRouteName(), ['admin.vendors.create','admin.vendors.index']) ? 'open' : '' }}">
                <a class="menu-link submenu-toggle {{ in_array(Route::currentRouteName(), ['admin.vendors.create','admin.vendors.index']) ? 'active' : '' }}"
                    data-bs-toggle="collapse" href="#vendorMenu" role="button"
                    aria-expanded="{{ in_array(Route::currentRouteName(), ['admin.vendors.create','admin.vendors.index']) ? 'true' : 'false' }}">
                    <span class="menu-icon"><i class="fas fa-store"></i></span>
                    <span class="menu-text">{{ __('cms.sidebar.vendors.title') }}</span>
                    <span class="menu-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <div class="collapse submenu {{ in_array(Route::currentRouteName(), ['admin.vendors.create','admin.vendors.index']) ? 'show' : '' }}"
                    id="vendorMenu">
                    <ul class="submenu-list">
                        <li><a class="submenu-link {{ Route::currentRouteName() == 'admin.vendors.create' ? 'active' : '' }}"
                                href="{{ route('admin.vendors.create') }}"><i class="fas fa-plus-circle me-2"></i>{{
                                __('cms.sidebar.vendors.add_new') }}</a></li>
                        <li><a class="submenu-link {{ Route::currentRouteName() == 'admin.vendors.index' ? 'active' : '' }}"
                                href="{{ route('admin.vendors.index') }}"><i class="fas fa-list me-2"></i>{{
                                __('cms.sidebar.vendors.list') }}</a></li>
                    </ul>
                </div>
            </li>

            <!-- Section Divider: Commerce -->
            <li class="menu-section">
                <span class="section-label">{{ __('cms.sidebar.sections.commerce') }}</span>
            </li>

            <!-- Orders -->
            <li
                class="menu-item has-submenu {{ in_array(Route::currentRouteName(), ['admin.orders.index','admin.orders.pending','admin.orders.completed']) ? 'open' : '' }}">
                <a class="menu-link submenu-toggle {{ in_array(Route::currentRouteName(), ['admin.orders.index','admin.orders.pending','admin.orders.completed']) ? 'active' : '' }}"
                    data-bs-toggle="collapse" href="#ordersMenu" role="button"
                    aria-expanded="{{ in_array(Route::currentRouteName(), ['admin.orders.index','admin.orders.pending','admin.orders.completed']) ? 'true' : 'false' }}">
                    <span class="menu-icon"><i class="fas fa-shopping-bag"></i></span>
                    <span class="menu-text">{{ __('cms.sidebar.orders.title') }}</span>
                    <span class="menu-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <div class="collapse submenu {{ in_array(Route::currentRouteName(), ['admin.orders.index','admin.orders.pending','admin.orders.completed']) ? 'show' : '' }}"
                    id="ordersMenu">
                    <ul class="submenu-list">
                        <li><a class="submenu-link {{ Route::currentRouteName() == 'admin.orders.index' ? 'active' : '' }}"
                                href="{{ route('admin.orders.index') }}"><i class="fas fa-inbox me-2"></i>{{
                                __('cms.sidebar.orders.all_orders') }}</a></li>
                        <li><a class="submenu-link {{ Route::currentRouteName() == 'admin.orders.pending' ? 'active' : '' }}"
                                href=""><i class="fas fa-clock me-2"></i>{{ __('cms.sidebar.orders.pending_orders')
                                }}</a></li>
                        <li><a class="submenu-link {{ Route::currentRouteName() == 'admin.orders.completed' ? 'active' : '' }}"
                                href=""><i class="fas fa-check-circle me-2"></i>{{
                                __('cms.sidebar.orders.completed_orders') }}</a></li>
                    </ul>
                </div>
            </li>

            <!-- Payments -->
            <li
                class="menu-item has-submenu {{ in_array(Route::currentRouteName(), ['admin.payments.index','admin.payments.getData']) ? 'open' : '' }}">
                <a class="menu-link submenu-toggle {{ in_array(Route::currentRouteName(), ['admin.payments.index','admin.payments.getData']) ? 'active' : '' }}"
                    data-bs-toggle="collapse" href="#paymentsMenu" role="button"
                    aria-expanded="{{ in_array(Route::currentRouteName(), ['admin.payments.index','admin.payments.getData']) ? 'true' : 'false' }}">
                    <span class="menu-icon"><i class="fas fa-credit-card"></i></span>
                    <span class="menu-text">{{ __('cms.sidebar.payments.title') }}</span>
                    <span class="menu-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <div class="collapse submenu {{ in_array(Route::currentRouteName(), ['admin.payments.index','admin.payments.getData']) ? 'show' : '' }}"
                    id="paymentsMenu">
                    <ul class="submenu-list">
                        <li><a class="submenu-link {{ Route::currentRouteName() == 'admin.payments.index' ? 'active' : '' }}"
                                href="{{ route('admin.payments.index') }}"><i class="fas fa-list me-2"></i>{{
                                __('cms.sidebar.payments.list') }}</a></li>
                    </ul>
                </div>
            </li>

            <!-- Refunds -->
            <li
                class="menu-item has-submenu {{ in_array(Route::currentRouteName(), ['admin.refunds.index','admin.refunds.getData']) ? 'open' : '' }}">
                <a class="menu-link submenu-toggle {{ in_array(Route::currentRouteName(), ['admin.refunds.index','admin.refunds.getData']) ? 'active' : '' }}"
                    data-bs-toggle="collapse" href="#refundsMenu" role="button"
                    aria-expanded="{{ in_array(Route::currentRouteName(), ['admin.refunds.index','admin.refunds.getData']) ? 'true' : 'false' }}">
                    <span class="menu-icon"><i class="fas fa-rotate-left"></i></span>
                    <span class="menu-text">{{ __('cms.sidebar.refunds.title') }}</span>
                    <span class="menu-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <div class="collapse submenu {{ in_array(Route::currentRouteName(), ['admin.refunds.index','admin.refunds.getData']) ? 'show' : '' }}"
                    id="refundsMenu">
                    <ul class="submenu-list">
                        <li><a class="submenu-link {{ Route::currentRouteName() == 'admin.refunds.index' ? 'active' : '' }}"
                                href="{{ route('admin.refunds.index') }}"><i class="fas fa-list me-2"></i>{{
                                __('cms.sidebar.refunds.list') }}</a></li>
                    </ul>
                </div>
            </li>

            <!-- Payment Gateways -->
            <li
                class="menu-item has-submenu {{ in_array(Route::currentRouteName(), ['admin.payment-gateways.index','admin.payment-gateways.getData','admin.payment-gateways.edit']) ? 'open' : '' }}">
                <a class="menu-link submenu-toggle {{ in_array(Route::currentRouteName(), ['admin.payment-gateways.index','admin.payment-gateways.getData','admin.payment-gateways.edit']) ? 'active' : '' }}"
                    data-bs-toggle="collapse" href="#gatewaysMenu" role="button"
                    aria-expanded="{{ in_array(Route::currentRouteName(), ['admin.payment-gateways.index','admin.payment-gateways.getData','admin.payment-gateways.edit']) ? 'true' : 'false' }}">
                    <span class="menu-icon"><i class="fas fa-wallet"></i></span>
                    <span class="menu-text">{{ __('cms.sidebar.payment_gateways.title') }}</span>
                    <span class="menu-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <div class="collapse submenu {{ in_array(Route::currentRouteName(), ['admin.payment-gateways.index','admin.payment-gateways.getData','admin.payment-gateways.edit']) ? 'show' : '' }}"
                    id="gatewaysMenu">
                    <ul class="submenu-list">
                        <li><a class="submenu-link {{ Route::currentRouteName() == 'admin.payment-gateways.index' ? 'active' : '' }}"
                                href="{{ route('admin.payment-gateways.index') }}"><i class="fas fa-list me-2"></i>{{
                                __('cms.sidebar.payment_gateways.list') }}</a></li>
                    </ul>
                </div>
            </li>

            <!-- Reviews -->
            <li
                class="menu-item has-submenu {{ in_array(Route::currentRouteName(), ['admin.product_reviews.create','admin.product_reviews.index']) ? 'open' : '' }}">
                <a class="menu-link submenu-toggle {{ in_array(Route::currentRouteName(), ['admin.product_reviews.create','admin.product_reviews.index']) ? 'active' : '' }}"
                    data-bs-toggle="collapse" href="#productReviewMenu" role="button"
                    aria-expanded="{{ in_array(Route::currentRouteName(), ['admin.product_reviews.create','admin.product_reviews.index']) ? 'true' : 'false' }}">
                    <span class="menu-icon"><i class="fas fa-star"></i></span>
                    <span class="menu-text">{{ __('cms.sidebar.product_reviews.title') }}</span>
                    <span class="menu-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <div class="collapse submenu {{ in_array(Route::currentRouteName(), ['admin.product_reviews.create','admin.product_reviews.index']) ? 'show' : '' }}"
                    id="productReviewMenu">
                    <ul class="submenu-list">
                        <li><a class="submenu-link {{ Route::currentRouteName() == 'admin.product_reviews.index' ? 'active' : '' }}"
                                href="{{ route('admin.reviews.index') }}"><i class="fas fa-list me-2"></i>{{
                                __('cms.sidebar.product_reviews.list') }}</a></li>
                    </ul>
                </div>
            </li>

            <!-- Section Divider: Content -->
            <li class="menu-section">
                <span class="section-label">{{ __('cms.sidebar.sections.content') }}</span>
            </li>

            <!-- Banners -->
            <li
                class="menu-item has-submenu {{ in_array(Route::currentRouteName(), ['admin.banners.create','admin.banners.index']) ? 'open' : '' }}">
                <a class="menu-link submenu-toggle {{ in_array(Route::currentRouteName(), ['admin.banners.create','admin.banners.index']) ? 'active' : '' }}"
                    data-bs-toggle="collapse" href="#bannerMenu" role="button"
                    aria-expanded="{{ in_array(Route::currentRouteName(), ['admin.banners.create','admin.banners.index']) ? 'true' : 'false' }}">
                    <span class="menu-icon"><i class="fas fa-image"></i></span>
                    <span class="menu-text">{{ __('cms.sidebar.banners.title') }}</span>
                    <span class="menu-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <div class="collapse submenu {{ in_array(Route::currentRouteName(), ['admin.banners.create','admin.banners.index']) ? 'show' : '' }}"
                    id="bannerMenu">
                    <ul class="submenu-list">
                        <li><a class="submenu-link {{ Route::currentRouteName() == 'admin.banners.create' ? 'active' : '' }}"
                                href="{{ route('admin.banners.create') }}"><i class="fas fa-plus-circle me-2"></i>{{
                                __('cms.sidebar.banners.add_new') }}</a></li>
                        <li><a class="submenu-link {{ Route::currentRouteName() == 'admin.banners.index' ? 'active' : '' }}"
                                href="{{ route('admin.banners.index') }}"><i class="fas fa-list me-2"></i>{{
                                __('cms.sidebar.banners.list') }}</a></li>
                    </ul>
                </div>
            </li>

            <!-- Menu -->
            <li
                class="menu-item has-submenu {{ in_array(Route::currentRouteName(), ['admin.menus.create','admin.menus.index']) ? 'open' : '' }}">
                <a class="menu-link submenu-toggle {{ in_array(Route::currentRouteName(), ['admin.menus.create','admin.menus.index']) ? 'active' : '' }}"
                    data-bs-toggle="collapse" href="#menuMenu" role="button"
                    aria-expanded="{{ in_array(Route::currentRouteName(), ['admin.menus.create','admin.menus.index']) ? 'true' : 'false' }}">
                    <span class="menu-icon"><i class="fas fa-bars-staggered"></i></span>
                    <span class="menu-text">{{ __('cms.sidebar.menu.title') }}</span>
                    <span class="menu-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <div class="collapse submenu {{ in_array(Route::currentRouteName(), ['admin.menus.create','admin.menus.index']) ? 'show' : '' }}"
                    id="menuMenu">
                    <ul class="submenu-list">
                        <li><a class="submenu-link {{ Route::currentRouteName() == 'admin.menus.create' ? 'active' : '' }}"
                                href="{{ route('admin.menus.create') }}"><i class="fas fa-plus-circle me-2"></i>{{
                                __('cms.sidebar.menu.add_new') }}</a></li>
                        <li><a class="submenu-link {{ Route::currentRouteName() == 'admin.menus.index' ? 'active' : '' }}"
                                href="{{ route('admin.menus.index') }}"><i class="fas fa-list me-2"></i>{{
                                __('cms.sidebar.menu.list') }}</a></li>
                    </ul>
                </div>
            </li>

            <!-- Menu Items -->
            <li
                class="menu-item has-submenu {{ in_array(Route::currentRouteName(), ['admin.menuitems.create','admin.menuitems.index']) ? 'open' : '' }}">
                <a class="menu-link submenu-toggle {{ in_array(Route::currentRouteName(), ['admin.menuitems.create','admin.menuitems.index']) ? 'active' : '' }}"
                    data-bs-toggle="collapse" href="#menuItemMenu" role="button"
                    aria-expanded="{{ in_array(Route::currentRouteName(), ['admin.menuitems.create','admin.menuitems.index']) ? 'true' : 'false' }}">
                    <span class="menu-icon"><i class="fas fa-list-ul"></i></span>
                    <span class="menu-text">{{ __('cms.sidebar.menu_items.title') }}</span>
                    <span class="menu-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <div class="collapse submenu {{ in_array(Route::currentRouteName(), ['admin.menuitems.create','admin.menuitems.index']) ? 'show' : '' }}"
                    id="menuItemMenu">
                    <ul class="submenu-list">
                        @if(isset($menu) && $menu)
                        <li><a class="submenu-link {{ Route::currentRouteName() == 'admin.menu.items.create' ? 'active' : '' }}"
                                href="{{ route('admin.menus.items.create', $menu) }}"><i
                                    class="fas fa-plus-circle me-2"></i>{{ __('cms.sidebar.menu_items.add_new') }}</a>
                        </li>
                        <li><a class="submenu-link {{ Route::currentRouteName() == 'admin.menus.item.index' ? 'active' : '' }}"
                                href="{{ route('admin.menus.item.index') }}"><i class="fas fa-list me-2"></i>{{
                                __('cms.sidebar.menu_items.list') }}</a></li>
                        @endif
                    </ul>
                </div>
            </li>

            <!-- Pages -->
            <li
                class="menu-item has-submenu {{ in_array(Route::currentRouteName(), ['admin.pages.create','admin.pages.index']) ? 'open' : '' }}">
                <a class="menu-link submenu-toggle {{ in_array(Route::currentRouteName(), ['admin.pages.create','admin.pages.index']) ? 'active' : '' }}"
                    data-bs-toggle="collapse" href="#pageMenu" role="button"
                    aria-expanded="{{ in_array(Route::currentRouteName(), ['admin.pages.create','admin.pages.index']) ? 'true' : 'false' }}">
                    <span class="menu-icon"><i class="fas fa-file-lines"></i></span>
                    <span class="menu-text">{{ __('cms.sidebar.pages.title') }}</span>
                    <span class="menu-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <div class="collapse submenu {{ in_array(Route::currentRouteName(), ['admin.pages.create','admin.pages.index']) ? 'show' : '' }}"
                    id="pageMenu">
                    <ul class="submenu-list">
                        <li><a class="submenu-link {{ Route::currentRouteName() == 'admin.pages.create' ? 'active' : '' }}"
                                href="{{ route('admin.pages.create') }}"><i class="fas fa-plus-circle me-2"></i>{{
                                __('cms.sidebar.pages.add_new') }}</a></li>
                        <li><a class="submenu-link {{ Route::currentRouteName() == 'admin.pages.index' ? 'active' : '' }}"
                                href="{{ route('admin.pages.index') }}"><i class="fas fa-list me-2"></i>{{
                                __('cms.sidebar.pages.list') }}</a></li>
                    </ul>
                </div>
            </li>

            <!-- Social Media Links -->
            <li
                class="menu-item has-submenu {{ in_array(Route::currentRouteName(), ['admin.social-media-links.create','admin.social-media-links.index']) ? 'open' : '' }}">
                <a class="menu-link submenu-toggle {{ in_array(Route::currentRouteName(), ['admin.social-media-links.create','admin.social-media-links.index']) ? 'active' : '' }}"
                    data-bs-toggle="collapse" href="#socialMediaLinkMenu" role="button"
                    aria-expanded="{{ in_array(Route::currentRouteName(), ['admin.social-media-links.create','admin.social-media-links.index']) ? 'true' : 'false' }}">
                    <span class="menu-icon"><i class="fas fa-share-nodes"></i></span>
                    <span class="menu-text">{{ __('cms.sidebar.social_media_links.title') }}</span>
                    <span class="menu-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <div class="collapse submenu {{ in_array(Route::currentRouteName(), ['admin.social-media-links.create','admin.social-media-links.index']) ? 'show' : '' }}"
                    id="socialMediaLinkMenu">
                    <ul class="submenu-list">
                        <li><a class="submenu-link {{ Route::currentRouteName() == 'admin.social-media-links.create' ? 'active' : '' }}"
                                href="{{ route('admin.social-media-links.create') }}"><i
                                    class="fas fa-plus-circle me-2"></i>{{ __('cms.sidebar.social_media_links.add_new')
                                }}</a></li>
                        <li><a class="submenu-link {{ Route::currentRouteName() == 'admin.social-media-links.index' ? 'active' : '' }}"
                                href="{{ route('admin.social-media-links.index') }}"><i class="fas fa-list me-2"></i>{{
                                __('cms.sidebar.social_media_links.list') }}</a></li>
                    </ul>
                </div>
            </li>

            <!-- Section Divider: Settings -->
            <li class="menu-section">
                <span class="section-label">{{ __('cms.sidebar.sections.settings') }}</span>
            </li>

            <!-- Site Settings -->
            <li class="menu-item has-submenu {{ Route::currentRouteName() == 'site-settings.index' ? 'open' : '' }}">
                <a class="menu-link submenu-toggle {{ Route::currentRouteName() == 'site-settings.index' ? 'active' : '' }}"
                    data-bs-toggle="collapse" href="#siteSettingsMenu" role="button"
                    aria-expanded="{{ Route::currentRouteName() == 'site-settings.index' ? 'true' : 'false' }}">
                    <span class="menu-icon"><i class="fas fa-gear"></i></span>
                    <span class="menu-text">{{ __('cms.sidebar.site_settings.title') }}</span>
                    <span class="menu-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <div class="collapse submenu {{ Route::currentRouteName() == 'site-settings.index' ? 'show' : '' }}"
                    id="siteSettingsMenu">
                    <ul class="submenu-list">
                        <li><a class="submenu-link {{ Route::currentRouteName() == 'site-settings.index' ? 'active' : '' }}"
                                href="{{ route('site-settings.index') }}"><i class="fas fa-sliders me-2"></i>{{
                                __('cms.sidebar.site_settings.manage') }}</a></li>
                        <li><a class="submenu-link {{ Route::currentRouteName() == 'admin.coupons.index' ? 'active' : '' }}"
                                href="{{ route('admin.coupons.index') }}"><i class="fas fa-ticket-alt me-2"></i>{{
                                __('cms.coupons.title') }}</a></li>
                    </ul>
                </div>
            </li>

        </ul>
    </div>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer" id="sidebarFooter">
        <div class="footer-user">
            <div class="user-avatar">
                <img src="{{ auth()->user()->profile_image
                    ? (\Illuminate\Support\Str::startsWith(auth()->user()->profile_image, ['http://', 'https://'])
                        ? auth()->user()->profile_image
                        : asset('storage/' . auth()->user()->profile_image))
                    : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=6366f1&color=fff&size=40' }}"
                    alt="User" class="footer-avatar">
            </div>
            <div class="user-info">
                <span class="user-name">{{ auth()->user()->name }}</span>
                <span class="user-role">{{ __('cms.sidebar.administrator') }}</span>
            </div>
        </div>
    </div>
</nav>