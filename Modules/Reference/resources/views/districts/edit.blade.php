<x-app-layout>

    <x-card module>
        <x-card-header flush>
            <x-card-title>{{ __('modules/reference/district.edit') }}: {{ $district->name }}</x-card-title>
        </x-card-header>

        <x-card-content flush>
            {{ html()->form('PUT', route('reference.districts.update', $district))->id('edit-district-form')->open() }}
            @include('reference::districts.fields')
            {{ html()->form()->close() }}

            <x-button-group plain end>
                <x-button as="a" variant="outline" href="{{ route('reference.districts.index') }}">{{ __('crud.cancel') }}</x-button>
                <x-button type="submit" form="edit-district-form">{{ __('crud.update') }}</x-button>
            </x-button-group>
        </x-card-content>
    </x-card>
</x-app-layout>
