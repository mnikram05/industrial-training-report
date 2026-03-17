<x-app-layout>

    <x-card module>
        <x-card-header flush>
            <x-card-title>{{ __('modules/reference/data-reference.edit') }}: {{ $dataReference->name }}</x-card-title>
        </x-card-header>

        <x-card-content flush>
            {{ html()->form('PUT', route('reference.data-references.update', $dataReference))->id('edit-data-reference-form')->open() }}
            @include('reference::data-references.fields')
            {{ html()->form()->close() }}

            <x-button-group plain end>
                <x-button as="a" variant="outline" href="{{ route('reference.data-references.index') }}">{{ __('crud.cancel') }}</x-button>
                <x-button type="submit" form="edit-data-reference-form">{{ __('crud.update') }}</x-button>
            </x-button-group>
        </x-card-content>
    </x-card>
</x-app-layout>
