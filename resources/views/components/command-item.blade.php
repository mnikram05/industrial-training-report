<button type="button"
    {{ $attributes->merge(['class' => 'aria-selected:bg-accent aria-selected:text-accent-foreground data-[disabled=true]:pointer-events-none data-[disabled=true]:opacity-50 relative flex w-full cursor-default items-center gap-2 rounded-sm px-2 py-1.5 text-sm outline-none']) }}>
    {{ $slot }}
</button>
