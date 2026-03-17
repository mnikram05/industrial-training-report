<x-app-layout>

    <x-card module>
        <x-card-header flush>
            <x-card-title>{{ __('modules/reference/menu.create') }}</x-card-title>
        </x-card-header>

        <x-card-content flush>
            {{ html()->form('POST', route('reference.menus.store'))->id('create-menu-form')->open() }}
            @include('reference::menus.fields', ['menu' => null])
            {{ html()->form()->close() }}

            <x-button-group plain end>
                <x-button as="a" variant="outline" href="{{ route('reference.menus.index') }}">{{ __('crud.cancel') }}</x-button>
                <x-button type="submit" form="create-menu-form">{{ __('modules/reference/menu.create') }}</x-button>
            </x-button-group>
        </x-card-content>
    </x-card>
</x-app-layout>
