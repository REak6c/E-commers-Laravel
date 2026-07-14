@extends('themes.xylo.layouts.master')

@section('content')
    @php $currency = activeCurrency(); @endphp

    <section class="xsf-section">
        <div class="container">
            <div class="xsf-listing-head">
                <h1 class="xsf-listing-head__title">{{ __('store.wishlist.title') }}</h1>
            </div>

            @if ($products->isEmpty())
                <div class="xsf-empty">
                    <i class="fa-regular fa-heart xsf-empty__icon" aria-hidden="true"></i>
                    <p class="xsf-empty__text">{{ __('store.wishlist.empty') }}</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-primary btn-pill mt-2">{{ __('store.home.view_all') ?? 'Browse products' }}</a>
                </div>
            @else
                <div class="row g-4">
                    @foreach ($products as $product)
                        <div class="col-6 col-md-4 col-lg-3 xsf-wishlist-item">
                            @include('themes.xylo.partials.product-card', ['product' => $product, 'currency' => $currency])
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection

@section('js')
    <script>
        // Toggle wishlist; remove the card on 'removed'
        $(document).on('click', '.wishlist-btn', function () {
            let button = $(this);
            let productId = button.data('product-id');
            $.post('{{ route('customer.wishlist.toggle') }}', {
                _token: '{{ csrf_token() }}',
                product_id: productId
            }, function (res) {
                if (res.status === 'removed') {
                    button.closest('.xsf-wishlist-item').fadeOut(200, function () { $(this).remove(); });
                }
                if (res.message) { toastr.info(res.message); }
            });
        });

        function addToCart(productId) {
            $.ajax({
                url: "{{ route('cart.add') }}",
                method: "POST",
                data: { _token: "{{ csrf_token() }}", product_id: productId, quantity: 1 },
                success: function (res) {
                    toastr.success(res.message);
                    const el = document.getElementById("cart-count");
                    if (el && res.cart) {
                        let totalCount = Object.values(res.cart).reduce((sum, item) => sum + item.quantity, 0);
                        el.textContent = totalCount;
                        el.classList.toggle('d-none', totalCount === 0);
                    }
                },
                error: function () { toastr.error("Error adding to cart"); }
            });
        }
    </script>
@endsection
