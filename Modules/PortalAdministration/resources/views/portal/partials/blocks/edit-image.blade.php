<div class="space-y-4">
    <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.image') }}</x-slot:labelText>
        <select x-model="block.data.image_path" class="w-full h-9 rounded-md border border-input bg-background px-3 text-sm sm:w-1/2">
            <option value="">-- {{ __('modules/portal/setting.messages.none') }} --</option>
            <template x-for="[path, label] in Object.entries(mediaOptions)" :key="path"><option :value="path" x-text="label" :selected="block.data.image_path === path"></option></template>
        </select>
        <p class="text-xs text-muted-foreground">{{ __('modules/portal/setting.hints.upload_media_first') }}</p>
    </x-field>
    <div class="grid gap-4 sm:grid-cols-2">
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.caption_my') }}</x-slot:labelText>
            <x-input type="text" x-model="block.data.caption_ms" /></x-field>
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.caption_en') }}</x-slot:labelText>
            <x-input type="text" x-model="block.data.caption_en" /></x-field>
    </div>
</div>
