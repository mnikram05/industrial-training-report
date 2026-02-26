@props([
    'flush' => false,
])

@php
    $baseClasses = 'grid auto-rows-min grid-rows-[auto_auto] items-start gap-1.5 [.border-b]:pb-6';
    $spacingClasses = $flush ? 'px-0 pt-0' : 'px-6';
@endphp

<div {{ $attributes->class([$baseClasses, $spacingClasses]) }}>
    {{ $slot }}
</div>
