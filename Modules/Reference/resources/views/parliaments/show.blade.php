<x-app-layout>

    <x-card module>
        <x-card-content flush stacked>
            <x-detail-grid>
                <x-detail-field :value="$parliament->name">
                    <x-slot:labelText>{{ __('modules/reference/parliament.fields.name') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$parliament->state?->name ?? '—'">
                    <x-slot:labelText>{{ __('modules/reference/parliament.fields.state') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$parliament->ddsa_code ?? '—'">
                    <x-slot:labelText>{{ __('modules/reference/parliament.fields.ddsa_code') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$parliament->new_code ?? '—'">
                    <x-slot:labelText>{{ __('modules/reference/parliament.fields.new_code') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="(string) ($parliament->sort ?? 0)">
                    <x-slot:labelText>{{ __('modules/reference/parliament.fields.sort') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$parliament->created_at?->format('M j, Y H:i') ?? '—'">
                    <x-slot:labelText>{{ __('modules/reference/parliament.fields.created_at') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$parliament->updated_at?->format('M j, Y H:i') ?? '—'">
                    <x-slot:labelText>{{ __('modules/reference/parliament.fields.updated_at') }}</x-slot:labelText>
                </x-detail-field>
            </x-detail-grid>

            <x-button-group plain end spaced>
                <a href="{{ route('reference.parliaments.edit', $parliament) }}">
                    <x-button variant="secondary">{{ __('modules/reference/parliament.edit') }}</x-button>
                </a>
            </x-button-group>
        </x-card-content>
    </x-card>
</x-app-layout>
