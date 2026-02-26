@props(['items' => null])

@php
    $breadcrumbItems = is_array($items) ? $items : \App\Support\Breadcrumbs\Breadcrumbs::current();
    $totalItems = count($breadcrumbItems);
@endphp

@if ($slot->hasActualContent())
    <nav aria-label="breadcrumb" {{ $attributes }}>
        <ol class="text-muted-foreground flex flex-wrap items-center gap-1.5 text-sm break-words sm:gap-2.5">
            {{ $slot }}
        </ol>
    </nav>
@elseif ($totalItems > 0)
    <nav aria-label="breadcrumb" {{ $attributes }}>
        <ol class="text-muted-foreground flex flex-wrap items-center gap-1.5 text-sm break-words sm:gap-2.5">
            @foreach ($breadcrumbItems as $index => $item)
                <x-breadcrumb-item>
                    @if (is_string($item->url) && $item->url !== '' && $index < $totalItems - 1)
                        <x-breadcrumb-link :href="$item->url">{{ $item->label }}</x-breadcrumb-link>
                    @else
                        <x-breadcrumb-page>{{ $item->label }}</x-breadcrumb-page>
                    @endif
                </x-breadcrumb-item>

                @if ($index < $totalItems - 1)
                    <x-breadcrumb-separator>/</x-breadcrumb-separator>
                @endif
            @endforeach
        </ol>
    </nav>
@endif
