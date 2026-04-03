<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('app.document_title') }}</title>

    <script>
        (function() {
            if (localStorage.getItem('theme') === 'dark') {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('layouts.partials.portal-admin-theme')
    @php
        $portalPublicColors = \Modules\PortalAdministration\Models\PortalSetting::forPage('header-footer');
        if ($portalPublicColors === []) {
            $portalPublicColors = \Modules\PortalAdministration\Models\PortalSetting::forPage('home');
        }
        $guestHeaderBgLight = $portalPublicColors['color_header_bg'] ?? '#0f172a';
        $guestHeaderBgDark = $portalPublicColors['dark_header_bg'] ?? '#020617';
    @endphp
    <style>
        :root {
            --portal-header-bg: {{ $guestHeaderBgLight }};
        }

        html.dark {
            --portal-header-bg: {{ $guestHeaderBgDark }};
        }
    </style>
</head>

<body class="font-sans antialiased min-h-screen bg-[var(--portal-header-bg)] text-white" x-data>
    <div class="fixed right-3 top-3 z-50 sm:right-4 sm:top-4">
        <button type="button" @click="$store.layout.toggleTheme()"
            class="inline-flex size-9 items-center justify-center rounded-full border border-white/20 bg-white/10 text-white shadow-md backdrop-blur-sm transition hover:bg-white/20 hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/40"
            title="{{ __('modules/login.guest.theme_aria_label') }}" aria-label="{{ __('modules/login.guest.theme_aria_label') }}">
            <svg x-cloak x-show="$store.layout.theme !== 'dark'" class="size-4" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364 6.364-1.414-1.414M7.05 7.05 5.636 5.636m12.728 0L16.95 7.05M7.05 16.95l-1.414 1.414" />
                <circle cx="12" cy="12" r="4" />
            </svg>
            <svg x-cloak x-show="$store.layout.theme === 'dark'" class="size-4" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 12.79A9 9 0 1 1 11.21 3A7 7 0 0 0 21 12.79z" />
            </svg>
        </button>
    </div>

    <div class="flex min-h-screen flex-col items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
        <header class="mb-8 w-full max-w-md text-center">
            <h1 class="text-balance text-xl font-semibold tracking-tight text-white drop-shadow-sm sm:text-2xl">
                {{ __('app.document_title') }}
            </h1>
        </header>

        <div class="w-full max-w-md">
            {{ $slot }}
        </div>
    </div>
</body>

</html>
