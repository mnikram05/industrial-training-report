<x-datatable-actions-menu>
    <x-datatable-action-link :href="route('roles.show', $role)">
        {{ __('ui.view') }}
    </x-datatable-action-link>

    <x-datatable-action-link :href="route('roles.edit', $role)">
        {{ __('ui.edit') }}
    </x-datatable-action-link>
</x-datatable-actions-menu>
