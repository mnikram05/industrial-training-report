<x-app-layout>
    <x-module-index-shell :latest-export-path="$latestExportPath ?? null">
        <x-slot:heading>{{ __('Landings') }}</x-slot:heading>
        <x-slot:subtitle>{{ __('Manage static landings.') }}</x-slot:subtitle>

        <x-slot:actions>
            <x-index-actions resource="landings">
                <x-slot:create>{{ __('New Landing') }}</x-slot:create>
            </x-index-actions>
        </x-slot:actions>

        @include('modules.landings.table')
    </x-module-index-shell>
</x-app-layout>
