<x-app-layout>
    <x-module-index-shell>
        <x-slot:heading>{{ __('modules/reference/menu.plural') }}</x-slot:heading>
        <x-slot:subtitle>{{ __('modules/reference/menu.subtitle') }}</x-slot:subtitle>

        <x-slot:actions>
            <x-index-actions resource="reference.menus" :showExport="false" :showImport="false">
                <x-slot:create>{{ __('modules/reference/menu.new') }}</x-slot:create>
            </x-index-actions>
        </x-slot:actions>

        @include('reference::menus.table')
    </x-module-index-shell>
</x-app-layout>
