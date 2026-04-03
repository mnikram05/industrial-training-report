<x-app-layout>

    <x-card module>
        <x-card-content flush stacked>
            <x-detail-grid>
                <x-detail-field :value="$role->name">
                    <x-slot:labelText>{{ __('ui.role_name') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$role->guard_name">
                    <x-slot:labelText>{{ __('ui.guard') }}</x-slot:labelText>
                </x-detail-field>
            </x-detail-grid>

            <x-button-group plain end spaced>
                <a href="{{ route('roles.edit', $role) }}">
                    <x-button variant="secondary">{{ __('ui.edit_role') }}</x-button>
                </a>
            </x-button-group>
        </x-card-content>
    </x-card>
</x-app-layout>
