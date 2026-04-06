<x-datatable-actions-menu>
    <x-datatable-action-link :href="route('reference.data-references.children', $dataReference)">
        {{ __('modules/reference/data-reference.children_list') }}
    </x-datatable-action-link>

    @if ($dataReference->label_ms === 'Jenis Menu')
        <x-datatable-action-link :href="route('portal-administration.menus.index')">
            {{ __('modules/portal-administration/menu.plural') }}
        </x-datatable-action-link>
    @elseif ($dataReference->label_ms === 'Jenis Dokumen')
        <x-datatable-action-link :href="route('articles.index')">
            {{ __('modules/portal-administration/article.plural') }}
        </x-datatable-action-link>
    @elseif ($dataReference->label_ms === 'Jenis Media')
        <x-datatable-action-link :href="route('media.index')">
            {{ __('modules/portal-administration/media.plural') }}
        </x-datatable-action-link>
    @endif

    <x-datatable-action-link :href="route('reference.data-references.edit', $dataReference)">
        {{ __('crud.edit') }}
    </x-datatable-action-link>

    <form method="POST" action="{{ route('reference.data-references.destroy', $dataReference) }}"
        onsubmit="return confirm('{{ __('crud.are_you_sure') }}')">
        @csrf
        @method('DELETE')
        <button type="submit"
            class="hover:bg-accent hover:text-accent-foreground flex w-full items-center rounded-sm px-2 py-1.5 text-sm text-destructive">
            {{ __('crud.delete') }}
        </button>
    </form>
</x-datatable-actions-menu>
