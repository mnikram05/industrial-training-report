@props([
    'articles' => [],
])

@php
    $articleItems = $articles instanceof \Illuminate\Support\Collection ? $articles : collect($articles);
@endphp

@if ($articleItems->isNotEmpty())
    <section class="w-full border-t border-border py-12 md:py-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8 space-y-2">
                <h2 class="text-2xl font-bold tracking-tight sm:text-3xl">
                    {{ __('ui.articles') }}
                </h2>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($articleItems as $article)
                    <article class="rounded-2xl bg-card p-6 ring-1 ring-foreground/10">
                        @if (!empty($article['image']))
                            <div class="mb-4 overflow-hidden rounded-xl">
                                <img src="{{ asset('storage/' . $article['image']) }}"
                                    alt="{{ $article['alt'] ?? ($article['_title'] ?? __('ui.article_image_77275d')) }}"
                                    class="h-40 w-full object-cover" loading="lazy">
                            </div>
                        @endif

                        @if (!empty($article['_title']))
                            <h3 class="text-lg font-semibold text-foreground">
                                {{ $article['_title'] }}
                            </h3>
                        @endif

                        @if (!empty($article['_excerpt']))
                            <p class="mt-2 text-sm text-muted-foreground">
                                {{ $article['_excerpt'] }}
                            </p>
                        @endif

                        @if (!empty($article['_url']))
                            <x-button as="a" href="{{ $article['_url'] }}"
                                target="{{ str_starts_with($article['_url'], 'http') ? '_blank' : '_self' }}"
                                variant="link" class="mt-4 px-0">
                                {{ __('ui.read_more') }}
                            </x-button>
                        @endif
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endif
