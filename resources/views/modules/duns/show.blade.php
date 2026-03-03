<x-app-layout>

    <x-card module>
        <x-card-content flush stacked>
            <x-detail-grid>
                <x-detail-field :value="$dun->name">
                    <x-slot:labelText>{{ __('Name') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$dun->parliament?->name ?? '—'">
                    <x-slot:labelText>{{ __('Parliament') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$dun->parliament?->state?->name ?? '—'">
                    <x-slot:labelText>{{ __('State') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$dun->ddsa_code ?? '—'">
                    <x-slot:labelText>{{ __('DDSA Code') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$dun->new_code ?? '—'">
                    <x-slot:labelText>{{ __('New Code') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="(string) ($dun->sort ?? 0)">
                    <x-slot:labelText>{{ __('Sort Order') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$dun->created_at?->format('M j, Y H:i') ?? '—'">
                    <x-slot:labelText>{{ __('Created At') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$dun->updated_at?->format('M j, Y H:i') ?? '—'">
                    <x-slot:labelText>{{ __('Updated At') }}</x-slot:labelText>
                </x-detail-field>
            </x-detail-grid>

            <x-button-group plain end spaced>
                <a href="{{ route('reference.duns.edit', $dun) }}">
                    <x-button variant="secondary">{{ __('Edit DUN') }}</x-button>
                </a>
            </x-button-group>
        </x-card-content>
    </x-card>
</x-app-layout>
