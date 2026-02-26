@props([
    'orientation' => 'horizontal',
])

@php
    $isVertical = $orientation === 'vertical';
@endphp

<div role="separator" aria-orientation="{{ $orientation }}"
    {{ $attributes->merge(['class' => $isVertical ? 'bg-border shrink-0 data-[orientation=vertical]:h-full data-[orientation=vertical]:w-px h-full w-px' : 'bg-border shrink-0 data-[orientation=horizontal]:h-px data-[orientation=horizontal]:w-full h-px w-full']) }}>
</div>
