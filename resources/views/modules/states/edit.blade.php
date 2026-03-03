<x-app-layout>

    <x-card module>
        <x-card-header flush>
            <x-card-title>{{ __('Edit State') }}</x-card-title>
        </x-card-header>

        <x-card-content flush>
            <x-flash-status-alert spaced :saved-statuses="['state-created', 'state-updated']" :deleted-statuses="['state-deleted']" />

            {{ html()->form('POST', route('reference.states.update', $state))->id('edit-state-form')->open() }}
            @method('PUT')
            @include('modules.states.fields')
            {{ html()->form()->close() }}

            <x-button-group plain between>
                <x-button type="submit" variant="destructive"
                    form="delete-state-form">{{ __('Delete') }}</x-button>
                <x-button type="submit" form="edit-state-form">{{ __('Save Changes') }}</x-button>
            </x-button-group>

            {{ html()->form('POST', route('reference.states.destroy', $state))->id('delete-state-form')->class('hidden')->open() }}
            @method('DELETE')
            {{ html()->form()->close() }}
        </x-card-content>
    </x-card>
</x-app-layout>
