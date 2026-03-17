<div class="space-y-4 pb-6">
    <x-field for="parliament_state_id" :error="$errors->first('state_id')" class="gap-1.5">
        <x-slot:labelText>{{ __('modules/reference/parliament.fields.state') }} <span class="text-destructive">*</span></x-slot:labelText>
        <x-select id="parliament_state_id" name="state_id" class="sm:w-1/2"
            :options="$stateOptions"
            :value="old('state_id', (string) ($parliament?->state_id ?? ''))"
            :placeholder="__('modules/reference/parliament.placeholders.state')" />
    </x-field>

    <x-field for="parliament_name" :error="$errors->first('name')" class="gap-1.5">
        <x-slot:labelText>{{ __('modules/reference/parliament.fields.name') }} <span class="text-destructive">*</span></x-slot:labelText>
        <x-input id="parliament_name" name="name" type="text" class="sm:w-1/2" placeholder="{{ __('modules/reference/parliament.fields.name') }}"
            :value="old('name', $parliament?->name ?? '')" maxlength="255" />
    </x-field>

    <x-field for="parliament_sort" :error="$errors->first('sort')" class="gap-1.5">
        <x-slot:labelText>{{ __('modules/reference/parliament.fields.sort') }} <span class="text-destructive">*</span></x-slot:labelText>
        <x-select id="parliament_sort" name="sort" class="sm:w-1/2"
            :options="$sortOptions"
            :value="old('sort', $parliament?->sort ?? 1)" />
    </x-field>

    <x-field for="parliament_status" :error="$errors->first('status')" class="gap-1.5">
        <x-slot:labelText>{{ __('modules/reference/parliament.fields.status') }} <span class="text-destructive">*</span></x-slot:labelText>
        <x-select id="parliament_status" name="status" class="sm:w-1/2"
            :options="['1' => __('crud.active'), '0' => __('crud.inactive')]"
            :value="old('status', $parliament?->status ?? 1)" />
    </x-field>
</div>
