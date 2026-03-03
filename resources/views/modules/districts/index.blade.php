<x-app-layout>
    <x-module-index-shell>
        <x-slot:heading>{{ __('Districts') }}</x-slot:heading>
        <x-slot:subtitle>{{ __('Manage reference districts.') }}</x-slot:subtitle>

        <x-slot:actions>
            <x-index-actions resource="reference.districts" :showExport="false" :showImport="false">
                <x-slot:create>{{ __('New District') }}</x-slot:create>
            </x-index-actions>
        </x-slot:actions>

        @include('modules.districts.table')
    </x-module-index-shell>
</x-app-layout>
