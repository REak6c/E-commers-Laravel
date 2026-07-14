<?php

namespace Tests\Feature;

use App\Models\Customer;
use Tests\TestCase;

class CustomerAccountTest extends TestCase
{
    public function test_profile_requires_customer_login(): void
    {
        $response = $this->get(route('customer.profile.edit'));
        $response->assertRedirect(route('customer.login'));
    }

    public function test_profile_renders_for_authenticated_customer(): void
    {
        $customer = Customer::query()->first();
        if (! $customer) {
            // Fall back to an in-memory customer so the view still renders.
            $customer = (new Customer)->forceFill([
                'id' => 999999,
                'name' => 'Test Customer',
                'email' => 'test.customer@example.com',
                'phone' => null,
                'address' => null,
                'profile_image' => null,
            ]);
        }

        $response = $this->actingAs($customer, 'customer')->get(route('customer.profile.edit'));

        $response->assertStatus(200);
        $response->assertSee('xsf-account-nav', false);
        $response->assertSee('id="customer-profile-form"', false);
        $response->assertSee('id="profilePreview"', false);
    }
}
