<button type="button"
    {{ $attributes->merge(['class' => 'focus:bg-accent focus:text-accent-foreground data-[disabled]:pointer-events-none data-[disabled]:opacity-50 relative flex w-full cursor-default select-none items-center gap-2 rounded-sm px-2 py-1.5 text-sm outline-none']) }}>
    {{ $slot }}
</button>
