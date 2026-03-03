<x-app-layout>

    <x-card module>
        <x-card-header flush>
            <x-card-title>{{ __('Edit DUN') }}</x-card-title>
        </x-card-header>

        <x-card-content flush>
            <x-flash-status-alert spaced :saved-statuses="['dun-created', 'dun-updated']" :deleted-statuses="['dun-deleted']" />

            {{ html()->form('POST', route('reference.duns.update', $dun))->id('edit-dun-form')->open() }}
            @method('PUT')
            @include('modules.duns.fields')
            {{ html()->form()->close() }}

            <x-button-group plain between>
                <x-button type="submit" variant="destructive"
                    form="delete-dun-form">{{ __('Delete') }}</x-button>
                <x-button type="submit" form="edit-dun-form">{{ __('Save Changes') }}</x-button>
            </x-button-group>

            {{ html()->form('POST', route('reference.duns.destroy', $dun))->id('delete-dun-form')->class('hidden')->open() }}
            @method('DELETE')
            {{ html()->form()->close() }}
        </x-card-content>
    </x-card>
</x-app-layout>
