<x-app-layout>

    <x-card module>
        <x-card-header flush>
            <x-card-title>{{ __('Edit District') }}</x-card-title>
        </x-card-header>

        <x-card-content flush>
            <x-flash-status-alert spaced :saved-statuses="['district-created', 'district-updated']" :deleted-statuses="['district-deleted']" />

            {{ html()->form('POST', route('reference.districts.update', $district))->id('edit-district-form')->open() }}
            @method('PUT')
            @include('modules.districts.fields')
            {{ html()->form()->close() }}

            <x-button-group plain between>
                <x-button type="submit" variant="destructive"
                    form="delete-district-form">{{ __('Delete') }}</x-button>
                <x-button type="submit" form="edit-district-form">{{ __('Save Changes') }}</x-button>
            </x-button-group>

            {{ html()->form('POST', route('reference.districts.destroy', $district))->id('delete-district-form')->class('hidden')->open() }}
            @method('DELETE')
            {{ html()->form()->close() }}
        </x-card-content>
    </x-card>
</x-app-layout>
