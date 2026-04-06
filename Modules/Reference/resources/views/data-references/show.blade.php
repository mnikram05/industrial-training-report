<x-app-layout>

    <x-card module>
        <x-card-content flush stacked>
            <x-detail-grid>
                <x-detail-field :value="$dataReference->name">
                    <x-slot:labelText>{{ __('modules/reference/data-reference.fields.name') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$dataReference->label_ms ?? '—'">
                    <x-slot:labelText>{{ __('modules/reference/data-reference.fields.label_ms') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$dataReference->label_en ?? '—'">
                    <x-slot:labelText>{{ __('modules/reference/data-reference.fields.label_en') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$dataReference->parent?->name ?? '—'">
                    <x-slot:labelText>{{ __('modules/reference/data-reference.fields.parent') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="(string) ($dataReference->sort ?? 0)">
                    <x-slot:labelText>{{ __('modules/reference/data-reference.fields.sort') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$dataReference->created_at?->format('M j, Y H:i') ?? '—'">
                    <x-slot:labelText>{{ __('modules/reference/data-reference.fields.created_at') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$dataReference->updated_at?->format('M j, Y H:i') ?? '—'">
                    <x-slot:labelText>{{ __('modules/reference/data-reference.fields.updated_at') }}</x-slot:labelText>
                </x-detail-field>
            </x-detail-grid>

            <x-button-group plain end spaced>
                <a href="{{ route('reference.data-references.edit', $dataReference) }}">
                    <x-button variant="secondary">{{ __('modules/reference/data-reference.edit') }}</x-button>
                </a>
            </x-button-group>
        </x-card-content>
    </x-card>
</x-app-layout>
