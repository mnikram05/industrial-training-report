<x-app-layout>
    <x-module-index-shell>
        <x-slot:heading>
            @if ($state ?? null)
                {{ $state->name }} — {{ __('modules/reference/district.plural') }}
            @else
                {{ __('modules/reference/district.plural') }}
            @endif
        </x-slot:heading>
        <x-slot:subtitle>{{ __('modules/reference/district.subtitle') }}</x-slot:subtitle>

        <x-slot:actions>
            @if ($state ?? null)
                <a href="{{ route('reference.states.index') }}">
                    <x-button variant="secondary">{{ __('crud.back') }}</x-button>
                </a>
            @endif
            <x-index-actions resource="reference.districts" :showExport="false" :showImport="false">
                <x-slot:create>{{ __('modules/reference/district.new') }}</x-slot:create>
            </x-index-actions>
        </x-slot:actions>

        @include('reference::districts.table')
    </x-module-index-shell>
</x-app-layout>
