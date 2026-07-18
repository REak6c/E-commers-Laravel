@extends('admin.layouts.admin')

@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">{{ 'Site Settings' }}</h4>
        </div>
    </div>
</div>

<form action="{{ route('admin.site-settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4">{{ 'General Configuration' }}</h6>

                    @if (session('success'))
                    <div class="alert alert-success border-0 shadow-sm mb-4">
                        {{ session('success') }}
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="site_name" class="form-label fw-semibold">{{ 'Site Name' }}</label>
                            <input type="text" name="site_name" class="form-control border-0 bg-light"
                                value="{{ old('site_name', $settings->site_name ?? '') }}" required
                                placeholder="e.g. My E-commerce">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tagline" class="form-label fw-semibold">{{ 'Tagline' }}</label>
                            <input type="text" name="tagline" class="form-control border-0 bg-light"
                                value="{{ old('tagline', $settings->tagline ?? '') }}"
                                placeholder="e.g. Best products online">
                        </div>
                    </div>

                    <div class="mb-3 mt-2">
                        <label for="footer_text" class="form-label fw-semibold">{{ 'Footer Text' }}</label>
                        <textarea name="footer_text" rows="3" class="form-control border-0 bg-light"
                            placeholder="Copy right information...">{{ old('footer_text', $settings->footer_text ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4">{{ 'SEO Settings' }}</h6>

                    <div class="mb-3">
                        <label for="meta_title" class="form-label fw-semibold">{{ 'Meta Title' }}</label>
                        <input type="text" name="meta_title" class="form-control border-0 bg-light"
                            value="{{ old('meta_title', $settings->meta_title ?? '') }}"
                            placeholder="Search engine title">
                    </div>

                    <div class="mb-3">
                        <label for="meta_keywords" class="form-label fw-semibold">{{ 'Meta Keywords' }}</label>
                        <input type="text" name="meta_keywords" class="form-control border-0 bg-light"
                            value="{{ old('meta_keywords', $settings->meta_keywords ?? '') }}"
                            placeholder="keyword1, keyword2, ...">
                    </div>

                    <div class="mb-0">
                        <label for="meta_description" class="form-label fw-semibold">{{ 'Meta Description' }}</label>
                        <textarea name="meta_description" rows="3" class="form-control border-0 bg-light"
                            placeholder="Brief description for search engines...">{{ old('meta_description', $settings->meta_description ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            {{-- Logo Upload --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">{{ 'Site Logo' }}</h6>

                    <div class="text-center mb-3">
                        <div id="logo_preview_wrap" class="{{ $settings->logo ? '' : 'd-none' }}">
                            <img id="logo_preview_img"
                                 src="{{ $settings->logo ? (\Illuminate\Support\Str::startsWith($settings->logo, ['http://','https://']) ? $settings->logo : asset('storage/' . $settings->logo)) : '' }}"
                                 class="img-fluid rounded shadow-sm mb-2"
                                 style="max-height:120px;">
                        </div>
                        <div id="logo_placeholder" class="bg-light rounded py-4 border border-2 border-dashed {{ $settings->logo ? 'd-none' : '' }}" style="cursor:pointer;"
                             onclick="document.getElementById('logo_input').click()">
                            <i class="bi bi-image text-muted" style="font-size:2rem;"></i>
                            <p class="text-muted small mt-2 mb-0">Click to upload logo</p>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="button" class="btn btn-outline-secondary btn-sm"
                                onclick="document.getElementById('logo_input').click()">
                            <i class="bi bi-upload me-1"></i> Change Logo
                        </button>
                    </div>
                    <p class="text-muted small mt-2 mb-0">Recommended: PNG or SVG, max 2 MB</p>
                </div>
            </div>
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4">{{ 'Contact Information' }}</h6>

                    <div class="mb-3">
                        <label for="contact_email" class="form-label fw-semibold">{{ 'Contact Email' }}</label>
                        <input type="email" name="contact_email" class="form-control border-0 bg-light"
                            value="{{ old('contact_email', $settings->contact_email ?? '') }}"
                            placeholder="support@example.com">
                    </div>

                    <div class="mb-3">
                        <label for="contact_phone" class="form-label fw-semibold">{{ 'Contact Phone' }}</label>
                        <input type="text" name="contact_phone" class="form-control border-0 bg-light"
                            value="{{ old('contact_phone', $settings->contact_phone ?? '') }}"
                            placeholder="+855 12 345 678">
                    </div>

                    <div class="mb-0">
                        <label for="address" class="form-label fw-semibold">{{ 'Address' }}</label>
                        <textarea name="address" rows="3" class="form-control border-0 bg-light"
                            placeholder="Physical store address...">{{ old('address', $settings->address ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">{{ 'Actions' }}</h6>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary shadow-sm py-2">
                            <i class="bi bi-save me-1"></i> {{ 'Save Settings' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
(function () {
    const input = document.createElement('input');
    input.type = 'file';
    input.id = 'logo_input';
    input.name = 'logo';
    input.accept = 'image/*';
    input.style.display = 'none';
    document.querySelector('form').appendChild(input);

    input.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function (e) {
            const img = document.getElementById('logo_preview_img');
            const wrap = document.getElementById('logo_preview_wrap');
            const placeholder = document.getElementById('logo_placeholder');
            img.src = e.target.result;
            wrap.classList.remove('d-none');
            placeholder.classList.add('d-none');
        };
        reader.readAsDataURL(file);
    });
})();
</script>
@endpush
