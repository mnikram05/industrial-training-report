@props([
    'title' => '',
    'subtitle' => '',
    'primaryText' => '',
    'primaryUrl' => '/login',
    'secondaryText' => '',
    'secondaryUrl' => '#',
])

<section class="w-full py-12 md:py-24 lg:py-32 xl:py-48">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col items-center space-y-4 text-center">
            <div class="space-y-2">
                <h1 class="text-3xl font-bold tracking-tighter sm:text-4xl md:text-5xl lg:text-6xl/none">
                    {{ $title }}
                </h1>
                @if ($subtitle !== '')
                    <p class="mx-auto max-w-175 text-muted-foreground md:text-xl">
                        {{ $subtitle }}
                    </p>
                @endif
            </div>

            <div class="flex flex-wrap items-center justify-center gap-3">
                @auth
                    <x-button as="a" href="{{ route('dashboard') }}" size="lg">
                        {{ __('Go to Dashboard') }}
                    </x-button>
                @else
                    @if ($primaryText !== '')
                        <x-button as="a" href="{{ $primaryUrl !== '' ? $primaryUrl : '/login' }}" size="lg">
                            {{ $primaryText }}
                        </x-button>
                    @endif

                    @if ($secondaryText !== '')
                        <x-button as="a" href="{{ $secondaryUrl !== '' ? $secondaryUrl : '#' }}"
                            target="{{ str_starts_with($secondaryUrl, 'http') ? '_blank' : '_self' }}" variant="outline"
                            size="lg">
                            {{ $secondaryText }}
                        </x-button>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</section>
