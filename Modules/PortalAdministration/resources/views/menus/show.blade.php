<x-app-layout>

    <x-card module>
        <x-card-content flush stacked>
            <x-detail-grid>
                <x-detail-field :value="$menu->title_en ?? '—'">
                    <x-slot:labelText>{{ __('modules/portal-administration/menu.fields.title_en') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$menu->title_ms ?? '—'">
                    <x-slot:labelText>{{ __('modules/portal-administration/menu.fields.title_ms') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$menu->parent?->title_en ?? '—'">
                    <x-slot:labelText>{{ __('modules/portal-administration/menu.fields.parent') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$menu->url ?? '—'">
                    <x-slot:labelText>{{ __('modules/portal-administration/menu.fields.url') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$menu->slug ?? '—'">
                    <x-slot:labelText>{{ __('modules/portal-administration/menu.fields.slug') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$menu->icon ?? '—'">
                    <x-slot:labelText>{{ __('modules/portal-administration/menu.fields.icon') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="(string) ($menu->sort ?? 0)">
                    <x-slot:labelText>{{ __('modules/portal-administration/menu.fields.sort') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$menu->created_at?->format('M j, Y H:i') ?? '—'">
                    <x-slot:labelText>{{ __('modules/portal-administration/menu.fields.created_at') }}</x-slot:labelText>
                </x-detail-field>
                <x-detail-field :value="$menu->updated_at?->format('M j, Y H:i') ?? '—'">
                    <x-slot:labelText>{{ __('modules/portal-administration/menu.fields.updated_at') }}</x-slot:labelText>
                </x-detail-field>
            </x-detail-grid>

            <x-button-group plain end spaced>
                <a href="{{ route('portal-administration.menus.edit', $menu) }}">
                    <x-button variant="secondary">{{ __('modules/portal-administration/menu.edit') }}</x-button>
                </a>
            </x-button-group>
        </x-card-content>
    </x-card>
</x-app-layout>
