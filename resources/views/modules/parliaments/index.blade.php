<x-app-layout>
    <x-module-index-shell>
        <x-slot:heading>{{ __('Parliaments') }}</x-slot:heading>
        <x-slot:subtitle>{{ __('Manage reference parliaments.') }}</x-slot:subtitle>

        <x-slot:actions>
            <x-index-actions resource="reference.parliaments" :showExport="false" :showImport="false">
                <x-slot:create>{{ __('New Parliament') }}</x-slot:create>
            </x-index-actions>
        </x-slot:actions>

        @include('modules.parliaments.table')
    </x-module-index-shell>
</x-app-layout>
