<x-datatable-actions-menu>
    @can(\App\Modules\Role\Constants\RolePermissionConstants::ACTIVITY_LOGS_VIEW)
        <x-datatable-action-link :href="route('activity-logs.show', $activity)">
            {{ __('ui.view') }}
        </x-datatable-action-link>
    @endcan
</x-datatable-actions-menu>
