@props([
    'previewData' => [],
])

<p class="text-sm text-muted-foreground">
    {{ __('ui.this_preview_matches_your_live_landing_page_layout_and_updates_while_you_edit') }}</p>

@once
    <svg class="sr-only" aria-hidden="true" focusable="false">
        <symbol id="feature-icon-sparkles" viewBox="0 0 24 24">
            <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z" />
            <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                d="M5 3v4" />
            <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                d="M19 17v4" />
            <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                d="M3 5h4" />
            <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                d="M17 19h4" />
        </symbol>
        <symbol id="feature-icon-shield" viewBox="0 0 24 24">
            <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10" />
            <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                d="m9 12 2 2 4-4" />
        </symbol>
        <symbol id="feature-icon-globe" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" />
            <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20" />
            <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                d="M2 12h20" />
        </symbol>
        <symbol id="feature-icon-zap" viewBox="0 0 24 24">
            <polygon fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                points="13 2 3 14 12 14 11 22 21 10 12 10 13 2" />
        </symbol>
        <symbol id="feature-icon-heart" viewBox="0 0 24 24">
            <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
        </symbol>
        <symbol id="feature-icon-star" viewBox="0 0 24 24">
            <polygon fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
        </symbol>
        <symbol id="feature-icon-default" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" />
        </symbol>
    </svg>
@endonce

