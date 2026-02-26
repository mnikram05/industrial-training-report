<button type="button" @click="open = !open"
    {{ $attributes->merge(['class' => 'focus:bg-accent focus:text-accent-foreground data-[state=open]:bg-accent data-[state=open]:text-accent-foreground flex cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm font-medium outline-none']) }}>
    {{ $slot }}
</button>
