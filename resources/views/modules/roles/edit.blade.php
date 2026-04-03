<x-app-layout>

    <x-card module>
        <x-card-header flush>
            <x-card-title>{{ __('ui.edit_role') }}</x-card-title>
        </x-card-header>

        <x-card-content flush>
            <x-flash-status-alert spaced :saved-statuses="['role-created', 'role-updated']" :deleted-statuses="['role-deleted']" />

            {{ html()->form('POST', route('roles.update', $role))->id('edit-role-management-form')->open() }}
            @method('PUT')
            @include('modules.roles.fields')
            {{ html()->form()->close() }}

            <x-button-group plain between>
                <x-button type="submit" variant="destructive"
                    form="delete-role-management-form">{{ __('ui.delete') }}</x-button>
                <x-button type="submit" form="edit-role-management-form">{{ __('ui.save_changes') }}</x-button>
            </x-button-group>

            {{ html()->form('POST', route('roles.destroy', $role))->id('delete-role-management-form')->class('hidden')->open() }}
            @method('DELETE')
            {{ html()->form()->close() }}
        </x-card-content>
    </x-card>
</x-app-layout>
