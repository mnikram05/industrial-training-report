<x-app-layout>
    <x-module-index-shell :latest-export-path="$latestExportPath ?? null">
        <x-slot:heading>{{ __('ui.landings') }}</x-slot:heading>
        <x-slot:subtitle>{{ __('ui.manage_static_landings') }}</x-slot:subtitle>

        <x-slot:actions>
            <x-index-actions resource="landings">
                <x-slot:create>{{ __('ui.new_landing') }}</x-slot:create>
            </x-index-actions>
        </x-slot:actions>

        @include('modules.landings.table')
    </x-module-index-shell>
</x-app-layout>
