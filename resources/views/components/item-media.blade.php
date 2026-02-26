@props([
    'variant' => 'default',
])

@php
    $variantClasses = match ($variant) {
        'image' => 'size-8 overflow-hidden rounded-md border border-border bg-muted',
        default
            => 'flex size-8 items-center justify-center rounded-md bg-muted text-xs font-medium text-muted-foreground',
    };
@endphp

<div {{ $attributes->merge(['class' => $variantClasses]) }}>
    {{ $slot }}
</div>
