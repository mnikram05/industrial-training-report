@props([
    'side' => 'right',
])

@php
    $positionClasses = match ($side) {
        'left' => 'left-0 h-full w-3/4 max-w-sm border-r',
        'top' => 'top-0 left-0 w-full border-b',
        'bottom' => 'bottom-0 left-0 w-full border-t',
        default => 'right-0 h-full w-3/4 max-w-sm border-l',
    };

    $enterStart = match ($side) {
        'left' => '-translate-x-full',
        'top' => '-translate-y-full',
        'bottom' => 'translate-y-full',
        default => 'translate-x-full',
    };
@endphp

<div x-show="open" x-cloak class="fixed inset-0 z-50" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-black/50" @click="open = false"></div>
    <div x-show="open" x-transition:enter="duration-200 ease-out" x-transition:enter-start="{{ $enterStart }}"
        x-transition:enter-end="translate-x-0 translate-y-0" x-transition:leave="duration-150 ease-in"
        x-transition:leave-start="translate-x-0 translate-y-0" x-transition:leave-end="{{ $enterStart }}"
        {{ $attributes->merge(['class' => "bg-background fixed z-50 p-6 shadow-lg border {$positionClasses}"]) }}>
        {{ $slot }}
    </div>
</div>
