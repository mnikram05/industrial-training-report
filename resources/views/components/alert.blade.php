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
        ? 'flex items-start gap-3 flex-wrap sm:flex-nowrap'
        : 'grid grid-cols-1 items-start gap-y-1 has-[>svg]:grid-cols-[calc(var(--spacing)*4)_1fr] has-[>svg]:gap-x-3 has-[>svg]:[&>[data-slot=alert-title]]:col-start-2 has-[>svg]:[&>[data-slot=alert-description]]:col-start-2';
@endphp

<div role="alert"
    {{ $attributes->merge(['class' => "relative w-full {$layoutClasses} rounded-lg border px-4 py-3 text-sm [&>svg]:size-4 {$variantClasses}"]) }}>
    {{ $slot }}
</div>
