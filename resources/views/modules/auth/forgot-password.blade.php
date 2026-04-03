<x-guest-layout>
    <x-card module class="w-full shadow-card ring-1 ring-black/[0.03] dark:shadow-card-dark dark:ring-white/[0.06]">
        <x-card-header>
            <x-card-title>{{ __('modules/login.forgot.heading') }}</x-card-title>
            <x-card-description>
                {{ __('modules/login.forgot.description') }}
            </x-card-description>
        </x-card-header>

        @if (session('status'))
            <x-card-content>
                <x-alert>
                    <x-alert-description>{{ session('status') }}</x-alert-description>
                </x-alert>
            </x-card-content>
        @endif

        {{ html()->form('POST', route('password.email'))->open() }}
        <x-card-content class="space-y-4">
            <div class="space-y-1.5">
                <x-label for="email">{{ __('modules/login.field.email') }}</x-label>
                <x-input id="email" class="w-full" type="email" name="email" :value="old('email')" required autofocus
                    autocomplete="username" placeholder="{{ __('modules/login.field.email') }}" />
                @error('email')
                    <p class="mt-1 text-sm font-medium text-destructive">{{ $message }}</p>
                @enderror
            </div>
        </x-card-content>

        <x-card-footer class="flex flex-col gap-3 border-t border-border/60 bg-muted/20 sm:flex-row sm:items-center sm:justify-between dark:bg-muted/10">
            <a href="{{ route('login') }}"
                class="text-sm text-muted-foreground underline-offset-4 hover:text-foreground hover:underline">{{ __('modules/login.forgot.back') }}</a>
            <x-button type="submit">{{ __('modules/login.forgot.submit') }}</x-button>
        </x-card-footer>
        {{ html()->form()->close() }}
    </x-card>
</x-guest-layout>
