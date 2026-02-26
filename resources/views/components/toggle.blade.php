@props([
    'pressed' => false,
    'variant' => 'default',
    'size' => 'default',
    'type' => 'button',
])

@php
    $sizeClasses = match ($size) {
        'sm' => 'h-8 px-2.5 min-w-8',
        'lg' => 'h-10 px-3 min-w-10',
        default => 'h-9 px-2 min-w-9',
    };

    $variantClasses = match ($variant) {
        'outline' => 'border border-input bg-transparent shadow-xs hover:bg-accent hover:text-accent-foreground',
        default => 'bg-transparent hover:bg-muted hover:text-muted-foreground',
    };
@endphp

<button type="{{ $type }}" x-data="{ on: @js((bool) $pressed) }" @click="on = !on" :aria-pressed="on"
    :data-state="on ? 'on' : 'off'"
    {{ $attributes->merge(['class' => "inline-flex items-center justify-center gap-2 rounded-md text-sm font-medium transition-[color,box-shadow] outline-none focus-visible:border-ring focus-visible:ring-ring/50 disabled:pointer-events-none disabled:opacity-50 data-[state=on]:bg-accent data-[state=on]:text-accent-foreground {$sizeClasses} {$variantClasses}"]) }}>
    {{ $slot }}
</button>
