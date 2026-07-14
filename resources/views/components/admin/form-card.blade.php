@props(['title' => null])

<div {{ $attributes->merge(['class' => 'card admin-card']) }}>
    @if ($title)
        <div class="card-header admin-card__header">{{ $title }}</div>
    @endif
    <div class="card-body">
        {{ $slot }}
    </div>
    @isset($footer)
        <div class="card-footer admin-card__footer">{{ $footer }}</div>
    @endisset
</div>
