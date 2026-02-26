@props([
    'variant' => 'default',
])

@php
    $variantClasses = match ($variant) {
        'outline' => 'border border-border bg-card shadow-xs',
        'muted' => 'bg-muted/50',
        default => 'bg-transparent',
    };
@endphp

<div
    {{ $attributes->merge(['class' => "rounded-[min(var(--radius-md),12px)] px-2 py-1.5 text-sm {$variantClasses}"]) }}>
    {{ $slot }}
</div>
