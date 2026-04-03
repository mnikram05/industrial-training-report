<div class="space-y-4 pb-6">
    <x-field for="role_name" :error="$errors->first('name')" class="gap-1.5">
        <x-slot:labelText>{{ __('ui.name') }}</x-slot:labelText>
        <x-input id="role_name" name="name" type="text" class="w-full" placeholder="{{ __('ui.role_name_2164e4') }}"
            :value="old('name', $role?->name ?? '')" />
    </x-field>

    <x-field :error="$errors->first('permissions') ?: $errors->first('permissions.*')" class="gap-2">
        <x-slot:labelText>{{ __('ui.permissions') }}</x-slot:labelText>
        <x-slot:descriptionText>{{ __('ui.select_what_this_role_can_access') }}</x-slot:descriptionText>
        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
            @forelse (($availablePermissions ?? []) as $permission)
                <label for="{{ 'role_permission_' . str_replace(['.', '-'], '_', $permission) }}"
                    class="flex items-center gap-2 rounded-md border border-border px-3 py-2 text-sm">
                    <x-checkbox id="{{ 'role_permission_' . str_replace(['.', '-'], '_', $permission) }}"
                        name="permissions[]" :value="$permission" :checked="collect(old('permissions', $selectedPermissions ?? []))->containsStrict($permission)" />
                    <span>{{ $permission }}</span>
                </label>
            @empty
                <p class="text-sm text-muted-foreground">{{ __('ui.no_permissions_available') }}</p>
            @endforelse
        </div>
    </x-field>
</div>
