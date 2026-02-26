@props([
    'href' => '#',
    'target' => null,
    'closeMenuOnClick' => true,
])

<a href="{{ $href }}" @if ($closeMenuOnClick) @click="closeMenu()" @endif
    @if (is_string($target) && $target !== '') target="{{ $target }}" @endif
    @if ($target === '_blank') rel="noopener noreferrer" @endif
    {{ $attributes->class('hover:bg-accent hover:text-accent-foreground flex w-full items-center rounded-sm px-2 py-1.5 text-sm') }}>
    {{ $slot }}
</a>
