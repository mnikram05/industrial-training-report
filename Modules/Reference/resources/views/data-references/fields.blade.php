<div class="space-y-4 pb-6">
    <x-field for="data_reference_label_my" :error="$errors->first('label_my')" class="gap-1.5">
        <x-slot:labelText>{{ __('modules/reference/data-reference.fields.label_my') }}</x-slot:labelText>
        <x-input id="data_reference_label_my" name="label_my" type="text" class="sm:w-1/2" placeholder="{{ __('modules/reference/data-reference.fields.label_my') }}"
            :value="old('label_my', $dataReference?->label_my ?? '')" maxlength="255" />
    </x-field>

    <x-field for="data_reference_label_en" :error="$errors->first('label_en')" class="gap-1.5">
        <x-slot:labelText>{{ __('modules/reference/data-reference.fields.label_en') }}</x-slot:labelText>
        <x-input id="data_reference_label_en" name="label_en" type="text" class="sm:w-1/2" placeholder="{{ __('modules/reference/data-reference.fields.label_en') }}"
            :value="old('label_en', $dataReference?->label_en ?? '')" maxlength="255" />
    </x-field>

    <x-field for="data_reference_description" :error="$errors->first('description')" class="gap-1.5">
        <x-slot:labelText>{{ __('modules/reference/data-reference.fields.description') }}</x-slot:labelText>
        <x-input id="data_reference_description" name="description" type="text" class="sm:w-1/2" placeholder="{{ __('modules/reference/data-reference.fields.description') }}"
            :value="old('description', $dataReference?->description ?? '')" />
    </x-field>
</div>
