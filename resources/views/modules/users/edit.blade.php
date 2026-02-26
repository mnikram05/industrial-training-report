<x-app-layout>

    <x-card module>
        <x-card-header flush>
            <x-card-title>{{ __('Edit User') }}</x-card-title>
        </x-card-header>

        <x-card-content flush>
            <x-flash-status-alert spaced :saved-statuses="['user-created', 'user-updated']" :deleted-statuses="['user-deleted']" />

            {{ html()->form('POST', route('users.update', $user))->id('edit-user-management-form')->open() }}
            @method('PUT')
            @include('modules.users.fields', ['availableRoleOptions' => $availableRoleOptions ?? []])
            {{ html()->form()->close() }}

            <x-button-group plain between>
                <x-button type="submit" variant="destructive"
                    form="delete-user-management-form">{{ __('Delete') }}</x-button>
                <x-button type="submit" form="edit-user-management-form">{{ __('Save Changes') }}</x-button>
            </x-button-group>

            {{ html()->form('POST', route('users.destroy', $user))->id('delete-user-management-form')->class('hidden')->open() }}
            @method('DELETE')
            {{ html()->form()->close() }}
        </x-card-content>
    </x-card>
</x-app-layout>
