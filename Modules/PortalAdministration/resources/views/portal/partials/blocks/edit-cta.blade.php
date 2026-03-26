<div class="space-y-4">
    <div class="grid gap-4 sm:grid-cols-2">
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.desc_my') }}</x-slot:labelText>
            <x-input type="text" x-model="block.data.text_ms" /></x-field>
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.desc_en') }}</x-slot:labelText>
            <x-input type="text" x-model="block.data.text_en" /></x-field>
    </div>
    <div class="grid gap-4 sm:grid-cols-2">
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.button_text_my') }}</x-slot:labelText>
            <x-input type="text" x-model="block.data.button_text_ms" /></x-field>
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.button_text_en') }}</x-slot:labelText>
            <x-input type="text" x-model="block.data.button_text_en" /></x-field>
    </div>
    <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.cta_url') }}</x-slot:labelText>
        <x-input type="url" x-model="block.data.url" placeholder="https://" /></x-field>
</div>
