@extends('admin.layouts.admin')

@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">{{ __('cms.social_media_links.create') ?? 'Create Social Media Link' }}</h4>
            <a href="{{ route('admin.social-media-links.index') }}" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> {{ __('cms.common.back') ?? 'Back' }}
            </a>
        </div>
    </div>
</div>

<form action="{{ route('admin.social-media-links.store') }}" method="POST">
    @csrf

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4">Link Information</h6>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="platform" class="form-label fw-semibold">{{ __('cms.social_media_links.platform') }}</label>
                            <input type="text" name="platform" id="platform" value="{{ old('platform') }}"
                                class="form-control border-0 bg-light @error('platform') is-invalid @enderror"
                                placeholder="e.g. Facebook Page">
                            @error('platform')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="link" class="form-label fw-semibold">{{ __('cms.social_media_links.link') }}</label>
                            <input type="url" name="link" id="link" value="{{ old('link') }}"
                                class="form-control border-0 bg-light @error('link') is-invalid @enderror"
                                placeholder="https://facebook.com/yourpage">
                            @error('link')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="mb-0">
                        <label class="form-label fw-semibold">{{ __('cms.social_media_links.translations.platform_name') }}</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="form-control border-0 bg-light @error('name') is-invalid @enderror"
                            placeholder="Platform name">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">Settings</h6>

                    <x-admin.select
                        name="type"
                        id="type"
                        wrapper-class="mb-4"
                        :label="__('cms.social_media_links.type')"
                        :placeholder="__('cms.social_media_links.select_type')"
                        :placeholder-disabled="true"
                        :options="[
                            'facebook' => __('cms.social_media_links.types.facebook'),
                            'instagram' => __('cms.social_media_links.types.instagram'),
                            'tiktok' => __('cms.social_media_links.types.tiktok'),
                            'youtube' => __('cms.social_media_links.types.youtube'),
                            'x' => __('cms.social_media_links.types.x'),
                        ]" />

                    <div class="d-grid pt-2">
                        <button type="submit" class="btn btn-primary shadow-sm py-2">
                            <i class="bi bi-save me-1"></i> {{ __('cms.social_media_links.save') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
