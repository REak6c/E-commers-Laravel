@props([
    'name',
    'label'             => null,
    'options'           => [],
    'selected'          => null,
    'placeholder'       => 'Select option',
    'optionValue'       => 'id',
    'optionLabel'       => 'name',
    'optionLabelFallback' => '—',
    'error'             => null,
    'wrapperClass'      => 'mb-4',
    'required'          => false,
    'searchPlaceholder' => null,
])

@php
    $fieldKey     = $error ?? str_replace(['[', ']'], ['.', ''], $name);
    $fieldKey     = trim($fieldKey, '.');
    $hasError     = $errors->has($fieldKey);
    $currentValue = old($fieldKey, $selected);

    // Normalise into [['value' => …, 'label' => …], …]
    // Use $optVal / $optLbl so we never overwrite the $label prop
    $normalizedOptions = [];
    foreach ($options as $optionKey => $option) {
        if (is_object($option) || is_array($option)) {
            $optVal = data_get($option, $optionValue);
            $optLbl = data_get($option, $optionLabel) ?? $optionLabelFallback;
        } else {
            $optVal = $optionKey;
            $optLbl = $option;
        }
        $normalizedOptions[] = ['value' => (string) $optVal, 'label' => (string) $optLbl];
    }

    // Resolve selected label for the trigger button
    $selectedLabel = null;
    foreach ($normalizedOptions as $nOpt) {
        if ((string) $currentValue === $nOpt['value']) {
            $selectedLabel = $nOpt['label'];
            break;
        }
    }

    $uid      = 'cb-' . Str::random(8);
    $searchPh = $searchPlaceholder ?? 'Search ' . strtolower($label ?? 'options') . '…';
@endphp

<div @class([$wrapperClass => filled($wrapperClass)])>

    @if ($label)
        <label for="{{ $uid }}-trigger" class="vp-label">
            {{ $label }}
            @if ($required) <span class="required">*</span> @endif
        </label>
    @endif

    {{-- Hidden input — submitted with the form --}}
    <input type="hidden" name="{{ $name }}" id="{{ $uid }}-value"
           value="{{ $currentValue ?? '' }}">

    {{-- Combobox shell — JS reads options from window.__cbOpts --}}
    <div class="adm-combobox"
         id="{{ $uid }}"
         data-cb-id="{{ $uid }}"
         data-value-input="{{ $uid }}-value">

        <button type="button"
                class="adm-combobox__trigger @if($hasError) is-invalid @endif"
                id="{{ $uid }}-trigger"
                aria-haspopup="listbox"
                aria-expanded="false"
                aria-controls="{{ $uid }}-panel"
                @if ($hasError) aria-invalid="true" @endif>
            <span class="adm-combobox__label @if(!$selectedLabel) adm-combobox__label--placeholder @endif">
                {{ $selectedLabel ?? $placeholder }}
            </span>
            <svg class="adm-combobox__chevron" width="16" height="16" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
        </button>

        <div class="adm-combobox__panel" id="{{ $uid }}-panel" hidden role="listbox">
            <div class="adm-combobox__search-wrap">
                <svg class="adm-combobox__search-icon" width="14" height="14" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2.5"
                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" class="adm-combobox__search"
                       id="{{ $uid }}-search"
                       placeholder="{{ $searchPh }}"
                       autocomplete="off"
                       aria-label="{{ $searchPh }}">
            </div>
            <div class="adm-combobox__options" id="{{ $uid }}-options"></div>
            <p class="adm-combobox__empty" id="{{ $uid }}-empty" hidden>No results found</p>
        </div>
    </div>

    {{-- Pass options via a JS variable — zero HTML-encoding ambiguity --}}
    <script>
        window.__cbOpts = window.__cbOpts || {};
        window.__cbOpts["{{ $uid }}"] = {!! Js::from($normalizedOptions) !!};
    </script>

    @error($fieldKey)
        <div class="vp-error">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
            {{ $message }}
        </div>
    @enderror
</div>
