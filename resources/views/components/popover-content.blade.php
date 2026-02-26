<div x-show="open" x-cloak @click.outside="open = false"
    {{ $attributes->merge(['class' => 'bg-popover text-popover-foreground z-50 w-72 rounded-md border p-4 shadow-md outline-none']) }}>
    {{ $slot }}
</div>
