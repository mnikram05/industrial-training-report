<x-guest-layout>
    <div class="mb-4 text-sm text-neutral-600">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    {{ html()->form('POST', route('password.confirm'))->open() }}
    <!-- Password -->
    <div>
        <x-label for="password">{{ __('Password') }}</x-label>

        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
            autocomplete="current-password" />

        @error('password')
            <p class="mt-2 text-sm font-medium text-destructive">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex justify-end mt-4">
        <x-button type="submit">
            {{ __('Confirm') }}
        </x-button>
    </div>
    {{ html()->form()->close() }}
</x-guest-layout>
