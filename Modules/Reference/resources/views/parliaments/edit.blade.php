<x-app-layout>

    <x-card module>
        <x-card-header flush>
            <x-card-title>{{ __('modules/reference/parliament.edit') }}: {{ $parliament->name }}</x-card-title>
        </x-card-header>

        <x-card-content flush>
            {{ html()->form('PUT', route('reference.parliaments.update', $parliament))->id('edit-parliament-form')->open() }}
            @include('reference::parliaments.fields')
            {{ html()->form()->close() }}

            <x-button-group plain end>
                <x-button as="a" variant="outline" href="{{ route('reference.parliaments.index') }}">{{ __('crud.cancel') }}</x-button>
                <x-button type="submit" form="edit-parliament-form">{{ __('crud.update') }}</x-button>
            </x-button-group>
        </x-card-content>
    </x-card>
</x-app-layout>
