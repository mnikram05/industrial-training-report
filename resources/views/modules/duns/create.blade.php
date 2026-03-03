<x-app-layout>

    <x-card module>
        <x-card-header flush>
            <x-card-title>{{ __('Create DUN') }}</x-card-title>
        </x-card-header>

        <x-card-content flush>
            {{ html()->form('POST', route('reference.duns.store'))->id('create-dun-form')->open() }}
            @include('modules.duns.fields', ['dun' => null])
            {{ html()->form()->close() }}

            <x-button-group plain end>
                <x-button type="submit" form="create-dun-form">{{ __('Create DUN') }}</x-button>
            </x-button-group>
        </x-card-content>
    </x-card>
</x-app-layout>
