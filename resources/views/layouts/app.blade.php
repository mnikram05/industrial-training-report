<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <script>
        (function() {
            if (localStorage.getItem('theme') === 'dark') {
                document.documentElement.classList.add('dark');
            }

            if (localStorage.getItem('sidebar:collapsed') === '1') {
                document.documentElement.classList.add('sidebar-collapsed');
            }
        })();
    </script>

    <style>
        @media (min-width: 1024px) {
            html.sidebar-collapsed .js-sidebar {
                transform: translateX(-100%);
            }

            html.sidebar-collapsed .js-app-content {
                padding-left: 0 !important;
            }
        }
    </style>

    <!-- Scripts -->
    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('layouts.partials.portal-admin-theme')
    @stack('styles')
</head>

<body class="font-sans antialiased" x-data>
    <div class="admin-shell min-h-screen">
        @include('layouts.partials.navigation')

        <div class="js-app-content admin-content-pane min-h-screen pt-14 lg:pt-0 lg:pl-60"
            :class="$store.layout.sidebarCollapsed ? 'lg:pl-0' : ''">
            <!-- Page Heading -->
            @php
                $breadcrumbItems = \App\Support\Breadcrumbs\Breadcrumbs::current();
                $hasPageHeading = isset($header) || $breadcrumbItems !== [];
            @endphp

            @if ($hasPageHeading)
                <header class="admin-page-header">
                    <div class="flex items-start justify-between gap-3 px-4 py-5 sm:px-6 lg:px-8">
                        <div class="min-w-0 flex-1 space-y-2">
                            <x-breadcrumb :items="$breadcrumbItems" />

                            @isset($header)
                                {{ $header }}
                            @endisset
                        </div>

                        <div class="hidden items-center gap-2 lg:flex">
                            <x-global-search />

                            <button type="button" @click="$store.layout.toggleTheme()"
                                class="inline-flex size-9 items-center justify-center rounded-md border border-input bg-background text-muted-foreground shadow-xs transition-colors hover:bg-accent hover:text-foreground"
                                title="{{ __('Theme') }}" aria-label="{{ __('Theme') }}">
                                <svg x-cloak x-show="$store.layout.theme !== 'dark'" class="size-4" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364 6.364-1.414-1.414M7.05 7.05 5.636 5.636m12.728 0L16.95 7.05M7.05 16.95l-1.414 1.414" />
                                    <circle cx="12" cy="12" r="4" />
                                </svg>
                                <svg x-cloak x-show="$store.layout.theme === 'dark'" class="size-4" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 12.79A9 9 0 1 1 11.21 3A7 7 0 0 0 21 12.79z" />
                                </svg>
                            </button>

                            <button type="button" @click="$store.layout.toggleSidebar()"
                                class="inline-flex size-9 items-center justify-center rounded-md border border-input bg-background text-muted-foreground shadow-xs transition-colors hover:bg-accent hover:text-foreground"
                                :title="$store.layout.sidebarCollapsed ? '{{ __('Expand') }}' : '{{ __('Collapse') }}'"
                                :aria-label="$store.layout.sidebarCollapsed ? '{{ __('Expand') }}' : '{{ __('Collapse') }}'">
                                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.8">
                                    <rect x="3" y="3" width="18" height="18" rx="2" />
                                    <path d="M9 3v18" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="admin-main px-4 py-7 sm:px-6 sm:py-8 lg:px-8">
                @unless ($hasPageHeading)
                    <div class="mb-4 hidden items-center justify-end gap-2 lg:flex">
                        <x-global-search />

                        <button type="button" @click="$store.layout.toggleTheme()"
                            class="inline-flex size-9 items-center justify-center rounded-md border border-input bg-background text-muted-foreground shadow-xs transition-colors hover:bg-accent hover:text-foreground"
                            title="{{ __('Theme') }}" aria-label="{{ __('Theme') }}">
                            <svg x-cloak x-show="$store.layout.theme !== 'dark'" class="size-4" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364 6.364-1.414-1.414M7.05 7.05 5.636 5.636m12.728 0L16.95 7.05M7.05 16.95l-1.414 1.414" />
                                <circle cx="12" cy="12" r="4" />
                            </svg>
                            <svg x-cloak x-show="$store.layout.theme === 'dark'" class="size-4" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 12.79A9 9 0 1 1 11.21 3A7 7 0 0 0 21 12.79z" />
                            </svg>
                        </button>

                        <button type="button" @click="$store.layout.toggleSidebar()"
                            class="inline-flex size-9 items-center justify-center rounded-md border border-input bg-background text-muted-foreground shadow-xs transition-colors hover:bg-accent hover:text-foreground"
                            :title="$store.layout.sidebarCollapsed ? '{{ __('Expand') }}' : '{{ __('Collapse') }}'"
                            :aria-label="$store.layout.sidebarCollapsed ? '{{ __('Expand') }}' : '{{ __('Collapse') }}'">
                            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <rect x="3" y="3" width="18" height="18" rx="2" />
                                <path d="M9 3v18" />
                            </svg>
                        </button>
                    </div>
                @endunless

                {{ $slot }}
            </main>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
