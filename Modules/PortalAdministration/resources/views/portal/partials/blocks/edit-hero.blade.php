<div class="space-y-4">
    <div class="grid gap-4 sm:grid-cols-2">
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.institution_ms') }}</x-slot:labelText>
            <x-input type="text" x-model="block.data.institution_ms" /></x-field>
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.institution_en') }}</x-slot:labelText>
            <x-input type="text" x-model="block.data.institution_en" /></x-field>
    </div>
    <div class="grid gap-4 sm:grid-cols-2">
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.subtitle_ms') }}</x-slot:labelText>
            <x-input type="text" x-model="block.data.subtitle_ms" /></x-field>
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.subtitle_en') }}</x-slot:labelText>
            <x-input type="text" x-model="block.data.subtitle_en" /></x-field>
    </div>
    <div class="grid gap-4 sm:grid-cols-2">
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.title_ms') }}</x-slot:labelText>
            <x-input type="text" x-model="block.data.title_ms" /></x-field>
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.title_en') }}</x-slot:labelText>
            <x-input type="text" x-model="block.data.title_en" /></x-field>
    </div>
    <div class="grid gap-4 sm:grid-cols-2">
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.subtitle_ms') }} 2</x-slot:labelText>
            <x-input type="text" x-model="block.data.subtitle2_ms" /></x-field>
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.subtitle_en') }} 2</x-slot:labelText>
            <x-input type="text" x-model="block.data.subtitle2_en" /></x-field>
    </div>
    <div class="grid gap-4 sm:grid-cols-2">
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.session_ms') }}</x-slot:labelText>
            <x-input type="text" x-model="block.data.session_ms" /></x-field>
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.session_en') }}</x-slot:labelText>
            <x-input type="text" x-model="block.data.session_en" /></x-field>
    </div>
    <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.address') }}</x-slot:labelText>
        <x-input type="text" x-model="block.data.address" /></x-field>
</div>
