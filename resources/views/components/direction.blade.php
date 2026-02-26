@props([
    'dir' => 'ltr',
])

<div dir="{{ $dir }}" {{ $attributes }}>
    {{ $slot }}
</div>
