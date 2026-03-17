{{-- Shared form fields for Create / Edit --}}

<div class="space-y-4 pb-6">
    <x-field for="state_name" :error="$errors->first('name')" class="gap-1.5">
        <x-slot:labelText>{{ __('modules/reference/state.fields.name') }} <span class="text-destructive">*</span></x-slot:labelText>
        <x-input id="state_name" name="name" type="text" class="sm:w-1/2" placeholder="{{ __('modules/reference/state.fields.name') }}"
            :value="old('name', $state->name ?? '')" maxlength="100" />
    </x-field>

    <x-field for="state_fullname" :error="$errors->first('fullname')" class="gap-1.5">
        <x-slot:labelText>{{ __('modules/reference/state.fields.fullname') }} <span class="text-destructive">*</span></x-slot:labelText>
        <x-input id="state_fullname" name="fullname" type="text" class="sm:w-1/2" placeholder="{{ __('modules/reference/state.fields.fullname') }}"
            :value="old('fullname', $state->fullname ?? '')" maxlength="255" />
    </x-field>

    <x-field for="state_sort" :error="$errors->first('sort')" class="gap-1.5">
        <x-slot:labelText>{{ __('modules/reference/state.fields.sort') }} <span class="text-destructive">*</span></x-slot:labelText>
        <x-select id="state_sort" name="sort" class="sm:w-1/2"
            :options="$sortOptions"
            :value="old('sort', $state->sort ?? 1)" />
    </x-field>

    <x-field for="state_status" :error="$errors->first('status')" class="gap-1.5">
        <x-slot:labelText>{{ __('modules/reference/state.fields.status') }} <span class="text-destructive">*</span></x-slot:labelText>
        <x-select id="state_status" name="status" class="sm:w-1/2"
            :options="['1' => __('crud.active'), '0' => __('crud.inactive')]"
            :value="old('status', $state->status ?? 1)" />
    </x-field>
</div>
