@php
    $wishlistCount = 0;
    if (auth('customer')->check()) {
        $wishlistCount = auth('customer')->user()->wishlistProducts()->count();
    }
    $cartCount = session('cart') ? collect(session('cart'))->sum('quantity') : 0;
@endphp

<header class="xsf-header" id="site-header">

    {{-- ── Announcement bar ────────────────────────────────── --}}
    <div class="xsf-topbar">
        <div class="container">
            <div class="xsf-topbar__inner">
                <p class="xsf-topbar__msg mb-0">
                    <i class="fas fa-truck xsf-topbar__icon"></i>
                    {{ __('store.header.top_bar_message') }}
                </p>

            </div>
        </div>
    </div>

    {{-- ── Primary bar: logo / search / actions ─────────────── --}}
    <div class="xsf-header__main">
        <div class="container">
            <div class="xsf-header__row">

                {{-- Mobile nav toggle --}}
                <button class="xsf-header__burger d-lg-none"
                        type="button"
                        data-bs-toggle="offcanvas"
                        data-bs-target="#xsfMobileNav"
                        aria-controls="xsfMobileNav"
                        aria-label="{{ __('store.header.open_menu') ?? 'Open menu' }}">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                </button>

                {{-- Logo --}}
                <a href="{{ route('xylo.home') }}" class="xsf-header__brand" aria-label="{{ config('app.name') }}">
                    @php $siteLogo = \App\Models\SiteSetting::first()?->logo ?? null; @endphp
                    @if($siteLogo)
                        <img src="{{ \Illuminate\Support\Str::startsWith($siteLogo, ['http://','https://']) ? $siteLogo : asset('storage/' . $siteLogo) }}"
                             alt="{{ config('app.name') }} logo" class="xsf-brand__img">
                    @else
                        <div class="xsf-brand__wordmark">
                            <span class="xsf-brand__dot"></span>
                            <span>{{ config('app.name') }}</span>
                        </div>
                    @endif
                </a>

                {{-- Search (desktop) --}}
                <form class="xsf-search d-none d-md-flex" action="{{ url('/search') }}" method="GET" role="search">
                    <div class="xsf-search__group">
                        <i class="fa fa-search xsf-search__icon" aria-hidden="true"></i>
                        <input type="text"
                               class="xsf-search__input"
                               id="search-input"
                               name="q"
                               autocomplete="off"
                               placeholder="{{ __('store.header.search_placeholder') }}"
                               aria-label="{{ __('store.header.search_placeholder') }}">
                        <button type="submit" class="xsf-search__btn">
                            {{ __('store.header.search') ?? 'Search' }}
                        </button>
                        <div id="search-suggestions" class="xsf-search__suggestions d-none"></div>
                    </div>
                </form>

                {{-- Action icons --}}
                <div class="xsf-actions">

                    {{-- Wishlist --}}
                    <a href="{{ auth('customer')->check() ? route('customer.wishlist.index') : route('customer.login') }}"
                       class="xsf-action"
                       aria-label="{{ __('store.header.wishlist') ?? 'Wishlist' }}"
                       title="{{ __('store.header.wishlist') ?? 'Wishlist' }}">
                        <i class="fa-regular fa-heart" aria-hidden="true"></i>
                        <span id="wishlist-count" class="xsf-action__badge {{ $wishlistCount > 0 ? '' : 'd-none' }}">{{ $wishlistCount }}</span>
                    </a>

                    {{-- Account --}}
                    <div class="dropdown xsf-account">
                        <a href="#"
                           class="xsf-action dropdown-toggle"
                           data-bs-toggle="dropdown"
                           aria-expanded="false"
                           aria-label="{{ __('store.header.account') ?? 'Account' }}">
                            @auth('customer')
                                @php $customer = Auth::guard('customer')->user(); @endphp
                                <img src="{{ $customer->profile_image ? asset('storage/' . $customer->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($customer->name) . '&background=6366f1&color=fff&size=40' }}"
                                     alt="{{ $customer->name }}"
                                     class="xsf-action__avatar">
                            @else
                                <i class="fa-regular fa-user" aria-hidden="true"></i>
                            @endauth
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end xsf-account__menu">
                            @guest('customer')
                                <li>
                                    <div class="xsf-account__guest-header">
                                        <i class="fa-regular fa-user-circle xsf-account__guest-icon"></i>
                                        <span>{{ __('store.header.my_account') ?? 'My Account' }}</span>
                                    </div>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('customer.login') }}">
                                        <i class="bi bi-box-arrow-in-right me-2"></i>
                                        {{ __('store.header.sign_in') ?? 'Sign In' }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('customer.register') }}">
                                        <i class="bi bi-person-plus me-2"></i>
                                        {{ __('store.header.sign_up') ?? 'Sign Up' }}
                                    </a>
                                </li>
                            @else
                                <li>
                                    <div class="xsf-account__user-header">
                                        <img src="{{ $customer->profile_image ? asset('storage/' . $customer->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($customer->name) . '&background=6366f1&color=fff&size=64' }}"
                                             alt="{{ $customer->name }}"
                                             class="xsf-account__user-avatar">
                                        <div>
                                            <p class="xsf-account__user-name">{{ $customer->name }}</p>
                                            <p class="xsf-account__user-email">{{ $customer->email }}</p>
                                        </div>
                                    </div>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('customer.profile.edit') }}">
                                        <i class="bi bi-person-circle me-2"></i>
                                        {{ __('store.header.my_profile') ?? 'My Profile' }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('customer.wishlist.index') }}">
                                        <i class="bi bi-heart me-2"></i>
                                        {{ __('store.header.wishlist') ?? 'Wishlist' }}
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item xsf-account__logout"
                                       href="#"
                                       onclick="event.preventDefault(); document.getElementById('customer-logout-form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i>
                                        {{ __('store.header.logout') ?? 'Logout' }}
                                    </a>
                                    <form id="customer-logout-form" action="{{ route('customer.logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            @endguest
                        </ul>
                    </div>

                    {{-- Cart --}}
                    <a href="{{ route('cart.view') }}"
                       class="xsf-action xsf-action--cart"
                       aria-label="{{ __('store.header.cart') ?? 'Cart' }}"
                       title="{{ __('store.header.cart') ?? 'Cart' }}">
                        <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                        <span id="cart-count" class="xsf-action__badge {{ $cartCount > 0 ? '' : 'd-none' }}">{{ $cartCount }}</span>
                    </a>
                </div>

            </div>{{-- /.xsf-header__row --}}

            {{-- Search (mobile) --}}
            <form class="xsf-search xsf-search--mobile d-flex d-md-none" action="{{ url('/search') }}" method="GET" role="search">
                <div class="xsf-search__group">
                    <i class="fa fa-search xsf-search__icon" aria-hidden="true"></i>
                    <input type="text"
                           class="xsf-search__input"
                           name="q"
                           autocomplete="off"
                           placeholder="{{ __('store.header.search_placeholder') }}"
                           aria-label="{{ __('store.header.search_placeholder') }}">
                    <button type="submit" class="xsf-search__btn">
                        {{ __('store.header.search') ?? 'Search' }}
                    </button>
                </div>
            </form>

        </div>
    </div>

    {{-- ── Primary navigation (desktop) ──────────────────────── --}}
    <nav class="xsf-nav d-none d-lg-block" aria-label="{{ __('store.header.primary_nav') ?? 'Primary' }}">
        <div class="container">
            <ul class="xsf-nav__list">
                @if (!empty($headerMenu) && $headerMenu->menuItems->count())
                    @foreach ($headerMenu->menuItems as $menuItem)
                        <li class="xsf-nav__item">
                            <a class="xsf-nav__link menu-text-color" href="{{ url($menuItem->slug) }}">
                                {{ $menuItem->title ?? 'Menu Item' }}
                            </a>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
    </nav>

</header>

{{-- ── Mobile navigation offcanvas ──────────────────────────── --}}
<div class="offcanvas offcanvas-start xsf-mobile-nav" tabindex="-1" id="xsfMobileNav" aria-labelledby="xsfMobileNavLabel">
    <div class="offcanvas-header xsf-mobile-nav__header">
        @if($siteLogo ?? false)
            <img src="{{ \Illuminate\Support\Str::startsWith($siteLogo, ['http://','https://']) ? $siteLogo : asset('storage/' . $siteLogo) }}"
                 alt="{{ config('app.name') }}" id="xsfMobileNavLabel" style="max-height:40px;">
        @else
            <span class="xsf-mobile-nav__brand" id="xsfMobileNavLabel">{{ config('app.name') }}</span>
        @endif
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
        <ul class="xsf-mobile-nav__list">
            @if (!empty($headerMenu) && $headerMenu->menuItems->count())
                @foreach ($headerMenu->menuItems as $menuItem)
                    <li>
                        <a class="xsf-mobile-nav__link" href="{{ url($menuItem->slug) }}">
                            {{ $menuItem->title ?? 'Menu Item' }}
                            <i class="fas fa-chevron-right xsf-mobile-nav__arrow"></i>
                        </a>
                    </li>
                @endforeach
            @endif
        </ul>

        {{-- Mobile auth links --}}
        <div class="xsf-mobile-nav__auth">
            @guest('customer')
                <a href="{{ route('customer.login') }}" class="btn btn-primary w-100 mb-2">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                </a>
                <a href="{{ route('customer.register') }}" class="btn btn-outline-primary w-100">
                    <i class="bi bi-person-plus me-2"></i>Create Account
                </a>
            @else
                <div class="d-flex align-items-center gap-3 mb-3">
                    <img src="{{ auth('customer')->user()->profile_image ? asset('storage/' . auth('customer')->user()->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode(auth('customer')->user()->name) . '&background=6366f1&color=fff&size=40' }}"
                         alt="{{ auth('customer')->user()->name }}"
                         class="rounded-circle" width="42" height="42" style="object-fit:cover;">
                    <div>
                        <p class="mb-0 fw-semibold" style="font-size:.9rem;">{{ auth('customer')->user()->name }}</p>
                        <p class="mb-0 text-muted" style="font-size:.78rem;">{{ auth('customer')->user()->email }}</p>
                    </div>
                </div>
                <a href="{{ route('customer.profile.edit') }}" class="btn btn-outline-primary w-100 mb-2">
                    <i class="bi bi-person-circle me-2"></i>My Profile
                </a>
            @endguest
        </div>
    </div>
</div>

{{-- Scroll-aware header elevation --}}
<script>
(function () {
    const header = document.getElementById('site-header');
    if (!header) return;
    const onScroll = function () {
        header.classList.toggle('is-scrolled', window.scrollY > 20);
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
})();
</script>
