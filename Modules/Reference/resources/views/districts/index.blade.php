<x-app-layout>
    <x-module-index-shell>
        <x-slot:heading>{{ __('modules/reference/district.plural') }}</x-slot:heading>
        <x-slot:subtitle>{{ __('modules/reference/district.subtitle') }}</x-slot:subtitle>

        <x-slot:actions>
            <x-index-actions resource="reference.districts" :showExport="false" :showImport="false">
                <x-slot:create>{{ __('modules/reference/district.new') }}</x-slot:create>
            </x-index-actions>
        </x-slot:actions>

        @include('reference::districts.table')
    </x-module-index-shell>
</x-app-layout>
