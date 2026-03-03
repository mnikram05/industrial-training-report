<x-app-layout>

    <x-card module>
        <x-card-header flush>
            <x-card-title>{{ __('Create District') }}</x-card-title>
        </x-card-header>

        <x-card-content flush>
            {{ html()->form('POST', route('reference.districts.store'))->id('create-district-form')->open() }}
            @include('modules.districts.fields', ['district' => null])
            {{ html()->form()->close() }}

            <x-button-group plain end>
                <x-button type="submit" form="create-district-form">{{ __('Create District') }}</x-button>
            </x-button-group>
        </x-card-content>
    </x-card>
</x-app-layout>
