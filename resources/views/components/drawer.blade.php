@props([
    'open' => false,
])

<div x-data="{ open: @js((bool) $open) }" @keydown.escape.window="open = false" {{ $attributes }}>
    {{ $slot }}
</div>
