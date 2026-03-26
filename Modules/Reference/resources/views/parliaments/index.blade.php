<x-app-layout>
    <x-module-index-shell>
        <x-slot:heading>
            @if ($state ?? null)
                {{ $state->name }} — {{ __('modules/reference/parliament.plural') }}
            @else
                {{ __('modules/reference/parliament.plural') }}
            @endif
        </x-slot:heading>
        <x-slot:subtitle>{{ __('modules/reference/parliament.subtitle') }}</x-slot:subtitle>

        <x-slot:actions>
            @if ($state ?? null)
                <a href="{{ route('reference.states.index') }}">
                    <x-button variant="secondary">{{ __('crud.back') }}</x-button>
                </a>
            @endif
            <x-index-actions resource="reference.parliaments" :showExport="false" :showImport="false">
                <x-slot:create>{{ __('modules/reference/parliament.new') }}</x-slot:create>
            </x-index-actions>
        </x-slot:actions>

        @include('reference::parliaments.table')
    </x-module-index-shell>
</x-app-layout>
