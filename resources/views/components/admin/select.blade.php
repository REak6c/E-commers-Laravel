@props([
    'name',
    'label' => null,
    'options' => [],
    'selected' => null,
    'placeholder' => null,
    'placeholderValue' => '',
    'placeholderDisabled' => false,
    'optionValue' => 'id',
    'optionLabel' => 'name',
    'optionLabelFallback' => '—',
    'error' => null,
    'wrapperClass' => 'mb-4',
    'labelClass' => 'form-label fw-semibold',
    'selectClass' => 'form-select border-0 bg-light',
    'hint' => null,
    'enhance' => true,
    'search' => null,
])

@php
    // Resolve the key used for old() input and the error bag. Supports names
    // such as "status", "category_id" and "languages[en][name]".
    $fieldKey = $error ?? str_replace(['[', ']'], ['.', ''], $name);
    $fieldKey = trim($fieldKey, '.');

    $hasError = $errors->has($fieldKey);

    // old() takes precedence (e.g. after a failed validation), then the
    // explicit selected value passed in for edit screens.
    $currentValue = old($fieldKey, $selected);

    // Normalise the options into a list of ['value' => ..., 'label' => ...].
    // Accepts an associative array [value => label] or a collection/array of
    // models/arrays (resolved through optionValue / optionLabel paths).
    $normalizedOptions = [];
    foreach ($options as $optionKey => $option) {
        if (is_object($option) || is_array($option)) {
            $value = data_get($option, $optionValue);
            $resolvedLabel = data_get($option, $optionLabel);
            $normalizedOptions[] = [
                'value' => $value,
                'label' => $resolvedLabel ?? $optionLabelFallback,
            ];
        } else {
            $normalizedOptions[] = [
                'value' => $optionKey,
                'label' => $option,
            ];
        }
    }

    $isSelected = fn ($value) => (string) $currentValue === (string) $value;

    $selectId = $attributes->get('id');

    // Marker class picked up by the Tom Select enhancer (resources public
    // asset). Progressive enhancement: the native <select> works if JS is off.
    $classes = trim($selectClass) . ($enhance ? ' admin-select' : '') . ($hasError ? ' is-invalid' : '');
@endphp

<div @class([$wrapperClass => filled($wrapperClass)])>
    @if ($label)
        <label @if ($selectId) for="{{ $selectId }}" @endif class="{{ $labelClass }}">{{ $label }}</label>
    @endif

    <select
        name="{{ $name }}"
        @unless ($enhance) data-no-enhance @endunless
        @if (! is_null($placeholder)) data-placeholder="{{ $placeholder }}" @endif
        @if (! is_null($search)) data-search="{{ $search ? 'true' : 'false' }}" @endif
        {{ $attributes->merge(['class' => $classes]) }}>
        @if (! is_null($placeholder))
            <option value="{{ $placeholderValue }}"
                @disabled($placeholderDisabled)
                @selected($isSelected($placeholderValue))>{{ $placeholder }}</option>
        @endif

        @if (! $slot->isEmpty())
            {{ $slot }}
        @else
            @foreach ($normalizedOptions as $option)
                <option value="{{ $option['value'] }}" @selected($isSelected($option['value']))>{{ $option['label'] }}</option>
            @endforeach
        @endif
    </select>

    @if ($hint)
        <small class="form-text text-muted">{{ $hint }}</small>
    @endif

    @error($fieldKey)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
