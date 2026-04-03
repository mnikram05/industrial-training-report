<x-guest-layout>
    <x-card module class="w-full shadow-card ring-1 ring-black/[0.03] dark:shadow-card-dark dark:ring-white/[0.06]">
        <x-card-header>
            <x-card-title>{{ __('modules/login.reset.heading') }}</x-card-title>
            <x-card-description>{{ __('modules/login.reset.description') }}</x-card-description>
        </x-card-header>

        {{ html()->form('POST', route('password.store'))->open() }}
        {{ html()->hidden('token', $request->route('token')) }}

        <x-card-content class="space-y-4">
            <div class="space-y-1.5">
                <x-label for="email">{{ __('modules/login.field.email') }}</x-label>
                <x-input id="email" class="w-full" type="email" name="email" :value="old('email', $request->email)" required
                    autofocus autocomplete="username" />
                @error('email')
                    <p class="mt-1 text-sm font-medium text-destructive">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-1.5">
                <x-label for="password">{{ __('modules/login.field.password') }}</x-label>
                <x-input id="password" class="w-full" type="password" name="password" required autocomplete="new-password" />
                @error('password')
                    <p class="mt-1 text-sm font-medium text-destructive">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-1.5">
                <x-label for="password_confirmation">{{ __('modules/login.field.confirm_password') }}</x-label>
                <x-input id="password_confirmation" class="w-full" type="password" name="password_confirmation" required
                    autocomplete="new-password" />
                @error('password_confirmation')
                    <p class="mt-1 text-sm font-medium text-destructive">{{ $message }}</p>
                @enderror
            </div>
        </x-card-content>

        <x-card-footer class="justify-end border-t border-border/60 bg-muted/20 dark:bg-muted/10">
            <x-button type="submit">{{ __('modules/login.reset.submit') }}</x-button>
        </x-card-footer>
        {{ html()->form()->close() }}
    </x-card>
</x-guest-layout>
