<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle ?? config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @php
        $colors = \Modules\PortalAdministration\Models\PortalSetting::forPage('header-footer');
        if (empty($colors)) {
            $colors = \Modules\PortalAdministration\Models\PortalSetting::forPage('home');
        }
        if (!empty($portalPage)) {
            $pageColors = \Modules\PortalAdministration\Models\PortalSetting::forPage($portalPage);
            $colorKeys = [
                'color_header_bg', 'color_hero_bg_from', 'color_hero_bg_to',
                'color_accent', 'color_footer_bg', 'color_body_bg',
                'color_lang_active', 'color_card_bg', 'color_nav_bg', 'color_text',
                'dark_header_bg', 'dark_hero_bg_from', 'dark_hero_bg_to',
                'dark_body_bg', 'dark_card_bg', 'dark_nav_bg',
                'dark_text', 'dark_footer_bg', 'dark_accent',
            ];
            foreach ($colorKeys as $key) {
                if (!empty($pageColors[$key])) {
                    $colors[$key] = $pageColors[$key];
                }
            }
        }
    @endphp
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.7s ease-out both;
        }
        .animate-slide-down {
            animation: slideDown 0.4s ease-out both;
        }
        .portal-nav-link:hover,
        .portal-nav-link.active {
            background: color-mix(in srgb, var(--portal-accent) 20%, transparent);
        }
        :root {
            --portal-header-bg: {{ $colors['color_header_bg'] ?? '#0f172a' }};
            --portal-hero-from: {{ $colors['color_hero_bg_from'] ?? '#0f172a' }};
            --portal-hero-to: {{ $colors['color_hero_bg_to'] ?? '#1e293b' }};
            --portal-accent: {{ $colors['color_accent'] ?? '#f43f5e' }};
            --portal-footer-bg: {{ $colors['color_footer_bg'] ?? '#0f172a' }};
            --portal-body-bg: {{ $colors['color_body_bg'] ?? '#f8fafc' }};
            --portal-lang-active: {{ $colors['color_lang_active'] ?? '#f43f5e' }};
            --portal-card-bg: {{ $colors['color_card_bg'] ?? '#ffffff' }};
            --portal-text: {{ $colors['color_text'] ?? '#1f2937' }};
            --portal-nav-bg: {{ $colors['color_nav_bg'] ?? ($colors['color_accent'] ?? '#f43f5e') }};
        }
        html.dark-portal {
            --portal-header-bg: {{ $colors['dark_header_bg'] ?? '#020617' }};
            --portal-hero-from: {{ $colors['dark_hero_bg_from'] ?? '#020617' }};
            --portal-hero-to: {{ $colors['dark_hero_bg_to'] ?? '#0f172a' }};
            --portal-accent: {{ $colors['dark_accent'] ?? '#fb7185' }};
            --portal-footer-bg: {{ $colors['dark_footer_bg'] ?? '#020617' }};
            --portal-body-bg: {{ $colors['dark_body_bg'] ?? '#0f172a' }};
            --portal-card-bg: {{ $colors['dark_card_bg'] ?? '#1e293b' }};
            --portal-text: {{ $colors['dark_text'] ?? '#e2e8f0' }};
            --portal-nav-bg: {{ $colors['dark_nav_bg'] ?? ($colors['dark_accent'] ?? '#fb7185') }};
        }
    </style>
