<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="{{ request()->cookie('appearance', 'system') === 'dark' ? 'dark' : '' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $landing?->localizedName() ?: config('app.name', 'Laravel') }}</title>

    <script>
        window.__REACT_DEVTOOLS_GLOBAL_HOOK__ = {
            isDisabled: true,
        };
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-background font-sans antialiased">
    @php
        $landingName = $landing?->localizedName() ?: config('app.name', 'Laravel');
        $currentLocale = app()->getLocale();
        $localeLabels = [
            'en' => __('English'),
            'ms' => __('Melayu'),
        ];

        $hero = is_array($content['hero'] ?? null) ? $content['hero'] : [];
        $banner = is_array($content['banner'] ?? null) ? $content['banner'] : [];
        $about = is_array($content['about'] ?? null) ? $content['about'] : [];
        $security = is_array($content['security'] ?? null) ? $content['security'] : [];
        $features = is_array($content['features'] ?? null) ? $content['features'] : [];
        $footer = is_array($content['footer'] ?? null) ? $content['footer'] : [];

        $articlePosts = $articlePosts ?? collect();
        $articlePosts =
            $articlePosts instanceof \Illuminate\Support\Collection ? $articlePosts : collect($articlePosts);

        $articles = collect($content['articles'] ?? [])
            ->map(function ($article) use ($articlePosts) {
                if (!is_array($article)) {
                    return [];
                }

                $postSlug = $article['article_slug'] ?? ($article['post_slug'] ?? null);
                $post = $postSlug && $articlePosts->has($postSlug) ? $articlePosts->get($postSlug) : null;

                $title = $article['title'] ?? null;
                if (empty($title) && $post) {
                    $title = $post->title;
                }

                $excerpt = $article['excerpt'] ?? null;
                if (empty($excerpt) && $post && !empty($post->excerpt)) {
                    $excerpt = $post->excerpt;
                }
                if (empty($excerpt) && $post && !empty($post->content)) {
                    $excerpt = \Illuminate\Support\Str::limit(strip_tags($post->content), 140);
                }

                $url = $post ? route('articles.show', $post) : null;

                return array_merge($article, [
                    '_title' => $title,
                    '_excerpt' => $excerpt,
                    '_url' => $url,
                ]);
            })
            ->filter(fn($article) => !empty($article['_url']))
            ->values();
    @endphp

    <div class="relative flex min-h-screen flex-col">
        <x-landing.page-header :current-locale="$currentLocale" :locale-labels="$localeLabels" :can-register="$canRegister" />

        <main class="flex-1">
            <x-landing.hero-section :title="$hero['title'] ?? $landingName" :subtitle="$hero['subtitle'] ?? ''" :primary-text="$hero['primary_button']['text'] ?? ''" :primary-url="$hero['primary_button']['url'] ?? '/login'"
                :secondary-text="$hero['secondary_button']['text'] ?? ''" :secondary-url="$hero['secondary_button']['url'] ?? '#'" />

            <x-landing.media-section :title="$banner['title'] ?? ''" :body="$banner['subtitle'] ?? ''" :image="$banner['image'] ?? ''" :alt="$banner['alt'] ?? ''"
                section-class="py-12 md:py-20">
                <x-slot:fallbackText>{{ __('Banner image') }}</x-slot:fallbackText>
            </x-landing.media-section>

            <x-landing.media-section :title="$about['title'] ?? ''" :body="$about['body'] ?? ''" :image="$about['image'] ?? ''" :alt="$about['alt'] ?? ''">
                <x-slot:fallbackText>{{ __('About image') }}</x-slot:fallbackText>
            </x-landing.media-section>

            <x-landing.media-section :title="$security['title'] ?? ''" :body="$security['body'] ?? ''" :image="$security['image'] ?? ''" :alt="$security['alt'] ?? ''">
                <x-slot:fallbackText>{{ __('Security image') }}</x-slot:fallbackText>
            </x-landing.media-section>

            <x-landing.articles-section :articles="$articles" />

            <x-landing.features-section :features="$features" />
        </main>

        <x-landing.page-footer :text="$footer['text'] ?? 'Built with Laravel'" />
    </div>
</body>

</html>
