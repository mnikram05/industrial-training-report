<x-app-layout>

    <x-card module>
        <x-card-content flush stacked>
            <x-detail-grid>
                <x-detail-field :value="$user->name">
                    <x-slot:labelText>{{ __('Name') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$user->email">
                    <x-slot:labelText>{{ __('Email') }}</x-slot:labelText>
                </x-detail-field>
            </x-detail-grid>

            <x-button-group plain end spaced>
                <a href="{{ route('users.edit', $user) }}">
                    <x-button variant="secondary">{{ __('Edit User') }}</x-button>
                </a>
            </x-button-group>
        </x-card-content>
    </x-card>
</x-app-layout>
