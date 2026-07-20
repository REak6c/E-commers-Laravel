<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class CustomerProfileController extends Controller
{
    /**
     * PUT /api/customer/profile
     * Update the authenticated customer's name, email, phone, address, or password.
     * Only fields that are present in the request body are updated.
     */
    public function update(Request $request)
    {
        /** @var Customer $customer */
        $customer = $request->user();

        $request->validate([
            'name'                  => 'sometimes|required|string|max:255',
            'email'                 => [
                'sometimes', 'required', 'email', 'max:255',
                Rule::unique('customers')->ignore($customer->id),
            ],
            'phone'                 => 'sometimes|nullable|string|max:20',
            'address'               => 'sometimes|nullable|string|max:500',
            'current_password'      => 'required_with:new_password|string',
            'new_password'          => [
                'sometimes', 'required', 'confirmed',
                Password::min(6),
            ],
        ]);

        // If changing password, verify the current one first
        if ($request->filled('new_password')) {
            if (! Hash::check($request->current_password, $customer->password)) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Current password is incorrect.',
                    'errors'  => ['current_password' => ['Current password is incorrect.']],
                ], 422);
            }
            $customer->password = bcrypt($request->new_password);
        }

        // Update only the fields that were sent
        if ($request->has('name'))    $customer->name    = $request->name;
        if ($request->has('email'))   $customer->email   = $request->email;
        if ($request->has('phone'))   $customer->phone   = $request->phone;
        if ($request->has('address')) $customer->address = $request->address;

        $customer->save();

        return response()->json([
            'status'   => true,
            'message'  => 'Profile updated successfully.',
            'customer' => [
                'id'      => $customer->id,
                'name'    => $customer->name,
                'email'   => $customer->email,
                'phone'   => $customer->phone,
                'address' => $customer->address,
            ],
        ]);
    }
}