</head>
<body class="flex min-h-screen flex-col antialiased" style="background-color: var(--portal-body-bg); color: var(--portal-text)"
    x-data="{
        mobileMenuOpen: false,
        darkMode: localStorage.getItem('portal-dark') === 'true',
        toggleDark() {
            this.darkMode = !this.darkMode;
            localStorage.setItem('portal-dark', this.darkMode);
            document.documentElement.classList.toggle('dark-portal', this.darkMode);
        }
    }"
    x-init="document.documentElement.classList.toggle('dark-portal', darkMode)">

    @php $menuUrl = fn ($m) => ($m->url && $m->url !== '#') ? url($m->url) : '#'; @endphp

    {{-- Header Navigation --}}
    <header class="sticky top-0 z-50 animate-slide-down text-white shadow-xl" style="background-color: var(--portal-header-bg)">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-14 items-center justify-between">
                @php $logoPath = $colors['logo_path'] ?? null; @endphp
                <a href="{{ route('portal.home') }}" class="flex shrink-0 items-center gap-2 text-sm font-bold tracking-wide uppercase transition-opacity duration-200 hover:opacity-80">
                    @if ($logoPath)
                        <img src="{{ Storage::disk('public')->url($logoPath) }}" alt="Logo" class="h-7 drop-shadow" />
                    @else
                        <svg class="size-6 drop-shadow" style="color: var(--portal-accent)" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a23.54 23.54 0 0 0-2.688 11.354 23.54 23.54 0 0 1 7.17-2.583M4.26 10.147A23.46 23.46 0 0 1 12 8.243a23.46 23.46 0 0 1 7.74 1.904M12 2.25a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" />
                        </svg>
                    @endif
                    <span class="hidden sm:inline">{{ $colors['site_name_' . app()->getLocale()] ?? $pageTitle ?? config('app.name') }}</span>
                </a>

                <nav class="hidden items-center lg:flex">
                    @foreach ($menuAtas as $menu)
                        @if ($menu->children && $menu->children->count())
                            <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                                <button @click="open = !open"
                                    class="portal-nav-link flex items-center gap-1 rounded px-2 py-1 text-[11px] font-medium text-white/85 transition-all duration-200 hover:text-white">
                                    @if ($menu->icon)<span class="text-[10px]">{!! $menu->icon !!}</span>@endif
                                    {{ app()->getLocale() === 'ms' ? ($menu->title_my ?? $menu->title_en) : ($menu->title_en ?? $menu->title_my) }}
                                    <svg class="size-2.5 transition-transform duration-200" :class="open && 'rotate-180'" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <div x-cloak x-show="open" x-transition.origin.top
                                    class="absolute left-0 top-full z-50 mt-1 min-w-48 rounded-xl border border-white/10 bg-white py-2 shadow-xl">
                                    @foreach ($menu->children as $child)
                                        <a href="{{ $menuUrl($child) }}"
                                            class="flex items-center gap-2 px-4 py-2 text-xs text-gray-700 transition-colors hover:bg-gray-50 hover:text-gray-900">
                                            @if ($child->icon)<span class="text-sm">{!! $child->icon !!}</span>@endif
                                            {{ app()->getLocale() === 'ms' ? ($child->title_my ?? $child->title_en) : ($child->title_en ?? $child->title_my) }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <a href="{{ $menuUrl($menu) }}"
                                class="portal-nav-link flex items-center gap-1 rounded px-2 py-1 text-[11px] font-medium text-white/85 transition-all duration-200 hover:text-white">
                                @if ($menu->icon)<span class="text-[10px]">{!! $menu->icon !!}</span>@endif
                                {{ app()->getLocale() === 'ms' ? ($menu->title_my ?? $menu->title_en) : ($menu->title_en ?? $menu->title_my) }}
                            </a>
                        @endif
                    @endforeach
                </nav>

                <div class="flex shrink-0 items-center gap-2">
                    <div class="flex items-center gap-1 text-sm">
                        <form method="POST" action="{{ route('locale.switch') }}" class="flex items-center gap-1">
                            @csrf
                            <button type="submit" name="locale" value="ms"
                                class="rounded-lg px-2 py-0.5 text-[10px] font-bold tracking-wide transition-all duration-200 {{ app()->getLocale() === 'ms' ? 'text-white shadow-md' : 'text-gray-500 hover:text-gray-300' }}"
                                @if(app()->getLocale() === 'ms') style="background-color: var(--portal-lang-active)" @endif>
                                MY
                            </button>
                            <span class="text-[10px] text-gray-600">|</span>
                            <button type="submit" name="locale" value="en"
                                class="rounded-lg px-2 py-0.5 text-[10px] font-bold tracking-wide transition-all duration-200 {{ app()->getLocale() === 'en' ? 'text-white shadow-md' : 'text-gray-500 hover:text-gray-300' }}"
                                @if(app()->getLocale() === 'en') style="background-color: var(--portal-lang-active)" @endif>
                                EN
                            </button>
                        </form>
                    </div>

                    <button @click="toggleDark()" class="flex size-7 items-center justify-center rounded-lg bg-white/5 text-gray-400 ring-1 ring-white/10 transition-all duration-200 hover:bg-white/15 hover:text-white hover:ring-white/25 hover:shadow-lg">
                        <svg x-show="!darkMode" class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                        </svg>
                        <svg x-show="darkMode" x-cloak class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                        </svg>
                    </button>

                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="inline-flex items-center justify-center rounded-lg p-1.5 text-gray-400 transition-colors hover:bg-white/10 hover:text-white lg:hidden">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            <path x-show="mobileMenuOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div x-cloak x-show="mobileMenuOpen" x-transition.origin.top class="border-t border-white/10 lg:hidden">
            <div class="space-y-1 px-4 py-3">
                @foreach ($menuAtas as $menu)
                    @if ($menu->children && $menu->children->count())
                        <div x-data="{ subOpen: false }">
                            <button @click="subOpen = !subOpen"
                                class="flex w-full items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium text-gray-400 transition-all duration-200 hover:bg-white/10 hover:text-white">
                                <span class="flex items-center gap-2">
                                    @if ($menu->icon)<span>{!! $menu->icon !!}</span>@endif
                                    {{ app()->getLocale() === 'ms' ? ($menu->title_my ?? $menu->title_en) : ($menu->title_en ?? $menu->title_my) }}
                                </span>
                                <svg class="size-4 transition-transform duration-200" :class="subOpen && 'rotate-180'" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div x-cloak x-show="subOpen" x-transition class="ml-4 mt-1 space-y-1 border-l border-white/10 pl-3">
                                @foreach ($menu->children as $child)
                                    <a href="{{ $menuUrl($child) }}"
                                        class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm text-gray-400 transition-all duration-200 hover:bg-white/10 hover:text-white">
                                        @if ($child->icon)<span>{!! $child->icon !!}</span>@endif
                                        {{ app()->getLocale() === 'ms' ? ($child->title_my ?? $child->title_en) : ($child->title_en ?? $child->title_my) }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ $menuUrl($menu) }}"
                            class="flex items-center gap-2 rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->url() === $menuUrl($menu) ? 'bg-white/15 text-white' : 'text-gray-400 hover:bg-white/10 hover:text-white' }}">
                            @if ($menu->icon)<span>{!! $menu->icon !!}</span>@endif
                            {{ app()->getLocale() === 'ms' ? ($menu->title_my ?? $menu->title_en) : ($menu->title_en ?? $menu->title_my) }}
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </header>

    <main class="flex-1">
        {{ $slot }}
    </main>

    <footer class="relative text-gray-400" style="background-color: var(--portal-footer-bg)">
        <div class="h-1" style="background-color: var(--portal-accent)"></div>

        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <div class="text-center">
                @php $footerKey = 'footer_text_' . app()->getLocale(); @endphp
                <p class="text-xs text-gray-500">{{ \Modules\PortalAdministration\Models\PortalSetting::getValue($footerKey, null, 'header-footer') ?? \Modules\PortalAdministration\Models\PortalSetting::getValue($footerKey) ?? '© ' . date('Y') . ' ' . config('app.name') }}</p>
            </div>
        </div>
    </footer>

</body>
</html>
