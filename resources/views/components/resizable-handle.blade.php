@props([
    'orientation' => 'horizontal',
])

<div
    {{ $attributes->merge(['class' => $orientation === 'vertical' ? 'bg-border h-px w-full' : 'bg-border h-auto w-px']) }}>
</div>
