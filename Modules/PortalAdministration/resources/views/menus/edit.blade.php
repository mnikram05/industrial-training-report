<x-app-layout>

    <x-card module>
        <x-card-header flush>
            <x-card-title>{{ __('modules/portal-administration/menu.edit') }}: {{ $menu->title_en }}</x-card-title>
        </x-card-header>

        <x-card-content flush>
            {{ html()->form('PUT', route('portal-administration.menus.update', $menu))->id('edit-menu-form')->open() }}
            @include('portaladministration::menus.fields')
            {{ html()->form()->close() }}

            <x-button-group plain end>
                <x-button as="a" variant="outline" href="{{ route('portal-administration.menus.index') }}">{{ __('crud.cancel') }}</x-button>
                <x-button type="submit" form="edit-menu-form">{{ __('crud.update') }}</x-button>
            </x-button-group>
        </x-card-content>
    </x-card>
</x-app-layout>
