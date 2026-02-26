@props([
    'value' => null,
])

@php
    $resolvedValue = $value ?? uniqid('accordion_', false);
@endphp

<div x-data="{ itemValue: '{{ $resolvedValue }}' }" data-value="{{ $resolvedValue }}"
    {{ $attributes->merge(['class' => 'border-b last:border-b-0']) }}>
    {{ $slot }}
</div>
