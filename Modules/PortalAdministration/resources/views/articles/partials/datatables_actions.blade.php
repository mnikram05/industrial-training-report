<x-datatable-actions-menu>
    <x-datatable-action-link :href="route('articles.edit', $article)">
        {{ __('crud.edit') }}
    </x-datatable-action-link>

    @if ($canViewPublished)
        <x-datatable-action-link :href="route('articles.show', $article)">
            {{ __('crud.view') }}
        </x-datatable-action-link>
    @endif
</x-datatable-actions-menu>
