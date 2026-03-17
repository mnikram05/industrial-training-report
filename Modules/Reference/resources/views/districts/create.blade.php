<x-app-layout>

    <x-card module>
        <x-card-header flush>
            <x-card-title>{{ __('modules/reference/district.create') }}</x-card-title>
        </x-card-header>

        <x-card-content flush>
            {{ html()->form('POST', route('reference.districts.store'))->id('create-district-form')->open() }}
            @include('reference::districts.fields', ['district' => null])
            {{ html()->form()->close() }}

            <x-button-group plain end>
                <x-button as="a" variant="outline" href="{{ route('reference.districts.index') }}">{{ __('crud.cancel') }}</x-button>
                <x-button type="submit" form="create-district-form">{{ __('modules/reference/district.create') }}</x-button>
            </x-button-group>
        </x-card-content>
    </x-card>
</x-app-layout>
