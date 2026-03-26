<x-app-layout>
    <x-module-index-shell>
        <x-slot:heading>{{ __('modules/portal-administration/menu.plural') }}</x-slot:heading>
        <x-slot:subtitle>{{ __('modules/portal-administration/menu.subtitle') }}</x-slot:subtitle>

        <x-slot:actions>
            <x-index-actions resource="portal-administration.menus" :showExport="false" :showImport="false">
                <x-slot:create>{{ __('modules/portal-administration/menu.new') }}</x-slot:create>
            </x-index-actions>
        </x-slot:actions>

        @include('portaladministration::menus.table')
    </x-module-index-shell>
</x-app-layout>
