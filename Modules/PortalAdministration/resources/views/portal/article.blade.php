<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $article->title }} - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-neutral-100 text-neutral-900 antialiased">
    @php
        $backHref = auth()->check() ? route('articles.index') : route('home');
        $backLabel = auth()->check() ? __('modules/portal-administration/article.messages.back_articles') : __('modules/portal-administration/article.messages.back_portal');
    @endphp

    <main class="mx-auto w-full max-w-4xl px-4 py-10 sm:px-6 lg:px-8">
        <article class="rounded-xl border border-border bg-card p-6 shadow-sm sm:p-8">
            <header class="space-y-3 border-b border-border pb-6">
                <a href="{{ $backHref }}" class="text-sm text-muted-foreground hover:text-foreground">
                    {{ $backLabel }}
                </a>
                <h1 class="text-3xl font-semibold tracking-tight sm:text-4xl">{{ $article->title }}</h1>
                <p class="text-sm text-muted-foreground">
                    {{ __('modules/portal-administration/article.messages.by_author', [
                        'author' => $article->user?->name ?? __('modules/portal-administration/article.messages.unknown'),
                        'date' => optional($article->published_at)->format('M j, Y'),
                    ]) }}
                </p>
            </header>

            @if ($article->excerpt)
                <p class="mt-6 text-lg text-muted-foreground">{{ $article->excerpt }}</p>
            @endif

            <div class="prose prose-neutral mt-8 max-w-none whitespace-pre-line">
                {{ $article->content }}
            </div>
        </article>
    </main>
</body>

</html>
