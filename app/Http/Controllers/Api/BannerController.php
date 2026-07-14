<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        $banners = Banner::where('status', 1)->get()->map(fn ($b) => [
            'id'          => $b->id,
            'type'        => $b->type,
            'title'       => $b->title,
            'description' => $b->description,
            'image_url'   => $b->image_url,
        ]);

        return response()->json(['status' => true, 'data' => $banners]);
    }
}
