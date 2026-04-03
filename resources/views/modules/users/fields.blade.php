<div class="space-y-4 pb-6">
    <x-field for="user_name" :error="$errors->first('name')" class="gap-1.5">
        <x-slot:labelText>{{ __('ui.name') }}</x-slot:labelText>
        <x-input id="user_name" name="name" type="text" class="w-full" placeholder="{{ __('ui.user_name') }}"
            :value="old('name', $user?->name ?? '')" />
    </x-field>

    <x-field for="user_email" :error="$errors->first('email')" class="gap-1.5">
        <x-slot:labelText>{{ __('ui.email') }}</x-slot:labelText>
        <x-input id="user_email" name="email" type="email" class="w-full" placeholder="{{ __('ui.user_email') }}"
            :value="old('email', $user?->email ?? '')" />
    </x-field>

    @if (($availableRoleOptions ?? []) !== [])
        <x-field for="user_role" :error="$errors->first('role')" class="gap-1.5">
            <x-slot:labelText>{{ __('ui.role') }}</x-slot:labelText>
            <x-combobox id="user_role" name="role" class="w-full" :options="$availableRoleOptions ?? []" :value="old('role', $user?->roles->pluck('name')->first() ?? '')"
                placeholder="{{ __('ui.select_a_role') }}" search-placeholder="{{ __('ui.search_roles') }}" />
        </x-field>
    @endif

    <div class="grid gap-4 sm:grid-cols-2">
        <x-field for="user_password" :error="$errors->first('password')" class="gap-1.5">
            <x-slot:labelText>{{ __('ui.password') }}</x-slot:labelText>
            <x-input id="user_password" name="password" type="password" class="w-full"
                placeholder="{{ __('ui.password') }}" />
        </x-field>

        <x-field for="user_password_confirmation" class="gap-1.5">
            <x-slot:labelText>{{ __('ui.confirm_password') }}</x-slot:labelText>
            <x-input id="user_password_confirmation" name="password_confirmation" type="password" class="w-full"
                placeholder="{{ __('ui.confirm_password') }}" />
        </x-field>
    </div>
</div>
