<div x-show="open" x-cloak @click.outside="open = false"
    {{ $attributes->merge(['class' => 'bg-popover text-popover-foreground absolute left-0 z-50 mt-1 min-w-[12rem] overflow-hidden rounded-md border p-1 shadow-md']) }}>
    {{ $slot }}
</div>
