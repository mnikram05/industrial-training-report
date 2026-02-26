@props([
    'title' => null,
    'description' => null,
])

@php
    $headingContent = isset($heading) && $heading->hasActualContent() ? $heading : $title;
    $subtitleContent = isset($subtitle) && $subtitle->hasActualContent() ? $subtitle : $description;
@endphp

<x-app-layout>
    <x-card module>
        <x-card-header flush>
            <x-card-title>{{ $headingContent }}</x-card-title>

            @if (filled($subtitleContent))
                <x-card-description>{{ $subtitleContent }}</x-card-description>
            @endif
        </x-card-header>
    </x-card>
</x-app-layout>
