<x-app-layout>

    <x-card module>
        <x-card-content flush stacked>
            <x-detail-grid>
                <x-detail-field :value="$activity->event">
                    <x-slot:labelText>{{ __('ui.event') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$activity->description">
                    <x-slot:labelText>{{ __('ui.description') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$activity->causer?->name ?? __('ui.system')">
                    <x-slot:labelText>{{ __('ui.causer') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="optional($activity->created_at)->toDayDateTimeString()">
                    <x-slot:labelText>{{ __('ui.created_at') }}</x-slot:labelText>
                </x-detail-field>
            </x-detail-grid>
        </x-card-content>
    </x-card>
</x-app-layout>
