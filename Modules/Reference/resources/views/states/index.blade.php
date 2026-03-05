<x-app-layout>
    <x-module-index-shell>
        <x-slot:heading>{{ __('States') }}</x-slot:heading>
        <x-slot:subtitle>{{ __('Manage reference states.') }}</x-slot:subtitle>

        <x-slot:actions>
            <x-index-actions resource="reference.states" :showExport="false" :showImport="false">
                <x-slot:create>{{ __('New State') }}</x-slot:create>
            </x-index-actions>
        </x-slot:actions>

        @include('reference::states.table')
    </x-module-index-shell>
</x-app-layout>
