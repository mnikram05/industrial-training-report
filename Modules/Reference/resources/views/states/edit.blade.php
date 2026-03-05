<x-app-layout>

    <x-card module>
        <x-card-header flush>
            <x-card-title>{{ __('Edit State') }}: {{ $state->name }}</x-card-title>
        </x-card-header>

        <x-card-content flush>
            {{ html()->form('PUT', route('reference.states.update', $state))->id('edit-state-form')->open() }}
            @include('reference::states._form')
            {{ html()->form()->close() }}

            <x-button-group plain end>
                <x-button as="a" variant="outline" href="{{ route('reference.states.index') }}">{{ __('Cancel') }}</x-button>
                <x-button type="submit" form="edit-state-form">{{ __('Update') }}</x-button>
            </x-button-group>
        </x-card-content>
    </x-card>
</x-app-layout>
