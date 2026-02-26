@props([
    'src' => null,
    'alt' => '',
])

@if ($src)
    <img src="{{ $src }}" alt="{{ $alt }}" onerror="this.classList.add('hidden')"
        {{ $attributes->merge(['class' => 'absolute inset-0 z-10 aspect-square size-full rounded-full object-cover']) }}>
@endif
