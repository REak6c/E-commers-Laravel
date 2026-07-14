@extends('admin.layouts.admin')

@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">{{ __('cms.menus.edit_menu') }}</h4>
            <a href="{{ route('admin.menus.index') }}" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> {{ __('cms.common.back') ?? 'Back' }}
            </a>
        </div>
    </div>
</div>

<form action="{{ route('admin.menus.update', $menu->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    @if(session('error'))
                    <div id="errorBar" class="alert alert-danger" role="alert">{{ session('error') }}</div>
                    @endif

                    <div class="mb-0">
                        <label for="title" class="form-label fw-semibold">{{ __('cms.menus.menu_title') }}</label>
                        <input type="text" name="title" id="title" class="form-control border-0 bg-light @error('title') is-invalid @enderror"
                            value="{{ old('title', $menu->title) }}" required placeholder="e.g. Header Menu">
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">{{ __('cms.menus.actions') }}</h6>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary shadow-sm py-2">
                            <i class="bi bi-save me-1"></i> {{ __('cms.menus.button_update') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
