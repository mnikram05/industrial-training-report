<x-app-layout>
    <x-module-index-shell>
        <x-slot:heading>{{ __('modules/reference/data-reference.plural') }}</x-slot:heading>
        <x-slot:subtitle>{{ __('modules/reference/data-reference.subtitle') }}</x-slot:subtitle>

        <x-slot:actions>
            <x-index-actions resource="reference.data-references" :showExport="false" :showImport="false">
                <x-slot:create>{{ __('modules/reference/data-reference.new') }}</x-slot:create>
            </x-index-actions>
        </x-slot:actions>

        @include('reference::data-references.table')
    </x-module-index-shell>
</x-app-layout>
