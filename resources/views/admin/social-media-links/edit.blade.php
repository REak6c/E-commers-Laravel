@extends('admin.layouts.admin')

@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">{{ 'Edit Social Media Link' }}</h4>
            <a href="{{ route('admin.social-media-links.index') }}" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> {{ 'Back' }}
            </a>
        </div>
    </div>
</div>

<form action="{{ route('admin.social-media-links.update', $socialMediaLink->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4">Link Information</h6>

                    @if(session('error'))
                    <div id="errorBar" class="alert alert-danger" role="alert">{{ session('error') }}</div>
                    @endif

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="platform" class="form-label fw-semibold">{{ 'Platform' }}</label>
                            <input type="text" name="platform" id="platform"
                                class="form-control border-0 bg-light @error('platform') is-invalid @enderror"
                                value="{{ old('platform', $socialMediaLink->platform) }}" required
                                placeholder="e.g. Facebook Page">
                            @error('platform')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="link" class="form-label fw-semibold">{{ 'Link URL' }}</label>
                            <input type="url" name="link" id="link"
                                class="form-control border-0 bg-light @error('link') is-invalid @enderror"
                                value="{{ old('link', $socialMediaLink->link) }}" required
                                placeholder="https://facebook.com/yourpage">
                            @error('link')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                        <label class="form-label fw-semibold">{{ 'Platform Name' }}</label>
                        <input type="text" name="name"
                            class="form-control border-0 bg-light @error('name') is-invalid @enderror"
                            value="{{ old('name', $socialMediaLink->name ?? '') }}"
                            required placeholder="Platform name">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">Settings</h6>

                    <x-admin.combobox
                        name="type"
                        id="type"
                        wrapper-class="mb-4"
                        :label="'Type'"
                        :selected="$socialMediaLink->type"
                        :placeholder="'Select Type'"
                        :placeholder-disabled="true"
                        required
                        :options="[
                            'facebook' => 'Facebook',
                            'instagram' => 'Instagram',
                            'tiktok' => 'TikTok',
                            'youtube' => 'YouTube',
                            'x' => 'X (Twitter)',
                        ]" />

                    <div class="d-grid pt-2">
                        <button type="submit" class="btn btn-primary shadow-sm py-2">
                            <i class="bi bi-save me-1"></i> {{ 'Update Link' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
