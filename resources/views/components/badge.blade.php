@props([
    'variant' => 'default',
])

@php
    $variantClasses = match ($variant) {
        'secondary' => 'border-transparent bg-secondary text-secondary-foreground hover:bg-secondary/80',
        'destructive'
            => 'border-transparent bg-destructive text-white hover:bg-destructive/90 focus-visible:ring-destructive/20 dark:focus-visible:ring-destructive/40',
        'outline' => 'text-foreground',
        default => 'border-transparent bg-primary text-primary-foreground hover:bg-primary/90',
    };
@endphp

<span
    {{ $attributes->merge(['class' => "inline-flex items-center justify-center rounded-md border px-2 py-0.5 text-xs font-medium w-fit whitespace-nowrap shrink-0 gap-1 overflow-hidden [&>svg]:size-3 {$variantClasses}"]) }}>
    {{ $slot }}
</span>
