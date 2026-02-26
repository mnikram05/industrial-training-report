<x-datatable-actions-menu>
    @if (is_string($showUrl ?? null) && $showUrl !== '')
        <x-datatable-action-link :href="$showUrl">
            {{ __('View') }}
        </x-datatable-action-link>
    @endif

    <x-datatable-action-link :href="route('statuses.edit', $status)">
        {{ __('Edit') }}
    </x-datatable-action-link>
</x-datatable-actions-menu>
