@props([
    'module' => false,
])

@php
    $baseClasses = 'bg-card text-card-foreground flex flex-col rounded-xl border shadow-sm';
    $spacingClasses = $module ? 'w-full max-w-none gap-6 p-6' : 'gap-6 py-6';
@endphp

<div {{ $attributes->class([$baseClasses, $spacingClasses]) }}>
    {{ $slot }}
</div>
