@props([
    'title',
    'createRoute' => null,
    'createLabel' => null,
])

<div class="admin-page-header">
    <div>
        <h1 class="admin-page-header__title">{{ $title }}</h1>
        @isset($subtitle)
            <p class="admin-page-header__subtitle">{{ $subtitle }}</p>
        @endisset
    </div>
    <div class="admin-page-header__actions">
        {{ $actions ?? '' }}
        @if ($createRoute)
            <a href="{{ $createRoute }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i> {{ $createLabel ?? __('Add New') }}
            </a>
        @endif
    </div>
</div>
