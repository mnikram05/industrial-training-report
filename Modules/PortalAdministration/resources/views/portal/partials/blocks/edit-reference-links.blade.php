<div class="space-y-4">
    <div class="grid gap-4 sm:grid-cols-2">
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.icon_emoji') }}</x-slot:labelText>
            <select x-model="block.data.icon" class="h-9 w-full rounded-md border border-input bg-background px-3 text-sm">
                <option value="">--</option>
                @foreach (['🔗' => 'Link','📚' => 'Books','🌐' => 'Web','📎' => 'Clip'] as $emoji => $label)
                    <option value="{{ $emoji }}">{{ $emoji }} {{ $label }}</option>
                @endforeach
            </select></x-field>
    </div>
    <div class="grid gap-4 sm:grid-cols-2">
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.title_ms') }}</x-slot:labelText>
            <x-input type="text" x-model="block.data.heading_ms" /></x-field>
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.title_en') }}</x-slot:labelText>
            <x-input type="text" x-model="block.data.heading_en" /></x-field>
    </div>
    <div class="flex items-center justify-end">
        <button type="button" @click="block.data.items.push({ label_ms: '', label_en: '', url: '' })"
            class="inline-flex items-center gap-1.5 rounded-md border border-input bg-background px-3 py-1.5 text-xs font-medium transition-colors hover:bg-accent hover:text-accent-foreground">
            <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            {{ __('modules/portal/setting.actions.add') }}
        </button>
    </div>
    <template x-for="(item, ri) in block.data.items" :key="ri">
        <div class="space-y-3 rounded-md border p-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-muted-foreground" x-text="'{{ __('modules/portal/setting.actions.item_label') }} ' + (ri + 1)"></span>
                <button type="button" @click="block.data.items.splice(ri, 1)" class="text-destructive hover:text-destructive/80"><svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg></button>
            </div>
            <x-field class="gap-1.5"><x-slot:labelText>URL</x-slot:labelText>
                <x-input type="url" x-model="item.url" placeholder="https://" /></x-field>
            <div class="grid gap-3 sm:grid-cols-2">
                <x-input type="text" x-model="item.label_ms" placeholder="{{ __('modules/portal/setting.fields.label_ms') }}" />
                <x-input type="text" x-model="item.label_en" placeholder="{{ __('modules/portal/setting.fields.label_en') }}" />
            </div>
        </div>
    </template>
</div>
