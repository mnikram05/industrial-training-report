<x-app-layout>
    <x-module-index-shell>
        <x-slot:heading>{{ $dataReference->label_ms ?? $dataReference->name }} — {{ __('modules/reference/data-reference.children_list') }}</x-slot:heading>
        <x-slot:subtitle>{{ __('modules/reference/data-reference.children_subtitle') }}</x-slot:subtitle>

        <x-slot:actions>
            <a href="{{ route('reference.data-references.index') }}">
                <x-button variant="secondary">{{ __('crud.back') }}</x-button>
            </a>
            <a href="{{ route('reference.data-references.children.create', $dataReference) }}">
                <x-button>{{ __('modules/reference/data-reference.create_child') }}</x-button>
            </a>
        </x-slot:actions>

        <div class="w-full">
            {!! $dataTable->table() !!}
        </div>
    </x-module-index-shell>
</x-app-layout>
