<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CouponController extends Controller
{
    public function index()
    {
        return view('admin.coupons.index');
    }

    public function getData(Request $request)
    {
        $query = Coupon::query();

        return DataTables::of($query)
            ->addColumn('action', function ($coupon) {
                return '<div class="d-flex justify-content-end gap-2">
                            <a href="'.route('admin.coupons.edit', $coupon->id).'" class="btn-action btn-action-edit" title="Edit">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <button type="button" class="btn-action btn-action-delete" onclick="deleteCoupon('.$coupon->id.')" title="Delete">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:coupons,code',
            'discount' => 'required|numeric',
            'type' => 'required|in:percentage,fixed',
            'expires_at' => 'nullable|date',
        ]);

        Coupon::create($request->all());

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon created successfully.');
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'code' => 'required|unique:coupons,code,'.$coupon->id,
            'discount' => 'required|numeric',
            'type' => 'required|in:percentage,fixed',
            'expires_at' => 'nullable|date',
        ]);

        $coupon->update($request->all());

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon updated successfully.');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return response()->json(['success' => true, 'message' => 'Coupon deleted successfully.']);
    }
}
