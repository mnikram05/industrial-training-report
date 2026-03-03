<x-app-layout>

    <x-card module>
        <x-card-header flush>
            <x-card-title>{{ __('Edit Parliament') }}</x-card-title>
        </x-card-header>

        <x-card-content flush>
            <x-flash-status-alert spaced :saved-statuses="['parliament-created', 'parliament-updated']" :deleted-statuses="['parliament-deleted']" />

            {{ html()->form('POST', route('reference.parliaments.update', $parliament))->id('edit-parliament-form')->open() }}
            @method('PUT')
            @include('modules.parliaments.fields')
            {{ html()->form()->close() }}

            <x-button-group plain between>
                <x-button type="submit" variant="destructive"
                    form="delete-parliament-form">{{ __('Delete') }}</x-button>
                <x-button type="submit" form="edit-parliament-form">{{ __('Save Changes') }}</x-button>
            </x-button-group>

            {{ html()->form('POST', route('reference.parliaments.destroy', $parliament))->id('delete-parliament-form')->class('hidden')->open() }}
            @method('DELETE')
            {{ html()->form()->close() }}
        </x-card-content>
    </x-card>
</x-app-layout>
