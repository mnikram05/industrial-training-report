@props([
    'type' => 'single',
    'value' => null,
])

<div x-data="{ accordionValue: @js($value) }" data-type="{{ $type }}" {{ $attributes->merge(['class' => 'w-full']) }}>
    {{ $slot }}
</div>
