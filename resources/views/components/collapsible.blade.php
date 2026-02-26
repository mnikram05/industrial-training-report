@props([
    'open' => false,
])

<div x-data="{ open: @js((bool) $open) }" {{ $attributes }}>
    {{ $slot }}
</div>
