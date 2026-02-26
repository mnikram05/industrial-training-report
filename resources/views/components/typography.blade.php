@props([
    'as' => 'p',
    'variant' => 'p',
])

@php
    $classes = match ($variant) {
        'h1' => 'scroll-m-20 text-balance text-4xl font-extrabold tracking-tight lg:text-5xl',
        'h2' => 'scroll-m-20 border-b pb-2 text-3xl font-semibold tracking-tight first:mt-0',
        'h3' => 'scroll-m-20 text-2xl font-semibold tracking-tight',
        'h4' => 'scroll-m-20 text-xl font-semibold tracking-tight',
        'lead' => 'text-muted-foreground text-xl',
        'large' => 'text-lg font-semibold',
        'small' => 'text-sm leading-none font-medium',
        'muted' => 'text-muted-foreground text-sm',
        default => 'leading-7 [&:not(:first-child)]:mt-6',
    };
@endphp

<{{ $as }} {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
    </{{ $as }}>
