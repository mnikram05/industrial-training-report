<div class="space-y-4 pb-6">
    <x-field for="district_state_id" :error="$errors->first('state_id')" class="gap-1.5">
        <x-slot:labelText>{{ __('modules/reference/district.fields.state') }} <span class="text-destructive">*</span></x-slot:labelText>
        <x-select id="district_state_id" name="state_id" class="sm:w-1/2"
            :options="$stateOptions"
            :value="old('state_id', (string) ($district?->state_id ?? ''))"
            :placeholder="__('modules/reference/district.placeholders.state')" />
    </x-field>

    <x-field for="district_name" :error="$errors->first('name')" class="gap-1.5">
        <x-slot:labelText>{{ __('modules/reference/district.fields.name') }} <span class="text-destructive">*</span></x-slot:labelText>
        <x-input id="district_name" name="name" type="text" class="sm:w-1/2" placeholder="{{ __('modules/reference/district.fields.name') }}"
            :value="old('name', $district?->name ?? '')" maxlength="255" />
    </x-field>

    <x-field for="district_fullname" :error="$errors->first('fullname')" class="gap-1.5">
        <x-slot:labelText>{{ __('modules/reference/district.fields.fullname') }}</x-slot:labelText>
        <x-input id="district_fullname" name="fullname" type="text" class="sm:w-1/2" placeholder="{{ __('modules/reference/district.fields.fullname') }}"
            :value="old('fullname', $district?->fullname ?? '')" maxlength="255" />
    </x-field>

    <x-field for="district_sort" :error="$errors->first('sort')" class="gap-1.5">
        <x-slot:labelText>{{ __('modules/reference/district.fields.sort') }} <span class="text-destructive">*</span></x-slot:labelText>
        <x-select id="district_sort" name="sort" class="sm:w-1/2"
            :options="$sortOptions"
            :value="old('sort', $district?->sort ?? 1)" />
    </x-field>

    <x-field for="district_status" :error="$errors->first('status')" class="gap-1.5">
        <x-slot:labelText>{{ __('modules/reference/district.fields.status') }} <span class="text-destructive">*</span></x-slot:labelText>
        <x-select id="district_status" name="status" class="sm:w-1/2"
            :options="['1' => __('crud.active'), '0' => __('crud.inactive')]"
            :value="old('status', $district?->status ?? 1)" />
    </x-field>
</div>
