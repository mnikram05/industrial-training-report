<x-app-layout>

    <x-card module>
        <x-card-content flush stacked>
            <x-detail-grid>
                <x-detail-field :value="$district->name">
                    <x-slot:labelText>{{ __('modules/reference/district.fields.name') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$district->fullname ?? '—'">
                    <x-slot:labelText>{{ __('modules/reference/district.fields.fullname') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$district->state?->name ?? '—'">
                    <x-slot:labelText>{{ __('modules/reference/district.fields.state') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$district->ddsa_code ?? '—'">
                    <x-slot:labelText>{{ __('modules/reference/district.fields.ddsa_code') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="(string) ($district->sort ?? 0)">
                    <x-slot:labelText>{{ __('modules/reference/district.fields.sort') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$district->created_at?->format('M j, Y H:i') ?? '—'">
                    <x-slot:labelText>{{ __('modules/reference/district.fields.created_at') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$district->updated_at?->format('M j, Y H:i') ?? '—'">
                    <x-slot:labelText>{{ __('modules/reference/district.fields.updated_at') }}</x-slot:labelText>
                </x-detail-field>
            </x-detail-grid>

            <x-button-group plain end spaced>
                <a href="{{ route('reference.districts.edit', $district) }}">
                    <x-button variant="secondary">{{ __('modules/reference/district.edit') }}</x-button>
                </a>
            </x-button-group>
        </x-card-content>
    </x-card>
</x-app-layout>
