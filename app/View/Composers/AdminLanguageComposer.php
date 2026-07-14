<?php

namespace App\View\Composers;

use App\Models\Menu;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class AdminLanguageComposer
{
    public function compose(View $view)
    {
        if (Schema::hasTable('menus')) {
            $view->with('menu', Menu::first());
        }
    }
}
