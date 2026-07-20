@extends('vendor.layouts.master')

@section('title', 'Dashboard')

@section('content')
@php $vendor = Auth::guard('vendor')->user(); @endphp

{{-- Page Header --}}
<div class="vp-page-header">
    <div class="vp-page-header__left">
        <h1 class="vp-page-header__title">
            <span class="vp-page-header__title-icon"><i class="fas fa-tachometer-alt"></i></span>
            Dashboard
        </h1>
        <p class="vp-page-header__sub">Welcome back, <strong>{{ $vendor->name }}</strong>. Here's your store overview.</p>
    </div>
    <div class="vp-page-header__actions">
        <span style="display:inline-flex;align-items:center;gap:7px;background:#fff;border:1.5px solid #ACBCBF;border-radius:10px;padding:7px 14px;font-size:.78rem;color:#698696;font-weight:500;box-shadow:0 1px 3px rgba(36,60,76,.06);">
            <i class="fas fa-calendar-alt" style="color:#5289AD;"></i>
            {{ now()->format('D, M j, Y') }}
        </span>
    </div>
</div>

{{-- ── Stat Cards ──────────────────────────────────────────────── --}}
<div class="row g-3 mb-4">

    {{-- Sales — Arctic steel blue --}}
    <div class="col-sm-6 col-xl-4">
        <div class="vp-card" style="border:none;background:linear-gradient(135deg,#5289AD 0%,#243C4C 100%);box-shadow:0 6px 24px rgba(82,137,173,.34);color:#fff;">
            <div class="vp-card-body" style="padding:22px;">
                <div style="width:46px;height:46px;background:rgba(255,255,255,.20);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.15rem;margin-bottom:16px;backdrop-filter:blur(4px);">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div style="font-size:.7rem;font-weight:600;text-transform:uppercase;letter-spacing:.1em;opacity:.85;margin-bottom:4px;">My Sales</div>
                <div class="db-stat-value" data-count="{{ $data['totalSales'] }}" data-prefix="$" data-decimals="2"
                     style="font-size:2rem;font-weight:800;line-height:1.1;margin-bottom:10px;">$0.00</div>
                <div style="font-size:.75rem;opacity:.82;display:flex;align-items:center;gap:7px;">
                    <span style="background:rgba(255,255,255,.20);border-radius:20px;padding:2px 9px;font-size:.69rem;font-weight:700;display:inline-flex;align-items:center;gap:4px;">
                        <i class="fas fa-sun"></i> Today
                    </span>
                    ${{ number_format($data['todaySales'], 2) }}
                </div>
            </div>
        </div>
    </div>

    {{-- Orders — sky (kept as accent contrast) --}}
    <div class="col-sm-6 col-xl-4">
        <div class="vp-card" style="border:none;background:linear-gradient(135deg,#0ea5e9 0%,#06b6d4 100%);box-shadow:0 6px 24px rgba(14,165,233,.28);color:#fff;">
            <div class="vp-card-body" style="padding:22px;">
                <div style="width:46px;height:46px;background:rgba(255,255,255,.20);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.15rem;margin-bottom:16px;">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div style="font-size:.7rem;font-weight:600;text-transform:uppercase;letter-spacing:.1em;opacity:.85;margin-bottom:4px;">My Orders</div>
                <div class="db-stat-value" data-count="{{ $data['totalOrders'] }}" data-prefix="" data-decimals="0"
                     style="font-size:2rem;font-weight:800;line-height:1.1;margin-bottom:10px;">0</div>
                <div style="font-size:.75rem;opacity:.82;display:flex;align-items:center;gap:7px;">
                    <span style="background:rgba(255,255,255,.20);border-radius:20px;padding:2px 9px;font-size:.69rem;font-weight:700;display:inline-flex;align-items:center;gap:4px;">
                        <i class="fas fa-check-circle"></i> Completed
                    </span>
                    {{ $data['completedOrders'] }}
                </div>
            </div>
        </div>
    </div>

    {{-- Products — amber (kept as accent contrast) --}}
    <div class="col-sm-6 col-xl-4">
        <div class="vp-card" style="border:none;background:linear-gradient(135deg,#f59e0b 0%,#f97316 100%);box-shadow:0 6px 24px rgba(245,158,11,.28);color:#fff;">
            <div class="vp-card-body" style="padding:22px;">
                <div style="width:46px;height:46px;background:rgba(255,255,255,.20);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.15rem;margin-bottom:16px;">
                    <i class="fas fa-box-open"></i>
                </div>
                <div style="font-size:.7rem;font-weight:600;text-transform:uppercase;letter-spacing:.1em;opacity:.85;margin-bottom:4px;">My Products</div>
                <div class="db-stat-value" data-count="{{ $data['totalProducts'] }}" data-prefix="" data-decimals="0"
                     style="font-size:2rem;font-weight:800;line-height:1.1;margin-bottom:10px;">0</div>
                <div style="font-size:.75rem;opacity:.82;display:flex;align-items:center;gap:7px;">
                    <span style="background:rgba(255,255,255,.20);border-radius:20px;padding:2px 9px;font-size:.69rem;font-weight:700;">
                        Active
                    </span>
                    Listed products
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ── Charts Row ──────────────────────────────────────────────── --}}
<div class="row g-3 mb-4">

    {{-- Sales Trend --}}
    <div class="col-lg-8">
        <div class="vp-card h-100">
            <div class="vp-card-header">
                <h6 class="vp-card-header__title">
                    <span class="vp-card-header__icon" style="background:#edf4f9;color:#5289AD;">
                        <i class="fas fa-chart-area"></i>
                    </span>
                    Sales Trend
                </h6>
                <span style="font-size:.72rem;color:#698696;">Last 7 days</span>
            </div>
            <div class="vp-card-body" style="padding:20px 20px 16px;">
                <canvas id="salesChart" height="88"></canvas>
            </div>
        </div>
    </div>

    {{-- Order Status --}}
    <div class="col-lg-4">
        <div class="vp-card h-100">
            <div class="vp-card-header">
                <h6 class="vp-card-header__title">
                    <span class="vp-card-header__icon" style="background:#e0f2fe;color:#0ea5e9;">
                        <i class="fas fa-chart-pie"></i>
                    </span>
                    Order Status
                </h6>
            </div>
            <div class="vp-card-body" style="padding:20px;display:flex;flex-direction:column;align-items:center;">
                <div style="position:relative;width:180px;height:180px;margin:0 auto 16px;">
                    <canvas id="statusChart"></canvas>
                    <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;pointer-events:none;">
                        <span style="font-size:1.4rem;font-weight:800;color:#1e2e3a;line-height:1;">
                            {{ $orderStatusCounts['completed'] + $orderStatusCounts['pending'] + $orderStatusCounts['cancelled'] }}
                        </span>
                        <span style="font-size:.68rem;color:#698696;font-weight:500;text-transform:uppercase;letter-spacing:.06em;">Total</span>
                    </div>
                </div>
                <div style="display:flex;flex-direction:column;gap:8px;width:100%;">
                    @foreach ([['color'=>'#10b981','label'=>'Completed','key'=>'completed'],['color'=>'#f59e0b','label'=>'Pending','key'=>'pending'],['color'=>'#ef4444','label'=>'Cancelled','key'=>'cancelled']] as $s)
                    <div style="display:flex;align-items:center;justify-content:space-between;font-size:.78rem;">
                        <span style="display:flex;align-items:center;gap:7px;color:#3d5760;">
                            <span style="width:8px;height:8px;border-radius:50%;background:{{ $s['color'] }};flex-shrink:0;"></span>
                            {{ $s['label'] }}
                        </span>
                        <strong style="color:#1e2e3a;">{{ $orderStatusCounts[$s['key']] }}</strong>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ── Bottom Row ──────────────────────────────────────────────── --}}
