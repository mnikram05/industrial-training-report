<x-app-layout>

    <x-card module>
        <x-card-header flush>
            <x-card-title>{{ __('modules/portal-administration/article.create') }}</x-card-title>
        </x-card-header>

        <x-card-content flush>
            {{ html()->form('POST', route('articles.store'))->id('create-article-management-form')->acceptsFiles()->open() }}
            @include('portaladministration::articles.fields', ['article' => null])
            {{ html()->form()->close() }}

            <x-button-group plain end>
                <x-button as="a" variant="outline" href="{{ route('articles.index') }}">{{ __('crud.cancel') }}</x-button>
                <x-button type="submit" form="create-article-management-form">{{ __('modules/portal-administration/article.create') }}</x-button>
            </x-button-group>
        </x-card-content>
    </x-card>
</x-app-layout>
