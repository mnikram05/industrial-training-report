@props([
    'variant' => 'default',
    'inline' => false,
])

@php
    $variantClasses = match ($variant) {
        'destructive'
            => 'text-destructive bg-card [&>svg]:text-current *:data-[slot=alert-description]:text-destructive/90',
        default => 'bg-card text-card-foreground',
    };

    $layoutClasses = $inline
        ? 'flex items-center gap-3 flex-wrap sm:flex-nowrap whitespace-nowrap overflow-x-auto'
        : 'grid grid-cols-[0_1fr] items-start gap-x-3 has-[>svg]:grid-cols-[calc(var(--spacing)*4)_1fr] has-[>svg]:gap-x-3';
@endphp

<div role="alert"
    {{ $attributes->merge(['class' => "relative w-full {$layoutClasses} rounded-lg border px-4 py-3 text-sm [&>svg]:size-4 {$variantClasses}"]) }}>
    {{ $slot }}
</div>
