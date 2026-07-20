@extends('vendor.layouts.master')

@section('title', 'Review Details')

@section('content')

<div class="vp-page-header">
    <div class="vp-page-header__left">
        <h1 class="vp-page-header__title">
            <span class="vp-page-header__title-icon"><i class="fas fa-star"></i></span>
            Review Details
        </h1>
        <p class="vp-page-header__sub">Full details for review #{{ $review->id }}</p>
    </div>
    <div class="vp-page-header__actions">
        <a href="{{ route('vendor.reviews.index') }}"
           class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-2"
           style="border-radius:8px;font-size:.82rem;">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="row g-4">

    {{-- Review content --}}
    <div class="col-lg-8">
        <div class="vp-card">
            <div class="vp-card-header">
                <h6 class="vp-card-header__title">
                    <span class="vp-card-header__icon"><i class="fas fa-comment-dots"></i></span>
                    Customer Review
                </h6>
                @if($review->status == 1)
                    <span class="vp-status-badge active" style="font-size:.72rem;padding:4px 12px;">
                        <i class="fas fa-check-circle me-1" style="font-size:.65rem;"></i>Approved
                    </span>
                @else
                    <span class="vp-status-badge pending" style="font-size:.72rem;padding:4px 12px;">
                        <i class="fas fa-clock me-1" style="font-size:.65rem;"></i>Pending
                    </span>
                @endif
            </div>
            <div class="vp-card-body">

                @php $stars = intval($review->rating ?? 0); @endphp
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="d-flex align-items-center gap-1">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star"
                               style="font-size:1.1rem;color:{{ $i <= $stars ? '#f59e0b' : '#e2e8f0' }};"></i>
                        @endfor
                    </div>
                    <div style="display:flex;flex-direction:column;gap:1px;">
                        <span style="font-size:1.1rem;font-weight:800;color:var(--vp-text);line-height:1;">
                            {{ number_format($review->rating, 1) }}
                        </span>
                        <span style="font-size:0.72rem;color:var(--vp-text-muted);">out of 5</span>
                    </div>
                </div>

                <div style="background:var(--vp-surface-muted);border:1.5px solid var(--vp-border);border-radius:var(--vp-r-lg);padding:18px 20px;">
                    @if($review->review)
                        <p style="font-size:.9rem;color:var(--vp-text-2);line-height:1.7;margin:0;">
                            "{{ $review->review }}"
                        </p>
                    @else
                        <p style="font-size:.85rem;color:var(--vp-text-muted);margin:0;font-style:italic;">
                            No written review provided.
                        </p>
                    @endif
                </div>

            </div>
        </div>
    </div>

    {{-- Sidebar meta --}}
    <div class="col-lg-4">

        {{-- Customer --}}
        <div class="vp-card mb-4">
            <div class="vp-card-header">
                <h6 class="vp-card-header__title">
                    <span class="vp-card-header__icon"><i class="fas fa-user"></i></span>
                    Customer
                </h6>
            </div>
            <div class="vp-card-body">
                <div class="d-flex align-items-center gap-3">
                    <div style="width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;font-size:1rem;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        {{ strtoupper(substr(optional($review->customer)->name ?? 'G', 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-size:.875rem;font-weight:700;color:var(--vp-text);">
                            {{ optional($review->customer)->name ?? 'Guest' }}
                        </div>
                        @if(optional($review->customer)->email)
                            <div style="font-size:.75rem;color:var(--vp-text-muted);margin-top:2px;">
                                {{ $review->customer->email }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Product --}}
        <div class="vp-card mb-4">
            <div class="vp-card-header">
                <h6 class="vp-card-header__title">
                    <span class="vp-card-header__icon"><i class="fas fa-box-open"></i></span>
                    Product
                </h6>
            </div>
            <div class="vp-card-body">
                <div style="font-size:.875rem;font-weight:600;color:var(--vp-text);">
                    {{ $review->product?->name ?? 'N/A' }}
                </div>
                @if($review->product)
                    <div class="mt-3">
                        <a href="{{ route('vendor.products.edit', $review->product->id) }}" class="vp-btn-primary" style="padding:7px 14px;font-size:.78rem;">
                            <i class="fas fa-external-link-alt" style="font-size:.7rem;"></i>
                            View Product
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Meta details --}}
        <div class="vp-card">
            <div class="vp-card-header">
                <h6 class="vp-card-header__title">
                    <span class="vp-card-header__icon"><i class="fas fa-info-circle"></i></span>
                    Details
                </h6>
            </div>
            <div class="vp-card-body p-0">
                <dl class="mb-0">
                    @foreach ([
                        ['label'=>'Review ID',  'value'=>'#'.$review->id],
                        ['label'=>'Rating',     'value'=>$stars.'/5 ★'],
                        ['label'=>'Status',     'value'=>$review->status == 1 ? 'Approved' : 'Pending'],
                        ['label'=>'Submitted',  'value'=>$review->created_at?->format('M j, Y') ?? '—'],
                    ] as $row)
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 20px;border-bottom:1px solid var(--vp-border);">
                        <dt style="font-size:.72rem;font-weight:600;color:var(--vp-text-muted);text-transform:uppercase;letter-spacing:.06em;margin:0;">{{ $row['label'] }}</dt>
                        <dd style="font-size:.85rem;font-weight:700;color:var(--vp-text);margin:0;">{{ $row['value'] }}</dd>
                    </div>
                    @endforeach
                </dl>
            </div>
        </div>

    </div>
</div>

@endsection
