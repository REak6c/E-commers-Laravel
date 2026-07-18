@extends('admin.layouts.admin')

@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">{{ 'Create Menu Item' }}</h4>
            <a href="{{ route('admin.menus.index') }}" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> {{ 'Back' }}
            </a>
        </div>
    </div>
</div>

<form action="{{ route('admin.menus.items.store', $menu->id) }}" method="POST">
    @csrf

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    @if(session('error'))
                    <div id="errorBar" class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="mb-0">
                        <label class="form-label fw-semibold">{{ 'Title' }}</label>
                        <input type="text" name="title[en]"
                            class="form-control border-0 bg-light @error('title.en') is-invalid @enderror"
                            value="{{ old('title.en') }}" placeholder="{{ 'Menu item title' }}">
                        @error('title.en')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">{{ 'Configuration' }}</h6>
                    <div class="row">
                        <x-admin.combobox
                            name="parent_id"
                            id="parent_id"
                            wrapper-class="col-md-6 mb-3"
                            :label="'Parent Item'"
                            :placeholder="'None (Top Level)'"
                            :options="$menu->menuItems"
                            option-label="title"
                            option-label-fallback="No Title" />

                        <div class="col-md-6 mb-3">
                            <label for="order_number" class="form-label fw-semibold">{{ 'Order' }}</label>
                            <input type="number" name="order_number" id="order_number"
                                class="form-control border-0 bg-light @error('order_number') is-invalid @enderror"
                                value="{{ old('order_number') }}" placeholder="0">
                            @error('order_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">{{ 'Menu' }}</h6>

                    <x-admin.combobox
                        name="menu_id"
                        id="menu_id"
                        wrapper-class="mb-4"
                        :label="'Select Menu'"
                        :selected="$menu->id"
                        :placeholder="'Select Menu'"
                        :placeholder-disabled="true"
                        :options="$menus"
                        option-label="title"
                        required />

                    <div class="d-grid pt-2">
                        <button type="submit" class="btn btn-primary shadow-sm py-2">
                            <i class="bi bi-plus-lg me-1"></i> {{ 'Create Item' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
