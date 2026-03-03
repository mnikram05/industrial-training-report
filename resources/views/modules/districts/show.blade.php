<x-app-layout>

    <x-card module>
        <x-card-content flush stacked>
            <x-detail-grid>
                <x-detail-field :value="$district->name">
                    <x-slot:labelText>{{ __('Name') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$district->fullname ?? '—'">
                    <x-slot:labelText>{{ __('Full Name') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$district->state?->name ?? '—'">
                    <x-slot:labelText>{{ __('State') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$district->ddsa_code ?? '—'">
                    <x-slot:labelText>{{ __('DDSA Code') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="(string) ($district->sort ?? 0)">
                    <x-slot:labelText>{{ __('Sort Order') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$district->created_at?->format('M j, Y H:i') ?? '—'">
                    <x-slot:labelText>{{ __('Created At') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$district->updated_at?->format('M j, Y H:i') ?? '—'">
                    <x-slot:labelText>{{ __('Updated At') }}</x-slot:labelText>
                </x-detail-field>
            </x-detail-grid>

            <x-button-group plain end spaced>
                <a href="{{ route('reference.districts.edit', $district) }}">
                    <x-button variant="secondary">{{ __('Edit District') }}</x-button>
                </a>
            </x-button-group>
        </x-card-content>
    </x-card>
</x-app-layout>
