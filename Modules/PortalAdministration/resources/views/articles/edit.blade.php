<x-app-layout>

    <x-card module>
        <x-card-header flush>
            <x-card-title>{{ __('modules/portal-administration/article.edit') }}</x-card-title>
        </x-card-header>

        <x-card-content flush>
            <x-flash-status-alert spaced :saved-statuses="['article-created', 'article-updated']" :deleted-statuses="['article-deleted']" />

            {{ html()->form('POST', route('articles.update', $article))->id('edit-article-management-form')->acceptsFiles()->open() }}
            @method('PUT')
            @include('portaladministration::articles.fields')
            {{ html()->form()->close() }}

            <x-button-group plain between>
                <x-button type="submit" variant="destructive"
                    form="delete-article-management-form">{{ __('modules/portal-administration/article.delete') }}</x-button>
                <x-button type="submit" form="edit-article-management-form">{{ __('modules/portal-administration/article.save') }}</x-button>
            </x-button-group>

            {{ html()->form('POST', route('articles.destroy', $article))->id('delete-article-management-form')->class('hidden')->open() }}
            @method('DELETE')
            {{ html()->form()->close() }}
        </x-card-content>
    </x-card>
</x-app-layout>
