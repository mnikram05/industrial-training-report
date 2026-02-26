<x-app-layout>
    <x-module-index-shell :latest-export-path="$latestExportPath ?? null">
        <x-slot:heading>{{ __('Activity Logs') }}</x-slot:heading>
        <x-slot:subtitle>{{ __('Recent application activity.') }}</x-slot:subtitle>

        <x-slot:actions>
            <x-index-actions resource="activity-logs" :show-import="false" :show-create="false" />
        </x-slot:actions>

        @include('modules.activity-logs.table')
    </x-module-index-shell>
</x-app-layout>
