<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Not Found') }}</title>
    @vite(['resources/css/app.css'])
</head>

<body class="bg-background text-foreground antialiased">
    <main class="mx-auto flex min-h-screen max-w-3xl flex-col items-center justify-center px-6 text-center">
        <p class="text-sm font-medium text-muted-foreground">404</p>
        <h1 class="mt-2 text-3xl font-semibold">{{ __('Page not found') }}</h1>
        <p class="mt-2 text-sm text-muted-foreground">{{ __('The page you are looking for does not exist.') }}</p>
        <a href="{{ url('/') }}"
            class="mt-6 inline-flex h-9 items-center rounded-md border px-4 text-sm">{{ __('Back to home') }}</a>
    </main>
</body>

</html>
