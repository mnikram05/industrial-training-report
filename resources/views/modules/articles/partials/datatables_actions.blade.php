<x-datatable-actions-menu>
    <x-datatable-action-link :href="route('articles.edit', $article)">
        {{ __('Edit') }}
    </x-datatable-action-link>

    @if ($canViewPublished)
        <x-datatable-action-link :href="route('articles.show', $article)">
            {{ __('View') }}
        </x-datatable-action-link>
    @endif
</x-datatable-actions-menu>
