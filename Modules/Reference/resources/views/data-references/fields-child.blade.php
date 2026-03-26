<div class="space-y-4 pb-6">
    <x-field for="data_reference_label_my" :error="$errors->first('label_my')" class="gap-1.5">
        <x-slot:labelText>{{ __('modules/reference/data-reference.fields.label_my') }}</x-slot:labelText>
        <x-input id="data_reference_label_my" name="label_my" type="text" class="sm:w-1/2" placeholder="{{ __('modules/reference/data-reference.fields.label_my') }}"
            :value="old('label_my', $child?->label_my ?? '')" maxlength="255" />
    </x-field>

    <x-field for="data_reference_label_en" :error="$errors->first('label_en')" class="gap-1.5">
        <x-slot:labelText>{{ __('modules/reference/data-reference.fields.label_en') }}</x-slot:labelText>
        <x-input id="data_reference_label_en" name="label_en" type="text" class="sm:w-1/2" placeholder="{{ __('modules/reference/data-reference.fields.label_en') }}"
            :value="old('label_en', $child?->label_en ?? '')" maxlength="255" />
    </x-field>

    <x-field for="data_reference_sort" :error="$errors->first('sort')" class="gap-1.5">
        <x-slot:labelText>{{ __('modules/reference/data-reference.fields.sort') }} <span class="text-destructive">*</span></x-slot:labelText>
        <x-select id="data_reference_sort" name="sort" class="sm:w-1/2"
            :options="$sortOptions"
            :value="old('sort', $child?->sort ?? 1)" />
    </x-field>
</div>
