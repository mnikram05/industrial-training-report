<x-datatable-actions-menu>
    <x-datatable-action-link :href="route('reference.duns.show', $dun)">
        {{ __('View') }}
    </x-datatable-action-link>

    <x-datatable-action-link :href="route('reference.duns.edit', $dun)">
        {{ __('Edit') }}
    </x-datatable-action-link>
</x-datatable-actions-menu>
