<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('vendor')->check();
    }

    public function rules(): array
    {
        // Vendor does not submit vendor_id — it is inferred from the session.
        // description is required on create but optional on update (method is PUT/PATCH).
        $descriptionRule = $this->isMethod('post') ? 'required|string|min:5' : 'nullable|string|min:5';

        return [
            'category_id'               => 'required|exists:categories,id',
            'brand_id'                  => 'nullable|exists:brands,id',
            'name'                      => 'required|string|max:255',
            'description'               => $descriptionRule,
            'images.*'                  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'variants'                  => 'required|array|min:1',
            'variants.*.name'           => 'required|string|max:255',
            'variants.*.price'          => 'required|numeric|min:0',
            'variants.*.discount_price' => 'nullable|numeric|min:0|lte:variants.*.price',
            'variants.*.stock'          => 'required|integer|min:0',
            'variants.*.SKU'            => 'required|string|max:255',
            'variants.*.barcode'        => 'nullable|string|max:255',
            'variants.*.weight'         => 'nullable|numeric|min:0',
            'variants.*.dimensions'     => 'nullable|string|max:255',
            'variants.*.size_id'        => 'nullable|exists:attribute_values,id',
            'variants.*.color_id'       => 'nullable|exists:attribute_values,id',
        ];
    }
}
