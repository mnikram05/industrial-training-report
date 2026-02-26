@props([
    'variant' => 'default',
    'size' => 'default',
    'type' => 'button',
    'as' => 'button',
])

@php
    $tag = $as === 'a' ? 'a' : 'button';
    $attrs = $attributes->except('as');

    $baseClasses =
        "inline-flex shrink-0 items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-all outline-none disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg:not([class*='size-'])]:size-4 [&_svg]:shrink-0 focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50 aria-invalid:border-destructive aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40";

    $sizeClasses = match ($size) {
        'xs' => 'h-7 rounded-md gap-1 px-2.5',
        'sm' => 'h-8 rounded-md gap-1.5 px-3 has-[>svg]:px-2.5',
        'lg' => 'h-10 rounded-md px-6 has-[>svg]:px-4',
        'icon' => 'size-9',
        'icon-xs' => 'size-7',
        'icon-sm' => 'size-8',
        'icon-lg' => 'size-10',
        default => 'h-9 px-4 py-2 has-[>svg]:px-3',
    };

    $variantClasses = match ($variant) {
        'secondary' => 'bg-secondary text-secondary-foreground shadow-xs hover:bg-secondary/80',
        'outline' => 'border border-input bg-background shadow-xs hover:bg-accent hover:text-accent-foreground',
        'ghost' => 'hover:bg-accent hover:text-accent-foreground',
        'destructive'
            => 'bg-destructive text-destructive-foreground shadow-xs hover:bg-destructive/90 focus-visible:ring-destructive/20 dark:focus-visible:ring-destructive/40',
        'link' => 'text-primary underline-offset-4 hover:underline',
        default => 'bg-primary text-primary-foreground shadow-xs hover:bg-primary/90',
    };
@endphp

@if ($tag === 'a')
    <a {{ $attrs->merge(['class' => "{$baseClasses} {$sizeClasses} {$variantClasses}"]) }} role="button">
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}"
        {{ $attrs->merge(['class' => "{$baseClasses} {$sizeClasses} {$variantClasses}"]) }}>
        {{ $slot }}
    </button>
@endif
