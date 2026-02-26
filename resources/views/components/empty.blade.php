@props([
    'title' => 'No data',
    'description' => null,
])

<div
    {{ $attributes->merge(['class' => 'flex min-h-40 flex-col items-center justify-center rounded-lg border border-dashed p-10 text-center']) }}>
    <p class="text-sm font-medium">{{ $title }}</p>
    @if ($description)
        <p class="text-muted-foreground mt-1 text-sm">{{ $description }}</p>
    @endif
    @if ($slot->hasActualContent())
        <div class="mt-4">{{ $slot }}</div>
    @endif
</div>
