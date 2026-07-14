<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    public function index()
    {
        return view('vendor.orders.index');
    }

    public function getData(Request $request)
    {
        $vendorId = Auth::guard('vendor')->id();

        $query = Order::whereHas('details.product', function ($q) use ($vendorId) {
            $q->where('vendor_id', $vendorId);
        })
            ->with([
                'details' => function ($q) use ($vendorId) {
                    // Eager-load only this vendor's items within each order
                    $q->whereHas('product', fn ($p) => $p->where('vendor_id', $vendorId));
                },
                'details.product',
                'customer',
            ])
            ->latest();

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('customer', function (Order $order) {
                if ($order->customer) {
                    return $order->customer->name . ' (' . $order->customer->email . ')';
                } elseif ($order->guest_email) {
                    return $order->guest_email . ' (Guest)';
                }

                return 'N/A';
            })
            ->addColumn('order_date', fn (Order $order) => $order->created_at?->format('Y-m-d H:i'))
            ->addColumn('total_price', function (Order $order) {
                // Sum only this vendor's items (qty × price)
                $vendorTotal = $order->details->sum(fn ($d) => $d->quantity * $d->price);

                return number_format((float) $vendorTotal, 2);
            })
            ->editColumn('status', fn (Order $order) => ucfirst($order->status))
            ->addColumn('action', function (Order $order) {
                return '
                    <span class="border border-danger dt-trash rounded-3 d-inline-block"
                          onclick="deleteOrder(' . $order->id . ')">
                        <i class="bi bi-trash-fill text-danger"></i>
                    </span>';
            })
            ->rawColumns(['action'])
            ->setRowId('id')
            ->make(true);
    }

    public function destroy($id)
    {
        $vendorId = Auth::guard('vendor')->id();

        $order = Order::whereHas('details.product', function ($query) use ($vendorId) {
            $query->where('vendor_id', $vendorId);
        })->findOrFail($id);

        $order->delete();

        return response()->json([
            'success' => true,
            'message' => __('cms.orders.deleted_success'),
        ]);
    }
}
