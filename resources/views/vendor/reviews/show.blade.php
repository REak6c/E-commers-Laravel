@extends('vendor.layouts.master')

@section('content')

{{-- Page Header --}}
<div class="vp-page-header">
    <div class="vp-page-header__left">
        <h1 class="vp-page-header__title">
            <i class="fas fa-star me-2" style="color:var(--vp-primary);font-size:1.1rem;"></i>
            {{ __('cms.product_reviews.review_details') }}
        </h1>
        <p class="vp-page-header__sub">Full details for review #{{ $review->id }}</p>
    </div>
    <div class="vp-page-header__actions">
        <a href="{{ route('vendor.reviews.index') }}"
           class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-2"
           style="border-radius:8px;font-size:.82rem;">
            <i class="fas fa-arrow-left"></i> {{ __('cms.product_reviews.back_button') }}
        </a>
    </div>
</div>

<div class="row g-4">

    {{-- ===== LEFT: Review content ===== --}}
    <div class="col-lg-8">

        {{-- Review body card --}}
        <div class="vp-card">
            <div class="vp-card-header">
                <h6 class="vp-card-header__title">
                    <span class="vp-card-header__icon"><i class="fas fa-comment-dots"></i></span>
                    Customer Review
                </h6>
                {{-- Status badge --}}
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

                {{-- Star rating display --}}
                @php $stars = intval($review->rating ?? 0); @endphp
                <div class="d-flex align-items-center gap-3 mb-20" style="margin-bottom:20px;">
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

                {{-- Review text --}}
                <div style="background:var(--vp-surface-muted);border:1.5px solid var(--vp-border-subtle);
                            border-radius:var(--vp-radius-lg);padding:18px 20px;margin-bottom:0;">
                    @if($review->review)
                        <p style="font-size:0.9rem;color:var(--vp-text-secondary);line-height:1.7;margin:0;">
                            "{{ $review->review }}"
                        </p>
                    @else
                        <p style="font-size:0.85rem;color:var(--vp-text-muted);margin:0;font-style:italic;">
                            No written review provided.
                        </p>
                    @endif
                </div>

            </div>
        </div>

    </div>

    {{-- ===== RIGHT: Meta info ===== --}}
    <div class="col-lg-4">

        {{-- Customer card --}}
        <div class="vp-card mb-4">
            <div class="vp-card-header">
                <h6 class="vp-card-header__title">
                    <span class="vp-card-header__icon"><i class="fas fa-user"></i></span>
                    {{ __('cms.product_reviews.customer_name') }}
                </h6>
            </div>
            <div class="vp-card-body" style="padding:20px;">
                <div class="d-flex align-items-center gap-3">
                    {{-- Avatar --}}
                    <div style="width:44px;height:44px;border-radius:50%;
                                background:linear-gradient(135deg,#6366f1,#8b5cf6);
                                color:#fff;font-size:1rem;font-weight:700;
                                display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        {{ strtoupper(substr(optional($review->customer)->name ?? 'G', 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-size:0.875rem;font-weight:700;color:var(--vp-text);line-height:1.3;">
                            {{ optional($review->customer)->name ?? 'Guest' }}
                        </div>
                        @if(optional($review->customer)->email)
                            <div style="font-size:0.75rem;color:var(--vp-text-muted);margin-top:2px;">
                                {{ $review->customer->email }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Product card --}}
        <div class="vp-card mb-4">
            <div class="vp-card-header">
                <h6 class="vp-card-header__title">
                    <span class="vp-card-header__icon"><i class="fas fa-box-open"></i></span>
                    {{ __('cms.product_reviews.product_name') }}
                </h6>
            </div>
            <div class="vp-card-body" style="padding:20px;">
                <div style="font-size:0.875rem;font-weight:600;color:var(--vp-text);">
                    {{ $review->product?->name ?? 'N/A' }}
                </div>
                @if($review->product)
                    <div style="margin-top:10px;">
                        <a href="{{ route('vendor.products.edit', $review->product->id) }}"
                           class="vp-btn-primary"
                           style="padding:7px 14px;font-size:0.78rem;">
                            <i class="fas fa-external-link-alt" style="font-size:0.7rem;"></i>
                            View Product
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Meta card --}}
        <div class="vp-card">
            <div class="vp-card-header">
                <h6 class="vp-card-header__title">
                    <span class="vp-card-header__icon"><i class="fas fa-info-circle"></i></span>
                    Details
                </h6>
            </div>
            <div class="vp-card-body" style="padding:0;">
                <dl style="margin:0;">
                    <div style="display:flex;justify-content:space-between;align-items:center;
                                padding:13px 20px;border-bottom:1px solid var(--vp-border-subtle);">
                        <dt style="font-size:0.75rem;font-weight:600;color:var(--vp-text-muted);text-transform:uppercase;letter-spacing:.06em;">Review ID</dt>
                        <dd style="font-size:0.85rem;font-weight:700;color:var(--vp-text);margin:0;">#{{ $review->id }}</dd>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;
                                padding:13px 20px;border-bottom:1px solid var(--vp-border-subtle);">
                        <dt style="font-size:0.75rem;font-weight:600;color:var(--vp-text-muted);text-transform:uppercase;letter-spacing:.06em;">Rating</dt>
                        <dd style="margin:0;">
                            <span style="font-size:0.82rem;font-weight:700;color:#f59e0b;">
                                {{ $stars }}/5 <i class="fas fa-star" style="font-size:0.72rem;"></i>
                            </span>
                        </dd>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;
                                padding:13px 20px;border-bottom:1px solid var(--vp-border-subtle);">
                        <dt style="font-size:0.75rem;font-weight:600;color:var(--vp-text-muted);text-transform:uppercase;letter-spacing:.06em;">Status</dt>
                        <dd style="margin:0;">
                            @if($review->status == 1)
                                <span class="vp-status-badge active">Approved</span>
                            @else
                                <span class="vp-status-badge pending">Pending</span>
                            @endif
                        </dd>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:13px 20px;">
                        <dt style="font-size:0.75rem;font-weight:600;color:var(--vp-text-muted);text-transform:uppercase;letter-spacing:.06em;">Submitted</dt>
                        <dd style="font-size:0.82rem;color:var(--vp-text-secondary);margin:0;">
                            {{ $review->created_at?->format('M j, Y') ?? '—' }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

    </div>
</div>

@endsection
