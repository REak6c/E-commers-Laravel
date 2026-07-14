<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['category', 'brand', 'thumbnail'])
            ->where('status', 1)
            ->get()
            ->map(fn ($p) => [
                'id'                => $p->id,
                'slug'              => $p->slug,
                'name'              => $p->name,
                'description'       => $p->description,
                'short_description' => $p->short_description,
                'price'             => $p->getConvertedPriceAttribute(),
                'thumbnail'         => $p->thumbnail->image_url ?? null,
                'category'          => $p->category?->name ?? '',
                'brand'             => $p->brand?->name ?? null,
                'rating'            => round($p->averageRating(), 1),
            ]);

        return response()->json(['status' => true, 'data' => $products]);
    }
}
