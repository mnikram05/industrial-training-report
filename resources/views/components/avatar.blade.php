@props([
    'size' => 'default',
])

@php
    $sizeClasses = match ($size) {
        'sm' => 'size-8',
        'lg' => 'size-12',
        default => 'size-10',
    };
@endphp

<span {{ $attributes->merge(['class' => "relative flex shrink-0 overflow-visible rounded-full {$sizeClasses}"]) }}>
    {{ $slot }}
</span>
