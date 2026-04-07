<x-datatable-actions-menu>
    @can(\App\Modules\Role\Constants\RolePermissionConstants::STATUSES_VIEW)
        @if (is_string($showUrl ?? null) && $showUrl !== '')
            <x-datatable-action-link :href="$showUrl">
                {{ __('ui.view') }}
            </x-datatable-action-link>
        @endif
    @endcan

    @can(\App\Modules\Role\Constants\RolePermissionConstants::STATUSES_EDIT)
        <x-datatable-action-link :href="route('statuses.edit', $status)">
            {{ __('ui.edit') }}
        </x-datatable-action-link>
    @endcan
</x-datatable-actions-menu>
