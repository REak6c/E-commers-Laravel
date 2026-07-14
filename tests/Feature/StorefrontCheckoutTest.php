<?php

namespace Tests\Feature;

use Tests\TestCase;

class StorefrontCheckoutTest extends TestCase
{
    public function test_cart_page_renders(): void
    {
        $response = $this->get(route('cart.view'));

        $response->assertStatus(200);
        $response->assertSee('cart-page', false);
    }

    public function test_checkout_page_renders_with_form_and_summary(): void
    {
        $response = $this->get(route('checkout.index'));

        $response->assertStatus(200);
        $response->assertSee('id="checkout-form"', false);
        $response->assertSee('xsf-steps', false);
        $response->assertSee('xsf-summary', false);
        // Payment gateway containers preserved.
        $response->assertSee('name="gateway"', false);
    }
}
