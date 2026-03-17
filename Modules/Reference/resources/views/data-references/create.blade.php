<x-app-layout>

    <x-card module>
        <x-card-header flush>
            <x-card-title>{{ __('modules/reference/data-reference.create') }}</x-card-title>
        </x-card-header>

        <x-card-content flush>
            {{ html()->form('POST', route('reference.data-references.store'))->id('create-data-reference-form')->open() }}
            @include('reference::data-references.fields', ['dataReference' => null])
            {{ html()->form()->close() }}

            <x-button-group plain end>
                <x-button as="a" variant="outline" href="{{ route('reference.data-references.index') }}">{{ __('crud.cancel') }}</x-button>
                <x-button type="submit" form="create-data-reference-form">{{ __('modules/reference/data-reference.create') }}</x-button>
            </x-button-group>
        </x-card-content>
    </x-card>
</x-app-layout>
