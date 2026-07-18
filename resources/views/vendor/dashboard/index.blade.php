@extends('vendor.layouts.master')

@section('css')
<style>
/* ---- Dashboard-specific overrides ---- */
.db-wrapper { padding: 4px 0 40px; }

/* ---- Page header ---- */
.db-header {
    display: flex; align-items: flex-start; justify-content: space-between;
    flex-wrap: wrap; gap: 12px; margin-bottom: 26px;
}
.db-header__title {
    font-size: 1.35rem; font-weight: 800; color: #0f172a;
    margin: 0 0 3px; letter-spacing: -.025em; line-height: 1.2;
}
.db-header__sub { font-size: .83rem; color: #94a3b8; margin: 0; }
.db-header__sub strong { color: #475569; font-weight: 600; }
.db-date-badge {
    display: inline-flex; align-items: center; gap: 7px;
    background: #fff; border: 1.5px solid #e4e8f0;
    border-radius: 10px; padding: 7px 14px;
    font-size: .78rem; color: #64748b; font-weight: 500;
    white-space: nowrap;
    box-shadow: 0 1px 3px rgba(15,23,42,.05);
}

/* ---- Stat cards ---- */
.db-stat {
    border-radius: 16px; padding: 22px 22px 18px;
    color: #fff; position: relative; overflow: hidden;
    border: none; cursor: default;
    transition: transform .22s ease, box-shadow .22s ease;
}
.db-stat:hover { transform: translateY(-3px); }

.db-stat::after {
    content: ''; position: absolute;
    top: -28px; right: -28px;
    width: 110px; height: 110px; border-radius: 50%;
    background: rgba(255,255,255,0.10); pointer-events: none;
}
.db-stat::before {
    content: ''; position: absolute;
    bottom: -24px; right: 20px;
    width: 80px; height: 80px; border-radius: 50%;
    background: rgba(255,255,255,0.07); pointer-events: none;
}

.db-stat--sales    { background: linear-gradient(135deg,#6366f1 0%,#8b5cf6 100%); box-shadow: 0 6px 24px rgba(99,102,241,.32); }
.db-stat--orders   { background: linear-gradient(135deg,#0ea5e9 0%,#06b6d4 100%); box-shadow: 0 6px 24px rgba(14,165,233,.28); }
.db-stat--products { background: linear-gradient(135deg,#f59e0b 0%,#f97316 100%); box-shadow: 0 6px 24px rgba(245,158,11,.28); }

.db-stat__icon {
    width: 46px; height: 46px;
    background: rgba(255,255,255,0.20);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.15rem; margin-bottom: 16px;
    backdrop-filter: blur(4px);
    position: relative; z-index: 1;
}
.db-stat__label {
    font-size: .7rem; font-weight: 600;
    text-transform: uppercase; letter-spacing: .1em;
    opacity: .85; margin-bottom: 4px;
    position: relative; z-index: 1;
}
.db-stat__value {
    font-size: 2rem; font-weight: 800; line-height: 1.1;
    margin-bottom: 10px; position: relative; z-index: 1;
}
.db-stat__footer {
    font-size: .75rem; opacity: .82;
    display: flex; align-items: center; gap: 7px;
    position: relative; z-index: 1;
}
.db-stat__pill {
    background: rgba(255,255,255,0.20);
    border-radius: 20px; padding: 2px 9px;
    font-size: .69rem; font-weight: 700;
    display: inline-flex; align-items: center; gap: 4px;
}

@keyframes valuePop {
    0%   { transform: scale(1); }
    40%  { transform: scale(1.06); }
    100% { transform: scale(1); }
}
.db-stat__value.popped { animation: valuePop .3s ease forwards; }
</style>
@endsection

@section('content')
@php $vendor = Auth::guard('vendor')->user(); @endphp
<div class="db-wrapper">

{{-- PAGE HEADER --}}
<div class="db-header">
    <div>
        <h1 class="db-header__title">
            <i class="fas fa-chart-line me-2" style="color:#6366f1;font-size:1.1rem;"></i>Vendor Dashboard
        </h1>
        <p class="db-header__sub">Welcome back, <strong>{{ $vendor->name }}</strong>. Here's your store overview.</p>
    </div>
    <span class="db-date-badge">
        <i class="fas fa-calendar-alt" style="color:#6366f1;"></i>
        {{ now()->format('D, M j, Y') }}
    </span>
</div>

{{-- STAT CARDS --}}
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-4">
        <div class="db-stat db-stat--sales">
            <div class="db-stat__icon"><i class="fas fa-dollar-sign"></i></div>
            <div class="db-stat__label">{{ 'My Sales' }}</div>
            <div class="db-stat__value" data-count="{{ $data['totalSales'] }}" data-prefix="$" data-decimals="2">$0.00</div>
            <div class="db-stat__footer">
                <span class="db-stat__pill"><i class="fas fa-sun"></i> Today</span>
                ${{ number_format($data['todaySales'], 2) }}
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="db-stat db-stat--orders">
            <div class="db-stat__icon"><i class="fas fa-shopping-bag"></i></div>
            <div class="db-stat__label">{{ 'My Orders' }}</div>
            <div class="db-stat__value" data-count="{{ $data['totalOrders'] }}" data-prefix="" data-decimals="0">0</div>
            <div class="db-stat__footer">
                <span class="db-stat__pill"><i class="fas fa-check-circle"></i> Completed</span>
                {{ $data['completedOrders'] }}
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="db-stat db-stat--products">
            <div class="db-stat__icon"><i class="fas fa-box-open"></i></div>
            <div class="db-stat__label">{{ 'My Products' }}</div>
            <div class="db-stat__value" data-count="{{ $data['totalProducts'] }}" data-prefix="" data-decimals="0">0</div>
            <div class="db-stat__footer">
                <span class="db-stat__pill">Active</span>
                Listed products
            </div>
        </div>
    </div>
</div>

{{-- CHARTS ROW --}}
<div class="row g-3 mb-4">

    {{-- Sales Trend --}}
    <div class="col-lg-8">
        <div class="vp-card h-100">
            <div class="vp-card-header">
                <h6 class="vp-card-header__title">
                    <span class="vp-card-header__icon" style="background:#eef2ff;color:#6366f1;">
                        <i class="fas fa-chart-area"></i>
                    </span>
                    Sales Trend
                </h6>
                <span style="font-size:.72rem;color:#94a3b8;">Last 7 days</span>
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
                    <div id="donut-center" style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;pointer-events:none;">
                        <span style="font-size:1.4rem;font-weight:800;color:#0f172a;line-height:1;">{{ $orderStatusCounts['completed'] + $orderStatusCounts['pending'] + $orderStatusCounts['cancelled'] }}</span>
                        <span style="font-size:.68rem;color:#94a3b8;font-weight:500;text-transform:uppercase;letter-spacing:.06em;">Total</span>
                    </div>
                </div>
                <div style="display:flex;flex-direction:column;gap:8px;width:100%;">
                    <div style="display:flex;align-items:center;justify-content:space-between;font-size:.78rem;">
                        <span style="display:flex;align-items:center;gap:7px;color:#475569;">
                            <span style="width:8px;height:8px;border-radius:50%;background:#10b981;flex-shrink:0;"></span> Completed
                        </span>
                        <strong style="color:#0f172a;">{{ $orderStatusCounts['completed'] }}</strong>
                    </div>
                    <div style="display:flex;align-items:center;justify-content:space-between;font-size:.78rem;">
                        <span style="display:flex;align-items:center;gap:7px;color:#475569;">
                            <span style="width:8px;height:8px;border-radius:50%;background:#f59e0b;flex-shrink:0;"></span> Pending
                        </span>
                        <strong style="color:#0f172a;">{{ $orderStatusCounts['pending'] }}</strong>
                    </div>
                    <div style="display:flex;align-items:center;justify-content:space-between;font-size:.78rem;">
                        <span style="display:flex;align-items:center;gap:7px;color:#475569;">
                            <span style="width:8px;height:8px;border-radius:50%;background:#ef4444;flex-shrink:0;"></span> Cancelled
                        </span>
                        <strong style="color:#0f172a;">{{ $orderStatusCounts['cancelled'] }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- BOTTOM ROW --}}
<div class="row g-3">

    {{-- Recent Orders --}}
    <div class="col-lg-8">
        <div class="vp-card">
            <div class="vp-card-header">
                <h6 class="vp-card-header__title">
                    <span class="vp-card-header__icon" style="background:#f8f9fc;color:#0f172a;">
                        <i class="fas fa-receipt"></i>
                    </span>
                    Recent Orders
                </h6>
                <a href="{{ route('vendor.orders.index') }}"
                   style="font-size:.75rem;font-weight:600;color:#6366f1;text-decoration:none;display:inline-flex;align-items:center;gap:5px;"
                   onmouseover="this.style.color='#4f46e5'" onmouseout="this.style.color='#6366f1'">
                    View all <i class="fas fa-arrow-right" style="font-size:.65rem;"></i>
                </a>
            </div>

            @if($recentOrders->isEmpty())
            <div style="text-align:center;padding:44px 20px;color:#94a3b8;">
                <div style="width:52px;height:52px;border-radius:14px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;font-size:1.3rem;color:#cbd5e1;">
                    <i class="fas fa-receipt"></i>
                </div>
                <p style="font-size:.83rem;margin:0;font-weight:500;">No orders yet</p>
                <p style="font-size:.75rem;margin:4px 0 0;color:#cbd5e1;">Orders will appear here once placed.</p>
            </div>
            @else
            <div style="overflow-x:auto;">
                <table style="width:100%;border-collapse:collapse;">
                    <thead>
                        <tr style="background:#f7f8fc;border-bottom:1px solid #edf0f7;">
                            <th style="padding:10px 18px;font-size:.66rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#94a3b8;text-align:left;white-space:nowrap;">Order #</th>
                            <th style="padding:10px 18px;font-size:.66rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#94a3b8;text-align:left;">Customer</th>
                            <th style="padding:10px 18px;font-size:.66rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#94a3b8;text-align:left;">Amount</th>
                            <th style="padding:10px 18px;font-size:.66rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#94a3b8;text-align:left;">Status</th>
                            <th style="padding:10px 18px;font-size:.66rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#94a3b8;text-align:left;">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                        <tr style="border-bottom:1px solid #f0f3fa;transition:background .15s;" onmouseover="this.style.background='#fafbff'" onmouseout="this.style.background='transparent'">
                            <td style="padding:13px 18px;font-size:.82rem;">
                                <strong style="color:#0f172a;">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</strong>
                            </td>
                            <td style="padding:13px 18px;font-size:.82rem;">
                                <div style="display:flex;align-items:center;gap:9px;">
                                    <div style="width:30px;height:30px;border-radius:50%;background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;font-size:.72rem;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        {{ strtoupper(substr($order->customer?->name ?? $order->guest_email ?? 'G', 0, 1)) }}
                                    </div>
                                    <span style="color:#475569;font-size:.82rem;">{{ $order->customer?->name ?? ($order->guest_email ?? 'Guest') }}</span>
                                </div>
                            </td>
                            <td style="padding:13px 18px;"><strong style="color:#0f172a;font-size:.84rem;">${{ number_format($order->vendor_total ?? 0, 2) }}</strong></td>
                            <td style="padding:13px 18px;">
                                <span class="vp-status-badge {{ $order->status }}">{{ ucfirst($order->status) }}</span>
                            </td>
                            <td style="padding:13px 18px;font-size:.78rem;color:#94a3b8;">{{ $order->created_at->format('M j, Y') }}</td>
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
                    ['route' => 'vendor.products.create', 'label' => 'Add New Product',  'icon' => 'fas fa-plus',        'bg' => '#eef2ff', 'color' => '#6366f1'],
                    ['route' => 'vendor.products.index',  'label' => 'My Products',       'icon' => 'fas fa-box-open',    'bg' => '#e0f2fe', 'color' => '#0ea5e9'],
                    ['route' => 'vendor.orders.index',    'label' => 'Manage Orders',     'icon' => 'fas fa-shopping-bag','bg' => '#dcfce7', 'color' => '#10b981'],
                    ['route' => 'vendor.reviews.index',   'label' => 'Product Reviews',   'icon' => 'fas fa-star',        'bg' => '#fef3c7', 'color' => '#f59e0b'],
                    ['route' => 'vendor.profile.edit',    'label' => 'My Profile',        'icon' => 'fas fa-user-circle', 'bg' => '#f1f5f9', 'color' => '#64748b'],
                ];
                @endphp
                @foreach($actions as $action)
                <a href="{{ route($action['route']) }}"
                   style="display:flex;align-items:center;gap:11px;padding:11px 12px;border-radius:10px;border:1.5px solid #e4e8f0;background:#f7f8fc;margin-bottom:8px;text-decoration:none;color:#374151;font-size:.83rem;font-weight:600;transition:all .17s ease;"
                   onmouseover="this.style.borderColor='#6366f1';this.style.color='#6366f1';this.style.background='#fff';this.style.transform='translateX(3px)';this.style.boxShadow='0 4px 12px rgba(99,102,241,.12)'"
                   onmouseout="this.style.borderColor='#e4e8f0';this.style.color='#374151';this.style.background='#f7f8fc';this.style.transform='translateX(0)';this.style.boxShadow='none'">
                    <span style="width:34px;height:34px;border-radius:9px;background:{{ $action['bg'] }};color:{{ $action['color'] }};display:flex;align-items:center;justify-content:center;font-size:.82rem;flex-shrink:0;">
                        <i class="{{ $action['icon'] }}"></i>
                    </span>
                    {{ $action['label'] }}
                    <i class="fas fa-chevron-right" style="margin-left:auto;font-size:.6rem;color:#cbd5e1;"></i>
                </a>
                @endforeach
            </div>
        </div>
    </div>

</div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ---- Sales Line Chart ---- */
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    const grad = salesCtx.createLinearGradient(0, 0, 0, 260);
    grad.addColorStop(0, 'rgba(99,102,241,0.28)');
    grad.addColorStop(1, 'rgba(99,102,241,0.00)');

    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Revenue',
                data: @json($chartSales),
                borderColor: '#6366f1',
                borderWidth: 2.5,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#6366f1',
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
                    backgroundColor: '#0f172a',
                    titleColor: '#94a3b8',
                    bodyColor: '#f1f5f9',
                    padding: 10,
                    cornerRadius: 8,
                    callbacks: { label: c => '  $' + c.parsed.y.toFixed(2) }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    border: { display: false },
                    ticks: { font: { size: 11, family: 'Inter' }, color: '#94a3b8' }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: '#f0f3fa', drawBorder: false },
                    border: { display: false, dash: [4,4] },
                    ticks: {
                        font: { size: 11, family: 'Inter' },
                        color: '#94a3b8',
                        callback: v => '$' + v.toFixed(0)
                    }
                }
            }
        }
    });

    /* ---- Doughnut Chart ---- */
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
                backgroundColor: total > 0
                    ? ['#10b981', '#f59e0b', '#ef4444']
                    : ['#e2e8f0'],
                borderWidth: 3,
                borderColor: '#fff',
                hoverOffset: 5
            }]
        },
        options: {
            responsive: true,
            cutout: '70%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0f172a',
                    titleColor: '#94a3b8',
                    bodyColor: '#f1f5f9',
                    padding: 10,
                    cornerRadius: 8,
                    callbacks: { label: c => '  ' + c.label + ': ' + c.parsed }
                }
            }
        }
    });

    /* ---- Animated counters ---- */
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
            el.textContent = prefix + v.toLocaleString('en-US', {
                minimumFractionDigits: decimals, maximumFractionDigits: decimals
            });
            if (p < 1) { requestAnimationFrame(tick); }
            else {
                el.textContent = prefix + target.toLocaleString('en-US', {
                    minimumFractionDigits: decimals, maximumFractionDigits: decimals
                });
                el.classList.add('popped');
                el.addEventListener('animationend', () => el.classList.remove('popped'), { once: true });
            }
        })(performance.now());
    }

    const cObs = new IntersectionObserver(entries => {
        entries.forEach(e => { if (e.isIntersecting) { setTimeout(() => runCounter(e.target), 150); cObs.unobserve(e.target); } });
    }, { threshold: 0.3 });

    document.querySelectorAll('.db-stat__value[data-count]').forEach(el => cObs.observe(el));
});
</script>
@endsection
