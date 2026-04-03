<x-app-layout>

    <x-card module>
        <x-card-header flush>
            <x-card-title>{{ __('ui.create_role') }}</x-card-title>
        </x-card-header>

        <x-card-content flush>
            {{ html()->form('POST', route('roles.store'))->id('create-role-management-form')->open() }}
            @include('modules.roles.fields', ['role' => null])
            {{ html()->form()->close() }}

            <x-button-group plain end>
                <x-button type="submit" form="create-role-management-form">{{ __('ui.create_role') }}</x-button>
            </x-button-group>
        </x-card-content>
    </x-card>
</x-app-layout>
