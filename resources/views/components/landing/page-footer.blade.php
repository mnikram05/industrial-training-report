@props([
    'text' => 'Built with Laravel',
])

<footer class="border-t border-border py-6 md:py-0">
    <div
        class="container mx-auto flex flex-col items-center justify-between gap-4 px-4 sm:px-6 lg:px-8 md:h-14 md:flex-row">
        <p class="text-center text-sm leading-loose text-muted-foreground md:text-left">
            {{ $text }}
        </p>
    </div>
</footer>
