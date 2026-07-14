<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class StorefrontProductDetailTest extends TestCase
{
    public function test_product_detail_renders_with_add_to_cart_and_gallery(): void
    {
        if (! Schema::hasTable('products')) {
            $this->markTestSkipped('products table not available');
        }

        $product = Product::query()->whereNotNull('slug')->first();

        if (! $product) {
            $this->markTestSkipped('no product available to test');
        }

        $response = $this->get(route('product.show', $product->slug));

        $response->assertStatus(200);

        // Rebuilt detail markup.
        $response->assertSee('xsf-pd', false);
        $response->assertSee('xsf-gallery', false);

        // Preserved interactive hooks.
        $response->assertSee('id="variant-price"', false);
        $response->assertSee('id="product-attributes"', false);
        $response->assertSee('id="qty"', false);
        $response->assertSee('add-to-cart', false);
    }
}
