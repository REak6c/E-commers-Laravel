@extends('themes.xylo.layouts.master')

@section('css')
<style>
/* ─────────────────────────────────────────────
   ABA PAY / KHQR Payment Modal  –  template3_color style
   ───────────────────────────────────────────── */

/* Modal card wrapper */
.khqr-modal-card {
    border: none;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.18);
    background: #ffffff;
    max-width: 340px;
    margin: 0 auto;
}

/* ── Brand header (red strip) ── */
.khqr-modal-header {
    background: #d00c18;             /* ABA red */
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 20px 12px;
}

.khqr-abapay-logo {
    line-height: 1;
}

.khqr-logo-aba {
    font-size: 22px;
    font-weight: 900;
    color: #ffffff;
    letter-spacing: -0.5px;
}

.khqr-logo-pay {
    font-size: 22px;
    font-weight: 900;
    color: #ffd700;   /* golden */
    letter-spacing: -0.5px;
}

.khqr-logo-tm {
    font-size: 9px;
    color: #ffd700;
    vertical-align: super;
    font-weight: 400;
}

.khqr-label-badge {
    background: #ffffff;
    color: #d00c18;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 1px;
    padding: 3px 10px;
    border-radius: 4px;
}

/* ── Merchant name ── */
.khqr-merchant-row {
    text-align: center;
    padding: 12px 16px 4px;
    border-bottom: 1px dashed #dee2e6;
}

.khqr-merchant-name {
    font-size: 14px;
    font-weight: 700;
    color: #1a1a2e;
    letter-spacing: 0.2px;
}

/* ── Amount ── */
.khqr-amount-row {
    display: flex;
    align-items: baseline;
    justify-content: center;
    gap: 4px;
    padding: 10px 16px 8px;
}

.khqr-amount-symbol {
    font-size: 18px;
    font-weight: 700;
    color: #1a1a2e;
}

.khqr-amount-value {
    font-size: 28px;
    font-weight: 800;
    color: #1a1a2e;
    letter-spacing: -0.5px;
}

/* ── QR frame ── */
.khqr-qr-wrapper {
    display: flex;
    justify-content: center;
    padding: 8px 20px 12px;
}

.khqr-qr-frame {
    border: 2px solid #e8e8e8;
    border-radius: 12px;
    padding: 10px;
    background: #ffffff;
    width: 220px;
    height: 220px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    box-shadow: inset 0 0 0 4px rgba(208, 12, 24, 0.07);
}

.khqr-qr-img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    border-radius: 6px;
}

/* Loading skeleton */
.khqr-skeleton {
    width: 100%;
    height: 100%;
    border-radius: 8px;
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: khqr-shimmer 1.4s infinite;
}

