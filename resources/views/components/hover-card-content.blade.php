<div x-show="open" x-cloak @mouseenter="open = true" @mouseleave="open = false"
    {{ $attributes->merge(['class' => 'bg-popover text-popover-foreground absolute left-0 z-50 mt-2 w-64 rounded-md border p-4 shadow-md']) }}>
    {{ $slot }}
</div>
