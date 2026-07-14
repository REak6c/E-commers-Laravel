@php $currency = activeCurrency(); @endphp

@forelse ($products as $product)
    <div class="xsf-product-grid__item">
        @include('themes.xylo.partials.product-card', ['product' => $product, 'currency' => $currency])
    </div>
@empty
    <div class="xsf-product-grid__empty">
        <div class="xsf-empty">
            <i class="fa-regular fa-bag-shopping xsf-empty__icon" aria-hidden="true"></i>
            <h3 class="xsf-empty__title">{{ __('store.shop.no_products_title') ?? 'No products found' }}</h3>
            <p class="xsf-empty__text">{{ __('store.shop.no_products_found') ?? 'Try adjusting your filters or browse all products.' }}</p>
            <a href="{{ route('shop.index') }}" class="xsf-empty__cta">
                <i class="fa-solid fa-arrow-rotate-left" aria-hidden="true"></i>
                {{ __('store.shop.clear_filters') ?? 'Clear filters' }}
            </a>
        </div>
    </div>
@endforelse

@if ($products->hasPages())
    <div class="xsf-product-grid__pagination xsf-pagination d-flex justify-content-between align-items-center mt-2">
        <p class="xsf-pagination__info mb-0">
            {{ __('store.shop.showing') ?? 'Showing' }}
            <strong>{{ $products->firstItem() }}–{{ $products->lastItem() }}</strong>
            {{ __('store.shop.of') ?? 'of' }}
            <strong>{{ $products->total() }}</strong>
            {{ __('store.shop.results') ?? 'results' }}
        </p>
        <div class="paginations">
            {{ $products->links('vendor.pagination.custom') }}
        </div>
    </div>
@endif
