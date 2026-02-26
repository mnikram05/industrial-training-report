@props([
    'value' => 0,
])

@php
    $progressValue = max(0, min(100, (int) $value));
@endphp

<div {{ $attributes->merge(['class' => 'bg-primary/20 relative h-2 w-full overflow-hidden rounded-full']) }}>
    <div class="bg-primary h-full w-full flex-1 transition-all"
        style="transform: translateX(-{{ 100 - $progressValue }}%);"></div>
</div>