<div class="row g-3">

    {{-- Recent Orders --}}
    <div class="col-lg-8">
        <div class="vp-card">
            <div class="vp-card-header">
                <h6 class="vp-card-header__title">
                    <span class="vp-card-header__icon" style="background:#F4FCFB;color:#243C4C;">
                        <i class="fas fa-receipt"></i>
                    </span>
                    Recent Orders
                </h6>
                <a href="{{ route('vendor.orders.index') }}"
                   style="font-size:.75rem;font-weight:600;color:#5289AD;text-decoration:none;display:inline-flex;align-items:center;gap:5px;">
                    View all <i class="fas fa-arrow-right" style="font-size:.65rem;"></i>
                </a>
            </div>

            @if($recentOrders->isEmpty())
                <div class="vp-card-body" style="text-align:center;padding:44px 20px;color:#698696;">
                    <div style="width:52px;height:52px;border-radius:14px;background:#F4FCFB;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;font-size:1.3rem;color:#ACBCBF;">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <p style="font-size:.83rem;margin:0;font-weight:500;">No orders yet</p>
                    <p style="font-size:.75rem;margin:4px 0 0;color:#ACBCBF;">Orders will appear here once placed.</p>
                </div>
            @else
                <div style="overflow-x:auto;">
                    <table class="table table-hover mb-0" style="font-size:.82rem;">
                        <thead style="background:#F4FCFB;">
                            <tr>
                                <th style="padding:10px 18px;font-size:.66rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#698696;border:none;">Order #</th>
                                <th style="padding:10px 18px;font-size:.66rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#698696;border:none;">Customer</th>
                                <th style="padding:10px 18px;font-size:.66rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#698696;border:none;">Amount</th>
                                <th style="padding:10px 18px;font-size:.66rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#698696;border:none;">Status</th>
                                <th style="padding:10px 18px;font-size:.66rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#698696;border:none;">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                            <tr style="border-bottom:1px solid #d0e0e3;">
                                <td style="padding:13px 18px;"><strong style="color:#1e2e3a;">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</strong></td>
                                <td style="padding:13px 18px;">
                                    <div style="display:flex;align-items:center;gap:9px;">
                                        <div style="width:30px;height:30px;border-radius:50%;background:linear-gradient(135deg,#5289AD,#243C4C);color:#fff;font-size:.72rem;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                            {{ strtoupper(substr($order->customer?->name ?? $order->guest_email ?? 'G', 0, 1)) }}
                                        </div>
                                        <span style="color:#3d5760;">{{ $order->customer?->name ?? ($order->guest_email ?? 'Guest') }}</span>
                                    </div>
                                </td>
                                <td style="padding:13px 18px;"><strong style="color:#1e2e3a;">${{ number_format($order->vendor_total ?? 0, 2) }}</strong></td>
                                <td style="padding:13px 18px;"><span class="vp-status-badge {{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                                <td style="padding:13px 18px;color:#698696;">{{ $order->created_at->format('M j, Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="col-lg-4">
        <div class="vp-card">
            <div class="vp-card-header">
                <h6 class="vp-card-header__title">
                    <span class="vp-card-header__icon" style="background:#fef3c7;color:#d97706;">
                        <i class="fas fa-bolt"></i>
                    </span>
                    Quick Actions
                </h6>
            </div>
            <div class="vp-card-body" style="padding:14px;">
                @php
                $actions = [
                    ['route'=>'vendor.products.create','label'=>'Add New Product',  'icon'=>'fas fa-plus',        'bg'=>'#edf4f9','color'=>'#5289AD'],
                    ['route'=>'vendor.products.index', 'label'=>'My Products',       'icon'=>'fas fa-box-open',    'bg'=>'#e0f2fe','color'=>'#0ea5e9'],
                    ['route'=>'vendor.orders.index',   'label'=>'Manage Orders',     'icon'=>'fas fa-shopping-bag','bg'=>'#dcfce7','color'=>'#10b981'],
                    ['route'=>'vendor.reviews.index',  'label'=>'Product Reviews',   'icon'=>'fas fa-star',        'bg'=>'#fef3c7','color'=>'#f59e0b'],
                    ['route'=>'vendor.profile.edit',   'label'=>'My Profile',        'icon'=>'fas fa-user-circle', 'bg'=>'#F4FCFB','color'=>'#698696'],
                ];
                @endphp
                @foreach($actions as $action)
                <a href="{{ route($action['route']) }}"
                   class="d-flex align-items-center gap-3 p-2 mb-2 rounded text-decoration-none"
                   style="border:1.5px solid #ACBCBF;background:#F4FCFB;color:#1e2e3a;font-size:.83rem;font-weight:600;transition:all .17s ease;"
                   onmouseover="this.style.borderColor='#5289AD';this.style.color='#5289AD';this.style.background='#fff';this.style.boxShadow='0 4px 12px rgba(82,137,173,.14)';"
                   onmouseout="this.style.borderColor='#ACBCBF';this.style.color='#1e2e3a';this.style.background='#F4FCFB';this.style.boxShadow='none';">
                    <span style="width:34px;height:34px;border-radius:9px;background:{{ $action['bg'] }};color:{{ $action['color'] }};display:flex;align-items:center;justify-content:center;font-size:.82rem;flex-shrink:0;">
                        <i class="{{ $action['icon'] }}"></i>
                    </span>
                    {{ $action['label'] }}
                    <i class="fas fa-chevron-right ms-auto" style="font-size:.6rem;color:#ACBCBF;"></i>
                </a>
                @endforeach
            </div>
        </div>
    </div>

