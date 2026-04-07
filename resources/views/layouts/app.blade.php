<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="idle-auto-logout-minutes" content="{{ config('session.lifetime') }}">
    <meta name="logout-url" content="{{ route('logout', absolute: true) }}">

    <title>{{ __('app.document_title') }}</title>

    <script>
        (function() {
            if (localStorage.getItem('theme') === 'dark') {
                document.documentElement.classList.add('dark');
            }

            // Sidebar sentiasa dibuka; jangan pulihkan state lipat lama (elak sidebar/log hilang tanpa butang toggle).
            localStorage.removeItem('sidebar:collapsed');
            document.documentElement.classList.remove('sidebar-collapsed');
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

        <div
            class="js-app-content admin-content-pane flex min-h-[100dvh] flex-col pl-60 pt-14 lg:pt-20">
            <!-- Page Heading -->
            @php
                $breadcrumbItems = \App\Support\Breadcrumbs\Breadcrumbs::current();
                $hasPageHeading = isset($header) || $breadcrumbItems !== [];
            @endphp

            <!-- Page Content -->
            <main class="admin-main flex-1 px-4 py-7 sm:px-6 sm:py-8 lg:px-8">
                @if ($hasPageHeading)
                    <div class="mb-6 min-w-0 space-y-2">
                        <x-breadcrumb :items="$breadcrumbItems" />

                        @isset($header)
                            {{ $header }}
                        @endisset
                    </div>
                @endif

                {{ $slot }}
            </main>

            @include('layouts.partials.cms-footer')
        </div>
    </div>

    @stack('scripts')
</body>

</html>
