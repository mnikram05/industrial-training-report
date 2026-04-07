<x-datatable-actions-menu>
    @can(\App\Modules\Role\Constants\RolePermissionConstants::DATA_REFERENCES_VIEW)
        <x-datatable-action-link :href="route('reference.data-references.children', $dataReference)">
            {{ __('modules/reference/data-reference.children_list') }}
        </x-datatable-action-link>
    @endcan

    @if ($dataReference->label_ms === 'Jenis Menu')
        @can(\App\Modules\Role\Constants\RolePermissionConstants::MENUS_VIEW)
            <x-datatable-action-link :href="route('portal-administration.menus.index')">
                {{ __('modules/portal-administration/menu.plural') }}
            </x-datatable-action-link>
        @endcan
    @elseif ($dataReference->label_ms === 'Jenis Dokumen')
        @can(\App\Modules\Role\Constants\RolePermissionConstants::ARTICLES_VIEW)
            <x-datatable-action-link :href="route('articles.index')">
                {{ __('modules/portal-administration/article.plural') }}
            </x-datatable-action-link>
        @endcan
    @elseif ($dataReference->label_ms === 'Jenis Media')
        @can(\App\Modules\Role\Constants\RolePermissionConstants::MEDIA_VIEW)
            <x-datatable-action-link :href="route('media.index')">
                {{ __('modules/portal-administration/media.plural') }}
            </x-datatable-action-link>
        @endcan
    @endif

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
