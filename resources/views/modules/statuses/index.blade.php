<x-app-layout>
    <x-module-index-shell :latest-export-path="$latestExportPath ?? null">
        <x-slot:heading>{{ __('Statuses') }}</x-slot:heading>
        <x-slot:subtitle>{{ __('Manage application statuses.') }}</x-slot:subtitle>

        <x-slot:actions>
            <x-index-actions resource="statuses">
                <x-slot:create>{{ __('New Status') }}</x-slot:create>
            </x-index-actions>
        </x-slot:actions>

        @include('modules.statuses.table')
    </x-module-index-shell>
</x-app-layout>
