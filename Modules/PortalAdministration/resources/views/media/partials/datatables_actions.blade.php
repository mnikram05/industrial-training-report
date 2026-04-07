<x-datatable-actions-menu>
    @can(\App\Modules\Role\Constants\RolePermissionConstants::MEDIA_VIEW)
        <x-datatable-action-link :href="route('media.show', $media)">
            {{ __('crud.view') }}
        </x-datatable-action-link>
    @endcan

    @can(\App\Modules\Role\Constants\RolePermissionConstants::MEDIA_DELETE)
        <form method="POST" action="{{ route('media.destroy', $media) }}"
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
