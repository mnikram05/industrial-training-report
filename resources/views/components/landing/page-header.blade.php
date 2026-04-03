@props([
    'currentLocale' => 'en',
    'localeLabels' => [],
    'canRegister' => false,
])

@php
    $activeLocaleLabel = $localeLabels[$currentLocale] ?? __('ui.language');
@endphp

<header
    class="sticky top-0 z-50 w-full border-b border-border bg-background/95 backdrop-blur supports-backdrop-filter:bg-background/60">
    <div class="container mx-auto flex min-h-14 flex-wrap items-center gap-2 px-4 py-2 sm:px-6 lg:px-8">
        <div class="mr-auto flex">
            <a href="{{ route('home') }}" class="mr-6 flex items-center space-x-2">
                <span class="font-bold">{{ config('app.name', 'Laravel') }}</span>
            </a>
        </div>

        <div class="flex w-full items-center justify-end sm:w-auto">
            <nav class="flex w-full flex-wrap items-center justify-end gap-2 sm:w-auto">
                <x-dropdown-menu class="w-full sm:w-auto">
                    <x-dropdown-menu-trigger
                        class="inline-flex h-8 w-full shrink-0 items-center justify-between gap-2 whitespace-nowrap rounded-md border border-input bg-background px-3 text-sm font-medium shadow-xs transition-all outline-none hover:bg-accent hover:text-accent-foreground focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50 sm:w-auto sm:justify-center"
                        :aria-label="__('ui.switch_language')">
                        <span>{{ $activeLocaleLabel }}</span>
                        <svg class="size-4" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                            <path d="M5 7.5L10 12.5L15 7.5" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </x-dropdown-menu-trigger>

                    <x-dropdown-menu-content class="w-40 space-y-0.5 p-1">
                        @foreach ($localeLabels as $localeCode => $localeLabel)
                            <form method="POST" action="{{ route('locale.switch') }}" class="w-full">
                                @csrf
                                <input type="hidden" name="locale" value="{{ $localeCode }}">
                                <x-dropdown-menu-item type="submit"
                                    class="w-full justify-between gap-2 rounded-md px-2 py-1.5 text-left text-sm leading-5 transition-colors {{ $currentLocale === $localeCode ? 'bg-accent text-accent-foreground' : '' }}">
                                    <span>{{ $localeLabel }}</span>
                                    @if ($currentLocale === $localeCode)
                                        <svg class="size-4" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                                            <path d="M5 10L8.5 13.5L15 7" stroke="currentColor" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    @endif
                                </x-dropdown-menu-item>
                            </form>
                        @endforeach
                    </x-dropdown-menu-content>
                </x-dropdown-menu>

                @auth
                    <x-button as="a" href="{{ route('dashboard') }}" size="sm">
                        {{ __('ui.dashboard') }}
                    </x-button>
                @else
                    <x-button as="a" href="{{ route('login') }}" variant="outline" size="sm">
                        {{ __('ui.login') }}
                    </x-button>
                    @if ($canRegister)
                        <x-button as="a" href="{{ route('register') }}" size="sm">
                            {{ __('ui.register') }}
                        </x-button>
                    @endif
                @endauth
            </nav>
        </div>
    </div>
</header>
