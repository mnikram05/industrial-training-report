<x-app-layout>
    <x-module-index-shell>
        <x-slot:heading>{{ __('modules/reference/dun.plural') }}</x-slot:heading>
        <x-slot:subtitle>{{ __('modules/reference/dun.subtitle') }}</x-slot:subtitle>

        <x-slot:actions>
            <x-index-actions resource="reference.duns" :showExport="false" :showImport="false">
                <x-slot:create>{{ __('modules/reference/dun.new') }}</x-slot:create>
            </x-index-actions>
        </x-slot:actions>

        @include('reference::duns.table')
    </x-module-index-shell>
</x-app-layout>
