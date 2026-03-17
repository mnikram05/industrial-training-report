<x-app-layout>

    <x-card module>
        <x-card-content flush stacked>
            <x-detail-grid>
                <x-detail-field :value="$dun->name">
                    <x-slot:labelText>{{ __('modules/reference/dun.fields.name') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$dun->parliament?->name ?? '—'">
                    <x-slot:labelText>{{ __('modules/reference/dun.fields.parliament') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$dun->parliament?->state?->name ?? '—'">
                    <x-slot:labelText>{{ __('modules/reference/dun.fields.state') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$dun->ddsa_code ?? '—'">
                    <x-slot:labelText>{{ __('modules/reference/dun.fields.ddsa_code') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$dun->new_code ?? '—'">
                    <x-slot:labelText>{{ __('modules/reference/dun.fields.new_code') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="(string) ($dun->sort ?? 0)">
                    <x-slot:labelText>{{ __('modules/reference/dun.fields.sort') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$dun->created_at?->format('M j, Y H:i') ?? '—'">
                    <x-slot:labelText>{{ __('modules/reference/dun.fields.created_at') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$dun->updated_at?->format('M j, Y H:i') ?? '—'">
                    <x-slot:labelText>{{ __('modules/reference/dun.fields.updated_at') }}</x-slot:labelText>
                </x-detail-field>
            </x-detail-grid>

            <x-button-group plain end spaced>
                <a href="{{ route('reference.duns.edit', $dun) }}">
                    <x-button variant="secondary">{{ __('modules/reference/dun.edit') }}</x-button>
                </a>
            </x-button-group>
        </x-card-content>
    </x-card>
</x-app-layout>
