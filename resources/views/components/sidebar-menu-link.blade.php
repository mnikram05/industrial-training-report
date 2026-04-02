@props([
    'active' => false,
    'href' => '#',
])

@php
    $classes =
        'group flex h-8 items-center gap-2 rounded-md px-2 text-[13px] font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--portal-accent)] focus-visible:ring-offset-2 focus-visible:ring-offset-[var(--portal-header-bg)] [&[data-state=active]_svg]:text-white';
    $classes .= $active
        ? ' bg-[var(--portal-accent)] text-white shadow-sm'
        : ' text-white/85 hover:bg-[color-mix(in_srgb,var(--portal-accent)_22%,transparent)] hover:text-white';
@endphp

<a href="{{ $href }}" data-state="{{ $active ? 'active' : 'inactive' }}"
    {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
