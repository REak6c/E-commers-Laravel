@extends('admin.layouts.admin')

@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">{{ __('cms.product_reviews.review_details') }}</h4>
            <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> {{ __('cms.product_reviews.back_button') }}
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4">{{ __('cms.product_reviews.review_content') }}</h6>

                <div class="mb-4">
                    <label class="form-label text-muted small fw-bold text-uppercase mb-1">{{
                        __('cms.product_reviews.rating') }}</label>
                    <div>
                        @for($i=1; $i<=5; $i++) <i
                            class="bi bi-star{{ $i <= $review->rating ? '-fill text-warning' : ' text-muted' }} fs-5">
                            </i>
                            @endfor
                            <span class="ms-2 fw-semibold">({{ $review->rating }} / 5.0)</span>
                    </div>
                </div>

                <div class="mb-0">
                    <label class="form-label text-muted small fw-bold text-uppercase mb-1">{{
                        __('cms.product_reviews.review') }}</label>
                    <div class="p-3 bg-light rounded-3 border-0">
                        {{ $review->review ?? __('cms.product_reviews.no_comment') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4">{{ __('cms.product_reviews.customer_and_product') }}</h6>

                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold text-uppercase mb-1">{{
                        __('cms.product_reviews.customer_name') }}</label>
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-2"
                            style="width: 40px; height: 40px;">
                            <i class="bi bi-person text-secondary"></i>
                        </div>
                        <span class="fw-semibold">{{ optional($review->customer)->name ?? __('cms.product_reviews.guest') }}</span>
                    </div>
                </div>

                <hr class="my-3 opacity-25">

                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold text-uppercase mb-1">{{
                        __('cms.product_reviews.product_name') }}</label>
                    <div class="fw-semibold">
                        {{ $review->product?->name ?? 'N/A' }}
                    </div>
                </div>

                <hr class="my-3 opacity-25">

                <div>
                    <label class="form-label text-muted small fw-bold text-uppercase mb-1">{{
                        __('cms.product_reviews.status') }}</label>
                    <div>
                        @if($review->status == 1)
                        <span class="badge bg-success-soft text-success px-3 fw-bold">{{ __('cms.product_reviews.approved') }}</span>
                        @else
                        <span class="badge bg-warning-soft text-warning px-3 fw-bold">{{ __('cms.product_reviews.pending_status') }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection