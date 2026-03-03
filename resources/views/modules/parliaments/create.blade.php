<x-app-layout>

    <x-card module>
        <x-card-header flush>
            <x-card-title>{{ __('Create Parliament') }}</x-card-title>
        </x-card-header>

        <x-card-content flush>
            {{ html()->form('POST', route('reference.parliaments.store'))->id('create-parliament-form')->open() }}
            @include('modules.parliaments.fields', ['parliament' => null])
            {{ html()->form()->close() }}

            <x-button-group plain end>
                <x-button type="submit" form="create-parliament-form">{{ __('Create Parliament') }}</x-button>
            </x-button-group>
        </x-card-content>
    </x-card>
</x-app-layout>
