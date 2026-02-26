@props([
    'ratio' => '16/9',
])

@php
    $parts = explode('/', (string) $ratio);
    $widthRatio = isset($parts[0]) ? (float) $parts[0] : 16.0;
    $heightRatio = isset($parts[1]) ? (float) $parts[1] : 9.0;
    $paddingBottom = $widthRatio > 0 ? ($heightRatio / $widthRatio) * 100 : 56.25;
@endphp

<div {{ $attributes->merge(['class' => 'relative w-full overflow-hidden']) }}
    style="padding-bottom: {{ $paddingBottom }}%;">
    <div class="absolute inset-0">
        {{ $slot }}
    </div>
</div>
