<div
    {{ $attributes->merge(['class' => 'bg-popover text-popover-foreground flex h-full w-full flex-col overflow-hidden rounded-md']) }}>
    {{ $slot }}
</div>
