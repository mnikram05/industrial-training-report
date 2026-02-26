<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-neutral-900">
    <div class="flex flex-col items-center min-h-screen pt-6 sm:justify-center sm:pt-0 bg-neutral-100">
        <div>
            <a href="/" class="inline-flex items-center gap-2 text-neutral-700">
                <svg class="size-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 12l8-4.5M12 12L4 7.5M12 12v9" />
                </svg>
            </a>
        </div>

        <x-card class="mt-6 w-full p-6 sm:max-w-md">
            {{ $slot }}
        </x-card>
    </div>
</body>

</html>
