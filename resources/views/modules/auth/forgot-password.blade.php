<x-guest-layout>
    <div class="mb-4 text-sm text-neutral-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    @if (session('status'))
        <x-alert class="mb-4">
            <x-alert-description>{{ session('status') }}</x-alert-description>
        </x-alert>
    @endif

    {{ html()->form('POST', route('password.email'))->open() }}
    <!-- Email Address -->
    <div>
        <x-label for="email">{{ __('Email') }}</x-label>
        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
            autofocus />
        @error('email')
            <p class="mt-2 text-sm font-medium text-destructive">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center justify-end mt-4">
        <x-button type="submit">
            {{ __('Email Password Reset Link') }}
        </x-button>
    </div>
    {{ html()->form()->close() }}
</x-guest-layout>
