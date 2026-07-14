<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::with('children')
            ->where('status', true)
            ->whereNull('parent_category_id')
            ->get()
            ->map(fn ($cat) => [
                'id'          => $cat->id,
                'slug'        => $cat->slug,
                'name'        => $cat->name,
                'description' => $cat->description,
                'image_url'   => $cat->image_url,
                'children'    => $cat->children->map(fn ($child) => [
                    'id'          => $child->id,
                    'slug'        => $child->slug,
                    'name'        => $child->name,
                    'description' => $child->description,
                    'image_url'   => $child->image_url,
                ]),
            ]);

        return response()->json(['status' => true, 'data' => $categories]);
    }
}
