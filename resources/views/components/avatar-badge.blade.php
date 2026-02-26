@props([
    'impersonating' => false,
])

<span
    {{ $attributes->merge(['class' => 'absolute bottom-0 right-0 z-20 block size-3.5 translate-x-1/4 translate-y-1/4 rounded-full border-2 border-background ' . ($impersonating ? 'bg-orange-500' : 'bg-emerald-500')]) }}></span>
