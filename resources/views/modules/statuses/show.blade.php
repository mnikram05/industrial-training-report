<x-app-layout>
    <x-module-index-shell>
        <x-slot:heading>{{ __('Statuses') }}: {{ $status->label() }}</x-slot:heading>
        <x-slot:subtitle>{{ __('Manage statuses for :module module.', ['module' => $status->label()]) }}</x-slot:subtitle>
        @include('modules.statuses.table')
    </x-module-index-shell>
</x-app-layout>
