@extends('admin.layouts.admin')

@section('content')
<div class="dashboard-wrapper">

    {{-- ======================= PAGE HEADER ======================= --}}
    <div class="dash-header d-flex align-items-start justify-content-between flex-wrap gap-3 fade-in-up fade-delay-0">
        <div>
            <h1><i class="fas fa-chart-line me-2" style="color:#6366f1;"></i>{{ __('cms.dashboard.overview_title') }}</h1>
            <p>{!! __('cms.dashboard.welcome_message', ['name' => '<strong>' . auth()->user()->name . '</strong>']) !!}</p>
        </div>
        <span class="date-badge">
            <i class="fas fa-calendar-alt text-indigo-500"></i>
            {{ now()->format('l, F j, Y') }}
        </span>
    </div>

    {{-- ======================= STAT CARDS ======================== --}}
    <div class="row g-4 mb-4">
        {{-- Total Sales --}}
        <div class="col-sm-6 col-xl-3 fade-in-up fade-delay-1">
            <div class="dash-stat card-sales">
                <div class="stat-icon"><i class="fas fa-dollar-sign"></i></div>
                <div class="stat-label">{{ __('cms.dashboard.total_sales') }}</div>
                <div class="stat-value" data-count="{{ $data['totalSales'] }}" data-prefix="$" data-decimals="2">$0.00</div>
                <div class="stat-sub">
                    <span class="badge-sub"><i class="fas fa-sun"></i> {{ __('cms.dashboard.today') }}</span>
                    ${{ number_format($data['todaySales'], 2) }}
                </div>
            </div>
        </div>

        {{-- Total Orders --}}
        <div class="col-sm-6 col-xl-3 fade-in-up fade-delay-2">
            <div class="dash-stat card-orders">
                <div class="stat-icon"><i class="fas fa-shopping-bag"></i></div>
                <div class="stat-label">{{ __('cms.dashboard.total_orders') }}</div>
                <div class="stat-value" data-count="{{ $data['totalOrders'] }}" data-prefix="" data-decimals="0">0</div>
                <div class="stat-sub">
                    <span class="badge-sub"><i class="fas fa-check"></i> {{ __('cms.dashboard.completed') }}</span>
                    {{ $data['completedOrders'] }}
                </div>
            </div>
        </div>

        {{-- Total Vendors --}}
        <div class="col-sm-6 col-xl-3 fade-in-up fade-delay-3">
            <div class="dash-stat card-vendors">
                <div class="stat-icon"><i class="fas fa-store"></i></div>
                <div class="stat-label">{{ __('cms.dashboard.total_vendors') }}</div>
                <div class="stat-value" data-count="{{ $data['totalVendors'] }}" data-prefix="" data-decimals="0">0</div>
                <div class="stat-sub">
                    <span class="badge-sub">{{ __('cms.dashboard.active') }}</span>
                    {{ __('cms.dashboard.verified_vendors') }}
                </div>
            </div>
        </div>

        {{-- Total Customers --}}
        <div class="col-sm-6 col-xl-3 fade-in-up fade-delay-4">
            <div class="dash-stat card-customers">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div class="stat-label">{{ __('cms.dashboard.total_customers') }}</div>
                <div class="stat-value" data-count="{{ $data['totalCustomers'] }}" data-prefix="" data-decimals="0">0</div>
                <div class="stat-sub">
                    <span class="badge-sub">{{ __('cms.dashboard.active') }}</span>
                    {{ __('cms.dashboard.registered_users') }}
                </div>
            </div>
        </div>
    </div>

    {{-- ======================= CHARTS ROW ======================== --}}
    <div class="row g-4 mb-4 fade-in-up fade-delay-5">
        {{-- Sales Line Chart --}}
        <div class="col-lg-8">
            <div class="chart-card h-100">
                <div class="chart-card-title"><i class="fas fa-chart-area me-2" style="color:#6366f1;"></i>{{ __('cms.dashboard.sales_trend') }}</div>
                <div class="chart-card-sub">{{ __('cms.dashboard.sales_trend_sub') }}</div>
                <canvas id="salesChart" height="100"></canvas>
            </div>
        </div>

        {{-- Order Status Doughnut --}}
        <div class="col-lg-4">
            <div class="chart-card h-100">
                <div class="chart-card-title"><i class="fas fa-chart-pie me-2" style="color:#0ea5e9;"></i>{{ __('cms.dashboard.order_status') }}</div>
                <div class="chart-card-sub">{{ __('cms.dashboard.order_status_sub') }}</div>
                <div style="position:relative; max-width:220px; margin: 0 auto;">
                    <canvas id="statusChart"></canvas>
                </div>
                {{-- Legend --}}
                <div class="d-flex justify-content-center gap-3 mt-3 flex-wrap">
                    <div class="d-flex align-items-center gap-2" style="font-size:.8rem;">
                        <span style="width:10px;height:10px;border-radius:50%;background:#10b981;display:inline-block;"></span>
                        {{ __('cms.dashboard.completed') }} ({{ $orderStatusCounts['completed'] }})
                    </div>
                    <div class="d-flex align-items-center gap-2" style="font-size:.8rem;">
                        <span style="width:10px;height:10px;border-radius:50%;background:#f59e0b;display:inline-block;"></span>
                        {{ __('cms.dashboard.pending') }} ({{ $orderStatusCounts['pending'] }})
                    </div>
                    <div class="d-flex align-items-center gap-2" style="font-size:.8rem;">
                        <span style="width:10px;height:10px;border-radius:50%;background:#ef4444;display:inline-block;"></span>
                        {{ __('cms.dashboard.cancelled') }} ({{ $orderStatusCounts['cancelled'] }})
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- =================== BOTTOM ROW ========================= --}}
    <div class="row g-4 fade-in-up fade-delay-6">
        {{-- Recent Orders Table --}}
        <div class="col-lg-8">
            <div class="orders-card">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <div class="chart-card-title"><i class="fas fa-receipt me-2" style="color:#0f172a;"></i>{{ __('cms.dashboard.recent_orders') }}</div>
                        <div class="chart-card-sub" style="margin:0">{{ __('cms.dashboard.recent_orders_sub') }}</div>
                    </div>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary" style="border-radius:8px;font-size:.8rem;">
                        {{ __('cms.dashboard.view_all') }} <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>

                @if($recentOrders->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-receipt d-block"></i>
                        <p>{{ __('cms.dashboard.no_orders') }}</p>
                    </div>
                @else
                    <table class="orders-table">
                        <thead>
                            <tr>
                                <th>{{ __('cms.dashboard.col_order') }}</th>
                                <th>{{ __('cms.dashboard.col_customer') }}</th>
                                <th>{{ __('cms.dashboard.col_amount') }}</th>
                                <th>{{ __('cms.dashboard.col_status') }}</th>
                                <th>{{ __('cms.dashboard.col_date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                            <tr>
                                <td><strong>#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</strong></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle">
                                            {{ strtoupper(substr($order->customer?->name ?? $order->guest_email ?? 'G', 0, 1)) }}
                                        </div>
                                        <span>{{ $order->customer?->name ?? ($order->guest_email ?? __('cms.dashboard.guest')) }}</span>
                                    </div>
                                </td>
                                <td><strong>${{ number_format($order->total_amount, 2) }}</strong></td>
                                <td>
                                    <span class="status-badge {{ $order->status }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td style="color:#94a3b8;">{{ $order->created_at->format('M j, Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="col-lg-4">
            <div class="quick-card">
                <div class="chart-card-title mb-1"><i class="fas fa-bolt me-2" style="color:#f59e0b;"></i>{{ __('cms.dashboard.quick_actions') }}</div>
                <div class="chart-card-sub">{{ __('cms.dashboard.quick_actions_sub') }}</div>

                <a href="{{ route('admin.products.create') }}" class="quick-btn">
                    <div class="qb-icon" style="background:#eef2ff;color:#6366f1;"><i class="fas fa-plus"></i></div>
                    {{ __('cms.dashboard.add_new_product') }}
                </a>
                <a href="{{ route('admin.orders.index') }}" class="quick-btn">
                    <div class="qb-icon" style="background:#e0f2fe;color:#0ea5e9;"><i class="fas fa-shopping-cart"></i></div>
                    {{ __('cms.dashboard.manage_orders') }}
                </a>
                <a href="{{ route('admin.customers.index') }}" class="quick-btn">
                    <div class="qb-icon" style="background:#dcfce7;color:#10b981;"><i class="fas fa-users"></i></div>
                    {{ __('cms.dashboard.view_customers') }}
                </a>
                <a href="{{ route('admin.vendors.index') }}" class="quick-btn">
                    <div class="qb-icon" style="background:#fef3c7;color:#f59e0b;"><i class="fas fa-store"></i></div>
                    {{ __('cms.dashboard.manage_vendors') }}
                </a>
                <a href="{{ route('admin.categories.index') }}" class="quick-btn">
                    <div class="qb-icon" style="background:#fce7f3;color:#ec4899;"><i class="fas fa-tags"></i></div>
                    {{ __('cms.dashboard.manage_categories') }}
                </a>
                <a href="{{ route('admin.site-settings.edit') }}" class="quick-btn">
                    <div class="qb-icon" style="background:#f1f5f9;color:#64748b;"><i class="fas fa-cog"></i></div>
                    {{ __('cms.dashboard.site_settings') }}
                </a>
            </div>
        </div>
    </div>

</div>
@endsection

@section('js')
{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const salesCtx = document.getElementById('salesChart').getContext('2d');
    const salesGradient = salesCtx.createLinearGradient(0, 0, 0, 280);
    salesGradient.addColorStop(0, 'rgba(99,102,241,0.35)');
    salesGradient.addColorStop(1, 'rgba(99,102,241,0.00)');

    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: '{{ __('cms.dashboard.chart_revenue') }}',
                data:  @json($chartSales),
                borderColor: '#6366f1',
                borderWidth: 2.5,
                pointBackgroundColor: '#6366f1',
                pointRadius: 5,
                pointHoverRadius: 7,
                fill: true,
                backgroundColor: salesGradient,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: { callbacks: { label: ctx => ' $' + ctx.parsed.y.toFixed(2) } }
            },
            scales: {
                x: { grid: { display: false }, ticks: { font: { size: 11 }, color: '#94a3b8' } },
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9' },
                    ticks: { font: { size: 11 }, color: '#94a3b8', callback: v => '$' + v.toFixed(0) }
                }
            }
        }
    });

    const statusCtx = document.getElementById('statusChart').getContext('2d');
    const completedCount = {{ $orderStatusCounts['completed'] }};
    const pendingCount   = {{ $orderStatusCounts['pending'] }};
    const cancelledCount = {{ $orderStatusCounts['cancelled'] }};
    const totalForChart  = completedCount + pendingCount + cancelledCount;

    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: [
                '{{ __('cms.dashboard.completed') }}',
                '{{ __('cms.dashboard.pending') }}',
                '{{ __('cms.dashboard.cancelled') }}'
            ],
            datasets: [{
                data: totalForChart > 0 ? [completedCount, pendingCount, cancelledCount] : [1, 0, 0],
                backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                borderWidth: 3,
                borderColor: '#fff',
                hoverOffset: 6
            }]
        },
        options: {
            responsive: true,
            cutout: '68%',
            plugins: {
                legend: { display: false },
                tooltip: { callbacks: { label: ctx => ' ' + ctx.label + ': ' + ctx.parsed } }
            }
        }
    });
});

