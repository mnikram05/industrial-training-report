@props([
    'title' => null,
    'description' => null,
    'savedStatuses' => null,
    'deletedStatuses' => null,
    'latestExportPath' => null,
])

@php
    $routeName = request()->route()?->getName();
    $resourceName =
        is_string($routeName) && str_ends_with($routeName, '.index')
            ? \Illuminate\Support\Str::beforeLast($routeName, '.index')
            : null;
    $resourceKey = is_string($resourceName) ? \Illuminate\Support\Str::singular($resourceName) : null;

    if ($savedStatuses === null && is_string($resourceKey)) {
        $savedStatuses = ["{$resourceKey}-created", "{$resourceKey}-updated"];
    }

    if ($deletedStatuses === null && is_string($resourceKey)) {
        $deletedStatuses = ["{$resourceKey}-deleted"];
    }

    $savedStatuses = is_array($savedStatuses) ? $savedStatuses : [];
    $deletedStatuses = is_array($deletedStatuses) ? $deletedStatuses : [];

    $headingContent = isset($heading) && $heading->hasActualContent() ? $heading : $title;
    $subtitleContent = isset($subtitle) && $subtitle->hasActualContent() ? $subtitle : $description;
@endphp

<x-datatables-assets />

<div class="space-y-7 sm:space-y-8">
    <x-flash-status-alert :saved-statuses="$savedStatuses" :deleted-statuses="$deletedStatuses" />
    <x-latest-export-alert :path="$latestExportPath" />

    <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-foreground sm:text-[1.65rem]">{{ $headingContent }}</h1>

            @if (filled($subtitleContent))
                <p class="text-sm text-muted-foreground">{{ $subtitleContent }}</p>
            @endif
        </div>

        @isset($actions)
            @if ($actions->hasActualContent())
                <div class="flex flex-col gap-2 lg:flex-row lg:flex-wrap lg:items-center lg:justify-end">
                    {{ $actions }}
                </div>
            @endif
        @endisset
    </div>

    {{ $slot }}
</div>