</div>

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* Sales line chart — Arctic steel blue */
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    const grad = salesCtx.createLinearGradient(0, 0, 0, 260);
    grad.addColorStop(0, 'rgba(82,137,173,0.28)');
    grad.addColorStop(1, 'rgba(82,137,173,0.00)');

    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Revenue',
                data: @json($chartSales),
                borderColor: '#5289AD',
                borderWidth: 2.5,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#5289AD',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                backgroundColor: grad,
                tension: 0.42
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#243C4C', titleColor: '#ACBCBF',
                    bodyColor: '#F4FCFB', padding: 10, cornerRadius: 8,
                    callbacks: { label: c => '  $' + c.parsed.y.toFixed(2) }
                }
            },
            scales: {
                x: { grid: { display: false }, border: { display: false }, ticks: { font: { size: 11 }, color: '#698696' } },
                y: {
                    beginAtZero: true,
                    grid: { color: '#d0e0e3' }, border: { display: false },
                    ticks: { font: { size: 11 }, color: '#698696', callback: v => '$' + v.toFixed(0) }
                }
            }
        }
    });

    /* Doughnut chart */
    const completed = {{ $orderStatusCounts['completed'] }};
    const pending   = {{ $orderStatusCounts['pending'] }};
    const cancelled = {{ $orderStatusCounts['cancelled'] }};
    const total     = completed + pending + cancelled;

    new Chart(document.getElementById('statusChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Completed', 'Pending', 'Cancelled'],
            datasets: [{
                data: total > 0 ? [completed, pending, cancelled] : [1, 0, 0],
                backgroundColor: total > 0 ? ['#10b981', '#f59e0b', '#ef4444'] : ['#ACBCBF'],
                borderWidth: 3, borderColor: '#fff', hoverOffset: 5
            }]
        },
        options: {
            responsive: true, cutout: '70%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#243C4C', titleColor: '#ACBCBF',
                    bodyColor: '#F4FCFB', padding: 10, cornerRadius: 8,
                    callbacks: { label: c => '  ' + c.label + ': ' + c.parsed }
                }
            }
        }
    });

    /* Animated counters */
    function easeOut(t) { return 1 - Math.pow(1 - t, 3); }
    function runCounter(el) {
        const target   = parseFloat(el.dataset.count) || 0;
        const prefix   = el.dataset.prefix || '';
        const decimals = parseInt(el.dataset.decimals, 10) || 0;
        const duration = 1400;
        let start = null;
        (function tick(ts) {
            if (!start) start = ts;
            const p = Math.min((ts - start) / duration, 1);
            const v = easeOut(p) * target;
            el.textContent = prefix + v.toLocaleString('en-US', { minimumFractionDigits: decimals, maximumFractionDigits: decimals });
            if (p < 1) { requestAnimationFrame(tick); }
            else {
                el.textContent = prefix + target.toLocaleString('en-US', { minimumFractionDigits: decimals, maximumFractionDigits: decimals });
            }
        })(performance.now());
    }

    const obs = new IntersectionObserver(entries => {
        entries.forEach(e => { if (e.isIntersecting) { setTimeout(() => runCounter(e.target), 150); obs.unobserve(e.target); } });
    }, { threshold: 0.3 });
    document.querySelectorAll('.db-stat-value[data-count]').forEach(el => obs.observe(el));
});
</script>
@endsection
