@props([
    'plain' => false,
    'between' => false,
    'end' => false,
    'spaced' => false,
])

@php
    $containerClasses = [
        'inline-flex items-center',
        'rounded-md border border-input p-0.5' => !$plain,
        'w-full justify-between' => $between,
        'w-full justify-end' => !$between && $end,
        'pt-2' => $spaced,
    ];
@endphp

<div role="group" {{ $attributes->class($containerClasses) }}>
    {{ $slot }}
</div>
