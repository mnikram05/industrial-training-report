<div class="space-y-4">
    <div class="grid gap-4 sm:grid-cols-2">
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.title_ms') }}</x-slot:labelText>
            <x-input type="text" x-model="block.data.heading_ms" /></x-field>
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.title_en') }}</x-slot:labelText>
            <x-input type="text" x-model="block.data.heading_en" /></x-field>
    </div>

    <div class="flex items-center justify-end">
        <button type="button" @click="block.data.items.push({ image: '', image_label_ms: '', image_label_en: '', title_ms: '', title_en: '', desc_ms: '', desc_en: '', bullets_ms: [], bullets_en: [] })"
            class="inline-flex items-center gap-1.5 rounded-md border border-input bg-background px-3 py-1.5 text-xs font-medium transition-colors hover:bg-accent hover:text-accent-foreground">
            <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            {{ __('modules/portal/setting.actions.add') }}
        </button>
    </div>

    <template x-for="(item, ti) in block.data.items" :key="ti">
        <div class="rounded-md border p-3 space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-muted-foreground" x-text="'{{ __('modules/portal/setting.actions.item_label') }} ' + (ti + 1)"></span>
                <button type="button" @click="block.data.items.splice(ti, 1)" class="text-destructive hover:text-destructive/80">
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Image --}}
            <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.image') }}</x-slot:labelText>
                <select x-model="item.image" class="h-9 w-full rounded-md border border-input bg-background px-3 text-sm">
                    <option value="">-- Tiada Gambar / No Image --</option>
                    <template x-for="[path, label] in Object.entries(mediaOptions)" :key="path">
                        <option :value="path" x-text="label" :selected="item.image === path"></option>
                    </template>
                </select></x-field>

            {{-- Image Label --}}
            <div class="grid gap-3 sm:grid-cols-2">
                <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.image_label_ms') }}</x-slot:labelText>
                    <x-input type="text" x-model="item.image_label_ms" /></x-field>
                <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.image_label_en') }}</x-slot:labelText>
                    <x-input type="text" x-model="item.image_label_en" /></x-field>
            </div>

            {{-- Title --}}
            <div class="grid gap-3 sm:grid-cols-2">
                <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.title_ms') }}</x-slot:labelText>
                    <x-input type="text" x-model="item.title_ms" /></x-field>
                <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.title_en') }}</x-slot:labelText>
                    <x-input type="text" x-model="item.title_en" /></x-field>
            </div>

            {{-- Description --}}
            <div class="grid gap-3 sm:grid-cols-2">
                <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.desc_ms') }}</x-slot:labelText>
                    <textarea x-model="item.desc_ms" rows="4" class="w-full rounded-md border border-input bg-background px-3 py-2 text-sm"></textarea></x-field>
                <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.desc_en') }}</x-slot:labelText>
                    <textarea x-model="item.desc_en" rows="4" class="w-full rounded-md border border-input bg-background px-3 py-2 text-sm"></textarea></x-field>
            </div>
        </div>
    </template>
</div>
