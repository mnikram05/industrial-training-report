@props([
    'module' => false,
])

@php
    $baseClasses = $module
        ? 'bg-card text-card-foreground flex flex-col rounded-xl border border-border/80 shadow-card ring-1 ring-black/[0.03] dark:border-border dark:shadow-card-dark dark:ring-white/[0.06]'
        : 'bg-card text-card-foreground flex flex-col rounded-xl border shadow-sm';
    $spacingClasses = $module ? 'w-full max-w-none gap-6 p-6' : 'gap-6 py-6';
@endphp

<div {{ $attributes->class([$baseClasses, $spacingClasses]) }}>
    {{ $slot }}
</div>
