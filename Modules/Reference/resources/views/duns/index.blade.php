<x-app-layout>
    <x-module-index-shell>
        <x-slot:heading>
            @if ($parliament ?? null)
                {{ $parliament->name }} — {{ __('modules/reference/dun.plural') }}
            @else
                {{ __('modules/reference/dun.plural') }}
            @endif
        </x-slot:heading>
        <x-slot:subtitle>{{ __('modules/reference/dun.subtitle') }}</x-slot:subtitle>

        <x-slot:actions>
            @if ($parliament ?? null)
                <a href="{{ route('reference.parliaments.index', ['state_id' => $parliament->state_id]) }}">
                    <x-button variant="secondary">{{ __('crud.back') }}</x-button>
                </a>
            @endif
            <x-index-actions resource="reference.duns" :showExport="false" :showImport="false">
                <x-slot:create>{{ __('modules/reference/dun.new') }}</x-slot:create>
            </x-index-actions>
        </x-slot:actions>

        @include('reference::duns.table')
    </x-module-index-shell>
</x-app-layout>
