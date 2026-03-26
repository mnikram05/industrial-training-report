<x-app-layout>

    <x-card module>
        <x-card-header flush>
            <x-card-title>{{ $dataReference->label_my ?? $dataReference->name }} — {{ __('modules/reference/data-reference.create_child') }}</x-card-title>
        </x-card-header>

        <x-card-content flush>
            {{ html()->form('POST', route('reference.data-references.children.store', $dataReference))->id('create-child-form')->open() }}
            @include('reference::data-references.fields-child', ['child' => null])
            {{ html()->form()->close() }}

            <x-button-group plain end>
                <x-button as="a" variant="outline" href="{{ route('reference.data-references.children', $dataReference) }}">{{ __('crud.cancel') }}</x-button>
                <x-button type="submit" form="create-child-form">{{ __('modules/reference/data-reference.create_child') }}</x-button>
            </x-button-group>
        </x-card-content>
    </x-card>
</x-app-layout>
