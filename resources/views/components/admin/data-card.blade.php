{{-- Card wrapper for admin index tables / content --}}
<div {{ $attributes->merge(['class' => 'card admin-data-card']) }}>
    <div class="card-body p-0">
        {{ $slot }}
    </div>
</div>
