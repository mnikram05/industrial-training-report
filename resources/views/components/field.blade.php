@props([
    'label' => null,
    'description' => null,
    'error' => null,
    'for' => null,
])

@php
    $resolvedLabel = isset($labelText) && $labelText->hasActualContent() ? $labelText : $label;
    $resolvedDescription =
        isset($descriptionText) && $descriptionText->hasActualContent() ? $descriptionText : $description;
@endphp

<div {{ $attributes->merge(['class' => 'grid min-w-0 gap-2']) }}>
    @if (filled($resolvedLabel))
        <x-label :for="$for">{{ $resolvedLabel }}</x-label>
    @endif

    {{ $slot }}

    @if (filled($resolvedDescription))
        <p class="text-muted-foreground break-words text-sm">{{ $resolvedDescription }}</p>
    @endif

    @if ($error)
        <p class="break-words text-sm font-medium text-destructive">{{ $error }}</p>
    @endif
</div>
