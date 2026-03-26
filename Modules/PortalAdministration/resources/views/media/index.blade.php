<x-app-layout>
    <x-module-index-shell>
        <x-slot:heading>
            @if ($type ?? null)
                {{ $type->label_my ?? $type->label_en }} — {{ __('modules/portal-administration/media.plural') }}
            @else
                {{ __('modules/portal-administration/media.plural') }}
            @endif
        </x-slot:heading>
        <x-slot:subtitle>{{ __('modules/portal-administration/media.subtitle') }}</x-slot:subtitle>

        <x-slot:actions>
            @if ($type ?? null)
                <a href="{{ route('reference.data-references.children', $type->parent_id) }}">
                    <x-button variant="secondary">{{ __('crud.back') }}</x-button>
                </a>
                <a href="{{ route('media.create', ['type_id' => $type->id]) }}">
                    <x-button>{{ __('modules/portal-administration/media.new') }}</x-button>
                </a>
            @else
                <a href="{{ route('media.create') }}">
                    <x-button>{{ __('modules/portal-administration/media.new') }}</x-button>
                </a>
            @endif
        </x-slot:actions>

        <div class="w-full">
            {!! $dataTable->table() !!}
        </div>
    </x-module-index-shell>
</x-app-layout>
