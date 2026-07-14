@extends('admin.layouts.admin')

@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">{{ __('cms.payments.details_title') }}</h4>
            <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> {{ __('cms.payments.back') }}
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4">{{ __('cms.payments.payment_information') }}</h6>

                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small fw-bold text-uppercase mb-1">{{
                            __('cms.payments.amount') }}</label>
                        <div class="fs-4 fw-bold text-primary">{{ number_format($payment->amount, 2) }}</div>
                    </div>
                    <div class="col-md-6 mb-3 text-md-end">
                        <label class="form-label text-muted small fw-bold text-uppercase mb-1 d-block">{{
                            __('cms.payments.status') }}</label>
                        <div class="d-inline-block">
                            @php
                            $badgeClass = 'bg-secondary-soft text-secondary';
                            if($payment->status === 'completed' || $payment->status === 'paid') $badgeClass =
                            'bg-success-soft text-success';
                            if($payment->status === 'pending') $badgeClass = 'bg-warning-soft text-warning';
                            if($payment->status === 'failed') $badgeClass = 'bg-danger-soft text-danger';
                            @endphp
                            <span class="badge {{ $badgeClass }} px-4 fw-bold text-capitalize fs-6">{{ $payment->status
                                }}</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small fw-bold text-uppercase mb-1">{{
                            __('cms.payments.transaction_id') }}</label>
                        <div class="p-2 bg-light rounded text-monospace small">{{ $payment->transaction_id ?? 'N/A' }}
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small fw-bold text-uppercase mb-1">{{
                            __('cms.payments.gateway') }}</label>
                        <div class="fw-semibold">{{ $payment->gateway->name ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4">{{ __('cms.payments.user_and_order') }}</h6>

                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold text-uppercase mb-1">{{ __('cms.payments.user')
                        }}</label>
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-2"
                            style="width: 40px; height: 40px;">
                            <i class="bi bi-person text-secondary"></i>
                        </div>
                        <span class="fw-semibold">{{ $payment->user->name ?? 'N/A' }}</span>
                    </div>
                </div>

                <hr class="my-3 opacity-25">

                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold text-uppercase mb-1">{{ __('cms.payments.order')
                        }}</label>
                    <div class="fw-semibold text-primary">#{{ $payment->order->id ?? 'N/A' }}</div>
                </div>

                <hr class="my-3 opacity-25">

                <div class="mb-0">
                    <label class="form-label text-muted small fw-bold text-uppercase mb-1">{{
                        __('cms.payments.created_at') }}</label>
                    <div class="text-muted">{{ $payment->created_at->format('d M Y, h:i A') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection