{{--
    Reusable storefront product card.
    Expects : $product (with thumbnail, primaryVariant, reviews_count)
    Optional: $currency (falls back to activeCurrency())
--}}
@php
    $currency    = $currency ?? activeCurrency();
    $hasDiscount = optional($product->primaryVariant)->converted_discount_price ? true : false;

    // Badge logic
    $isNew  = $product->created_at && $product->created_at->diffInDays(now()) <= 30;
    $isSale = $hasDiscount;

    // Star rating
    $reviewCount = $product->reviews_count ?? 0;
    $avgRating   = $product->average_rating ?? ($reviewCount > 0 ? 4 : 0);
    $fullStars   = (int) floor($avgRating);
    $halfStar    = ($avgRating - $fullStars) >= 0.5;
    $emptyStars  = 5 - $fullStars - ($halfStar ? 1 : 0);
@endphp

<article class="xsf-product-card">

    {{-- ── Media ─────────────────────────────────────────── --}}
    <div class="xsf-product-card__media">

        {{-- Badges --}}
        @if ($isSale || $isNew)
            <div class="xsf-product-card__badge">
                @if ($isSale)
                    <span class="xsf-product-card__badge-item xsf-product-card__badge-item--sale">
                        {{ __('store.home.badge_sale') }}
                    </span>
                @elseif ($isNew)
                    <span class="xsf-product-card__badge-item xsf-product-card__badge-item--new">
                        {{ __('store.home.badge_new') }}
                    </span>
                @endif
            </div>
        @endif

        {{-- Product image --}}
        <a href="{{ route('product.show', $product->slug) }}"
           class="xsf-product-card__img"
           tabindex="-1"
           aria-hidden="true">
            <img src="{{ product_image_url(optional($product->thumbnail)->image_url) }}"
                 loading="lazy"
                 alt="{{ $product->name ?? __('store.home.product_unavailable') }}">
        </a>

        {{-- Hover overlay with quick-view --}}
        <div class="xsf-product-card__overlay" aria-hidden="true">
            <a href="{{ route('product.show', $product->slug) }}"
               class="xsf-product-card__quickview"
               tabindex="-1">
                <i class="fa-regular fa-eye" aria-hidden="true"></i>
                {{ __('store.shop.quick_view') }}
            </a>
        </div>

        {{-- Wishlist button --}}
        <button type="button"
                class="xsf-product-card__wish wishlist-btn"
                data-product-id="{{ $product->id }}"
                aria-label="{{ __('store.home.add_to_wishlist') }}">
            <i class="fa-regular fa-heart" aria-hidden="true"></i>
        </button>
    </div>

    {{-- ── Body ─────────────────────────────────────────── --}}
    <div class="xsf-product-card__body">

        {{-- Star rating + review count --}}
        <div class="xsf-product-card__reviews">
            <div class="stars" aria-label="{{ $avgRating }} {{ __('store.home.out_of_5_stars') }}">
                @for ($i = 0; $i < $fullStars; $i++)
                    <i class="fa-solid fa-star" aria-hidden="true"></i>
                @endfor
                @if ($halfStar)
                    <i class="fa-solid fa-star-half-stroke" aria-hidden="true"></i>
                @endif
                @for ($i = 0; $i < $emptyStars; $i++)
                    <i class="fa-regular fa-star empty" aria-hidden="true"></i>
                @endfor
            </div>
            <span class="count">({{ $reviewCount }} {{ __('store.home.reviews') }})</span>
        </div>

        {{-- Title --}}
        <h3 class="xsf-product-card__title">
            <a href="{{ route('product.show', $product->slug) }}">
                {{ $product->name ?? __('store.home.product_unavailable') }}
            </a>
        </h3>

        {{-- Price + cart --}}
        <div class="xsf-product-card__footer">
            <p class="xsf-product-card__price price mb-0">
                <span class="original {{ $hasDiscount ? 'has-discount' : '' }}">
                    {{ $currency->symbol ?? '' }}{{ optional($product->primaryVariant)->converted_price ?? __('store.home.price_unavailable') }}
                </span>
                @if ($hasDiscount)
                    <span class="discount">
                        {{ $currency->symbol ?? '' }}{{ $product->primaryVariant->converted_discount_price }}
                    </span>
                @endif
            </p>

            <button type="button"
                    class="xsf-product-card__cart cart-btn"
                    onclick="addToCart({{ $product->id }})"
                    aria-label="{{ __('store.home.add_to_cart') }}"
                    title="{{ __('store.home.add_to_cart') }}">
                <i class="fa fa-shopping-bag" aria-hidden="true"></i>
            </button>
        </div>
    </div>

</article>
