<div class="space-y-4 pb-6">
    <x-field for="data_reference_label_ms" :error="$errors->first('label_ms')" class="gap-1.5">
        <x-slot:labelText>{{ __('modules/reference/data-reference.fields.label_ms') }}</x-slot:labelText>
        <x-input id="data_reference_label_ms" name="label_ms" type="text" class="sm:w-1/2" placeholder="{{ __('modules/reference/data-reference.fields.label_ms') }}"
            :value="old('label_ms', $dataReference?->label_ms ?? '')" maxlength="255" />
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
