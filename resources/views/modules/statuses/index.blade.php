<x-app-layout>
    <x-module-index-shell :latest-export-path="$latestExportPath ?? null">
        <x-slot:heading>{{ __('ui.statuses') }}</x-slot:heading>
        <x-slot:subtitle>{{ __('ui.manage_application_statuses') }}</x-slot:subtitle>

        <x-slot:actions>
            <x-index-actions resource="statuses">
                <x-slot:create>{{ __('ui.new_status') }}</x-slot:create>
            </x-index-actions>
        </x-slot:actions>

        @include('modules.statuses.table')
    </x-module-index-shell>
</x-app-layout>
