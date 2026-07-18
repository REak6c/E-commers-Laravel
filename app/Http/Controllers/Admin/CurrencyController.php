<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CurrencyController extends Controller
{
    public function index()
    {
        return view('admin.currencies.index');
    }

    public function getData(Request $request)
    {
        $query = Currency::query();

        return DataTables::of($query)
            ->addColumn('action', function ($currency) {
                return '<div class="d-flex justify-content-end gap-2">
                            <a href="'.route('admin.currencies.edit', $currency->id).'" class="btn-action-edit" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button type="button" class="btn-action-delete" onclick="deleteCurrency('.$currency->id.')" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.currencies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:currencies,code',
            'symbol' => 'required|string|max:10',
            'exchange_rate' => 'required|numeric',
        ]);

        Currency::create($request->all());

        return redirect()->route('admin.currencies.index')->with('success', 'Currency created successfully.');
    }

    public function edit(Currency $currency)
    {
        return view('admin.currencies.edit', compact('currency'));
    }

    public function update(Request $request, Currency $currency)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:currencies,code,'.$currency->id,
            'symbol' => 'required|string|max:10',
            'exchange_rate' => 'required|numeric',
        ]);

        $currency->update($request->all());

        return redirect()->route('admin.currencies.index')->with('success', 'Currency updated successfully.');
    }

    public function destroy(Currency $currency)
    {
        $currency->delete();

        return response()->json(['success' => true, 'message' => 'Currency deleted successfully.']);
    }
}
