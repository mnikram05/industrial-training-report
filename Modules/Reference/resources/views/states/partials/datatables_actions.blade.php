<x-datatable-actions-menu>
    <x-datatable-action-link :href="route('reference.parliaments.index', ['state_id' => $state->id])">
        {{ __('modules/reference/parliament.plural') }}
    </x-datatable-action-link>

    <x-datatable-action-link :href="route('reference.districts.index', ['state_id' => $state->id])">
        {{ __('modules/reference/district.plural') }}
    </x-datatable-action-link>

    <x-datatable-action-link :href="route('reference.states.edit', $state)">
        {{ __('crud.edit') }}
    </x-datatable-action-link>

    <form method="POST" action="{{ route('reference.states.destroy', $state) }}"
        onsubmit="return confirm('{{ __('crud.are_you_sure') }}')">
        @csrf
        @method('DELETE')
        <button type="submit"
            class="hover:bg-accent hover:text-accent-foreground flex w-full items-center rounded-sm px-2 py-1.5 text-sm text-destructive">
            {{ __('crud.delete') }}
        </button>
    </form>
</x-datatable-actions-menu>
