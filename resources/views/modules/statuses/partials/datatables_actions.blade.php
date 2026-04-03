<x-datatable-actions-menu>
    @if (is_string($showUrl ?? null) && $showUrl !== '')
        <x-datatable-action-link :href="$showUrl">
            {{ __('ui.view') }}
        </x-datatable-action-link>
    @endif

    <x-datatable-action-link :href="route('statuses.edit', $status)">
        {{ __('ui.edit') }}
    </x-datatable-action-link>
</x-datatable-actions-menu>
