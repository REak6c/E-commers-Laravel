@extends('admin.layouts.admin')

@section('content')

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">{{ __('cms.menu_items.edit') }}</h4>
            <a href="{{ route('admin.menus.index') }}" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> {{ __('cms.common.back') ?? 'Back' }}
            </a>
        </div>
    </div>
</div>

<form action="{{ route('admin.items.update', $menuItem->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    @if(session('error'))
                    <div id="errorBar" class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="mb-0">
                        <label class="form-label fw-semibold">{{ __('cms.menu_items.title') }}</label>
                        <input type="text" name="title[en]"
                            class="form-control border-0 bg-light @error('title.en') is-invalid @enderror"
                            value="{{ old('title.en', $menuItem->title) }}"
                            required placeholder="{{ __('cms.menu_items.title_placeholder') }}">
                        @error('title.en')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">{{ __('cms.menu_items.item_configuration') }}</h6>
                    <div class="row">
                        <x-admin.select
                            name="parent_id"
                            id="parent_id"
                            wrapper-class="col-md-6 mb-3"
                            :label="__('cms.menu_items.parent_item')"
                            :selected="$menuItem->parent_id"
                            :placeholder="__('cms.menu_items.parent_none')"
                            :options="$menuItem->menu->menuItems"
                            option-label="title"
                            option-label-fallback="No Title" />

                        <div class="col-md-6 mb-3">
                            <label for="order_number" class="form-label fw-semibold">{{ __('cms.menu_items.order_number') }}</label>
                            <input type="number" name="order_number" id="order_number"
                                class="form-control border-0 bg-light @error('order_number') is-invalid @enderror"
                                value="{{ old('order_number', $menuItem->order_number) }}" required placeholder="0">
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
                    <h6 class="fw-bold mb-3">{{ __('cms.menu_items.menu_selection') }}</h6>

                    <x-admin.select
                        name="menu_id"
                        id="menu_id"
                        wrapper-class="mb-4"
                        :label="__('cms.menu_items.select_menu')"
                        :selected="$menuItem->menu_id"
                        :options="$menus"
                        option-label="title"
                        required />

                    <div class="d-grid pt-2">
                        <button type="submit" class="btn btn-primary shadow-sm py-2">
                            <i class="bi bi-save me-1"></i> {{ __('cms.menu_items.update_button') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
