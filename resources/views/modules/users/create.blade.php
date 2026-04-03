<x-app-layout>

    <x-card module>
        <x-card-header flush>
            <x-card-title>{{ __('ui.create_user') }}</x-card-title>
        </x-card-header>

        <x-card-content flush>
            {{ html()->form('POST', route('users.store'))->id('create-user-management-form')->open() }}
            @include('modules.users.fields', [
                'user' => null,
                'availableRoleOptions' => $availableRoleOptions ?? [],
            ])
            {{ html()->form()->close() }}

            <x-button-group plain end>
                <x-button type="submit" form="create-user-management-form">{{ __('ui.create_user') }}</x-button>
            </x-button-group>
        </x-card-content>
    </x-card>
</x-app-layout>
