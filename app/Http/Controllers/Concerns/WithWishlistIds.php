<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Support\Facades\Auth;

trait WithWishlistIds
{
    /**
     * Return an array of product IDs in the current customer's wishlist.
     * Returns an empty array for guests.
     */
    protected function getWishlistIds(): array
    {
        if (! Auth::guard('customer')->check()) {
            return [];
        }

        return Auth::guard('customer')
            ->user()
            ->wishlistProducts()
            ->pluck('products.id')
            ->toArray();
    }
}
