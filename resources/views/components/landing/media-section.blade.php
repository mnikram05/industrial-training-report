@props([
    'title' => '',
    'body' => '',
    'image' => '',
    'alt' => '',
    'sectionClass' => 'py-12 md:py-24',
])

@php
    $hasContent = $title !== '' || $body !== '' || $image !== '';
    $fallbackText = isset($fallbackText) ? trim((string) $fallbackText) : '';
@endphp

@if ($hasContent)
    <section class="w-full border-t border-border {{ $sectionClass }}">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-2 lg:items-center">
                <div class="space-y-4">
                    @if ($title !== '')
                        <h2 class="text-2xl font-bold tracking-tight sm:text-3xl">
                            {{ $title }}
                        </h2>
                    @endif

                    @if ($body !== '')
                        <p class="text-muted-foreground">
                            {{ $body }}
                        </p>
                    @endif
                </div>

                @if ($image !== '')
                    <div class="overflow-hidden rounded-3xl bg-background ring-1 ring-foreground/10">
                        <img src="{{ asset('storage/' . $image) }}"
                            alt="{{ $alt !== '' ? $alt : ($title !== '' ? $title : $fallbackText) }}"
                            class="h-48 w-full object-cover sm:h-64" loading="lazy">
                    </div>
                @endif
            </div>
        </div>
    </section>
@endif
