@props([
    'active' => false,
    'href' => '#',
])

@php
    $classes =
        'group flex h-8 items-center gap-2 rounded-md px-2 text-[13px] font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring';
    $classes .= $active
        ? ' bg-accent text-accent-foreground'
        : ' text-foreground/90 hover:bg-accent hover:text-foreground';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
