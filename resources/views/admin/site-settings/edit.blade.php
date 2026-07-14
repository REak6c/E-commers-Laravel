@extends('admin.layouts.admin')

@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">{{ __('cms.site_settings.title') }}</h4>
        </div>
    </div>
</div>

<form action="{{ route('admin.site-settings.update') }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4">{{ __('cms.site_settings.general_configuration') }}</h6>

                    @if (session('success'))
                    <div class="alert alert-success border-0 shadow-sm mb-4">
                        {{ session('success') }}
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="site_name" class="form-label fw-semibold">{{ __('cms.site_settings.site_name') }}</label>
                            <input type="text" name="site_name" class="form-control border-0 bg-light"
                                value="{{ old('site_name', $settings->site_name ?? '') }}" required
                                placeholder="e.g. My E-commerce">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tagline" class="form-label fw-semibold">{{ __('cms.site_settings.tagline') }}</label>
                            <input type="text" name="tagline" class="form-control border-0 bg-light"
                                value="{{ old('tagline', $settings->tagline ?? '') }}"
                                placeholder="e.g. Best products online">
                        </div>
                    </div>

                    <div class="mb-3 mt-2">
                        <label for="footer_text" class="form-label fw-semibold">{{ __('cms.site_settings.footer_text') }}</label>
                        <textarea name="footer_text" rows="3" class="form-control border-0 bg-light"
                            placeholder="Copy right information...">{{ old('footer_text', $settings->footer_text ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4">{{ __('cms.site_settings.seo_settings') }}</h6>

                    <div class="mb-3">
                        <label for="meta_title" class="form-label fw-semibold">{{ __('cms.site_settings.meta_title') }}</label>
                        <input type="text" name="meta_title" class="form-control border-0 bg-light"
                            value="{{ old('meta_title', $settings->meta_title ?? '') }}"
                            placeholder="Search engine title">
                    </div>

                    <div class="mb-3">
                        <label for="meta_keywords" class="form-label fw-semibold">{{ __('cms.site_settings.meta_keywords') }}</label>
                        <input type="text" name="meta_keywords" class="form-control border-0 bg-light"
                            value="{{ old('meta_keywords', $settings->meta_keywords ?? '') }}"
                            placeholder="keyword1, keyword2, ...">
                    </div>

                    <div class="mb-0">
                        <label for="meta_description" class="form-label fw-semibold">{{ __('cms.site_settings.meta_description') }}</label>
                        <textarea name="meta_description" rows="3" class="form-control border-0 bg-light"
                            placeholder="Brief description for search engines...">{{ old('meta_description', $settings->meta_description ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4">{{ __('cms.site_settings.contact_information') }}</h6>

                    <div class="mb-3">
                        <label for="contact_email" class="form-label fw-semibold">{{ __('cms.site_settings.contact_email') }}</label>
                        <input type="email" name="contact_email" class="form-control border-0 bg-light"
                            value="{{ old('contact_email', $settings->contact_email ?? '') }}"
                            placeholder="support@example.com">
                    </div>

                    <div class="mb-3">
                        <label for="contact_phone" class="form-label fw-semibold">{{ __('cms.site_settings.contact_phone') }}</label>
                        <input type="text" name="contact_phone" class="form-control border-0 bg-light"
                            value="{{ old('contact_phone', $settings->contact_phone ?? '') }}"
                            placeholder="+855 12 345 678">
                    </div>

                    <div class="mb-0">
                        <label for="address" class="form-label fw-semibold">{{ __('cms.site_settings.address') }}</label>
                        <textarea name="address" rows="3" class="form-control border-0 bg-light"
                            placeholder="Physical store address...">{{ old('address', $settings->address ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">{{ __('cms.site_settings.actions') }}</h6>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary shadow-sm py-2">
                            <i class="bi bi-save me-1"></i> {{ __('cms.site_settings.update_button') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
