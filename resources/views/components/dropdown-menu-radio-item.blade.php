<label
    {{ $attributes->merge(['class' => 'focus:bg-accent focus:text-accent-foreground hover:bg-accent hover:text-accent-foreground relative flex cursor-default select-none items-center rounded-sm py-1.5 pr-2 pl-8 text-sm outline-none']) }}>
    <input type="radio" class="absolute left-2 size-4 border-input text-primary focus-visible:ring-ring/50">
    {{ $slot }}
</label>
