<x-app-layout>

    <x-card module>
        <x-card-header flush>
            <x-card-title>{{ __('modules/reference/menu.edit') }}: {{ $menu->title_en }}</x-card-title>
        </x-card-header>

        <x-card-content flush>
            {{ html()->form('PUT', route('reference.menus.update', $menu))->id('edit-menu-form')->open() }}
            @include('reference::menus.fields')
            {{ html()->form()->close() }}

            <x-button-group plain end>
                <x-button as="a" variant="outline" href="{{ route('reference.menus.index') }}">{{ __('crud.cancel') }}</x-button>
                <x-button type="submit" form="edit-menu-form">{{ __('crud.update') }}</x-button>
            </x-button-group>
        </x-card-content>
    </x-card>
</x-app-layout>
