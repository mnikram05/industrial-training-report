<x-app-layout>

    <x-card module>
        <x-card-content flush stacked>
            <x-detail-grid>
                <x-detail-field :value="$state->name">
                    <x-slot:labelText>{{ __('Name') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$state->fullname ?? '—'">
                    <x-slot:labelText>{{ __('Full Name') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$state->ddsa_code ?? '—'">
                    <x-slot:labelText>{{ __('DDSA Code') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$state->iso_code ?? '—'">
                    <x-slot:labelText>{{ __('ISO Code') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="(string) $state->sort">
                    <x-slot:labelText>{{ __('Sort Order') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$state->status ? __('Active') : __('Inactive')">
                    <x-slot:labelText>{{ __('Status') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$state->created_at?->format('M j, Y H:i') ?? '—'">
                    <x-slot:labelText>{{ __('Created At') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$state->updated_at?->format('M j, Y H:i') ?? '—'">
                    <x-slot:labelText>{{ __('Updated At') }}</x-slot:labelText>
                </x-detail-field>
            </x-detail-grid>

            <x-button-group plain end spaced>
                <a href="{{ route('reference.states.edit', $state) }}">
                    <x-button variant="secondary">{{ __('Edit State') }}</x-button>
                </a>
            </x-button-group>
        </x-card-content>
    </x-card>
</x-app-layout>
