@props([
    'active' => false,
    'href' => '#',
])

@php
    $classes =
        'group flex h-7 items-center rounded-md px-2 text-[13px] transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--portal-accent)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--portal-header-bg)]';
    $classes .= $active
        ? ' bg-[color-mix(in_srgb,var(--portal-accent)_42%,transparent)] font-medium text-white'
        : ' text-white/60 hover:bg-white/10 hover:text-white';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
