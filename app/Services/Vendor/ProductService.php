<?php

namespace App\Services\Vendor;

use App\Models\Product;
use App\Repositories\Shared\Product\ProductRepository;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class ProductService
{
    protected ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getProductsForDataTable($request)
    {
        $vendorId = auth()->guard('vendor')->id();

        $products = Product::with(['primaryVariant' => fn ($q) => $q->where('is_primary', 1)])
            ->where('vendor_id', $vendorId)
            ->whereHas('variants', fn ($q) => $q->where('is_primary', 1));

        return DataTables::of($products)
            ->addColumn('name', fn ($p) => $p->name ?? 'No name')
            ->addColumn('price', fn ($p) => ($pv = $p->variants->firstWhere('is_primary', true))
                ? '$' . number_format($pv->price, 2) : 'No price')
            ->addColumn('status', fn ($p) => $p->status)
            ->addColumn('action', function ($p) {
                return '
                    <a href="' . route('vendor.products.edit', $p->id) . '" class="btn btn-primary btn-sm">Edit</a>
                    <form action="' . route('vendor.products.destroy', $p->id) . '" method="POST" class="d-inline"
                          onsubmit="return confirm(\'Are you sure?\');">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function destroy($id)
    {
        try {
            return $this->productRepository->destroy($id);
        } catch (\Exception $e) {
            Log::error("Error deleting product {$id}: " . $e->getMessage());
            return false;
        }
    }
}
