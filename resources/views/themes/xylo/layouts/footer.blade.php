<footer class="xsf-footer">
    <div class="container">
        <div class="row gy-5 xsf-footer__top">

            {{-- Brand + blurb + social --}}
            <div class="col-12 col-lg-4">
                @php $siteLogo = \App\Models\SiteSetting::first()?->logo ?? null; @endphp
                @if($siteLogo)
                    <img src="{{ \Illuminate\Support\Str::startsWith($siteLogo, ['http://','https://']) ? $siteLogo : asset('storage/' . $siteLogo) }}"
                         alt="{{ config('app.name') }} logo"
                         class="xsf-footer__logo">
                @else
                    <span class="xsf-footer__wordmark">{{ config('app.name') }}</span>
                @endif
                <p class="xsf-footer__blurb">{{ __('store.footer.blurb') ?? 'Quality products, delivered with care.' }}</p>

                {{-- Social --}}
                <div class="xsf-footer__social">
                    <a href="#" aria-label="Facebook" title="Facebook"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
                    <a href="#" aria-label="X / Twitter" title="X / Twitter"><i class="fab fa-x-twitter" aria-hidden="true"></i></a>
                    <a href="#" aria-label="Instagram" title="Instagram"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                    <a href="#" aria-label="TikTok" title="TikTok"><i class="fab fa-tiktok" aria-hidden="true"></i></a>
                </div>
            </div>

            {{-- Account links --}}
            <div class="col-6 col-lg-2">
                <h2 class="xsf-footer__heading">{{ __('store.footer.account') }}</h2>
                <ul class="xsf-footer__links">
                    <li><a href="{{ route('customer.profile.edit') }}">{{ __('store.footer.my_account') }}</a></li>
                    <li><a href="{{ route('customer.wishlist.index') }}">{{ __('store.footer.wishlist') }}</a></li>
                    <li><a href="{{ route('shop.index') }}">{{ __('store.footer.shop') ?? 'Shop' }}</a></li>
                </ul>
            </div>

            {{-- Pages links --}}
            <div class="col-6 col-lg-2">
                <h2 class="xsf-footer__heading">{{ __('store.footer.pages') }}</h2>
                <ul class="xsf-footer__links">
                    <li><a href="#">{{ __('store.footer.privacy_policy') }}</a></li>
                    <li><a href="#">{{ __('store.footer.terms_of_service') }}</a></li>
                    <li><a href="#">{{ __('store.footer.about') ?? 'About Us' }}</a></li>
                </ul>
            </div>

            {{-- Newsletter --}}
            <div class="col-12 col-lg-4">
                <h2 class="xsf-footer__heading">{{ __('store.footer.follow_us') }}</h2>
                <p class="xsf-footer__blurb mb-4">
                    {{ __('store.footer.follow_blurb') ?? 'Stay in the loop with our latest drops and exclusive offers.' }}
                </p>
                <div class="xsf-footer__newsletter">
                    <div class="xsf-footer__newsletter-form">
                        <input type="email"
                               class="xsf-footer__newsletter-input"
                               placeholder="your@email.com"
                               aria-label="Newsletter email">
                        <button type="button" class="xsf-footer__newsletter-btn">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom bar --}}
    <div class="xsf-footer__bottom">
        <div class="container">
            <div class="xsf-footer__bottom-row">
                <span>{{ __('store.footer.copyright') }}</span>
                <div class="xsf-footer__payment-icons">
                    <i class="fab fa-cc-visa" title="Visa"></i>
                    <i class="fab fa-cc-mastercard" title="Mastercard"></i>
                    <i class="fab fa-cc-paypal" title="PayPal"></i>
                </div>
                <span>{{ __('store.footer.powered_by') }}</span>
            </div>
        </div>
    </div>
</footer>
