@props([
    'title' => null,
])

<section {{ $attributes->class('min-w-0 space-y-4 rounded-xl border border-border p-4') }}>
    @if (isset($labelText))
        <h3 class="text-sm font-semibold">{{ $labelText }}</h3>
    @elseif (filled($title))
        <h3 class="text-sm font-semibold">{{ $title }}</h3>
    @endif

    {{ $slot }}
</section>
