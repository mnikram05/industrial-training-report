<x-app-layout>
    <x-module-index-shell :latest-export-path="$latestExportPath ?? null">
        <x-slot:heading>{{ __('ui.roles') }}</x-slot:heading>
        <x-slot:subtitle>{{ __('ui.manage_roles_and_permissions') }}</x-slot:subtitle>

        <x-slot:actions>
            <x-index-actions resource="roles">
                <x-slot:create>{{ __('ui.new_role') }}</x-slot:create>
            </x-index-actions>
        </x-slot:actions>

        @include('modules.roles.table')
    </x-module-index-shell>
</x-app-layout>
