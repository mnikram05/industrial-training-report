<x-guest-layout>
    <div class="mb-4 text-sm text-neutral-600">
        {{ __("Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.") }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 text-sm font-medium text-emerald-700">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        {{ html()->form('POST', route('verification.send'))->open() }}
        <div>
            <x-button type="submit">
                {{ __('Resend Verification Email') }}
            </x-button>
        </div>
        {{ html()->form()->close() }}

        {{ html()->form('POST', route('logout'))->open() }}
        <button type="submit"
            class="text-sm underline rounded-md text-neutral-600 hover:text-neutral-900 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-neutral-400 focus-visible:ring-offset-2">
            {{ __('Log Out') }}
        </button>
        {{ html()->form()->close() }}
    </div>
</x-guest-layout>
