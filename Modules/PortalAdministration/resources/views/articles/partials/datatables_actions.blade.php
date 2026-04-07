<x-datatable-actions-menu>
    @can(\App\Modules\Role\Constants\RolePermissionConstants::ARTICLES_EDIT)
        <x-datatable-action-link :href="route('articles.edit', $article)">
            {{ __('crud.edit') }}
        </x-datatable-action-link>
    @endcan

    @can(\App\Modules\Role\Constants\RolePermissionConstants::ARTICLES_VIEW)
        @if ($canViewPublished)
            <x-datatable-action-link :href="route('articles.show', $article)">
                {{ __('crud.view') }}
            </x-datatable-action-link>
        @endif
    @endcan
</x-datatable-actions-menu>
