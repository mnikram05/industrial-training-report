@props([
    'orientation' => 'horizontal',
])

<div {{ $attributes->merge(['class' => $orientation === 'vertical' ? 'flex h-full flex-col' : 'flex w-full']) }}>
    {{ $slot }}
</div>
