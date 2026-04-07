<x-datatable-actions-menu>
    @can(\App\Modules\Role\Constants\RolePermissionConstants::DATA_REFERENCES_EDIT)
        <x-datatable-action-link :href="route('reference.data-references.edit', $dataReference)">
            {{ __('crud.edit') }}
        </x-datatable-action-link>
    @endcan

    @can(\App\Modules\Role\Constants\RolePermissionConstants::DATA_REFERENCES_DELETE)
        <form method="POST" action="{{ route('reference.data-references.destroy', $dataReference) }}"
            onsubmit="return confirm('{{ __('crud.are_you_sure') }}')">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="hover:bg-accent hover:text-accent-foreground flex w-full items-center rounded-sm px-2 py-1.5 text-sm text-destructive">
                {{ __('crud.delete') }}
            </button>
        </form>
    @endcan
</x-datatable-actions-menu>