<div class="overflow-hidden rounded-2xl border border-border bg-background" data-landing-preview x-data="landingPreview(@js($previewData))"
    x-init="init($el.closest('form'))">
    <div class="pointer-events-none relative flex min-h-screen flex-col select-none" aria-disabled="true">
        <header
            class="sticky top-0 z-50 w-full border-b border-border bg-background/95 backdrop-blur supports-backdrop-filter:bg-background/60">
            <div class="container mx-auto flex min-h-14 flex-wrap items-center gap-2 px-4 py-2 sm:px-6 lg:px-8">
                <div class="mr-auto flex">
                    <a :href="preview.homeUrl || '#'" class="mr-6 flex items-center space-x-2">
                        <span class="font-bold" x-text="preview.appName"></span>
                    </a>
                </div>
                <div class="flex w-full items-center justify-end sm:w-auto">
                    <nav class="flex w-full flex-wrap items-center justify-end gap-2 sm:w-auto">
                        <x-dropdown-menu class="w-full sm:w-auto">
                            <x-dropdown-menu-trigger
                                class="inline-flex h-8 w-full shrink-0 items-center justify-between gap-2 whitespace-nowrap rounded-md border border-input bg-background px-3 text-sm font-medium shadow-xs transition-all outline-none hover:bg-accent hover:text-accent-foreground focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50 sm:w-auto sm:justify-center">
                                <span x-text="languageLabel()"></span>
                                <svg class="size-4" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                                    <path d="M5 7.5L10 12.5L15 7.5" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </x-dropdown-menu-trigger>

                            <x-dropdown-menu-content class="w-40 space-y-0.5 p-1">
                                <x-dropdown-menu-item @click="preview.locale = 'en'; open = false"
                                    class="w-full justify-between gap-2 rounded-md px-2 py-1.5 text-left text-sm leading-5 transition-colors"
                                    x-bind:class="preview.locale === 'en' ? 'bg-accent text-accent-foreground' : ''">
                                    <span>{{ __('ui.english') }}</span>
                                    <svg x-show="preview.locale === 'en'" class="size-4" viewBox="0 0 20 20"
                                        fill="none" aria-hidden="true">
                                        <path d="M5 10L8.5 13.5L15 7" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </x-dropdown-menu-item>
                                <x-dropdown-menu-item @click="preview.locale = 'ms'; open = false"
                                    class="w-full justify-between gap-2 rounded-md px-2 py-1.5 text-left text-sm leading-5 transition-colors"
                                    x-bind:class="preview.locale === 'ms' ? 'bg-accent text-accent-foreground' : ''">
                                    <span>{{ __('ui.melayu') }}</span>
                                    <svg x-show="preview.locale === 'ms'" class="size-4" viewBox="0 0 20 20"
                                        fill="none" aria-hidden="true">
                                        <path d="M5 10L8.5 13.5L15 7" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </x-dropdown-menu-item>
                            </x-dropdown-menu-content>
                        </x-dropdown-menu>
                        <template x-if="preview.isAuthenticated">
                            <x-button as="a" size="sm" ::href="preview.dashboardUrl || '#'">
                                {{ __('ui.dashboard') }}
                            </x-button>
                        </template>

                        <template x-if="!preview.isAuthenticated">
                            <x-button as="a" variant="outline" size="sm" ::href="preview.loginUrl || '#'">
                                {{ __('ui.login') }}
                            </x-button>
                        </template>

                        <template x-if="!preview.isAuthenticated && preview.canRegister">
                            <x-button as="a" size="sm" ::href="preview.registerUrl || '#'">
                                {{ __('ui.register') }}
                            </x-button>
                        </template>
                    </nav>
                </div>
            </div>
        </header>

        <main class="flex-1">
            <section class="w-full py-12 md:py-24 lg:py-32 xl:py-48">
                <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col items-center space-y-4 text-center">
                        <div class="space-y-2">
                            <h1 class="text-3xl font-bold tracking-tighter sm:text-4xl md:text-5xl lg:text-6xl/none"
                                x-text="heroTitle()"></h1>
                            <p class="mx-auto max-w-175 text-muted-foreground md:text-xl"
                                x-text="preview.heroSubtitle"></p>
                        </div>
                        <div class="flex flex-wrap items-center justify-center gap-3">
                            <template x-if="preview.isAuthenticated">
                                <x-button as="a" size="lg" ::href="preview.dashboardUrl || '#'">
                                    {{ __('ui.go_to_dashboard') }}
                                </x-button>
                            </template>

                            <template x-if="!preview.isAuthenticated && isFilled(preview.heroPrimaryText)">
                                <x-button as="a" size="lg" ::href="heroPrimaryUrl()">
                                    <span x-text="preview.heroPrimaryText"></span>
                                </x-button>
                            </template>

                            <template x-if="!preview.isAuthenticated && isFilled(preview.heroSecondaryText)">
                                <x-button as="a" variant="outline" size="lg" ::href="preview.heroSecondaryUrl || '#'"
                                    ::target="heroSecondaryTarget()">
                                    <span x-text="preview.heroSecondaryText"></span>
                                </x-button>
                            </template>
                        </div>
                    </div>
                </div>
            </section>

            <template x-if="hasBannerSection()">
                <section class="w-full border-t border-border py-12 md:py-20">
                    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="grid gap-8 lg:grid-cols-2 lg:items-center">
                            <div class="space-y-4">
                                <template x-if="isFilled(preview.bannerTitle)">
                                    <h2 class="text-2xl font-bold tracking-tight sm:text-3xl"
                                        x-text="preview.bannerTitle"></h2>
                                </template>
                                <template x-if="isFilled(preview.bannerSubtitle)">
                                    <p class="text-muted-foreground" x-text="preview.bannerSubtitle"></p>
                                </template>
                            </div>
                            <template x-if="isFilled(preview.bannerImageUrl)">
                                <div class="overflow-hidden rounded-3xl ring-1 ring-foreground/10 bg-background">
                                    <img :src="preview.bannerImageUrl"
                                        :alt="preview.bannerAlt || preview.bannerTitle || '{{ __('ui.banner_image_137d2d') }}'"
                                        class="h-48 w-full object-cover sm:h-64" loading="lazy">
                                </div>
                            </template>
                        </div>
                    </div>
                </section>
            </template>

            <template x-if="hasAboutSection()">
                <section class="w-full border-t border-border py-12 md:py-24">
                    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="grid gap-10 lg:grid-cols-2 lg:items-center">
                            <div class="space-y-4">
                                <template x-if="isFilled(preview.aboutTitle)">
                                    <h2 class="text-2xl font-bold tracking-tight sm:text-3xl"
                                        x-text="preview.aboutTitle"></h2>
                                </template>
                                <template x-if="isFilled(preview.aboutBody)">
                                    <p class="text-muted-foreground" x-text="preview.aboutBody"></p>
                                </template>
                            </div>
                            <template x-if="isFilled(preview.aboutImageUrl)">
                                <div class="overflow-hidden rounded-3xl ring-1 ring-foreground/10 bg-background">
                                    <img :src="preview.aboutImageUrl"
                                        :alt="preview.aboutAlt || preview.aboutTitle || '{{ __('ui.about_image_57d7f4') }}'"
                                        class="h-48 w-full object-cover sm:h-64" loading="lazy">
                                </div>
                            </template>
                        </div>
                    </div>
                </section>
            </template>

            <template x-if="hasSecuritySection()">
                <section class="w-full border-t border-border py-12 md:py-24">
                    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="grid gap-10 lg:grid-cols-2 lg:items-center">
                            <div class="space-y-4">
                                <template x-if="isFilled(preview.securityTitle)">
                                    <h2 class="text-2xl font-bold tracking-tight sm:text-3xl"
                                        x-text="preview.securityTitle"></h2>
                                </template>
                                <template x-if="isFilled(preview.securityBody)">
                                    <p class="text-muted-foreground" x-text="preview.securityBody"></p>
                                </template>
                            </div>
                            <template x-if="isFilled(preview.securityImageUrl)">
                                <div class="overflow-hidden rounded-3xl ring-1 ring-foreground/10 bg-background">
                                    <img :src="preview.securityImageUrl"
                                        :alt="preview.securityAlt || preview.securityTitle || '{{ __('ui.security_image_117ee2') }}'"
                                        class="h-48 w-full object-cover sm:h-64" loading="lazy">
                                </div>
                            </template>
                        </div>
                    </div>
                </section>
            </template>

            <template x-if="visibleArticles().length > 0">
                <section class="w-full border-t border-border py-12 md:py-24">
                    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="mb-8 space-y-2">
                            <h2 class="text-2xl font-bold tracking-tight sm:text-3xl">{{ __('ui.articles') }}</h2>
                        </div>
                        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                            <template x-for="(article, index) in visibleArticles()" :key="'preview-article-' + index">
                                <article class="rounded-2xl ring-1 ring-foreground/10 bg-card p-6">
                                    <template x-if="isFilled(article.imageUrl)">
                                        <div class="mb-4 overflow-hidden rounded-xl">
                                            <img :src="article.imageUrl"
                                                :alt="article.alt || article.title || '{{ __('ui.article_image_77275d') }}'"
                                                class="h-40 w-full object-cover" loading="lazy">
                                        </div>
                                    </template>

                                    <template x-if="isFilled(article.title)">
                                        <h3 class="text-lg font-semibold text-foreground" x-text="article.title"></h3>
                                    </template>

                                    <template x-if="isFilled(article.excerpt)">
                                        <p class="mt-2 text-sm text-muted-foreground" x-text="article.excerpt"></p>
                                    </template>

                                    <template x-if="isFilled(article.url)">
                                        <a :href="article.url" :target="articleTarget(article.url)"
                                            class="mt-4 inline-flex items-center text-sm font-medium text-primary hover:underline">
                                            {{ __('ui.read_more') }}
                                        </a>
                                    </template>
                                </article>
                            </template>
                        </div>
                    </div>
                </section>
            </template>

            <template x-if="hasFeatures()">
                <section class="w-full border-t border-border py-12 md:py-24 lg:py-32">
                    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-3">
                            <template x-for="(feature, index) in preview.features" :key="'preview-feature-' + index">
                                <div class="flex flex-col items-center space-y-4 text-center">
                                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-primary/10">
                                        <svg class="h-8 w-8 text-primary" aria-hidden="true" focusable="false">
                                            <use :href="'#' + featureIconId(feature.icon)"></use>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold" x-text="feature.title || ''"></h3>
                                    <p class="text-muted-foreground" x-text="feature.description || ''"></p>
                                </div>
                            </template>
                        </div>
                    </div>
                </section>
            </template>
        </main>

        <footer class="border-t border-border py-6 md:py-0">
            <div
                class="container mx-auto flex flex-col items-center justify-between gap-4 px-4 sm:px-6 lg:px-8 md:h-14 md:flex-row">
                <p class="text-center text-sm leading-loose text-muted-foreground md:text-left" x-text="footerText()">
                </p>
            </div>
        </footer>
    </div>
</div>
