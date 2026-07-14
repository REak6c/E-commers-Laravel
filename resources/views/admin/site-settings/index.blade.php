@extends('admin.layouts.admin')

@section('content')

<div class="row mb-4">
    <div class="col-12 text-end">
        <a href="{{ route('admin.site-settings.edit') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-pencil-square me-1"></i> {{ __('cms.site_settings.edit_button') }}
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4">{{ __('cms.site_settings.site_overview') }}</h6>

                @if (session('success'))
                <div class="alert alert-success border-0 shadow-sm mb-4">
                    {{ session('success') }}
                </div>
                @endif

                <div class="row mb-4">
                    <div class="col-sm-4 text-muted">{{ __('cms.site_settings.site_name') }}</div>
                    <div class="col-sm-8 fw-semibold">{{ $settings->site_name ?? __('cms.site_settings.not_set') }}</div>
                </div>

                <div class="row mb-4">
                    <div class="col-sm-4 text-muted">{{ __('cms.site_settings.tagline') }}</div>
                    <div class="col-sm-8 fw-semibold">{{ $settings->tagline ?? __('cms.site_settings.not_set') }}</div>
                </div>

                <div class="row mb-4">
                    <div class="col-sm-4 text-muted">{{ __('cms.site_settings.footer_text') }}</div>
                    <div class="col-sm-8">{{ $settings->footer_text ?? __('cms.site_settings.not_set') }}</div>
                </div>

                <hr class="my-4">

                <h6 class="fw-bold mb-4">{{ __('cms.site_settings.seo_details') }}</h6>

                <div class="row mb-4">
                    <div class="col-sm-4 text-muted">{{ __('cms.site_settings.meta_title') }}</div>
                    <div class="col-sm-8">{{ $settings->meta_title ?? __('cms.site_settings.not_set') }}</div>
                </div>

                <div class="row mb-4">
                    <div class="col-sm-4 text-muted">{{ __('cms.site_settings.meta_keywords') }}</div>
                    <div class="col-sm-8">{{ $settings->meta_keywords ?? __('cms.site_settings.not_set') }}</div>
                </div>

                <div class="row mb-0">
                    <div class="col-sm-4 text-muted">{{ __('cms.site_settings.meta_description') }}</div>
                    <div class="col-sm-8">{{ $settings->meta_description ?? __('cms.site_settings.not_set') }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4">{{ __('cms.site_settings.contact_details') }}</h6>

                <div class="mb-4">
                    <div class="text-muted small mb-1">{{ __('cms.site_settings.email_support') }}</div>
                    <div class="fw-semibold">{{ $settings->contact_email ?? __('cms.site_settings.not_set') }}</div>
                </div>

                <div class="mb-4">
                    <div class="text-muted small mb-1">{{ __('cms.site_settings.phone_number') }}</div>
                    <div class="fw-semibold">{{ $settings->contact_phone ?? __('cms.site_settings.not_set') }}</div>
                </div>

                <div class="mb-0">
                    <div class="text-muted small mb-1">{{ __('cms.site_settings.address') }}</div>
                    <div class="fw-semibold">{{ $settings->address ?? __('cms.site_settings.not_set') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
