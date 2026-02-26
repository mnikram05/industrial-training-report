<div class="space-y-4 pb-6">
    <x-field for="user_name" :error="$errors->first('name')" class="gap-1.5">
        <x-slot:labelText>{{ __('Name') }}</x-slot:labelText>
        <x-input id="user_name" name="name" type="text" class="w-full" placeholder="{{ __('User name') }}"
            :value="old('name', $user?->name ?? '')" />
    </x-field>

    <x-field for="user_email" :error="$errors->first('email')" class="gap-1.5">
        <x-slot:labelText>{{ __('Email') }}</x-slot:labelText>
        <x-input id="user_email" name="email" type="email" class="w-full" placeholder="{{ __('User email') }}"
            :value="old('email', $user?->email ?? '')" />
    </x-field>

    @if (($availableRoleOptions ?? []) !== [])
        <x-field for="user_role" :error="$errors->first('role')" class="gap-1.5">
            <x-slot:labelText>{{ __('Role') }}</x-slot:labelText>
            <x-combobox id="user_role" name="role" class="w-full" :options="$availableRoleOptions ?? []" :value="old('role', $user?->roles->pluck('name')->first() ?? '')"
                placeholder="{{ __('Select a role') }}" search-placeholder="{{ __('Search roles...') }}" />
        </x-field>
    @endif

    <div class="grid gap-4 sm:grid-cols-2">
        <x-field for="user_password" :error="$errors->first('password')" class="gap-1.5">
            <x-slot:labelText>{{ __('Password') }}</x-slot:labelText>
            <x-input id="user_password" name="password" type="password" class="w-full"
                placeholder="{{ __('Password') }}" />
        </x-field>

        <x-field for="user_password_confirmation" class="gap-1.5">
            <x-slot:labelText>{{ __('Confirm Password') }}</x-slot:labelText>
            <x-input id="user_password_confirmation" name="password_confirmation" type="password" class="w-full"
                placeholder="{{ __('Confirm Password') }}" />
        </x-field>
    </div>
</div>
