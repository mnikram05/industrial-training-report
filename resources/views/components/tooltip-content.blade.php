<div x-show="open" x-cloak x-transition.opacity
    {{ $attributes->merge(['class' => 'bg-primary text-primary-foreground z-50 w-fit rounded-md px-3 py-1.5 text-xs']) }}>
    {{ $slot }}
</div>
