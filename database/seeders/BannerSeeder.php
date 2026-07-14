<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $imageUrl = 'https://i.postimg.cc/sxpYkSgk/shoes-ready.png';
        $imageName = basename($imageUrl);

        try {
            $imageContents = file_get_contents($imageUrl);
            $localPath = 'banners/' . $imageName;
            Storage::disk('public')->put($localPath, $imageContents);
        } catch (\Exception $e) {
            $localPath = $imageUrl;
        }

        Banner::create([
            'type'        => 'promotion',
            'status'      => 1,
            'title'       => 'Ready to Shop',
            'description' => 'Your one-stop shop for everything you need.',
            'image_url'   => $localPath,
        ]);
    }
}
