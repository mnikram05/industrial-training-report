@props([
    'flush' => false,
    'stacked' => false,
])

@php
    $containerClasses = [$flush ? 'px-0 pb-0' : 'px-6', 'space-y-4' => $stacked];
@endphp

<div {{ $attributes->class($containerClasses) }}>
    {{ $slot }}
</div>
