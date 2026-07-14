<?php

namespace App\View\Composers;

use App\Models\Currency;
use App\Models\Menu;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class StoreMenuComposer
{
    public function compose(View $view)
    {
        if (Schema::hasTable('menus')) {
            $headerMenu = Menu::where('status', 1)
                ->with([
                    'menuItems' => function ($query) {
                        $query->orderBy('order_number', 'asc');
                    },
                ])
                ->first();

            $view->with('headerMenu', $headerMenu);
        }

        // Share currency options for the header currency switcher.
        if (Schema::hasTable('currencies')) {
            $view->with('storeCurrencies', Currency::orderBy('code')->get());
            $view->with('activeCurrencyCode', session('currency', getWebConfig('default_currency', 'USD')));
        }
    }
}
