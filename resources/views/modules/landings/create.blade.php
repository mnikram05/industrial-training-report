<x-app-layout>

    <x-card module>
        <x-card-header flush>
            <x-card-title>{{ __('ui.create_landing') }}</x-card-title>
        </x-card-header>

        <x-card-content flush>
            {{ html()->form('POST', route('landings.store'))->attribute('enctype', 'multipart/form-data')->id('create-landing-management-form')->open() }}
            @include('modules.landings.fields', ['landing' => null])
            {{ html()->form()->close() }}

            <x-button-group plain end>
                <x-button type="submit" form="create-landing-management-form">{{ __('ui.create_landing') }}</x-button>
            </x-button-group>
        </x-card-content>
    </x-card>
</x-app-layout>
