<x-app-layout>

    <x-card module>
        <x-card-header flush>
            <x-card-title>{{ __('Edit Landing') }}</x-card-title>
        </x-card-header>

        <x-card-content flush>
            <x-flash-status-alert spaced :saved-statuses="['landing-created', 'landing-updated']" :deleted-statuses="['landing-deleted']" />

            {{ html()->form('POST', route('landings.update', $landing))->attribute('enctype', 'multipart/form-data')->id('edit-landing-management-form')->open() }}
            @method('PUT')
            @include('modules.landings.fields')
            {{ html()->form()->close() }}

            <x-button-group plain between>
                <x-button type="submit" variant="destructive"
                    form="delete-landing-management-form">{{ __('Delete') }}</x-button>
                <x-button type="submit" form="edit-landing-management-form">{{ __('Save Changes') }}</x-button>
            </x-button-group>

            {{ html()->form('POST', route('landings.destroy', $landing))->id('delete-landing-management-form')->class('hidden')->open() }}
            @method('DELETE')
            {{ html()->form()->close() }}
        </x-card-content>
    </x-card>
</x-app-layout>
