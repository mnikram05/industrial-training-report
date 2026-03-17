<x-app-layout>
    <x-module-index-shell>
        <x-slot:heading>{{ __('modules/reference/state.plural') }}</x-slot:heading>
        <x-slot:subtitle>{{ __('modules/reference/state.subtitle') }}</x-slot:subtitle>

        <x-slot:actions>
            <x-index-actions resource="reference.states" :showExport="false" :showImport="false">
                <x-slot:create>{{ __('modules/reference/state.new') }}</x-slot:create>
            </x-index-actions>
        </x-slot:actions>

        @include('reference::states.table')
    </x-module-index-shell>
</x-app-layout>
