@props([
    'label',
    'value' => 'N/A',
])

<div {{ $attributes }}>
    <h4 class="font-semibold">{{ $label }}</h4>

    <p>{{ filled($value) ? $value : 'N/A' }}</p>
</div>