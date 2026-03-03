<x-datatable-actions-menu>
    <x-datatable-action-link :href="route('reference.parliaments.show', $parliament)">
        {{ __('View') }}
    </x-datatable-action-link>

    <x-datatable-action-link :href="route('reference.parliaments.edit', $parliament)">
        {{ __('Edit') }}
    </x-datatable-action-link>
</x-datatable-actions-menu>
