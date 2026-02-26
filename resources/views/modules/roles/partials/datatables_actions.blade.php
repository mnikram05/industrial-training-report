<x-datatable-actions-menu>
    <x-datatable-action-link :href="route('roles.show', $role)">
        {{ __('View') }}
    </x-datatable-action-link>

    <x-datatable-action-link :href="route('roles.edit', $role)">
        {{ __('Edit') }}
    </x-datatable-action-link>
</x-datatable-actions-menu>
