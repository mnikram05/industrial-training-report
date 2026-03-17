<x-app-layout>
    <x-module-index-shell>
        <x-slot:heading>{{ __('modules/reference/parliament.plural') }}</x-slot:heading>
        <x-slot:subtitle>{{ __('modules/reference/parliament.subtitle') }}</x-slot:subtitle>

        <x-slot:actions>
            <x-index-actions resource="reference.parliaments" :showExport="false" :showImport="false">
                <x-slot:create>{{ __('modules/reference/parliament.new') }}</x-slot:create>
            </x-index-actions>
        </x-slot:actions>

        @include('reference::parliaments.table')
    </x-module-index-shell>
</x-app-layout>