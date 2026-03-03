<x-app-layout>

    <x-card module>
        <x-card-header flush>
            <x-card-title>{{ __('Create State') }}</x-card-title>
        </x-card-header>

        <x-card-content flush>
            {{ html()->form('POST', route('reference.states.store'))->id('create-state-form')->open() }}
            @include('modules.states.fields', ['state' => null])
            {{ html()->form()->close() }}

            <x-button-group plain end>
                <x-button type="submit" form="create-state-form">{{ __('Create State') }}</x-button>
            </x-button-group>
        </x-card-content>
    </x-card>
</x-app-layout>
