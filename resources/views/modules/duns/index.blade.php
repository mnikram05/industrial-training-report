<x-app-layout>
    <x-module-index-shell>
        <x-slot:heading>{{ __('DUNs') }}</x-slot:heading>
        <x-slot:subtitle>{{ __('Manage reference DUNs (Dewan Undangan Negeri).') }}</x-slot:subtitle>

        <x-slot:actions>
            <x-index-actions resource="reference.duns" :showExport="false" :showImport="false">
                <x-slot:create>{{ __('New DUN') }}</x-slot:create>
            </x-index-actions>
        </x-slot:actions>

        @include('modules.duns.table')
    </x-module-index-shell>
</x-app-layout>
