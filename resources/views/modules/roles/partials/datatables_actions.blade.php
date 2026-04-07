<x-datatable-actions-menu>
    @can(\App\Modules\Role\Constants\RolePermissionConstants::ROLES_VIEW)
        <x-datatable-action-link :href="route('roles.show', $role)">
            {{ __('ui.view') }}
        </x-datatable-action-link>
    @endcan

    @can(\App\Modules\Role\Constants\RolePermissionConstants::ROLES_EDIT)
        <x-datatable-action-link :href="route('roles.edit', $role)">
            {{ __('ui.edit') }}
        </x-datatable-action-link>
    @endcan
</x-datatable-actions-menu>
