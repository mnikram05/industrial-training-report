<x-datatable-actions-menu>
    <x-datatable-action-link :href="route('reference.districts.show', $district)">
        {{ __('View') }}
    </x-datatable-action-link>

    <x-datatable-action-link :href="route('reference.districts.edit', $district)">
        {{ __('Edit') }}
    </x-datatable-action-link>
</x-datatable-actions-menu>
