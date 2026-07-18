<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\WithWishlistIds;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\Page;

class StoreController extends Controller
{
    use WithWishlistIds;

    public function index()
    {
        $banners = Banner::where('status', 1)
            ->orderBy('id', 'desc')
            ->take(3)
            ->get();

        $categories = Category::where('status', 1)
            ->orderBy('id', 'desc')
            ->take(10)
            ->get();

        $products = Product::where('status', 1)
            ->with(['thumbnail', 'primaryVariant'])
            ->withCount('reviews')
            ->orderBy('id', 'desc')
            ->take(10)
            ->get();

        $wishlistIds = $this->getWishlistIds();

        return view('themes.xylo.home', compact('banners', 'categories', 'products', 'wishlistIds'));
    }

    public function showPage($slug)
    {
        $page = Page::where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        return view('themes.xylo.page', compact('page'));
    }
}
