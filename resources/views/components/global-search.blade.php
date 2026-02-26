@props([
    'placeholder' => __('Search'),
])

@php
    $globalSearchEndpoint = \Illuminate\Support\Facades\Route::has('search.global')
        ? route('search.global', absolute: false)
        : null;
@endphp

<div {{ $attributes->merge(['class' => 'relative w-48 sm:w-56 lg:w-64 xl:w-72 max-w-full']) }} x-data="{
    endpoint: @js($globalSearchEndpoint),
    query: '',
    results: [],
    open: false,
    loading: false,
    activeIndex: -1,
    abortController: null,
    debounceTimeout: null,
    minLength: 2,
    limit: 5,
    close() {
        this.open = false;
        this.activeIndex = -1;
    },
    clearResults() {
        this.results = [];
        this.close();
    },
    onInput() {
        clearTimeout(this.debounceTimeout);

        if (this.abortController) {
            this.abortController.abort();
            this.abortController = null;
        }

        const term = this.query.trim();

        if (term.length < this.minLength) {
            this.loading = false;
            this.clearResults();
            return;
        }

        this.debounceTimeout = setTimeout(() => {
            this.fetchResults(term);
        }, 250);
    },
    onFocus() {
        if (this.results.length > 0) {
            this.open = true;
        }
    },
    clearSearch() {
        this.query = '';
        this.loading = false;

        if (this.abortController) {
            this.abortController.abort();
            this.abortController = null;
        }

        clearTimeout(this.debounceTimeout);
        this.clearResults();

        this.$nextTick(() => {
            this.$refs.searchInput?.focus();
        });
    },
    async fetchResults(term) {
        if (!this.endpoint) {
            this.loading = false;
            this.clearResults();
            return;
        }

        this.loading = true;
        this.abortController = new AbortController();

        try {
            const response = await fetch(`${this.endpoint}?query=${encodeURIComponent(term)}`, {
                headers: {
                    'Accept': 'application/json',
                },
                signal: this.abortController.signal,
            });

            if (!response.ok) {
                this.loading = false;
                this.clearResults();
                return;
            }

            const payload = await response.json();
            const items = Array.isArray(payload?.data) ? payload.data : [];
            this.results = items.slice(0, this.limit);
            this.open = this.results.length > 0;
            this.activeIndex = this.results.length > 0 ? 0 : -1;
            this.loading = false;
        } catch (error) {
            if (error.name === 'AbortError') {
                return;
            }

            this.loading = false;
            this.clearResults();
        }
    },
    moveDown() {
        if (this.results.length === 0) {
            return;
        }

        this.open = true;
        this.activeIndex = this.activeIndex >= this.results.length - 1 ? 0 : this.activeIndex + 1;
    },
    moveUp() {
        if (this.results.length === 0) {
            return;
        }

        this.open = true;
        this.activeIndex = this.activeIndex <= 0 ? this.results.length - 1 : this.activeIndex - 1;
    },
    navigateActive() {
        if (this.activeIndex < 0 || this.activeIndex >= this.results.length) {
            return;
        }

        window.location.assign(this.results[this.activeIndex].url);
    }
}"
    @keydown.escape.window="close()">
    <label for="global-search-input" class="sr-only">{{ __('Global search') }}</label>

    <div class="relative">
        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-muted-foreground">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <circle cx="11" cy="11" r="7" />
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35" />
            </svg>
        </span>

        <input id="global-search-input" type="search" x-ref="searchInput" x-model="query" autocomplete="off"
            placeholder="{{ $placeholder }}"
            class="flex h-9 w-full rounded-md border border-input bg-background pl-10 pr-10 text-sm shadow-xs outline-none transition-[color,box-shadow] placeholder:text-muted-foreground focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50 [&::-webkit-search-cancel-button]:hidden [&::-webkit-search-cancel-button]:appearance-none [&::-webkit-search-decoration]:appearance-none"
            :disabled="!endpoint" @input="onInput()" @focus="onFocus()" @keydown.arrow-down.prevent="moveDown()"
            @keydown.arrow-up.prevent="moveUp()" @keydown.enter.prevent="navigateActive()" />

        <span x-cloak x-show="loading"
            class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-muted-foreground">
            <svg class="size-4 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3a9 9 0 1 0 9 9" />
            </svg>
        </span>

        <x-button type="button" variant="ghost" size="icon-xs" x-cloak x-show="!loading && query.length > 0"
            @click="clearSearch()" title="{{ __('Clear') }}" aria-label="{{ __('Clear') }}"
            class="absolute inset-y-0 right-1 my-auto text-muted-foreground hover:text-foreground">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m18 6-12 12" />
                <path stroke-linecap="round" stroke-linejoin="round" d="m6 6 12 12" />
            </svg>
            <span class="sr-only">{{ __('Clear') }}</span>
        </x-button>
    </div>

    <div x-cloak x-show="open" x-transition.opacity.duration.120ms @click.outside="close()"
        class="absolute left-0 right-0 top-[calc(100%+0.375rem)] z-40 overflow-hidden rounded-md border border-border bg-popover shadow-md">
        <p
            class="border-b border-border px-3 py-2 text-[11px] font-medium uppercase tracking-wide text-muted-foreground">
            {{ __('Top 5 results') }}
        </p>

        <div class="max-h-72 overflow-y-auto p-1.5">
            <template x-for="(result, index) in results" :key="`${result.type}-${result.id}`">
                <a :href="result.url" class="block rounded-sm px-2.5 py-2 transition-colors"
                    :class="activeIndex === index ? 'bg-accent text-popover-foreground' :
                        'text-popover-foreground hover:bg-accent/70'"
                    @mouseenter="activeIndex = index" @click="close()">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <p class="truncate text-sm font-medium" x-text="result.title"></p>
                            <p class="truncate text-xs text-muted-foreground" x-text="result.subtitle"></p>
                        </div>
                        <span
                            class="rounded border border-border px-1.5 py-0.5 text-[10px] uppercase tracking-wide text-muted-foreground"
                            x-text="result.label"></span>
                    </div>
                </a>
            </template>
        </div>
    </div>
</div>
