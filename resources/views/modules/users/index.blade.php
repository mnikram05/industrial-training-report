<x-app-layout>
    <x-module-index-shell :latest-export-path="$latestExportPath ?? null">
        <x-slot:heading>{{ __('Users') }}</x-slot:heading>
        <x-slot:subtitle>{{ __('Manage application users.') }}</x-slot:subtitle>

        <x-slot:actions>
            <x-index-actions resource="users">
                <x-slot:create>{{ __('New User') }}</x-slot:create>
            </x-index-actions>
        </x-slot:actions>

        @include('modules.users.table')
    </x-module-index-shell>
</x-app-layout>
