<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $sizeAttr  = Attribute::firstOrCreate(['name' => 'Size']);
            $colorAttr = Attribute::firstOrCreate(['name' => 'Color']);

            foreach (['Small', 'Medium', 'Large'] as $size) {
                AttributeValue::firstOrCreate(['attribute_id' => $sizeAttr->id, 'value' => $size]);
            }
            foreach (['Red', 'Blue', 'Black'] as $color) {
                AttributeValue::firstOrCreate(['attribute_id' => $colorAttr->id, 'value' => $color]);
            }

            $vendor = Vendor::first() ?? Vendor::create([
                'name'     => 'Default Vendor',
                'email'    => 'vendor@example.com',
                'password' => bcrypt('password'),
                'status'   => 1,
            ]);

            $shop = \App\Models\Shop::first() ?? \App\Models\Shop::create([
                'vendor_id'   => $vendor->id,
                'name'        => 'Default Shop',
                'description' => 'The default store shop.',
                'status'      => 'active',
            ]);

            $category = Category::first();
            $brand    = Brand::first();

            $products = [
                ['name' => 'Cool T-Shirt',          'slug' => 'cool-tshirt',          'image' => 'https://i.postimg.cc/zBCkRRvb/T-Shirt-removebg-preview.png',          'description' => 'Trendy T-Shirt available in multiple sizes and colors.'],
                ['name' => 'Sport Shoes',            'slug' => 'sport-shoes',          'image' => 'https://i.postimg.cc/YS1FXBHT/images-removebg-preview.png',            'description' => 'Comfortable sport shoes for daily use.'],
                ['name' => 'Wireless Headphones',    'slug' => 'wireless-headphones',  'image' => 'https://i.postimg.cc/2Sn3YdKZ/images-1-removebg-preview-2.png',        'description' => 'Noise-cancelling wireless headphones with long battery life.'],
                ['name' => 'Travel Backpack',        'slug' => 'travel-backpack',      'image' => 'https://i.postimg.cc/WpDkKZTM/images-2-removebg-preview-1.png',        'description' => 'Durable backpack for travel and outdoor activities.'],
            ];

            $sizeValues  = AttributeValue::where('attribute_id', $sizeAttr->id)->get();
            $colorValues = AttributeValue::where('attribute_id', $colorAttr->id)->get();

            foreach ($products as $item) {
                $product = Product::create([
                    'shop_id'      => $shop->id,
                    'vendor_id'    => $vendor->id,
                    'slug'         => $item['slug'],
                    'name'         => $item['name'],
                    'description'  => $item['description'],
                    'category_id'  => $category->id,
                    'brand_id'     => $brand->id,
                    'product_type' => 'variable',
                    'status'       => 1,
                ]);

                $imageName = basename($item['image']);
                try {
                    $localPath = 'products/' . $imageName;
                    Storage::disk('public')->put($localPath, file_get_contents($item['image']));
                } catch (\Exception $e) {
                    $localPath = $item['image'];
                }

                $product->images()->create([
                    'name'      => $imageName,
                    'image_url' => $localPath,
                    'type'      => 'thumb',
                ]);

                foreach ($sizeValues as $size) {
                    foreach ($colorValues as $color) {
                        $price         = rand(20, 60);
                        $discountPrice = rand(10, $price);

                        $variant = $product->variants()->create([
                            'variant_slug'   => Str::slug("{$item['name']} {$size->value}-{$color->value}") . '-' . uniqid(),
                            'name'           => "{$size->value} - {$color->value}",
                            'price'          => $price,
                            'discount_price' => $discountPrice,
                            'stock'          => rand(50, 200),
                            'SKU'            => strtoupper(substr($size->value, 0, 1)) . substr($color->value, 0, 2) . rand(100, 999),
                            'weight'         => '0.5',
                            'dimensions'     => '10x10x2 cm',
                            'is_primary'     => 1,
                        ]);

                        foreach ([$size->id, $color->id] as $attrValueId) {
                            DB::table('product_variant_attribute_values')->insert([
                                'product_id'         => $product->id,
                                'product_variant_id' => $variant->id,
                                'attribute_value_id' => $attrValueId,
                                'created_at'         => now(),
                                'updated_at'         => now(),
                            ]);
                            ProductAttributeValue::firstOrCreate([
                                'product_id'        => $product->id,
                                'attribute_value_id'=> $attrValueId,
                            ]);
                        }
                    }
                }
            }
        });
    }
}
