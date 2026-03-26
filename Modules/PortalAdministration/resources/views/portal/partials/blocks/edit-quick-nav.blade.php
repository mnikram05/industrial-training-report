<div class="space-y-4">
    <div class="grid gap-4 sm:grid-cols-2">
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.title_my') }}</x-slot:labelText>
            <x-input type="text" x-model="block.data.heading_ms" /></x-field>
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.title_en') }}</x-slot:labelText>
            <x-input type="text" x-model="block.data.heading_en" /></x-field>
    </div>
    <div class="flex items-center justify-end">
        <button type="button" @click="block.data.items.push({ icon: '', title_ms: '', title_en: '', subtitle_ms: '', subtitle_en: '', url: '' })"
            class="inline-flex items-center gap-1.5 rounded-md border border-input bg-background px-3 py-1.5 text-xs font-medium transition-colors hover:bg-accent hover:text-accent-foreground">
            <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            {{ __('modules/portal/setting.actions.add') }}
        </button>
    </div>
    <template x-for="(item, ni) in block.data.items" :key="ni">
        <div class="rounded-md border p-3 space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-muted-foreground" x-text="'{{ __('modules/portal/setting.actions.item_label') }} ' + (ni + 1)"></span>
                <button type="button" @click="block.data.items.splice(ni, 1)" class="text-destructive hover:text-destructive/80"><svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg></button>
            </div>
            <div class="grid gap-3 sm:grid-cols-3">
                <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.icon_emoji') }}</x-slot:labelText>
                    <select x-model="item.icon" class="h-9 w-full rounded-md border border-input bg-background px-3 text-sm">
                        <option value="">--</option>
                        @foreach (['👤' => 'Person','🏢' => 'Building','📅' => 'Calendar','🎓' => 'Graduation','📄' => 'Document','📋' => 'Clipboard','📈' => 'Chart','⭐' => 'Star','🏆' => 'Trophy','🚀' => 'Rocket','💡' => 'Idea','👥' => 'Group','👁️' => 'Eye','⚙️' => 'Gear','📱' => 'Mobile','🖥️' => 'Desktop','🚩' => 'Flag','⬆️' => 'Up','📌' => 'Pin','🔗' => 'Link','✅' => 'Check','❤️' => 'Heart','📝' => 'Note','🔍' => 'Search'] as $emoji => $label)
                            <option value="{{ $emoji }}">{{ $emoji }} {{ $label }}</option>
                        @endforeach
                    </select></x-field>
                <x-field class="gap-1.5 sm:col-span-2"><x-slot:labelText>URL</x-slot:labelText>
                    <x-input type="text" x-model="item.url" placeholder="/portal/page-name" /></x-field>
            </div>
            <div class="grid gap-3 sm:grid-cols-2">
                <x-input type="text" x-model="item.title_ms" placeholder="{{ __('modules/portal/setting.fields.title_my') }}" />
                <x-input type="text" x-model="item.title_en" placeholder="{{ __('modules/portal/setting.fields.title_en') }}" />
            </div>
            <div class="grid gap-3 sm:grid-cols-2">
                <x-input type="text" x-model="item.subtitle_ms" placeholder="{{ __('modules/portal/setting.fields.subtitle_my') }}" />
                <x-input type="text" x-model="item.subtitle_en" placeholder="{{ __('modules/portal/setting.fields.subtitle_en') }}" />
            </div>
        </div>
    </template>
</div>
