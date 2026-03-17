<x-app-layout>

    <x-card module>
        <x-card-header flush>
            <x-card-title>{{ __('modules/reference/dun.create') }}</x-card-title>
        </x-card-header>

        <x-card-content flush>
            {{ html()->form('POST', route('reference.duns.store'))->id('create-dun-form')->open() }}
            @include('reference::duns.fields', ['dun' => null])
            {{ html()->form()->close() }}

            <x-button-group plain end>
                <x-button as="a" variant="outline" href="{{ route('reference.duns.index') }}">{{ __('crud.cancel') }}</x-button>
                <x-button type="submit" form="create-dun-form">{{ __('modules/reference/dun.create') }}</x-button>
            </x-button-group>
        </x-card-content>
    </x-card>
</x-app-layout>
