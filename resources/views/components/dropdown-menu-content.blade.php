<div x-show="open" x-cloak @click.outside="open = false"
    {{ $attributes->merge(['class' => 'bg-popover text-popover-foreground absolute right-0 z-50 mt-2 min-w-[8rem] overflow-hidden rounded-md border p-1 shadow-md']) }}>
    {{ $slot }}
</div>
