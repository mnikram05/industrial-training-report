<x-datatable-actions-menu>
    <x-datatable-action-link :href="route('reference.states.show', $state)">
        {{ __('View') }}
    </x-datatable-action-link>

    <x-datatable-action-link :href="route('reference.states.edit', $state)">
        {{ __('Edit') }}
    </x-datatable-action-link>
</x-datatable-actions-menu>
