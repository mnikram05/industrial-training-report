<x-guest-layout>
    <x-card module class="w-full shadow-card ring-1 ring-black/[0.03] dark:shadow-card-dark dark:ring-white/[0.06]">
        <x-card-header>
            <x-card-title>{{ __('modules/login.password_gate.heading') }}</x-card-title>
            <x-card-description>
                {{ __('modules/login.password_gate.description') }}
            </x-card-description>
        </x-card-header>

        {{ html()->form('POST', route('password.confirm'))->open() }}
        <x-card-content class="space-y-4">
            <div class="space-y-1.5">
                <x-label for="password">{{ __('modules/login.field.password') }}</x-label>
                <x-input id="password" class="w-full" type="password" name="password" required
                    autocomplete="current-password" />
                @error('password')
                    <p class="mt-1 text-sm font-medium text-destructive">{{ $message }}</p>
                @enderror
            </div>
        </x-card-content>

        <x-card-footer class="justify-end border-t border-border/60 bg-muted/20 dark:bg-muted/10">
            <x-button type="submit">{{ __('modules/login.password_gate.submit') }}</x-button>
        </x-card-footer>
        {{ html()->form()->close() }}
    </x-card>
</x-guest-layout>
