<?php

namespace Tests\Feature;

use App\Models\Vendor;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class VendorPanelTest extends TestCase
{
    public function test_vendor_login_renders_with_auth_card(): void
    {
        $response = $this->get(route('vendor.login'));

        $response->assertStatus(200);
        $response->assertSee('vl-form-box', false);
        $response->assertSee('name="email"', false);
        $response->assertSee('name="password"', false);
    }

    public function test_vendor_dashboard_requires_auth(): void
    {
        $response = $this->get(route('vendor.dashboard'));
        // Guarded by auth.vendor -> redirect (302) for guests.
        $this->assertContains($response->getStatusCode(), [301, 302]);
    }

    public function test_vendor_index_pages_render_when_vendor_exists(): void
    {
        $vendor = Vendor::query()->first();
        if (! $vendor) {
            $this->markTestSkipped('no vendor available');
        }

        foreach (['vendor.products.index', 'vendor.orders.index', 'vendor.reviews.index'] as $name) {
            if (! Route::has($name)) {
                continue;
            }
            $response = $this->actingAs($vendor, 'vendor')->get(route($name));
            $this->assertContains(
                $response->getStatusCode(),
                [200, 302],
                "Vendor route {$name} returned {$response->getStatusCode()}"
            );
        }
    }
}
