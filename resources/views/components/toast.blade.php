<div
    {{ $attributes->merge(['class' => 'bg-background text-foreground relative grid gap-1 rounded-lg border p-4 pr-8 shadow-lg']) }}>
    {{ $slot }}
</div>
