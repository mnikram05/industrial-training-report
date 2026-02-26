@props([
    'active' => false,
    'href' => '#',
])

@php
    $classes =
        'group flex h-7 items-center rounded-md px-2 text-[13px] transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring';
    $classes .= $active
        ? ' bg-accent/60 text-foreground font-medium'
        : ' text-muted-foreground hover:bg-accent/50 hover:text-foreground';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