@keyframes khqr-shimmer {
    0%   { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}

/* ── Scan hint ── */
.khqr-scan-hint {
    text-align: center;
    font-size: 11.5px;
    color: #6c757d;
    padding: 0 20px 8px;
    line-height: 1.55;
    margin: 0;
}

/* ── Currency strip ── */
.khqr-currency-strip {
    background: #f7f7f7;
    border-top: 1px dashed #dee2e6;
    padding: 7px 16px;
    text-align: center;
}

.khqr-currency-label {
    font-size: 11px;
    color: #888;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* ── Waiting spinner row ── */
.khqr-waiting-row {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 16px 8px;
}

.khqr-spinner {
    display: inline-block;
    width: 16px;
    height: 16px;
    border: 2px solid rgba(208, 12, 24, 0.2);
    border-top-color: #d00c18;
    border-radius: 50%;
    animation: khqr-spin 0.8s linear infinite;
    flex-shrink: 0;
}

@keyframes khqr-spin {
    to { transform: rotate(360deg); }
}

.khqr-waiting-text {
    font-size: 12px;
    color: #6c757d;
}

/* ── App store badges ── */
.khqr-stores {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    justify-content: center;
    padding: 8px 16px 4px;
}

.khqr-store-badge {
    display: flex;
    align-items: center;
    gap: 8px;
    background: #1a1a2e;
    color: #ffffff;
    text-decoration: none;
    border-radius: 8px;
    padding: 7px 14px;
    font-size: 12px;
    line-height: 1.3;
    flex: 1;
    min-width: 120px;
    transition: opacity 0.2s;
}

.khqr-store-badge:hover {
    opacity: 0.85;
    color: #ffffff;
}

.khqr-store-icon {
    font-size: 20px;
}

.khqr-deeplink-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    background: #d00c18;
    color: #ffffff;
    text-decoration: none;
    border-radius: 8px;
    padding: 10px 16px;
    font-size: 13px;
    font-weight: 600;
    transition: background 0.2s;
}

.khqr-deeplink-btn:hover {
    background: #a80a13;
    color: #ffffff;
}

/* ── Footer / cancel button ── */
.khqr-footer {
    padding: 10px 20px 18px;
    text-align: center;
}

.khqr-cancel-btn {
    background: transparent;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    color: #6c757d;
    font-size: 13px;
    padding: 8px 28px;
    cursor: pointer;
    transition: background 0.15s, color 0.15s;
}

.khqr-cancel-btn:hover {
    background: #f8f8f8;
    color: #d00c18;
    border-color: #d00c18;
}

/* Backdrop dim */
.modal-backdrop.show { opacity: 0.65; }

/* ── Ensure modal-sm is wide enough for the card ── */
@media (min-width: 576px) {
    #paywayQRModal .modal-dialog { max-width: 360px; }
}
</style>
@endsection

@section('content')
    @php $currency = activeCurrency(); @endphp

    <section class="xsf-section">
        <div class="container">
            <nav aria-label="breadcrumb" class="xsf-breadcrumb">
                <a href="{{ route('xylo.home') }}">{{ __('store.checkout.breadcrumb_home') }}</a>
                <i class="fa fa-angle-right" aria-hidden="true"></i>
                <a href="{{ route('cart.view') }}">{{ __('store.checkout.breadcrumb_category') }}</a>
                <i class="fa fa-angle-right" aria-hidden="true"></i>
                <span>{{ __('store.checkout.breadcrumb_checkout') }}</span>
            </nav>

            {{-- Step indicator --}}
            <ol class="xsf-steps">
                <li class="xsf-steps__item is-done"><span class="xsf-steps__num"><i class="fa fa-check"></i></span>{{ __('store.cart.breadcrumb_cart') ?? 'Cart' }}</li>
                <li class="xsf-steps__item is-active"><span class="xsf-steps__num">2</span>{{ __('store.checkout.breadcrumb_checkout') ?? 'Checkout' }}</li>
                <li class="xsf-steps__item"><span class="xsf-steps__num">3</span>{{ __('store.checkout.complete') ?? 'Complete' }}</li>
            </ol>

            <div class="row g-4">
                <div class="col-lg-7">
                    <form id="checkout-form" method="POST" action="{{ route('checkout.store') }}">
                        @csrf

                        {{-- Shipping --}}
                        <div class="card mb-4 shipping_info">
                            <div class="card-body">
                                <h3 class="cart-heading xsf-summary__title">{{ __('store.checkout.shipping_information') }}</h3>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <input type="text" name="first_name" class="form-control" placeholder="{{ __('store.checkout.first_name') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="last_name" class="form-control" placeholder="{{ __('store.checkout.last_name') }}" required>
                                    </div>
                                    <div class="col-12">
                                        <input type="text" name="address" class="form-control" placeholder="{{ __('store.checkout.address') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="suite" class="form-control" placeholder="{{ __('store.checkout.suite') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <select name="country" class="form-select" required>
                                            <option value="">{{ __('store.checkout.select_country') }}</option>
                                            <option value="1">United States</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="city" class="form-control" placeholder="{{ __('store.checkout.city') }}" required>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="state" class="form-select" required>
                                            <option value="">{{ __('store.checkout.select_state') }}</option>
                                            <option value="1">New York</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="zipcode" class="form-control" placeholder="{{ __('store.checkout.zipcode') }}" required>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="use_as_billing" value="1" id="use_as_billing" checked>
                                            <label class="form-check-label" for="use_as_billing">{{ __('store.checkout.use_as_billing') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Contact --}}
                        <div class="card mb-4 shipping_info">
                            <div class="card-body">
                                <h3 class="cart-heading xsf-summary__title">{{ __('store.checkout.contact_information') }}</h3>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <input type="email" name="email" class="form-control" placeholder="{{ __('store.checkout.email') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="phone" class="form-control" placeholder="{{ __('store.checkout.phone') }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Payment --}}
                        <div class="card mb-4 shipping_info">
                            <div class="card-body">
                                <h3 class="cart-heading xsf-summary__title">{{ __('store.checkout.payment_method') }}</h3>

                                <div class="xsf-gateways">
                                    @foreach ($paymentGateways as $gateway)
                                        <label class="xsf-gateway" for="gateway-{{ $gateway->id }}">
                                            <input type="radio" name="gateway" value="{{ $gateway->code }}" id="gateway-{{ $gateway->id }}" required>
                                            <span class="xsf-gateway__label">{{ $gateway->name }}</span>
                                        </label>

                                        @if ($gateway->code === 'paypal')
                                            <div id="paypal-button-container" class="mt-3" style="display: none;"></div>
                                        @endif
                                        @if ($gateway->code === 'stripe')
                                            <div id="card-element" class="form-control mt-3" style="display: none;"></div>
                                            <div id="card-errors" class="text-danger mt-2"></div>
                                        @endif
                                    @endforeach

                                    <div id="payment-fields"></div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" id="place-order" class="btn btn-primary btn-lg btn-pill w-100">{{ __('store.checkout.place_order') }}</button>
                    </form>
                </div>

                <div class="col-lg-5">
                    <div class="card xsf-summary xsf-summary--sticky">
                        <div class="card-body">
                            <h3 class="cart-heading xsf-summary__title">{{ __('store.checkout.order_summary') }}</h3>

                            <div class="xsf-summary__row">
                                <span>{{ __('store.checkout.subtotal') }}</span>
                                <span>{{ $currency->symbol }}{{ number_format($subtotal, 2) }}</span>
                            </div>
                            @if ($coupon && $discountAmount > 0)
                                <div class="xsf-summary__row">
                                    <span>{{ __('store.checkout.discount') }} ({{ $coupon['code'] }})</span>
                                    <span class="text-danger">&minus;{{ $currency->symbol }}{{ number_format($discountAmount, 2) }}</span>
                                </div>
                            @endif
                            <div class="xsf-summary__row">
                                <span>{{ __('store.checkout.shipping') }}</span>
                                <span class="text-muted"><small>{{ __('store.checkout.shipping_info') }}</small></span>
                            </div>
                            <div class="xsf-summary__row xsf-summary__row--total">
                                <span>{{ __('store.checkout.total') }}</span>
                                <span>{{ $currency->symbol }}{{ number_format($total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ABA PayWay QR Code Payment Modal -->
    <div class="modal fade" id="paywayQRModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="paywayQRModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content khqr-modal-card">

                {{-- ── Top brand header ── --}}
                <div class="khqr-modal-header">
                    {{-- ABA PAY wordmark (text-based fallback; swap for <img> if you have the SVG) --}}
                    <div class="khqr-abapay-logo">
                        <span class="khqr-logo-aba">ABA</span><span class="khqr-logo-pay">PAY</span><sup class="khqr-logo-tm">™</sup>
                    </div>
                    <div class="khqr-label-badge">KHQR</div>
                </div>

                {{-- ── Merchant / store name ── --}}
                <div class="khqr-merchant-row">
                    <span id="khqr-merchant-name" class="khqr-merchant-name">{{ config('app.name') }}</span>
                </div>

                {{-- ── Amount row ── --}}
                <div class="khqr-amount-row">
                    <span id="khqr-currency-symbol" class="khqr-amount-symbol">$</span>
                    <span id="khqr-amount-display" class="khqr-amount-value">0.00</span>
                </div>

                {{-- ── QR image ── --}}
                <div class="khqr-qr-wrapper">
                    <div class="khqr-qr-frame">
                        {{-- Loading skeleton shown while QR loads --}}
                        <div id="khqr-loading-skeleton" class="khqr-skeleton"></div>
                        <img id="payway-qr-image"
                             src=""
                             alt="KHQR Code"
                             class="khqr-qr-img d-none"
                             onload="this.classList.remove('d-none'); document.getElementById('khqr-loading-skeleton').classList.add('d-none');" />
                    </div>
                </div>

                {{-- ── Scan instruction ── --}}
                <p class="khqr-scan-hint">
                    Scan with ABA Mobile or any KHQR<br>supported banking app
                </p>

                {{-- ── Currency label strip ── --}}
                <div class="khqr-currency-strip">
                    <span id="khqr-currency-label" class="khqr-currency-label">KHQR: US Dollar</span>
                </div>

                {{-- ── Waiting / spinner ── --}}
                <div class="khqr-waiting-row">
                    <span class="khqr-spinner" role="status" aria-hidden="true"></span>
                    <span class="khqr-waiting-text">Waiting for payment verification…</span>
                </div>

                {{-- ── App store badges (visible on mobile only via JS) ── --}}
                <div id="payway-deeplink-container" class="khqr-stores d-none">
                    <a id="payway-app-store-btn" href="#" target="_blank" rel="noopener" class="khqr-store-badge khqr-store-badge--ios" aria-label="Download on the App Store">
                        <i class="fa-brands fa-apple khqr-store-icon"></i>
                        <span><small>Download on the</small><br><strong>App Store</strong></span>
                    </a>
                    <a id="payway-play-store-btn" href="#" target="_blank" rel="noopener" class="khqr-store-badge khqr-store-badge--android" aria-label="Get it on Google Play">
                        <i class="fa-brands fa-google-play khqr-store-icon"></i>
                        <span><small>Get it on</small><br><strong>Google Play</strong></span>
                    </a>
                    <a id="payway-deeplink-btn" href="#" class="khqr-deeplink-btn w-100 mt-2">
                        <i class="fa fa-mobile-screen-button me-2"></i>Open in ABA Mobile
                    </a>
                </div>

                {{-- ── Cancel button ── --}}
                <div class="khqr-footer">
                    <button type="button" id="payway-cancel-btn" class="khqr-cancel-btn">Cancel Order</button>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="https://www.paypal.com/sdk/js?client-id={{ $paypalClientId }}&currency=USD"></script>
<script src="https://js.stripe.com/v3/"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const gatewayRadios = document.querySelectorAll('input[name="gateway"]');
    const paypalContainer = document.getElementById("paypal-button-container");
    const stripeContainer = document.getElementById("card-element");
    const placeOrderBtn = document.getElementById("place-order");

    @if(session('error'))
        toastr.error("{{ session('error') }}");
    @endif
    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    let stripe = null;
    let card = null;

    if (stripeContainer) {
        stripe = Stripe("asdasd");
        let elements = stripe.elements();
        card = elements.create("card");
        card.mount("#card-element");
    }

    // Show correct payment fields
    gatewayRadios.forEach(radio => {
        radio.addEventListener("change", function () {
            if (this.value === "paypal") {
                if (paypalContainer) paypalContainer.style.display = "block";
                if (stripeContainer) stripeContainer.style.display = "none";
            } else if (this.value === "stripe") {
                if (stripeContainer) stripeContainer.style.display = "block";
                if (paypalContainer) paypalContainer.style.display = "none";
            } else {
                if (paypalContainer) paypalContainer.style.display = "none";
                if (stripeContainer) stripeContainer.style.display = "none";
            }
        });
    });

    // PayPal integration
    if (typeof paypal !== "undefined") {
        paypal.Buttons({
            createOrder: function (data, actions) {
                return actions.order.create({
                    purchase_units: [{ amount: { value: "{{ number_format($total, 2, '.', '') }}" } }]
                });
            },
            onApprove: function (data, actions) {
                return actions.order.capture().then(function (details) {
                    // Send to backend
                    fetch("{{ route('checkout.store') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            gateway: "paypal",
                            order_id: data.orderID,
                            details: details
                        })
                    }).then(res => res.json()).then(result => {
                        window.location.href = "/thank-you";
                    });
                });
            }
        }).render("#paypal-button-container");
    }

    // Stripe and general form integration
    const form = document.getElementById("checkout-form");
    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        let selectedGateway = document.querySelector('input[name="gateway"]:checked').value;

        if (selectedGateway === "stripe") {
            if (!stripe || !card) {
                alert("Stripe is not active or initialized.");
                return;
            }
            const {paymentMethod, error} = await stripe.createPaymentMethod({
                type: "card",
                card: card,
            });

            if (error) {
                document.getElementById("card-errors").textContent = error.message;
            } else {
                // Send paymentMethod.id + form data to backend
                let formData = new FormData(form);
                formData.append("payment_method_id", paymentMethod.id);

                fetch("{{ route('checkout.store') }}", {
                    method: "POST",
                    headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
                    body: formData
                }).then(res => res.json()).then(result => {
                    window.location.href = "/thank-you";
                });
            }
        } else if (selectedGateway === "paypal") {
            alert("Please complete payment with PayPal button");
        } else if (selectedGateway === "abapayway") {
            let formData = new FormData(form);
            placeOrderBtn.disabled = true;
            placeOrderBtn.textContent = "Processing...";

            fetch("{{ route('checkout.store') }}", {
                method: "POST",
                headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
                body: formData
            }).then(res => {
                if (!res.ok) {
                    throw new Error("HTTP error " + res.status);
                }
                return res.json();
            }).then(result => {
                if (result.success && result.gateway === 'abapayway') {
                    if (result.response_type === 'html') {
                        // Redirect to hosted page
                        window.location.href = result.redirect_url;
                    } else if (result.response_type === 'json') {
                        // QR Code / Deeplink JSON response
                        const paywayData = result.data;

                        // ── Populate amount & currency ──
                        const amount   = result.amount   ?? paywayData.amount   ?? '0.00';
                        const currency = result.currency ?? paywayData.currency ?? 'USD';
                        const symbol   = currency === 'KHR' ? '៛' : '$';
                        const currencyLabel = currency === 'KHR' ? 'KHQR: Khmer Riel' : 'KHQR: US Dollar';

                        document.getElementById('khqr-amount-display').textContent  = Number(amount).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                        document.getElementById('khqr-currency-symbol').textContent = symbol;
                        document.getElementById('khqr-currency-label').textContent  = currencyLabel;

                        // ── Set QR image (prefer qrImage base64, else build from qrString) ──
                        const qrImg = document.getElementById('payway-qr-image');
                        if (paywayData.qrImage) {
                            qrImg.src = paywayData.qrImage;
                        } else if (paywayData.qrString) {
                            // Render locally via QR API if base64 not provided
                            qrImg.src = 'https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=' + encodeURIComponent(paywayData.qrString);
                            qrImg.classList.remove('d-none');
                            document.getElementById('khqr-loading-skeleton').classList.add('d-none');
                        }

                        // ── Mobile: show deep-link & store badges ──
                        const isMobile = /Android|iPhone|iPad|iPod|Opera Mini|IEMobile|WPDesktop/i.test(navigator.userAgent);
                        const deepContainer = document.getElementById('payway-deeplink-container');
                        if (isMobile) {
                            if (paywayData.abapay_deeplink) {
                                document.getElementById('payway-deeplink-btn').href = paywayData.abapay_deeplink;
                            }
                            if (paywayData.app_store) {
                                document.getElementById('payway-app-store-btn').href = paywayData.app_store;
                            }
                            if (paywayData.play_store) {
                                document.getElementById('payway-play-store-btn').href = paywayData.play_store;
                            }
                            deepContainer.classList.remove('d-none');
                        } else {
                            deepContainer.classList.add('d-none');
                        }

                        // ── Show modal ──
                        const paywayModal = new bootstrap.Modal(document.getElementById('paywayQRModal'));
                        paywayModal.show();

                        // ── Resolve tran_id from response ──
                        const tranId = result.tran_id ?? paywayData.status?.tran_id ?? paywayData.tran_id ?? '';

                        // ── Poll for payment status every 3 s ──
                        let pollInterval = setInterval(function () {
                            if (!tranId) return;
                            fetch("/checkout/payway/status/" + encodeURIComponent(tranId))
                                .then(res => res.json())
                                .then(statusResult => {
                                    if (statusResult.success && statusResult.approved) {
                                        clearInterval(pollInterval);
                                        paywayModal.hide();
                                        toastr.success("Payment completed successfully!");
                                        setTimeout(() => {
                                            window.location.href = "/thank-you";
                                        }, 1200);
                                    }
                                })
                                .catch(err => console.error("Error polling status:", err));
                        }, 3000);

                        // ── Cancel handler ──
                        document.getElementById('payway-cancel-btn').addEventListener('click', function () {
                            clearInterval(pollInterval);
                            paywayModal.hide();
                            window.location.href = "{{ route('payway.cancel') }}";
                        });
                    }
                } else {
                    alert(result.message || "An error occurred during checkout processing.");
                    placeOrderBtn.disabled = false;
                    placeOrderBtn.textContent = "Place Order";
                }
            }).catch(err => {
                console.error(err);
                alert("An error occurred. Please check your inputs and try again.");
                placeOrderBtn.disabled = false;
                placeOrderBtn.textContent = "Place Order";
            });
        } else {
            form.submit();
        }
    });
});
</script>
@endsection
