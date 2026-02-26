<x-app-layout>

    <x-card module>
        <x-card-header flush>
            <x-card-title>{{ __('Create Article') }}</x-card-title>
        </x-card-header>

        <x-card-content flush>
            {{ html()->form('POST', route('articles.store'))->id('create-article-management-form')->open() }}
            @include('modules.articles.fields', ['article' => null])
            {{ html()->form()->close() }}

            <x-button-group plain end>
                <x-button type="submit" form="create-article-management-form">{{ __('Create Article') }}</x-button>
            </x-button-group>
        </x-card-content>
    </x-card>
</x-app-layout>
