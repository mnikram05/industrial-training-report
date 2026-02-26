<div
    {{ $attributes->merge(['class' => 'focus:bg-accent focus:text-accent-foreground relative flex w-full cursor-default items-center gap-2 rounded-sm py-1.5 pr-8 pl-2 text-sm outline-none select-none']) }}>
    {{ $slot }}
</div>