(function () {
    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) { entry.target.classList.add('visible'); observer.unobserve(entry.target); }
        });
    }, { threshold: 0.12 });
    document.querySelectorAll('.fade-in-up').forEach(function (el) { observer.observe(el); });
})();

(function () {
    function easeOutCubic(t) { return 1 - Math.pow(1 - t, 3); }
    function animateCounter(el) {
        const target = parseFloat(el.dataset.count) || 0;
        const prefix = el.dataset.prefix || '';
        const decimals = parseInt(el.dataset.decimals, 10) || 0;
        const duration = 1600;
        let startTime = null;
        function step(timestamp) {
            if (!startTime) startTime = timestamp;
            const elapsed = timestamp - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const current = easeOutCubic(progress) * target;
            el.textContent = prefix + current.toLocaleString('en-US', { minimumFractionDigits: decimals, maximumFractionDigits: decimals });
            if (progress < 1) { requestAnimationFrame(step); } else {
                el.textContent = prefix + target.toLocaleString('en-US', { minimumFractionDigits: decimals, maximumFractionDigits: decimals });
                el.classList.add('popped');
                el.addEventListener('animationend', () => el.classList.remove('popped'), { once: true });
            }
        }
        requestAnimationFrame(step);
    }
    const counterObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) { setTimeout(() => animateCounter(entry.target), 200); counterObserver.unobserve(entry.target); }
        });
    }, { threshold: 0.3 });
    document.querySelectorAll('.stat-value[data-count]').forEach(function (el) { counterObserver.observe(el); });
})();
</script>
@endsection
