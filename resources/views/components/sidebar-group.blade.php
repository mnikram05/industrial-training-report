@props([
    'label' => null,
])

<section {{ $attributes->merge(['class' => 'space-y-1.5']) }}>
    @if ($label)
        <x-sidebar-group-label>{{ $label }}</x-sidebar-group-label>
    @endif

    {{ $slot }}
</section>
