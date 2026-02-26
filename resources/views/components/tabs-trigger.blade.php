@props(['value'])

<button type="button" role="tab" @click="tabValue = '{{ $value }}'"
    :data-state="tabValue === '{{ $value }}' ? 'active' : 'inactive'"
    {{ $attributes->merge(['class' => 'inline-flex h-[calc(100%-1px)] min-w-[calc(var(--spacing)*20)] items-center justify-center gap-1.5 rounded-md border border-transparent px-2 py-1 text-sm font-medium whitespace-nowrap text-foreground transition-[color,box-shadow] focus-visible:outline-none focus-visible:ring-[3px] focus-visible:ring-ring/50 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:bg-background data-[state=active]:text-foreground data-[state=active]:shadow-sm']) }}>
    {{ $slot }}
</button>
