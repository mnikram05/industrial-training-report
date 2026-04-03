<x-app-layout>

    <x-card module>
        <x-card-header flush>
            <x-card-title>{{ __('ui.edit_status') }}</x-card-title>
        </x-card-header>

        <x-card-content flush>
            <x-flash-status-alert spaced :saved-statuses="['status-created', 'status-updated']" :deleted-statuses="['status-deleted']" />

            {{ html()->form('POST', route('statuses.update', $status))->id('edit-status-management-form')->open() }}
            @method('PUT')
            @include('modules.statuses.fields')
            {{ html()->form()->close() }}

            <x-button-group plain between>
                <x-button type="submit" variant="destructive"
                    form="delete-status-management-form">{{ __('ui.delete') }}</x-button>
                <x-button type="submit" form="edit-status-management-form">{{ __('ui.save_changes') }}</x-button>
            </x-button-group>

            {{ html()->form('POST', route('statuses.destroy', $status))->id('delete-status-management-form')->class('hidden')->open() }}
            @method('DELETE')
            {{ html()->form()->close() }}
        </x-card-content>
    </x-card>
</x-app-layout>
