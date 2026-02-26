<x-tabs :value="old('_auth_tab', $active ?? 'login') === 'register' ? 'register' : 'login'" class="w-full max-w-md">
    <x-tabs-list class="grid w-full grid-cols-2">
        <x-tabs-trigger value="login">{{ __('Login') }}</x-tabs-trigger>
        <x-tabs-trigger value="register">{{ __('Register') }}</x-tabs-trigger>
    </x-tabs-list>

    <x-tabs-content value="login" class="mt-3">
        <x-card>
            <x-card-header>
                <x-card-title>{{ __('Login') }}</x-card-title>
                <x-card-description>{{ __('Sign in with your email and password.') }}</x-card-description>
            </x-card-header>

            @if (filled($status ?? null))
                <x-card-content>
                    <x-alert>
                        <x-alert-description>{{ $status ?? '' }}</x-alert-description>
                    </x-alert>
                </x-card-content>
            @endif

            {{ html()->form('POST', route('login'))->open() }}
            {{ html()->hidden('_auth_tab', 'login') }}

            <x-card-content class="space-y-3">
                <div class="space-y-1.5">
                    <x-label for="login_username">{{ __('Email') }}</x-label>
                    <x-input id="login_username" type="email" name="email" :value="old('email')"
                        placeholder="{{ __('Email') }}" required autofocus autocomplete="username" class="w-full" />
                    @error('email')
                        <p class="mt-1 text-sm font-medium text-destructive">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <x-label for="login_password">{{ __('Password') }}</x-label>
                    <x-input id="login_password" type="password" name="password" placeholder="{{ __('Password') }}"
                        required autocomplete="current-password" class="w-full" />
                    @error('password')
                        <p class="mt-1 text-sm font-medium text-destructive">{{ $message }}</p>
                    @enderror
                </div>

                <label for="remember_me" class="inline-flex items-center gap-2">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="text-sm text-muted-foreground">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <div>
                        <a href="{{ route('password.request') }}"
                            class="text-sm text-muted-foreground underline underline-offset-4 hover:text-foreground">{{ __('Forgot your password?') }}</a>
                    </div>
                @endif
            </x-card-content>

            <x-card-footer class="justify-end pt-4">
                <x-button type="submit">{{ __('Log in') }}</x-button>
            </x-card-footer>
            {{ html()->form()->close() }}
        </x-card>
    </x-tabs-content>

    <x-tabs-content value="register" class="mt-3">
        <x-card>
            <x-card-header>
                <x-card-title>{{ __('Register') }}</x-card-title>
                <x-card-description>{{ __('Create your account with your name and password.') }}</x-card-description>
            </x-card-header>

            {{ html()->form('POST', route('register'))->open() }}
            {{ html()->hidden('_auth_tab', 'register') }}

            <x-card-content class="space-y-3">
                <div class="space-y-1.5">
                    <x-label for="register_username">{{ __('Name') }}</x-label>
                    <x-input id="register_username" type="text" name="name" :value="old('name')"
                        placeholder="{{ __('Name') }}" required autocomplete="name" class="w-full" />
                    @error('name')
                        <p class="mt-1 text-sm font-medium text-destructive">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <x-label for="register_email">{{ __('Email') }}</x-label>
                    <x-input id="register_email" type="email" name="email" :value="old('email')"
                        placeholder="{{ __('Email') }}" required autocomplete="username" class="w-full" />
                    @error('email')
                        <p class="mt-1 text-sm font-medium text-destructive">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <x-label for="register_password">{{ __('Password') }}</x-label>
                    <x-input id="register_password" type="password" name="password" placeholder="{{ __('Password') }}"
                        required autocomplete="new-password" class="w-full" />
                    @error('password')
                        <p class="mt-1 text-sm font-medium text-destructive">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <x-label for="register_password_confirmation">{{ __('Confirm Password') }}</x-label>
                    <x-input id="register_password_confirmation" type="password" name="password_confirmation"
                        placeholder="{{ __('Confirm Password') }}" required autocomplete="new-password"
                        class="w-full" />
                    @error('password_confirmation')
                        <p class="mt-1 text-sm font-medium text-destructive">{{ $message }}</p>
                    @enderror
                </div>
            </x-card-content>

            <x-card-footer class="justify-end pt-4">
                <x-button type="submit">{{ __('Register') }}</x-button>
            </x-card-footer>
            {{ html()->form()->close() }}
        </x-card>
    </x-tabs-content>
</x-tabs>
