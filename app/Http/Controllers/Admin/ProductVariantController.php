<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ProductVariantController extends Controller
{
    public function index()
    {
        return view('admin.product_variants.index');
    }

    public function getData(Request $request)
    {
        $productVariants = ProductVariant::with('product')
            ->select('product_variants.*');

        return DataTables::of($productVariants)
            ->addColumn('id', fn ($pv) => $pv->id)
            ->addColumn('product', fn ($pv) => $pv->product->name ?? 'Unknown Product')
            ->addColumn('variant_name', fn ($pv) => $pv->name ?? 'N/A')
            ->addColumn('action', function ($pv) {
                return '<a href="'.route('admin.product_variants.edit', $pv->id).'" class="btn btn-warning btn-sm">Edit</a>
                    <form action="'.route('admin.product_variants.destroy', $pv->id).'" method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure?\');">
                        '.csrf_field().method_field('DELETE').'
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $products = Product::where('status', 1)->get();

        return view('admin.product_variants.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name'       => 'required|string|max:255',
            'price'      => 'required|numeric',
            'stock'      => 'required|integer',
        ]);

        $data = $request->only(['product_id', 'name', 'price', 'stock', 'SKU', 'barcode', 'discount_price', 'weight', 'dimensions', 'is_primary']);
        $data['variant_slug'] = Str::slug($request->name);

        ProductVariant::create($data);

        return redirect()->route('admin.product_variants.index')->with('success', 'Product Variant created successfully.');
    }

    public function edit($id)
    {
        $productVariant = ProductVariant::findOrFail($id);
        $products = Product::where('status', 1)->get();

        return view('admin.product_variants.edit', compact('productVariant', 'products'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $productVariant = ProductVariant::findOrFail($id);
        $data = $request->only(['product_id', 'name', 'price', 'stock', 'SKU', 'barcode', 'discount_price', 'weight', 'dimensions', 'is_primary']);
        $data['variant_slug'] = Str::slug($request->name);
        $productVariant->update($data);

        return redirect()->route('admin.product_variants.index')->with('success', 'Product Variant updated successfully.');
    }

    public function destroy($id)
    {
        try {
            ProductVariant::findOrFail($id)->delete();

            return response()->json(['success' => true, 'message' => 'Product Variant deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while deleting the product variant.']);
        }
    }
}
