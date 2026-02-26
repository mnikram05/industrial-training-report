<x-app-layout>
    <x-module-index-shell :latest-export-path="$latestExportPath ?? null">
        <x-slot:heading>{{ __('Articles') }}</x-slot:heading>
        <x-slot:subtitle>{{ __('Manage your article content.') }}</x-slot:subtitle>

        <x-slot:actions>
            <x-index-actions resource="articles">
                <x-slot:create>{{ __('New Article') }}</x-slot:create>
            </x-index-actions>
        </x-slot:actions>

        @include('modules.articles.table')
    </x-module-index-shell>
</x-app-layout>
