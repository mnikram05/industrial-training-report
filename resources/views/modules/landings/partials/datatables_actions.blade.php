<x-datatable-actions-menu>
    @can(\App\Modules\Role\Constants\RolePermissionConstants::LANDINGS_EDIT)
        <x-datatable-action-link :href="route('landings.edit', $landing)">
            {{ __('ui.edit') }}
        </x-datatable-action-link>
    @endcan
</x-datatable-actions-menu>
