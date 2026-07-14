@extends('themes.xylo.layouts.master')

@section('title', $category->name)

@section('content')
    @php $currency = activeCurrency(); @endphp

    <section class="xsf-section">
        <div class="container">
            {{-- Breadcrumbs --}}
            <nav aria-label="breadcrumb" class="xsf-breadcrumb">
                <a href="{{ route('xylo.home') }}">{{ __('store.category.home') }}</a>
                @foreach ($breadcrumbs as $crumb)
                    <i class="fa-solid fa-angle-right" aria-hidden="true"></i>
                    <a href="{{ route('category.show', $crumb->slug) }}">{{ $crumb->name }}</a>
                @endforeach
            </nav>

            <div class="xsf-listing-head">
                <h1 class="xsf-listing-head__title">{{ $category->name }}</h1>
            </div>

            {{-- Filter / sort bar --}}
            <form method="GET" class="xsf-toolbar">
                <div class="xsf-toolbar__prices">
                    <input type="number" name="min_price" class="form-control form-control-sm"
                        placeholder="{{ __('store.category.min_price') }}" value="{{ request('min_price') }}">
                    <span class="xsf-toolbar__dash">&ndash;</span>
                    <input type="number" name="max_price" class="form-control form-control-sm"
                        placeholder="{{ __('store.category.max_price') }}" value="{{ request('max_price') }}">
                </div>
                <div class="xsf-toolbar__sort">
                    <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">{{ __('store.category.sort_by') }}</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>{{ __('store.category.newest') }}</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>{{ __('store.category.price_low_high') }}</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>{{ __('store.category.price_high_low') }}</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>{{ __('store.category.top_rated') }}</option>
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm">{{ __('store.category.filter') }}</button>
                </div>
            </form>

            {{-- Products --}}
            <div class="row g-4">
                @forelse ($products as $product)
                    <div class="col-6 col-md-4 col-lg-3">
                        @include('themes.xylo.partials.product-card', ['product' => $product, 'currency' => $currency])
                    </div>
                @empty
                    <div class="col-12">
                        <div class="xsf-empty">
                            <i class="fa-regular fa-face-frown xsf-empty__icon" aria-hidden="true"></i>
                            <p class="xsf-empty__text">{{ __('store.category.no_products_found') }}</p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if ($products->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </section>
@endsection

@section('js')
    <script>
        function addToCart(productId) {
            fetch("{{ route('cart.add') }}", {
                method: "POST",
                headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                body: JSON.stringify({ product_id: productId, quantity: 1 })
            })
            .then(response => response.json())
            .then(data => {
                toastr.success(data.message || "{{ __('store.home.added_to_cart') ?? 'Added to cart' }}");
                updateCartCount(data.cart);
            })
            .catch(error => console.error("Error:", error));
        }

        function updateCartCount(cart) {
            let totalCount = Object.values(cart || {}).reduce((sum, item) => sum + item.quantity, 0);
            const el = document.getElementById("cart-count");
            if (el) { el.textContent = totalCount; el.classList.toggle('d-none', totalCount === 0); }
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.wishlist-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const productId = this.getAttribute('data-product-id');
                    fetch('/customer/wishlist', {
                        method: 'POST',
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Accept": "application/json",
                        },
                        body: JSON.stringify({ product_id: productId })
                    })
                    .then(response => {
                        if (response.status === 401) { window.location.href = '/customer/login'; }
                        else if (response.ok) { return response.json(); }
                        else { throw new Error('Something went wrong'); }
                    })
                    .then(data => { if (data?.message) { this.classList.toggle('is-active'); toastr.success(data.message); } })
                    .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>
@endsection
