@props([
    'features' => [],
])

@php
    $featureItems = is_array($features) ? $features : [];
    $featureIcons = [
        'sparkles' => 'feature-icon-sparkles',
        'shield' => 'feature-icon-shield',
        'globe' => 'feature-icon-globe',
        'zap' => 'feature-icon-zap',
        'heart' => 'feature-icon-heart',
        'star' => 'feature-icon-star',
        'default' => 'feature-icon-default',
    ];
@endphp

@if ($featureItems !== [])
    <x-landing.feature-icons />

    <section class="w-full border-t border-border py-12 md:py-24 lg:py-32">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($featureItems as $feature)
                    @php
                        $iconKey = $feature['icon'] ?? 'sparkles';
                        $iconId = $featureIcons[$iconKey] ?? $featureIcons['default'];
                    @endphp
                    <div class="flex flex-col items-center space-y-4 text-center">
                        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-primary/10">
                            <svg class="h-8 w-8 text-primary" aria-hidden="true" focusable="false">
                                <use href="#{{ $iconId }}"></use>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold">{{ $feature['title'] ?? '' }}</h3>
                        <p class="text-muted-foreground">{{ $feature['description'] ?? '' }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
