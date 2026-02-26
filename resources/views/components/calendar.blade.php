@props([
    'value' => null,
])

<x-date-picker mode="date" :value="$value" {{ $attributes }} />
