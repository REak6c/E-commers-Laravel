<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with([
                'category',
                'brand',
                'thumbnail',
                'primaryVariant',
                'variants.attributeValues.attribute',
            ])
            ->where('status', 1)
            ->get()
            ->map(fn ($p) => [
                'id'                => $p->id,
                'slug'              => $p->slug,
                'name'              => $p->name,
                'description'       => $p->description,
                'short_description' => $p->short_description,
                'price'             => $p->getConvertedPriceAttribute(),
                'thumbnail'         => $p->thumbnail ? product_image_url($p->thumbnail->image_url) : null,
                'category'          => $p->category?->name ?? '',
                'brand'             => $p->brand?->name ?? null,
                'rating'            => round($p->averageRating(), 1),
                'variants'          => $p->variants->map(fn ($v) => [
                    'id'             => $v->id,
                    'name'           => $v->name,
                    'price'          => $v->converted_price,
                    'discount_price' => $v->converted_discount_price,
                    'stock'          => $v->stock,
                    'sku'            => $v->SKU,
                    'is_primary'     => (bool) $v->is_primary,
                    'attributes'     => $v->attributeValues->map(fn ($av) => [
                        'id'    => $av->id,
                        'name'  => $av->attribute?->name ?? '',
                        'value' => $av->value,
                    ])->values()->all(),
                ])->values()->all(),
            ]);

        return response()->json(['status' => true, 'data' => $products]);
    }
}
