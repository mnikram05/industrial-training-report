<x-app-layout>

    <x-card module>
        <x-card-header flush>
            <x-card-title>{{ __('ui.create_status') }}</x-card-title>
        </x-card-header>

        <x-card-content flush>
            {{ html()->form('POST', route('statuses.store'))->id('create-status-management-form')->open() }}
            @include('modules.statuses.fields', ['status' => null])
            {{ html()->form()->close() }}

            <x-button-group plain end>
                <x-button type="submit" form="create-status-management-form">{{ __('ui.create_status') }}</x-button>
            </x-button-group>
        </x-card-content>
    </x-card>
</x-app-layout>
