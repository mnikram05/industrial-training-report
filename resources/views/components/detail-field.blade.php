@props([
    'label' => null,
    'value' => null,
    'empty' => '—',
])

@php
    $resolvedLabel = isset($labelText) && $labelText->hasActualContent() ? $labelText : $label;
    $resolvedValue = $value;

    if ($resolvedValue === null && !$slot->isEmpty()) {
        $resolvedValue = trim((string) $slot);
    }

    if ($resolvedValue === null || $resolvedValue === '') {
        $resolvedValue = $empty;
    }
@endphp

<div {{ $attributes }}>
    <p class="text-sm text-muted-foreground">{{ $resolvedLabel }}</p>
    <p class="font-medium">{{ $resolvedValue }}</p>
</div>
