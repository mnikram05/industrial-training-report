@props([
    'value' => null,
])

<div x-data="{ tabValue: @js($value) }" {{ $attributes }}>
    {{ $slot }}
</div>
