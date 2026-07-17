<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderApiController extends Controller
{
    /**
     * Return all orders belonging to the authenticated customer.
     */
    public function index(Request $request)
    {
        $customer = $request->user();

        $orders = Order::with(['details.product', 'shippingAddress'])
            ->where('customer_id', $customer->id)
            ->orderByDesc('created_at')
            ->get();

        $data = $orders->map(function (Order $order) {
            $shipping = $order->shippingAddress;

            // Split name stored as "First Last"
            $nameParts = $shipping ? explode(' ', $shipping->name, 2) : [];
            $firstName = $nameParts[0] ?? '';
            $lastName  = $nameParts[1] ?? '';

            $items = $order->details->map(function ($detail) {
                $product = $detail->product;
                // thumbnail() is a relationship — call it to get the ProductImage model, then read image_url
                $thumbnailUrl = $product?->thumbnail()?->value('image_url') ?? $product?->image_url ?? null;
                return [
                    'id'                => $detail->id,
                    'product_id'        => $detail->product_id,
                    'product_name'      => $product?->name ?? 'Unknown Product',
                    'product_thumbnail' => $thumbnailUrl,
                    'quantity'          => $detail->quantity,
                    'price'             => (float) $detail->price,
                ];
            });

            return [
                'id'              => $order->id,
                'status'          => $order->status,
                'total'           => (float) $order->total_amount,
                'coupon_code'     => $order->coupon_code,
                'discount_amount' => (float) $order->discount_amount,
                'first_name'      => $firstName,
                'last_name'       => $lastName,
                'phone'           => $shipping?->phone,
                'email'           => $order->guest_email,
                'address'         => $shipping?->address,
                'city'            => $shipping?->city,
                'country'         => $shipping?->country,
                'gateway'         => $order->payment_method ?? 'cod',
                'items'           => $items,
                'created_at'      => $order->created_at?->toISOString(),
            ];
        });

        return response()->json([
            'status' => true,
            'data'   => $data,
        ]);
    }
}
