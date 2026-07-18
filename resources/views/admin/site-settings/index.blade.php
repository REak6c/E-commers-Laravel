@extends('admin.layouts.admin')

@section('content')

<div class="row mb-4">
    <div class="col-12 text-end">
        <a href="{{ route('admin.site-settings.edit') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-pencil-square me-1"></i> {{ 'Edit Settings' }}
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4">{{ 'Site Overview' }}</h6>

                @if (session('success'))
                <div class="alert alert-success border-0 shadow-sm mb-4">
                    {{ session('success') }}
                </div>
                @endif

                <div class="row mb-4">
                    <div class="col-sm-4 text-muted">{{ 'Site Name' }}</div>
                    <div class="col-sm-8 fw-semibold">{{ $settings->site_name ?? 'Not set' }}</div>
                </div>

                <div class="row mb-4">
                    <div class="col-sm-4 text-muted">{{ 'Tagline' }}</div>
                    <div class="col-sm-8 fw-semibold">{{ $settings->tagline ?? 'Not set' }}</div>
                </div>

                <div class="row mb-4">
                    <div class="col-sm-4 text-muted">{{ 'Footer Text' }}</div>
                    <div class="col-sm-8">{{ $settings->footer_text ?? 'Not set' }}</div>
                </div>

                <hr class="my-4">

                <h6 class="fw-bold mb-4">{{ 'SEO Details' }}</h6>

                <div class="row mb-4">
                    <div class="col-sm-4 text-muted">{{ 'Meta Title' }}</div>
                    <div class="col-sm-8">{{ $settings->meta_title ?? 'Not set' }}</div>
                </div>

                <div class="row mb-4">
                    <div class="col-sm-4 text-muted">{{ 'Meta Keywords' }}</div>
                    <div class="col-sm-8">{{ $settings->meta_keywords ?? 'Not set' }}</div>
                </div>

                <div class="row mb-0">
                    <div class="col-sm-4 text-muted">{{ 'Meta Description' }}</div>
                    <div class="col-sm-8">{{ $settings->meta_description ?? 'Not set' }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4">{{ 'Contact Details' }}</h6>

                <div class="mb-4">
                    <div class="text-muted small mb-1">{{ 'Support Email' }}</div>
                    <div class="fw-semibold">{{ $settings->contact_email ?? 'Not set' }}</div>
                </div>

                <div class="mb-4">
                    <div class="text-muted small mb-1">{{ 'Phone Number' }}</div>
                    <div class="fw-semibold">{{ $settings->contact_phone ?? 'Not set' }}</div>
                </div>

                <div class="mb-0">
                    <div class="text-muted small mb-1">{{ 'Address' }}</div>
                    <div class="fw-semibold">{{ $settings->address ?? 'Not set' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
