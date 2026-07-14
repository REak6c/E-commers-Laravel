@extends('themes.xylo.layouts.master')

@section('content')
    @php $currency = activeCurrency(); @endphp

    <section class="xsf-section">
        <div class="container">
            <div class="xsf-listing-head">
                <h1 class="xsf-listing-head__title">
                    {{ __('store.search.results_for') ?? 'Search results for' }}
                    <span class="xsf-listing-head__query">"{{ $query }}"</span>
                </h1>
                <span class="xsf-listing-head__count">{{ $products->total() }} {{ __('store.search.results') ?? 'results' }}</span>
            </div>

            <div class="row g-4">
                @forelse ($products as $product)
                    <div class="col-6 col-md-4 col-lg-3">
                        @include('themes.xylo.partials.product-card', ['product' => $product, 'currency' => $currency])
                    </div>
                @empty
                    <div class="col-12">
                        <div class="xsf-empty">
                            <i class="fa-regular fa-magnifying-glass xsf-empty__icon" aria-hidden="true"></i>
                            <p class="xsf-empty__text">{{ __('store.search.no_products') ?? 'No products found.' }}</p>
                            <a href="{{ route('shop.index') }}" class="btn btn-outline-primary btn-pill mt-2">{{ __('store.home.view_all') ?? 'Browse all products' }}</a>
                        </div>
                    </div>
                @endforelse
            </div>

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

        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.wishlist-btn');
            if (!btn) return;
            const productId = btn.getAttribute('data-product-id');
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
            .then(data => { if (data?.message) { btn.classList.toggle('is-active'); toastr.success(data.message); } })
            .catch(error => console.error('Error:', error));
        });
    </script>
@endsection
