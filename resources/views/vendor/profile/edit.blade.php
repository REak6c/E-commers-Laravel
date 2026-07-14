@extends('vendor.layouts.master')

@section('content')

{{-- Page Header --}}
<div class="vp-page-header">
    <div class="vp-page-header__left">
        <h1 class="vp-page-header__title">
            <i class="fas fa-user-circle me-2" style="color:var(--vp-primary);font-size:1.1rem;"></i>
            {{ __('cms.profile.title') }}
        </h1>
        <p class="vp-page-header__sub">Update your store details, contact info and password.</p>
    </div>
    <div class="vp-page-header__actions">
        <span class="badge d-inline-flex align-items-center gap-2"
              style="background:var(--vp-primary-bg);color:var(--vp-primary);font-size:.78rem;font-weight:700;
                     padding:7px 14px;border-radius:20px;border:1px solid #c7d2fe;">
            <i class="fas fa-store" style="font-size:.7rem;"></i> Vendor Account
        </span>
    </div>
</div>

<form method="POST" action="{{ route('vendor.profile.update') }}"
      enctype="multipart/form-data" autocomplete="off" id="vendor-profile-form">
@csrf
@method('PATCH')

<div class="row g-4">

    {{-- ===== LEFT COLUMN: Avatar + Danger Zone ===== --}}
    <div class="col-lg-4 col-xl-3">

        {{-- Avatar card --}}
        <div class="vp-card mb-4">
            <div class="vp-card-body" style="padding:28px 24px;text-align:center;">

                {{-- Avatar with camera overlay --}}
                <div style="position:relative;display:inline-block;margin-bottom:16px;">
                    <img id="profilePreview"
                         src="{{ $vendor->profile_image
                             ? (\Illuminate\Support\Str::startsWith($vendor->profile_image, ['http://', 'https://'])
                                 ? $vendor->profile_image
                                 : asset('storage/' . $vendor->profile_image))
                             : 'https://ui-avatars.com/api/?name=' . urlencode($vendor->name) . '&background=6366f1&color=fff&size=120' }}"
                         alt="Profile"
                         style="width:110px;height:110px;border-radius:50%;object-fit:cover;
                                border:4px solid var(--vp-primary-bg);
                                box-shadow:0 0 0 3px rgba(99,102,241,0.18),0 4px 16px rgba(0,0,0,0.10);">

                    <label for="profile_image"
                           style="position:absolute;bottom:4px;right:4px;width:32px;height:32px;
                                  border-radius:50%;background:var(--vp-primary);color:#fff;
                                  display:flex;align-items:center;justify-content:center;
                                  cursor:pointer;font-size:0.75rem;
                                  border:2px solid #fff;
                                  box-shadow:0 2px 8px rgba(99,102,241,0.35);
                                  transition:background 0.18s;"
                           title="{{ __('cms.profile.choose_file') }}"
                           onmouseover="this.style.background='#4f46e5'"
                           onmouseout="this.style.background='var(--vp-primary)'">
                        <i class="fas fa-camera"></i>
                    </label>
                    <input type="file" id="profile_image" name="profile_image"
                           accept="image/*" class="d-none">
                </div>

                @error('profile_image')
                    <div class="vp-error justify-content-center mb-2">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror

                <h5 style="font-size:1rem;font-weight:700;color:var(--vp-text);margin:0 0 4px;">
                    {{ $vendor->name }}
                </h5>
                <p style="font-size:0.78rem;color:var(--vp-text-muted);margin:0;">
                    {{ $vendor->email }}
                </p>

            </div>
        </div>

        {{-- Danger Zone --}}
        <div class="vp-danger-zone">
            <p class="vp-danger-zone__title">
                <i class="fas fa-exclamation-triangle"></i>
                Danger Zone
            </p>
            <p class="vp-danger-zone__text">
                Once you delete your account, there is no going back. Please be certain.
            </p>
            <button type="button" class="vp-btn-danger"
                    onclick="if(confirm('{{ __('cms.profile.delete_confirm') }}')) document.getElementById('delete-account-form').submit();">
                <i class="fas fa-trash-alt"></i>
                {{ __('cms.profile.delete_account') }}
            </button>
        </div>

    </div>

    {{-- ===== RIGHT COLUMN: Details + Password ===== --}}
    <div class="col-lg-8 col-xl-9">

        {{-- Personal Details card --}}
        <div class="vp-card mb-4">
            <div class="vp-card-header">
                <h6 class="vp-card-header__title">
                    <span class="vp-card-header__icon"><i class="fas fa-user"></i></span>
                    Personal Details
                </h6>
            </div>
            <div class="vp-card-body">
                <div class="row g-3">

                    {{-- Name --}}
                    <div class="col-md-6">
                        <div class="vp-form-group" style="margin-bottom:0;">
                            <label class="vp-label" for="name">
                                {{ __('cms.profile.name') }} <span class="required">*</span>
                            </label>
                            <div class="vp-input-group">
                                <span class="vp-input-group-icon"><i class="fas fa-user"></i></span>
                                <input type="text" id="name" name="name"
                                       class="vp-input @error('name') is-invalid @enderror"
                                       value="{{ old('name', $vendor->name) }}"
                                       placeholder="{{ __('cms.profile.name') }}" required>
                            </div>
                            @error('name')
                                <div class="vp-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6">
                        <div class="vp-form-group" style="margin-bottom:0;">
                            <label class="vp-label" for="email">
                                {{ __('cms.profile.email') }} <span class="required">*</span>
                            </label>
                            <div class="vp-input-group">
                                <span class="vp-input-group-icon"><i class="fas fa-envelope"></i></span>
                                <input type="email" id="email" name="email"
                                       class="vp-input @error('email') is-invalid @enderror"
                                       value="{{ old('email', $vendor->email) }}"
                                       placeholder="{{ __('cms.profile.email') }}" required>
                            </div>
                            @error('email')
                                <div class="vp-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Phone --}}
                    <div class="col-12">
                        <div class="vp-form-group" style="margin-bottom:0;">
                            <label class="vp-label" for="phone">{{ __('cms.profile.phone') }}</label>
                            <div class="vp-input-group">
                                <span class="vp-input-group-icon"><i class="fas fa-phone"></i></span>
                                <input type="text" id="phone" name="phone"
                                       class="vp-input @error('phone') is-invalid @enderror"
                                       value="{{ old('phone', $vendor->phone) }}"
                                       placeholder="{{ __('cms.profile.phone') }}">
                            </div>
                            @error('phone')
                                <div class="vp-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Security & Password card --}}
        <div class="vp-card mb-4">
            <div class="vp-card-header">
                <h6 class="vp-card-header__title">
                    <span class="vp-card-header__icon"
                          style="background:#f0fdf4;color:#16a34a;">
                        <i class="fas fa-shield-alt"></i>
                    </span>
                    Security &amp; Password
                </h6>
                <span style="font-size:0.72rem;color:var(--vp-text-muted);">
                    Leave blank to keep current password
                </span>
            </div>
            <div class="vp-card-body">
                <div class="row g-3">

                    {{-- Current Password --}}
                    <div class="col-12">
                        <div class="vp-form-group" style="margin-bottom:0;">
                            <label class="vp-label" for="current_password">
                                {{ __('cms.profile.current_password') }}
                            </label>
                            <div class="vp-input-group">
                                <span class="vp-input-group-icon"><i class="fas fa-lock"></i></span>
                                <input type="password" id="current_password" name="current_password"
                                       class="vp-input @error('current_password') is-invalid @enderror"
                                       placeholder="{{ __('cms.profile.current_password') }}">
                            </div>
                            @error('current_password')
                                <div class="vp-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- New Password --}}
                    <div class="col-md-6">
                        <div class="vp-form-group" style="margin-bottom:0;">
                            <label class="vp-label" for="password">
                                {{ __('cms.profile.new_password') }}
                            </label>
                            <div class="vp-input-group">
                                <span class="vp-input-group-icon"><i class="fas fa-key"></i></span>
                                <input type="password" id="password" name="password"
                                       class="vp-input @error('password') is-invalid @enderror"
                                       placeholder="{{ __('cms.profile.new_password') }}">
                            </div>
                            @error('password')
                                <div class="vp-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Confirm Password --}}
                    <div class="col-md-6">
                        <div class="vp-form-group" style="margin-bottom:0;">
                            <label class="vp-label" for="password_confirmation">
                                {{ __('cms.profile.confirm_new_password') }}
                            </label>
                            <div class="vp-input-group">
                                <span class="vp-input-group-icon"><i class="fas fa-key"></i></span>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                       class="vp-input @error('password_confirmation') is-invalid @enderror"
                                       placeholder="{{ __('cms.profile.confirm_new_password') }}">
                            </div>
                            @error('password_confirmation')
                                <div class="vp-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="d-flex justify-content-end">
            <button type="submit" class="vp-btn-save" id="saveProfileBtn">
                <span class="spinner-border spinner-border-sm d-none" id="profileLoader" role="status"></span>
                <i class="fas fa-check-circle" id="saveIcon"></i>
                {{ __('cms.profile.save') }}
            </button>
        </div>

    </div>
</div>

</form>

<form id="delete-account-form" action="{{ route('vendor.profile.destroy') }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>

@endsection

@section('js')
@if (session('success'))
<script>
    toastr.success("{{ session('success') }}", "{{ __('cms.profile.success') }}", {
        closeButton: true, progressBar: true, positionClass: "toast-top-right", timeOut: 5000
    });
</script>
@endif

<script>
document.addEventListener('DOMContentLoaded', function () {

    // Submit loader
    const form   = document.getElementById('vendor-profile-form');
    const btn    = document.getElementById('saveProfileBtn');
    const loader = document.getElementById('profileLoader');
    const icon   = document.getElementById('saveIcon');

    form.addEventListener('submit', function () {
        btn.disabled = true;
        loader.classList.remove('d-none');
        icon.classList.add('d-none');
    });

    // Live avatar preview
    document.getElementById('profile_image').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = ev => {
                document.getElementById('profilePreview').src = ev.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

});
</script>
@endsection
