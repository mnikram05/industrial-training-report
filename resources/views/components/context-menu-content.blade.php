<div x-show="open" x-cloak @click.outside="open = false" :style="`position: fixed; left: ${x}px; top: ${y}px;`"
    {{ $attributes->merge(['class' => 'bg-popover text-popover-foreground z-50 min-w-[8rem] overflow-hidden rounded-md border p-1 shadow-md']) }}>
    {{ $slot }}
</div>
