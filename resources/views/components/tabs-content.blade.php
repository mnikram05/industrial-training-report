@props(['value'])

<div role="tabpanel" x-show="tabValue === '{{ $value }}'" x-cloak
    {{ $attributes->merge(['class' => 'flex-1 outline-none']) }}>
    {{ $slot }}
</div>
