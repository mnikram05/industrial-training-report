<x-app-layout>
    <x-module-index-shell :latest-export-path="$latestExportPath ?? null">
        <x-slot:heading>{{ __('Roles') }}</x-slot:heading>
        <x-slot:subtitle>{{ __('Manage roles and permissions.') }}</x-slot:subtitle>

        <x-slot:actions>
            <x-index-actions resource="roles">
                <x-slot:create>{{ __('New Role') }}</x-slot:create>
            </x-index-actions>
        </x-slot:actions>

        @include('modules.roles.table')
    </x-module-index-shell>
</x-app-layout>
