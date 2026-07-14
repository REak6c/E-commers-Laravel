@extends('themes.xylo.layouts.master')

@section('content')
<section class="xsf-section">
    <div class="container">
        <div class="xsf-listing-head">
            <h1 class="xsf-listing-head__title">{{ __('store.profile.title') }}</h1>
        </div>

        <div class="row g-4">
            {{-- Account nav --}}
            <aside class="col-lg-3">
                <nav class="xsf-account-nav">
                    <a href="{{ route('customer.profile.edit') }}" class="xsf-account-nav__link is-active">
                        <i class="fa-solid fa-user-gear" aria-hidden="true"></i> {{ __('store.profile.title') }}
                    </a>
                    <a href="{{ route('customer.wishlist.index') }}" class="xsf-account-nav__link">
                        <i class="fa-regular fa-heart" aria-hidden="true"></i> {{ __('store.footer.wishlist') ?? 'Wishlist' }}
                    </a>
                    <a href="{{ route('xylo.home') }}" class="xsf-account-nav__link">
                        <i class="fa-solid fa-bag-shopping" aria-hidden="true"></i> {{ __('store.home.view_all') ?? 'Continue Shopping' }}
                    </a>
                    <a href="{{ route('customer.logout') }}" class="xsf-account-nav__link text-danger"
                        onclick="event.preventDefault(); document.getElementById('account-logout-form').submit();">
                        <i class="fa-solid fa-arrow-right-from-bracket" aria-hidden="true"></i> {{ __('store.header.logout') ?? 'Logout' }}
                    </a>
                    <form id="account-logout-form" action="{{ route('customer.logout') }}" method="POST" class="d-none">@csrf</form>
                </nav>
            </aside>

            {{-- Profile form --}}
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data" id="customer-profile-form">
                            @csrf
                            @method('PUT')

                            <div class="row g-4">
                                {{-- Avatar + danger zone --}}
                                <div class="col-md-4 text-center">
                                    <div class="xsf-account-avatar">
                                        <img id="profilePreview"
                                            src="{{ $customer->profile_image ? asset('storage/' . $customer->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($customer->name) . '&background=0D8ABC&color=fff&size=120' }}"
                                            alt="Profile">
                                        <label for="profile_image" class="xsf-account-avatar__btn" title="{{ __('store.profile.choose_file') }}">
                                            <i class="fa-solid fa-camera" aria-hidden="true"></i>
                                        </label>
                                        <input type="file" id="profile_image" name="profile_image" accept="image/*" class="d-none">
                                    </div>
                                    @error('profile_image')<div class="text-danger small mb-2">{{ $message }}</div>@enderror

                                    <h2 class="h6 fw-bold mb-0 mt-3">{{ $customer->name }}</h2>
                                    <p class="text-muted small">{{ $customer->email }}</p>

                                    <div class="xsf-danger-zone">
                                        <h3 class="xsf-danger-zone__title"><i class="fa-solid fa-triangle-exclamation me-1"></i>{{ __('store.profile.danger_zone') ?? 'Danger Zone' }}</h3>
                                        <p class="xsf-danger-zone__text">{{ __('store.profile.danger_text') ?? 'Once you delete your account, there is no going back.' }}</p>
                                        <button type="button" class="btn btn-danger btn-sm btn-pill w-100"
                                            onclick="if(confirm('{{ __('store.profile.delete_confirm') }}')) document.getElementById('delete-account-form').submit();">
                                            <i class="fa-solid fa-trash-can me-1"></i>{{ __('store.profile.delete_account') }}
                                        </button>
                                    </div>
                                </div>

                                {{-- Details --}}
                                <div class="col-md-8">
                                    <h3 class="xsf-account-section-title">{{ __('store.profile.personal_details') ?? 'Personal Details' }}</h3>

                                    <div class="mb-3">
                                        <label class="form-label">{{ __('store.profile.name') }}</label>
                                        <input type="text" name="name" value="{{ old('name', $customer->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('store.profile.email') }}</label>
                                        <input type="email" name="email" value="{{ old('email', $customer->email) }}" class="form-control @error('email') is-invalid @enderror" required>
                                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('store.profile.phone') }}</label>
                                        <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}" class="form-control @error('phone') is-invalid @enderror">
                                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('store.profile.address') }}</label>
                                        <textarea name="address" rows="2" class="form-control @error('address') is-invalid @enderror">{{ old('address', $customer->address) }}</textarea>
                                        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <h3 class="xsf-account-section-title mt-4">{{ __('store.profile.security') ?? 'Security & Password' }}</h3>
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label">{{ __('store.profile.current_password') }}</label>
                                            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="{{ __('store.profile.current_password') }}">
                                            @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">{{ __('store.profile.new_password') }}</label>
                                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">{{ __('store.profile.confirm_new_password') }}</label>
                                            <input type="password" name="password_confirmation" class="form-control">
                                        </div>
                                    </div>

                                    <div class="text-end mt-4">
                                        <button type="submit" class="btn btn-primary btn-pill px-4">
                                            <i class="fa-solid fa-circle-check me-1"></i>{{ __('store.profile.save') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<form id="delete-account-form" action="{{ route('customer.profile.destroy') }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>
@endsection

@section('js')
@if (session('success'))
    <script>
        toastr.success("{{ session('success') }}", "{{ __('store.profile.success') }}", {
            closeButton: true, progressBar: true, positionClass: "toast-top-right", timeOut: 5000
        });
    </script>
@endif
<script>
document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('profile_image');
    const previewImg = document.getElementById('profilePreview');
    if (fileInput) {
        fileInput.addEventListener('change', e => {
            const file = e.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = ev => previewImg.src = ev.target.result;
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>
@endsection
