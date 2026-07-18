@extends('admin.layouts.admin')

@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">{{ 'Create Menu' }}</h4>
            <a href="{{ route('admin.menus.index') }}" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> {{ 'Back' }}
            </a>
        </div>
    </div>
</div>

<form action="{{ route('admin.menus.store') }}" method="POST">
    @csrf

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    @if(session('error'))
                    <div id="errorBar" class="alert alert-danger" role="alert">{{ session('error') }}</div>
                    @endif

                    <div class="mb-0">
                        <label for="title" class="form-label fw-semibold">{{ 'Menu Title' }}</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}"
                            class="form-control border-0 bg-light @error('title') is-invalid @enderror"
                            placeholder="e.g. Header Menu">
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
                    <h6 class="fw-bold mb-3">{{ 'Actions' }}</h6>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary shadow-sm py-2">
                            <i class="bi bi-plus-lg me-1"></i> {{ 'Create Menu' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
