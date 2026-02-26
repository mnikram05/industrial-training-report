@props([
    'items' => [],
])

@php
    $normalizedItems = collect($items)
        ->map(
            static fn(array $item): array => [
                'id' => (int) data_get($item, 'id', 0),
                'title' => (string) data_get($item, 'title', ''),
                'description' => (string) data_get($item, 'description', ''),
                'time' => (string) data_get($item, 'time', ''),
                'url' => (string) data_get($item, 'url', '#'),
                'initial' => (string) data_get($item, 'initial', 'S'),
            ],
        )
        ->filter(static fn(array $item): bool => $item['title'] !== '')
        ->take(5)
        ->values()
        ->all();
@endphp

<x-card>
    <x-card-header class="pb-2">
        <x-card-title>{{ __('Latest Activity Logs') }}</x-card-title>
        <x-card-description>{{ __('Showing the 5 most recent events') }}</x-card-description>
    </x-card-header>

    <x-card-content class="pb-2 px-3 sm:px-6">
        @if ($normalizedItems === [])
            <p class="text-muted-foreground text-sm">{{ __('No recent activity') }}</p>
        @else
            <x-item-group role="list">
                @foreach ($normalizedItems as $item)
                    <x-item variant="outline" role="listitem" class="overflow-hidden rounded-xl p-0">
                        <a href="{{ $item['url'] }}"
                            class="flex w-full flex-col items-center justify-center gap-2.5 rounded-xl px-4 py-3 text-center sm:flex-row sm:items-center sm:justify-start sm:gap-3 sm:px-3 sm:py-2.5 sm:text-left">
                            <x-item-media>
                                <x-avatar size="sm">
                                    <x-avatar-fallback>{{ $item['initial'] }}</x-avatar-fallback>
                                </x-avatar>
                            </x-item-media>

                            <x-item-content class="min-w-0 sm:flex-1">
                                <x-item-title class="leading-tight">{{ $item['title'] }}</x-item-title>
                                <x-item-description
                                    class="leading-relaxed">{{ $item['description'] }}</x-item-description>
                            </x-item-content>

                            <x-item-content
                                class="w-full flex-none pt-0.5 text-center sm:w-auto sm:max-w-[35%] sm:pt-0 sm:text-right">
                                <x-item-description
                                    class="truncate leading-relaxed">{{ $item['time'] }}</x-item-description>
                            </x-item-content>
                        </a>
                    </x-item>
                @endforeach
            </x-item-group>
        @endif
    </x-card-content>
</x-card>
