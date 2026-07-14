<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Vendor;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // --- Stat Cards ---
        $data = [
            'totalSales'       => Order::where('status', 'completed')->sum('total_amount'),
            'todaySales'       => Order::whereDate('created_at', today())->where('status', 'completed')->sum('total_amount'),
            'totalOrders'      => Order::count(),
            'completedOrders'  => Order::where('status', 'completed')->count(),
            'pendingOrders'    => Order::where('status', 'pending')->count(),
            'cancelledOrders'  => Order::where('status', 'cancelled')->count(),
            'totalVendors'     => Vendor::where('status', 'active')->count(),
            'totalCustomers'   => Customer::where('status', 'active')->count(),
        ];

        // --- Sales Chart: last 7 days ---
        $last7Days = collect(range(6, 0))->map(fn($i) => Carbon::today()->subDays($i));

        $salesByDay = Order::where('status', 'completed')
            ->where('created_at', '>=', Carbon::today()->subDays(6)->startOfDay())
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->groupBy('date')
            ->pluck('total', 'date');

        $chartLabels = $last7Days->map(fn($d) => $d->format('D, M j'))->values()->toArray();
        $chartSales  = $last7Days->map(fn($d) => (float) ($salesByDay[$d->toDateString()] ?? 0))->values()->toArray();

        // --- Order Status Doughnut ---
        $orderStatusCounts = [
            'completed'  => $data['completedOrders'],
            'pending'    => $data['pendingOrders'],
            'cancelled'  => $data['cancelledOrders'],
        ];

        // --- Recent Orders (last 5) ---
        $recentOrders = Order::with('customer')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard.index', compact('data', 'chartLabels', 'chartSales', 'orderStatusCounts', 'recentOrders'));
    }
}
