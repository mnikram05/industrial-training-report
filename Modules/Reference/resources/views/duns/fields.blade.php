<div class="space-y-4 pb-6">
    <x-field for="dun_parliament_id" :error="$errors->first('parliament_id')" class="gap-1.5">
        <x-slot:labelText>{{ __('modules/reference/dun.fields.parliament') }} <span class="text-destructive">*</span></x-slot:labelText>
        <x-select id="dun_parliament_id" name="parliament_id" class="sm:w-1/2"
            :options="$parliamentOptions"
            :value="old('parliament_id', (string) ($dun?->parliament_id ?? ''))"
            :placeholder="__('modules/reference/dun.placeholders.parliament')" />
    </x-field>

    <x-field for="dun_name" :error="$errors->first('name')" class="gap-1.5">
        <x-slot:labelText>{{ __('modules/reference/dun.fields.name') }} <span class="text-destructive">*</span></x-slot:labelText>
        <x-input id="dun_name" name="name" type="text" class="sm:w-1/2" placeholder="{{ __('modules/reference/dun.fields.name') }}"
            :value="old('name', $dun?->name ?? '')" maxlength="255" />
    </x-field>

    <x-field for="dun_sort" :error="$errors->first('sort')" class="gap-1.5">
        <x-slot:labelText>{{ __('modules/reference/dun.fields.sort') }} <span class="text-destructive">*</span></x-slot:labelText>
        <x-select id="dun_sort" name="sort" class="sm:w-1/2"
            :options="$sortOptions"
            :value="old('sort', $dun?->sort ?? 1)" />
    </x-field>

    <x-field for="dun_status" :error="$errors->first('status')" class="gap-1.5">
        <x-slot:labelText>{{ __('modules/reference/dun.fields.status') }} <span class="text-destructive">*</span></x-slot:labelText>
        <x-select id="dun_status" name="status" class="sm:w-1/2"
            :options="['1' => __('crud.active'), '0' => __('crud.inactive')]"
            :value="old('status', $dun?->status ?? 1)" />
    </x-field>
</div>
