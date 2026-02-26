@props([
    'type' => 'button',
])

<button type="{{ $type }}"
    {{ $attributes->merge(['class' => 'focus:bg-accent focus:text-accent-foreground hover:bg-accent hover:text-accent-foreground relative flex w-full cursor-default select-none items-center gap-2 rounded-sm px-2 py-1.5 text-sm outline-none']) }}>
    {{ $slot }}
</button>
