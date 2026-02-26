@props([
    'value' => 0,
    'min' => 0,
    'max' => 100,
    'step' => 1,
])

<input type="range" min="{{ $min }}" max="{{ $max }}" step="{{ $step }}"
    value="{{ $value }}" {{ $attributes->merge(['class' => 'w-full accent-primary']) }}>
