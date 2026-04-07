<x-datatable-actions-menu>
    @can(\App\Modules\Role\Constants\RolePermissionConstants::DUNS_EDIT)
        <x-datatable-action-link :href="route('reference.duns.edit', $dun)">
            {{ __('crud.edit') }}
        </x-datatable-action-link>
    @endcan

    @can(\App\Modules\Role\Constants\RolePermissionConstants::DUNS_DELETE)
        <form method="POST" action="{{ route('reference.duns.destroy', $dun) }}"
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
