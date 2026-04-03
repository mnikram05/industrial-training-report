<div class="space-y-4 pb-6">
    <div class="grid gap-4 sm:grid-cols-2">
        <x-field for="status_type" :error="$errors->first('type')" class="gap-1.5">
            <x-slot:labelText>{{ __('ui.status_type') }}</x-slot:labelText>
            <x-select id="status_type" name="type" class="w-full" :options="$typeOptions ?? []" :value="old('type', $status?->type ?? \App\Support\Status\StatusType::Article->value)" />
        </x-field>

        <x-field for="status_parent_id" :error="$errors->first('parent_id')" class="gap-1.5">
            <x-slot:labelText>{{ __('ui.parent_status') }}</x-slot:labelText>
            <x-select id="status_parent_id" name="parent_id" class="w-full" :options="$parentStatusOptions ?? []" :value="old('parent_id', $status?->parent_id ?? '')" />
        </x-field>
    </div>

    <x-field for="status_key" :error="$errors->first('key')" class="gap-1.5">
        <x-slot:labelText>{{ __('ui.status_key') }}</x-slot:labelText>
        <x-input id="status_key" name="key" type="text" class="w-full" placeholder="{{ __('ui.e_g_draft') }}"
            :value="old('key', $status?->key ?? '')" />
    </x-field>

    <div class="grid gap-4 sm:grid-cols-2">
        <x-field for="status_name_en" :error="$errors->first('name_en')" class="gap-1.5">
            <x-slot:labelText>{{ __('ui.name_english') }}</x-slot:labelText>
            <x-input id="status_name_en" name="name_en" type="text" class="w-full" :value="old('name_en', $status?->name_en ?? '')" />
        </x-field>

        <x-field for="status_name_ms" :error="$errors->first('name_ms')" class="gap-1.5">
            <x-slot:labelText>{{ __('ui.name_malay') }}</x-slot:labelText>
            <x-input id="status_name_ms" name="name_ms" type="text" class="w-full" :value="old('name_ms', $status?->name_ms ?? '')" />
        </x-field>
    </div>
</div>
