@props([
    'active' => false,
])

<x-button :variant="$active ? 'outline' : 'ghost'" size="icon" {{ $attributes->merge(['class' => 'size-9']) }}>
    {{ $slot }}
</x-button>
