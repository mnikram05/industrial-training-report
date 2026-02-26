<div
    {{ $attributes->merge(['class' => 'bg-popover text-popover-foreground relative z-50 max-h-96 min-w-[8rem] overflow-hidden rounded-md border shadow-md']) }}>
    {{ $slot }}
</div>
