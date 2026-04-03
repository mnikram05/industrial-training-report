<x-guest-layout>
    <x-card module class="w-full shadow-card ring-1 ring-black/[0.03] dark:shadow-card-dark dark:ring-white/[0.06]">
        <x-card-header>
            <x-card-title>{{ __('modules/login.verify_email.heading') }}</x-card-title>
            <x-card-description>
                {{ __('modules/login.verify_email.intro') }}
            </x-card-description>
        </x-card-header>

        @if (session('status') == 'verification-link-sent')
            <x-card-content>
                <x-alert>
                    <x-alert-description>
                        {{ __('modules/login.verify_email.link_sent') }}
                    </x-alert-description>
                </x-alert>
            </x-card-content>
        @endif

        <x-card-footer
            class="flex flex-col gap-3 border-t border-border/60 bg-muted/20 sm:flex-row sm:items-center sm:justify-between dark:bg-muted/10">
            {{ html()->form('POST', route('verification.send'))->open() }}
            <x-button type="submit">{{ __('modules/login.verify_email.resend_button') }}</x-button>
            {{ html()->form()->close() }}

            {{ html()->form('POST', route('logout'))->class('inline')->open() }}
            <button type="submit"
                class="text-sm text-muted-foreground underline-offset-4 transition hover:text-foreground hover:underline">
                {{ __('modules/login.verify_email.log_out') }}
            </button>
            {{ html()->form()->close() }}
        </x-card-footer>
    </x-card>
</x-guest-layout>
