@extends('admin.layouts.admin')

@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">{{ __('cms.refunds.details_title') }}</h4>
            <a href="{{ route('admin.refunds.index') }}" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> {{ __('cms.refunds.back') }}
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4">{{ __('cms.refunds.refund_information') }}</h6>

                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted small fw-bold text-uppercase mb-1">{{
                            __('cms.refunds.amount') }}</label>
                        <div class="fs-4 fw-bold text-primary">{{ $refund->amount }}</div>
                    </div>
                    <div class="col-md-6 mb-3 text-md-end">
                        <label class="form-label text-muted small fw-bold text-uppercase mb-1 d-block">{{
                            __('cms.refunds.status') }}</label>
                        <div class="d-inline-block">
                            @php
                            $badgeClass = 'bg-secondary-soft text-secondary';
                            if($refund->status === 'completed') $badgeClass = 'bg-success-soft text-success';
                            if($refund->status === 'pending') $badgeClass = 'bg-warning-soft text-warning';
                            if($refund->status === 'failed') $badgeClass = 'bg-danger-soft text-danger';
                            @endphp
                            <span class="badge {{ $badgeClass }} px-3 fw-bold text-capitalize fs-6">{{ $refund->status
                                }}</span>
                        </div>
                    </div>
                </div>

                <div class="mb-0">
                    <label class="form-label text-muted small fw-bold text-uppercase mb-1">{{ __('cms.refunds.reason')
                        }}</label>
                    <div class="p-3 bg-light rounded-3 border-0">
                        {{ $refund->reason ?? __('cms.refunds.not_available') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4">{{ __('cms.refunds.payment_and_timestamps') }}</h6>

                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold text-uppercase mb-1">{{ __('cms.refunds.payment')
                        }}</label>
                    <div class="fw-semibold">
                        @if($refund->payment)
                        <div class="mb-1 text-primary">#{{ $refund->payment->id }}</div>
                        <div class="text-muted small">
                            {{ __('cms.payments.amount') }}: {{ $refund->payment->amount }}<br>
                            {{ __('cms.common.status') }}: {{ $refund->payment->status }}
                        </div>
                        @else
                        <span class="text-muted">{{ __('cms.refunds.not_available') }}</span>
                        @endif
                    </div>
                </div>

                <hr class="my-3 opacity-25">

                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold text-uppercase mb-1">{{
                        __('cms.refunds.created_at') }}</label>
                    <div class="text-muted">{{ $refund->created_at->format('M d, Y H:i') }}</div>
                </div>

                <div class="mb-0">
                    <label class="form-label text-muted small fw-bold text-uppercase mb-1">{{
                        __('cms.refunds.updated_at') }}</label>
                    <div class="text-muted">{{ $refund->updated_at->format('M d, Y H:i') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection