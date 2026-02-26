<x-app-layout>

    <x-card module>
        <x-card-content flush stacked>
            <x-detail-grid>
                <x-detail-field :value="$activity->event">
                    <x-slot:labelText>{{ __('Event') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$activity->description">
                    <x-slot:labelText>{{ __('Description') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$activity->causer?->name ?? __('System')">
                    <x-slot:labelText>{{ __('Causer') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="optional($activity->created_at)->toDayDateTimeString()">
                    <x-slot:labelText>{{ __('Created At') }}</x-slot:labelText>
                </x-detail-field>
            </x-detail-grid>
        </x-card-content>
    </x-card>
</x-app-layout>
