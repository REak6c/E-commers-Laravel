@extends('admin.layouts.admin')

@section('content')
<div class="row justify-content-center my-4">
    <div class="col-lg-10 col-xl-9">
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
            <!-- Card Header -->
            <div class="card-header bg-dark text-white py-3 px-4 d-flex justify-content-between align-items-center" 
                 style="background: linear-gradient(135deg, #1e293b, #0f172a);">
                <h5 class="mb-0 fw-bold d-flex align-items-center">
                    <i class="bi bi-person-circle me-2 fs-4"></i>
                    {{ 'My Profile' }}
                </h5>
                <span class="badge bg-danger px-3 py-2 rounded-pill">{{ 'Administrator' }}</span>
            </div>

            <div class="card-body p-4 bg-light-subtle">
                <form method="POST" action="{{ route('admin.profile.update') }}" 
                      enctype="multipart/form-data" autocomplete="off" id="admin-profile-form">
                    @csrf
                    @method('PATCH')

                    <!-- Two-Column Grid -->
                    <div class="row g-4">
                        
                        <!-- Left Column: Avatar & Danger Zone -->
                        <div class="col-md-5 col-lg-4 text-center border-end pe-md-4">
                            <!-- Profile Image Container -->
                            <div class="position-relative d-inline-block mb-3">
                                <img id="profilePreview"
                                     src="{{ $admin->profile_image
                                         ? (\Illuminate\Support\Str::startsWith($admin->profile_image, ['http://', 'https://'])
                                             ? $admin->profile_image
                                             : asset('storage/' . $admin->profile_image))
                                         : 'https://ui-avatars.com/api/?name=' . urlencode($admin->name) . '&background=0d6efd&color=fff&size=120' }}"
                                     alt="Profile"
                                     class="rounded-circle shadow img-thumbnail"
                                     style="width: 130px; height: 130px; object-fit: cover; transition: 0.3s; border: 4px solid #fff;">
                                
                                <label for="profile_image" class="btn btn-primary btn-sm rounded-circle position-absolute bottom-0 end-0 shadow d-flex align-items-center justify-content-center" 
                                       style="width: 36px; height: 36px; cursor: pointer;" title="{{ 'Choose Photo' }}">
                                    <i class="bi bi-camera-fill fs-6"></i>
                                </label>
                                <input type="file" id="profile_image" name="profile_image" accept="image/*" class="d-none">
                            </div>

                            @error('profile_image')
                                <div class="text-danger small mb-3">{{ $message }}</div>
                            @enderror

                            <h5 class="fw-bold mb-1 text-dark">{{ $admin->name }}</h5>
                            <p class="text-muted small mb-4">{{ $admin->email }}</p>

                            <!-- Danger Zone -->
                            <div class="card border-danger mt-4 bg-danger-subtle rounded-3 text-start">
                                <div class="card-body p-3">
                                    <h6 class="text-danger fw-bold mb-2 d-flex align-items-center">
                                        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ 'Danger Zone' }}
                                    </h6>
                                    <p class="text-muted small mb-3" style="font-size: 12px; line-height: 1.4;">
                                        {{ 'Deleting your account is permanent and cannot be undone.' }}
                                    </p>
                                    <button type="button" class="btn btn-danger btn-sm rounded-pill w-100"
                                            onclick="if(confirm('{{ 'Are you sure you want to delete your account?' }}')) document.getElementById('delete-account-form').submit();">
                                        <i class="bi bi-trash-fill me-1"></i>{{ 'Delete Account' }}
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Personal details & Password -->
                        <div class="col-md-7 col-lg-8">
                            <h6 class="fw-bold mb-3 text-dark border-bottom pb-2">
                                <i class="bi bi-person-lines-fill me-2"></i>{{ 'Personal Details' }}
                            </h6>

                            <!-- Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold text-secondary small mb-1">{{ 'Full Name' }}</label>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control border-start-0" id="name" name="name" 
                                           value="{{ old('name', $admin->name) }}" placeholder="{{ 'Full Name' }}" required>
                                </div>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold text-secondary small mb-1">{{ 'Email Address' }}</label>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control border-start-0" id="email" name="email" 
                                           value="{{ old('email', $admin->email) }}" placeholder="{{ 'Email Address' }}" required>
                                </div>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="mb-3">
                                <label for="phone" class="form-label fw-semibold text-secondary small mb-1">{{ 'Phone Number' }}</label>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-telephone"></i></span>
                                    <input type="text" class="form-control border-start-0" id="phone" name="phone" 
                                           value="{{ old('phone', $admin->phone) }}" placeholder="{{ 'Phone Number' }}">
                                </div>
                                @error('phone')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Change Password Section -->
                            <div class="card border-0 bg-light rounded-3 p-3 mt-4 border-start border-primary border-3 shadow-sm">
                                <h6 class="fw-bold mb-3 text-primary d-flex align-items-center">
                                    <i class="bi bi-shield-lock me-2"></i>{{ 'Change Password' }}
                                </h6>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="current_password" class="form-label fw-semibold text-secondary small mb-1">{{ 'Current Password' }}</label>
                                        <div class="input-group shadow-sm">
                                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-lock-fill"></i></span>
                                            <input type="password" class="form-control border-start-0" id="current_password" name="current_password" 
                                                   placeholder="{{ 'Current Password' }}">
                                        </div>
                                        @error('current_password')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="password" class="form-label fw-semibold text-secondary small mb-1">{{ 'New Password' }}</label>
                                        <div class="input-group shadow-sm">
                                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-key-fill"></i></span>
                                            <input type="password" class="form-control border-start-0" id="password" name="password" 
                                                   placeholder="{{ 'New Password' }}">
                                        </div>
                                        @error('password')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="password_confirmation" class="form-label fw-semibold text-secondary small mb-1">{{ 'Confirm New Password' }}</label>
                                        <div class="input-group shadow-sm">
                                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-key-fill"></i></span>
                                            <input type="password" class="form-control border-start-0" id="password_confirmation" name="password_confirmation" 
                                                   placeholder="{{ 'Confirm New Password' }}">
                                        </div>
                                        @error('password_confirmation')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Save Button -->
                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill d-inline-flex align-items-center shadow-sm" id="saveProfileBtn">
                                    <span class="spinner-border spinner-border-sm me-2 d-none" id="profileLoader" role="status"></span>
                                    <i class="bi bi-check-circle-fill me-2"></i>
                                    {{ 'Save Changes' }}
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<form id="delete-account-form" action="{{ route('admin.profile.destroy') }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('admin-profile-form');
    const btn = document.getElementById('saveProfileBtn');
    const loader = document.getElementById('profileLoader');
    form.addEventListener('submit', function() {
        btn.setAttribute('disabled', 'disabled');
        loader.classList.remove('d-none');
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('profile_image');
    const previewImg = document.getElementById('profilePreview');

    fileInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endsection
