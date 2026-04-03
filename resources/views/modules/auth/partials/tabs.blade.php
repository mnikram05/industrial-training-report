<x-tabs :value="old('_auth_tab', $active ?? 'login') === 'register' ? 'register' : 'login'" class="w-full">
    <x-card module
        class="w-full !gap-0 !p-0 overflow-hidden !border-2 !border-[var(--portal-accent)] !ring-0 shadow-card dark:!border-[var(--portal-accent)] dark:shadow-card-dark">
        <div class="border-b border-border/80 bg-muted/40 p-1.5 dark:bg-muted/25">
            <x-tabs-list class="grid h-10 w-full grid-cols-2 gap-1 bg-transparent p-0">
                <x-tabs-trigger value="login">{{ __('modules/login.tabs.login') }}</x-tabs-trigger>
                <x-tabs-trigger value="register">{{ __('modules/login.tabs.register') }}</x-tabs-trigger>
            </x-tabs-list>
        </div>

        <x-tabs-content value="login" class="mt-0">
            <x-card-header class="px-6 pt-6">
                <x-card-title>{{ __('modules/login.login.heading') }}</x-card-title>
                <x-card-description>{{ __('modules/login.login.description') }}</x-card-description>
            </x-card-header>

            @if (filled($status ?? null))
                <x-card-content class="px-6 pb-0 pt-0">
                    <x-alert>
                        <x-alert-description>{{ $status ?? '' }}</x-alert-description>
                    </x-alert>
                </x-card-content>
            @endif

            {{ html()->form('POST', route('login'))->open() }}
            {{ html()->hidden('_auth_tab', 'login') }}

            <x-card-content class="space-y-3 px-6 pb-2 pt-2">
                <div class="space-y-1.5">
                    <x-label for="login_username">{{ __('modules/login.field.email') }}</x-label>
                    <x-input id="login_username" type="email" name="email" :value="old('email')"
                        placeholder="{{ __('modules/login.field.email') }}" required autofocus autocomplete="username" class="w-full" />
                    @error('email')
                        <p class="mt-1 text-sm font-medium text-destructive">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <x-label for="login_password">{{ __('modules/login.field.password') }}</x-label>
                    <x-input id="login_password" type="password" name="password" placeholder="{{ __('modules/login.field.password') }}"
                        required autocomplete="current-password" class="w-full" />
                    @error('password')
                        <p class="mt-1 text-sm font-medium text-destructive">{{ $message }}</p>
                    @enderror
                </div>

                <label for="remember_me" class="inline-flex items-center gap-2">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="text-sm text-muted-foreground">{{ __('modules/login.remember_me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <div>
                        <a href="{{ route('password.request') }}"
                            class="text-sm text-muted-foreground underline underline-offset-4 hover:text-foreground">{{ __('modules/login.forgot.link_text') }}</a>
                    </div>
                @endif
            </x-card-content>

            <x-card-footer class="justify-end border-t border-border/60 bg-muted/20 px-6 py-4 dark:bg-muted/10">
                <x-button type="submit">{{ __('modules/login.login.submit') }}</x-button>
            </x-card-footer>
            {{ html()->form()->close() }}
        </x-tabs-content>

        <x-tabs-content value="register" class="mt-0">
            <x-card-header class="px-6 pt-6">
                <x-card-title>{{ __('modules/login.register.heading') }}</x-card-title>
                <x-card-description>{{ __('modules/login.register.description') }}</x-card-description>
            </x-card-header>

            {{ html()->form('POST', route('register'))->open() }}
            {{ html()->hidden('_auth_tab', 'register') }}

            <x-card-content class="space-y-3 px-6 pb-2 pt-2">
                <div class="space-y-1.5">
                    <x-label for="register_username">{{ __('modules/login.field.name') }}</x-label>
                    <x-input id="register_username" type="text" name="name" :value="old('name')"
                        placeholder="{{ __('modules/login.field.name') }}" required autocomplete="name" class="w-full" />
                    @error('name')
                        <p class="mt-1 text-sm font-medium text-destructive">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <x-label for="register_email">{{ __('modules/login.field.email') }}</x-label>
                    <x-input id="register_email" type="email" name="email" :value="old('email')"
                        placeholder="{{ __('modules/login.field.email') }}" required autocomplete="username" class="w-full" />
                    @error('email')
                        <p class="mt-1 text-sm font-medium text-destructive">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <x-label for="register_password">{{ __('modules/login.field.password') }}</x-label>
                    <x-input id="register_password" type="password" name="password" placeholder="{{ __('modules/login.field.password') }}"
                        required autocomplete="new-password" class="w-full" />
                    @error('password')
                        <p class="mt-1 text-sm font-medium text-destructive">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <x-label for="register_password_confirmation">{{ __('modules/login.field.confirm_password') }}</x-label>
                    <x-input id="register_password_confirmation" type="password" name="password_confirmation"
                        placeholder="{{ __('modules/login.field.confirm_password') }}" required autocomplete="new-password"
                        class="w-full" />
                    @error('password_confirmation')
                        <p class="mt-1 text-sm font-medium text-destructive">{{ $message }}</p>
                    @enderror
                </div>
            </x-card-content>

            <x-card-footer class="justify-end border-t border-border/60 bg-muted/20 px-6 py-4 dark:bg-muted/10">
                <x-button type="submit">{{ __('modules/login.register.submit') }}</x-button>
            </x-card-footer>
            {{ html()->form()->close() }}
        </x-tabs-content>
    </x-card>
</x-tabs>
