<x-app-layout>
    <x-module-index-shell :latest-export-path="$latestExportPath ?? null">
        <x-slot:heading>{{ __('modules/portal-administration/article.plural') }}</x-slot:heading>
        <x-slot:subtitle>{{ __('modules/portal-administration/article.subtitle') }}</x-slot:subtitle>

        <x-slot:actions>
            <x-index-actions resource="articles">
                <x-slot:create>{{ __('modules/portal-administration/article.new') }}</x-slot:create>
            </x-index-actions>
        </x-slot:actions>

        @include('portaladministration::articles.table')
    </x-module-index-shell>
</x-app-layout>
