@extends('themes.xylo.layouts.master')

@section('content')
    @php $currency = activeCurrency(); @endphp

    <section class="xsf-section pt-4 pb-0">
        <div class="container">
            {{-- Breadcrumb --}}
            <nav aria-label="breadcrumb" class="xsf-breadcrumb">
                <a href="{{ url('/') }}">{{ __('store.product_detail.home') }}</a>
                @foreach ($breadcrumbs as $category)
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                    <a href="{{ url('category/' . $category->slug) }}">{{ $category->name ?? $category->slug }}</a>
                @endforeach
                <i class="fa fa-angle-right" aria-hidden="true"></i>
                <span>{{ $product->name }}</span>
            </nav>
        </div>
    </section>

    <div class="xsf-section pt-4">
        <div class="container">
            <div class="row g-5 xsf-pd">
                {{-- Gallery --}}
                <div class="col-lg-6">
                    <div class="xsf-pd__gallery">
                        <div class="xsf-gallery">
                            @forelse ($product->images as $image)
                                <div class="xsf-gallery__slide">
                                    <img src="{{ Storage::url($image['image_url']) }}" alt="{{ $image['name'] ?? $product->name }}" />
                                </div>
                            @empty
                                <div class="xsf-gallery__slide">
                                    <img src="{{ product_image_url(optional($product->thumbnail)->image_url) }}" alt="{{ $product->name }}" />
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Info --}}
                <div class="col-lg-6">
                    <div class="xsf-pd__info">
                        @php $averageRating = round($product->reviews_avg_rating, 1); @endphp

                        <span id="product-stock" class="xsf-pd__stock {{ $inStock ? 'is-in' : 'is-out text-danger' }}">
                            {{ $inStock ? __('store.product_detail.in_stock') : 'OUT OF STOCK' }}
                        </span>

                        <div class="xsf-pd__rating stars">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= floor($averageRating))
                                    <i class="fa-solid fa-star text-warning"></i>
                                @elseif ($i - 0.5 == $averageRating)
                                    <i class="fa-solid fa-star-half-alt text-warning"></i>
                                @else
                                    <i class="fa-regular fa-star text-muted"></i>
                                @endif
                            @endfor
                            <span class="spanstar">({{ $product->reviews_count }} {{ __('store.product_detail.customer_reviews') }})</span>
                        </div>

                        <div class="xsf-pd__title-row">
                            <h1 class="xsf-pd__title">{{ $product->name }}</h1>

                            @auth('customer')
                                @php
                                    $isFavorite = auth('customer')->user()->wishlistProducts()
                                        ->where('product_id', $product->id)->exists();
                                @endphp
                            @else
                                @php $isFavorite = false; @endphp
                            @endauth

                            <button id="test-heart" class="xsf-pd__wish" aria-label="{{ __('store.header.wishlist') ?? 'Wishlist' }}">
                                <i class="{{ $isFavorite ? 'fa-solid fa-heart text-danger' : 'fa-regular fa-heart text-secondary' }} fs-4"></i>
                            </button>
                        </div>

                        <div class="xsf-pd__price">
                            <span id="currency-symbol">{{ $currency->symbol ?? '' }}</span><span id="variant-price">{{ $product->primaryVariant->converted_price ?? 'N/A' }}</span>
                        </div>

                        <p class="xsf-pd__short">{{ $product->short_description }}</p>

                        <div id="product-attributes" class="product-options xsf-pd__attributes">
                            @php $groupedAttributes = $product->attributeValues->groupBy(fn ($item) => $item->attribute->id); @endphp

                            @foreach ($groupedAttributes as $attributeId => $values)
                                @php $attrName = strtolower($values->first()->attribute->name); @endphp
                                <div class="attribute-options xsf-pd__attribute">
                                    <h3 class="xsf-pd__attribute-label">{{ __('store.product_detail.' . $attrName) }}</h3>
                                    <div class="{{ $attrName }}-wrapper xsf-pd__attribute-options">
                                        @foreach ($values as $index => $value)
                                            @php $inputId = $attrName . '-' . $index; @endphp
                                            <input type="radio" name="attribute_{{ $attributeId }}" id="{{ $inputId }}"
                                                value="{{ $value->id }}" {{ $index === 0 ? 'checked' : '' }}>
                                            <label for="{{ $inputId }}"
                                                class="{{ $attrName === 'color' ? 'color-circle' : 'size-box' }}"
                                                style="{{ $attrName === 'color' ? 'background-color:' . strtolower($value->value) . ';' : '' }}">
                                                @if ($attrName === 'size'){{ $value->translated_value }}@endif
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="cart-actions xsf-pd__actions">
                            <div class="quantity xsf-pd__qty">
                                <button type="button" onclick="changeQty(-1)" aria-label="Decrease quantity">&minus;</button>
                                <input type="text" id="qty" value="1" aria-label="Quantity">
                                <button type="button" onclick="changeQty(1)" aria-label="Increase quantity">+</button>
                            </div>
                            <button class="add-to-cart btn btn-primary btn-pill btn-lg"
                                onclick="addToCart({{ $product->id }}, '{{ $product->product_type }}')">
                                <i class="fa fa-shopping-bag me-2" aria-hidden="true"></i>{{ __('store.product_detail.add_to_cart') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabs: description + reviews --}}
    <div class="xsf-section reviewbox">
        <div class="container">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description"
                        type="button" role="tab" aria-controls="description" aria-selected="true">{{ __('store.product_detail.description') }}</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews"
                        type="button" role="tab" aria-controls="reviews" aria-selected="false">{{ __('store.product_detail.reviews') }} ({{ $product->reviews_count }})</button>
                </li>
            </ul>

            <div class="tab-content pt-4" id="myTabContent">
                <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                    <div class="xsf-pd__description">{!! $product->description !!}</div>
                </div>

                <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                    <div class="product-detail-customer-review">
                        @auth('customer')
                            <div class="xsf-review-form">
                                <h5>{{ __('store.product_detail.submit_review_title') }}</h5>
                                <form action="{{ route('review.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="rating" id="rating-value" required>

                                    <div id="starWrapper" class="xsf-review-form__stars">
                                        <span class="star" data-value="1">&#9733;</span>
                                        <span class="star" data-value="2">&#9733;</span>
                                        <span class="star" data-value="3">&#9733;</span>
                                        <span class="star" data-value="4">&#9733;</span>
                                        <span class="star" data-value="5">&#9733;</span>
                                    </div>

                                    <div class="mb-3 mt-3">
                                        <label class="form-label">{{ __('store.product_detail.review_optional') }}</label>
                                        <textarea name="review" class="form-control" rows="3"></textarea>
                                    </div>

                                    <button class="btn btn-primary">{{ __('store.product_detail.submit_review_btn') }}</button>
                                </form>
                            </div>
                        @else
                            <p class="mt-3">{{ __('store.product_detail.please') }} <a href="{{ route('customer.login') }}">{{ __('store.product_detail.login') }}</a> {{ __('store.product_detail.submit') }}</p>
                        @endauth

                        @if ($product->reviews->isEmpty())
                            <p class="mt-4">{{ __('store.product_detail.no_reviews_yet') }}</p>
                        @else
                            <ul class="xsf-review-list">
                                @foreach ($product->reviews as $review)
                                    @if ($review->is_approved)
                                        <li class="xsf-review">
                                            <div class="review-customer-info">
                                                <img src="{{ $review->customer->profile_image ? asset('storage/' . $review->customer->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($review->customer->name) . '&background=0D8ABC&color=fff&size=70' }}"
                                                    alt="{{ $review->customer->name }}" class="review-customer-avatar" />
                                                <strong>{{ ucwords($review->customer->name) }}</strong>
                                            </div>
                                            <div class="review-rating">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <span style="color: {{ $i <= $review->rating ? 'gold' : '#ccc' }}">&#9733;</span>
                                                @endfor
                                                <span class="review-time">
                                                    @php
                                                        $created_at = \Carbon\Carbon::parse($review->created_at);
                                                        $diffInDays = (int) $created_at->diffInDays(\Carbon\Carbon::now());
                                                    @endphp
                                                    ({{ $diffInDays }} {{ $diffInDays == 1 ? __('store.product_detail.day') : __('store.product_detail.days') }} {{ __('store.product_detail.ago') }})
                                                </span>
                                            </div>
                                            @if ($review->review)
                                                <p>{{ $review->review }}</p>
                                            @else
                                                <p>{{ __('store.product_detail.no_review_text') }}</p>
                                            @endif
                                        </li>
                                    @endif
                                @endforeach
                            </ul>

                            <div class="average-rating">
                                <div class="review-rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= floor($product->reviews_avg_rating))
                                            <span style="color: gold">&#9733;</span>
                                        @elseif ($i == ceil($product->reviews_avg_rating) && $product->reviews_avg_rating - floor($product->reviews_avg_rating) >= 0.5)
                                            <span style="color: gold">&#9733;</span>
                                        @else
                                            <span style="color: #ccc">&#9733;</span>
                                        @endif
                                    @endfor
                                    {{ number_format($product->reviews_avg_rating, 1) }} <span>{{ __('store.product_detail.average_rating') }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#test-heart').on('click', function () {
                var button = $(this);
                var icon = button.find('i');
                var productId = {{ $product->id }};
                $.ajax({
                    url: '{{ route('customer.wishlist.toggle') }}',
                    method: 'POST',
                    data: { _token: '{{ csrf_token() }}', product_id: productId },
                    success: function (response) {
                        if (response.status === 'added') {
                            icon.removeClass('fa-regular text-secondary').addClass('fa-solid text-danger');
                            toastr.success(response.message || 'Added to favorites');
                        } else if (response.status === 'removed') {
                            icon.removeClass('fa-solid text-danger').addClass('fa-regular text-secondary');
                            toastr.info(response.message || 'Removed from favorites');
                        }
                    },
                    error: function (xhr) {
                        if (xhr.status === 401) {
                            toastr.warning('{{ __('store.product_detail.login_to_wishlist') }}');
                        } else {
                            toastr.error('Something went wrong.');
                        }
                    }
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const stars = document.querySelectorAll('#starWrapper .star');
            const ratingInput = document.getElementById('rating-value');
            if (!ratingInput) return;

            stars.forEach(star => {
                star.addEventListener('mouseover', function () {
                    const val = parseInt(this.dataset.value);
                    stars.forEach(s => { s.style.color = (parseInt(s.dataset.value) <= val) ? 'gold' : '#ccc'; });
                });
                star.addEventListener('mouseout', function () {
                    const currentRating = parseInt(ratingInput.value) || 0;
                    stars.forEach(s => { s.style.color = (parseInt(s.dataset.value) <= currentRating) ? 'gold' : '#ccc'; });
                });
                star.addEventListener('click', function () {
                    const val = parseInt(this.dataset.value);
                    ratingInput.value = val;
                    stars.forEach(s => { s.style.color = (parseInt(s.dataset.value) <= val) ? 'gold' : '#ccc'; });
                });
            });
        });
    </script>

    <script>
        @if (Session::has('success'))
            toastr.success("{{ session('success') }}");
        @endif
        @if (Session::has('error'))
            toastr.error("{{ session('error') }}");
        @endif

        // Gallery slider (own class to avoid master's .product-slider 4-col init)
        $(document).ready(function () {
            $('.xsf-gallery').slick({
                arrows: true,
                dots: true,
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
                nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
            });
        });
    </script>

    <script>
        const variantMap = @json($variantMap);

        $(document).ready(function () {
            const productId = {{ $product->id }};

            function getSelectedAttributeValueIds() {
                let selected = [];
                $('#product-attributes input[type="radio"]:checked').each(function () {
                    selected.push(parseInt($(this).val()));
                });
                return selected.sort((a, b) => a - b);
            }

            function findMatchingVariantId(selectedAttrIds) {
                for (const variant of variantMap) {
                    const variantAttrIds = variant.attributes.slice().sort((a, b) => a - b);
                    if (JSON.stringify(variantAttrIds) === JSON.stringify(selectedAttrIds)) {
                        return variant.id;
                    }
                }
                return null;
            }

            $('#product-attributes input[type="radio"]').on('change', function () {
                const selectedAttrIds = getSelectedAttributeValueIds();
                const variantId = findMatchingVariantId(selectedAttrIds);
                if (!variantId) { toastr.warning('Selected variant not available.'); return; }

                $.ajax({
                    url: '/get-variant-price',
                    type: 'GET',
                    data: { variant_id: variantId, product_id: productId },
                    success: function (response) {
                        if (response.success) {
                            $('#variant-price').text(response.price);
                            $('#product-stock').text(response.stock);
                            $('#currency-symbol').text(response.currency_symbol);
                            $('#product-stock').toggleClass('text-danger is-out', !!response.is_out_of_stock);
                            $('#product-stock').toggleClass('is-in', !response.is_out_of_stock);
                        } else {
                            console.log('Unable to fetch variant price.');
                        }
                    },
                    error: function () { toastr.error('Something went wrong. Please try again.'); }
                });
            });

            $('#product-attributes input[type="radio"]:checked').trigger('change');
        });
    </script>

    <script>
        function changeQty(amount) {
            let qtyInput = document.getElementById("qty");
            let currentQty = parseInt(qtyInput.value);
            let newQty = currentQty + amount;
            if (newQty < 1 || isNaN(newQty)) newQty = 1;
            qtyInput.value = newQty;
        }

        function addToCart(productId, product_type) {
            const quantity = parseInt(document.getElementById("qty").value);
            const attributeInputs = document.querySelectorAll('#product-attributes input[type="radio"]:checked');
            let selectedAttributes = [];
            attributeInputs.forEach(input => { selectedAttributes.push(parseInt(input.value)); });

            fetch("{{ route('cart.add') }}", {
                method: "POST",
                headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity,
                    attribute_value_ids: selectedAttributes,
                    product_type: product_type
                })
            })
            .then(response => response.json())
            .then(data => {
                toastr.success(data.message);
                updateCartCount(data.cart);
            })
            .catch(error => console.error("Error:", error));
        }

        function updateCartCount(cart) {
            let totalCount = Object.values(cart || {}).reduce((sum, item) => sum + item.quantity, 0);
            const el = document.getElementById("cart-count");
            if (el) { el.textContent = totalCount; el.classList.toggle('d-none', totalCount === 0); }
        }
    </script>
@endsection
