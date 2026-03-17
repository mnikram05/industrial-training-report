<x-app-layout>

    <x-card module>
        <x-card-header flush>
            <x-card-title>{{ __('modules/reference/dun.edit') }}: {{ $dun->name }}</x-card-title>
        </x-card-header>

        <x-card-content flush>
            {{ html()->form('PUT', route('reference.duns.update', $dun))->id('edit-dun-form')->open() }}
            @include('reference::duns.fields')
            {{ html()->form()->close() }}

            <x-button-group plain end>
                <x-button as="a" variant="outline" href="{{ route('reference.duns.index') }}">{{ __('crud.cancel') }}</x-button>
                <x-button type="submit" form="edit-dun-form">{{ __('crud.update') }}</x-button>
            </x-button-group>
        </x-card-content>
    </x-card>
</x-app-layout>