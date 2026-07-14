<?php

use App\Models\Currency;
use App\Models\StoreSetting;
use Illuminate\Support\Facades\Cache;

if (! function_exists('convert_price')) {
    function convert_price($amount, $currencyCode = null)
    {
        $currencyCode = $currencyCode ?: session('currency', getWebConfig('default_currency', 'USD'));

        $usdExchangeRate = Cache::rememberForever('currency_USD', function () {
            return Currency::where('code', 'USD')->value('exchange_rate') ?: 1.0;
        });

        $targetExchangeRate = Cache::rememberForever("currency_{$currencyCode}", function () use ($currencyCode) {
            return Currency::where('code', $currencyCode)->value('exchange_rate') ?: 1.0;
        });

        return round($amount * ($targetExchangeRate / $usdExchangeRate), 2);
    }
}

if (! function_exists('currency_to_usd')) {
    function currency_to_usd($amount, $fromCurrency)
    {
        $usdRate = Currency::where('code', 'USD')->value('exchange_rate') ?: 1.0;
        $fromRate = Currency::where('code', $fromCurrency)->value('exchange_rate') ?: 1.0;

        return round($amount * ($usdRate / $fromRate), 2);
    }
}

if (! function_exists('getWebConfig')) {
    function getWebConfig($key, $default = null)
    {
        return Cache::rememberForever("store_setting_{$key}", function () use ($key, $default) {
            return StoreSetting::where('key', $key)->value('value') ?? $default;
        });
    }
}

if (! function_exists('activeCurrency')) {
    /**
     * Return the active Currency model for the current session.
     *
     * Falls back to any available currency, then to an anonymous object with
     * safe defaults so views never crash when the currencies table is empty
     * (e.g. during testing or a fresh install).
     */
    function activeCurrency()
    {
        $code = session('currency', 'USD');

        $currency = Cache::rememberForever('active_currency_' . $code, function () use ($code) {
            return Currency::where('code', $code)->first()
                ?? Currency::first();
        });

        // Final safety net: return a value-object so $currency->symbol never throws.
        return $currency ?? (object) [
            'symbol'        => '$',
            'code'          => 'USD',
            'name'          => 'US Dollar',
            'exchange_rate' => 1.0,
        ];
    }
}

if (! function_exists('product_image_url')) {
    /**
     * Resolve a product image URL for display.
     * - External URLs (http/https) → used directly.
     * - Local storage paths → wrapped with Storage::url().
     * - Null/empty → placeholder icon.
     */
    function product_image_url(?string $imageUrl): string
    {
        if (empty($imageUrl)) {
            return asset('images/no-product.png');
        }

        if (str_starts_with($imageUrl, 'http://') || str_starts_with($imageUrl, 'https://')) {
            return $imageUrl;
        }

        return \Illuminate\Support\Facades\Storage::url($imageUrl);
    }
}
