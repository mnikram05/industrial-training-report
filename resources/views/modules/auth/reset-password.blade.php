<x-guest-layout>
    {{ html()->form('POST', route('password.store'))->open() }}
    <!-- Password Reset Token -->
    {{ html()->hidden('token', $request->route('token')) }}

    <!-- Email Address -->
    <div>
        <x-label for="email">{{ __('Email') }}</x-label>
        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus
            autocomplete="username" />
        @error('email')
            <p class="mt-2 text-sm font-medium text-destructive">{{ $message }}</p>
        @enderror
    </div>

    <!-- Password -->
    <div class="mt-4">
        <x-label for="password">{{ __('Password') }}</x-label>
        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
            autocomplete="new-password" />
        @error('password')
            <p class="mt-2 text-sm font-medium text-destructive">{{ $message }}</p>
        @enderror
    </div>

    <!-- Confirm Password -->
    <div class="mt-4">
        <x-label for="password_confirmation">{{ __('Confirm Password') }}</x-label>

        <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation"
            required autocomplete="new-password" />

        @error('password_confirmation')
            <p class="mt-2 text-sm font-medium text-destructive">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center justify-end mt-4">
        <x-button type="submit">
            {{ __('Reset Password') }}
        </x-button>
    </div>
    {{ html()->form()->close() }}
</x-guest-layout>
