<x-app-layout>
    <x-module-index-shell :latest-export-path="$latestExportPath ?? null">
        <x-slot:heading>{{ __('ui.users') }}</x-slot:heading>
        <x-slot:subtitle>{{ __('ui.manage_application_users') }}</x-slot:subtitle>

        <x-slot:actions>
            <x-index-actions resource="users">
                <x-slot:create>{{ __('ui.new_user') }}</x-slot:create>
            </x-index-actions>
        </x-slot:actions>

        @include('modules.users.table')
    </x-module-index-shell>
</x-app-layout>
