<x-app-layout>

    <x-card module>
        <x-card-header flush>
            <x-card-title>{{ __('modules/portal-administration/menu.create') }}</x-card-title>
        </x-card-header>

        <x-card-content flush>
            {{ html()->form('POST', route('portal-administration.menus.store'))->id('create-menu-form')->open() }}
            @include('portaladministration::menus.fields', ['menu' => null])
            {{ html()->form()->close() }}

            <x-button-group plain end>
                <x-button as="a" variant="outline" href="{{ route('portal-administration.menus.index') }}">{{ __('crud.cancel') }}</x-button>
                <x-button type="submit" form="create-menu-form">{{ __('modules/portal-administration/menu.create') }}</x-button>
            </x-button-group>
        </x-card-content>
    </x-card>
</x-app-layout>
