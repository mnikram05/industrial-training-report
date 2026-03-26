<div class="space-y-4">
    <div class="grid gap-4 sm:grid-cols-2">
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.title_my') }}</x-slot:labelText>
            <x-input type="text" x-model="block.data.heading_ms" /></x-field>
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.title_en') }}</x-slot:labelText>
            <x-input type="text" x-model="block.data.heading_en" /></x-field>
    </div>
    <div class="flex items-center justify-end">
        <button type="button" @click="block.data.items.push({ icon: '', title_ms: '', title_en: '', desc_ms: '', desc_en: '', bullets_ms: [], bullets_en: [] })"
            class="inline-flex items-center gap-1.5 rounded-md border border-input bg-background px-3 py-1.5 text-xs font-medium transition-colors hover:bg-accent hover:text-accent-foreground">
            <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            {{ __('modules/portal/setting.actions.add') }}
        </button>
    </div>
    <template x-for="(item, gi) in block.data.items" :key="gi">
        <div class="rounded-md border p-3 space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-muted-foreground" x-text="'{{ __('modules/portal/setting.actions.item_label') }} ' + (gi + 1)"></span>
                <button type="button" @click="block.data.items.splice(gi, 1)" class="text-destructive hover:text-destructive/80"><svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg></button>
            </div>
            <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.icon_emoji') }}</x-slot:labelText>
                <select x-model="item.icon" class="h-9 w-32 rounded-md border border-input bg-background px-3 text-sm">
                    <option value="">--</option>
                    @foreach (['👤' => 'Person','🏢' => 'Building','📅' => 'Calendar','🎓' => 'Graduation','📄' => 'Document','📋' => 'Clipboard','📈' => 'Chart','⭐' => 'Star','🏆' => 'Trophy','🚀' => 'Rocket','💡' => 'Idea','👥' => 'Group','👁️' => 'Eye','⚙️' => 'Gear','📱' => 'Mobile','🖥️' => 'Desktop','🚩' => 'Flag','⬆️' => 'Up','📌' => 'Pin','🔗' => 'Link','✅' => 'Check','❤️' => 'Heart','📝' => 'Note','🔍' => 'Search'] as $emoji => $label)
                        <option value="{{ $emoji }}">{{ $emoji }} {{ $label }}</option>
                    @endforeach
                </select></x-field>
            <div class="grid gap-3 sm:grid-cols-2">
                <x-input type="text" x-model="item.title_ms" placeholder="{{ __('modules/portal/setting.fields.title_my') }}" />
                <x-input type="text" x-model="item.title_en" placeholder="{{ __('modules/portal/setting.fields.title_en') }}" />
            </div>
            <div class="grid gap-3 sm:grid-cols-2">
                <textarea x-model="item.desc_ms" rows="2" class="w-full rounded-md border border-input bg-background px-3 py-2 text-sm" placeholder="{{ __('modules/portal/setting.fields.desc_my') }}"></textarea>
                <textarea x-model="item.desc_en" rows="2" class="w-full rounded-md border border-input bg-background px-3 py-2 text-sm" placeholder="{{ __('modules/portal/setting.fields.desc_en') }}"></textarea>
            </div>
            <div class="rounded border bg-gray-50/50 p-3 space-y-2">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-semibold text-muted-foreground">{{ __('modules/portal/setting.fields.bullets') }}</p>
                    <button type="button" @click="if(!item.bullets_ms) item.bullets_ms=[]; if(!item.bullets_en) item.bullets_en=[]; item.bullets_ms.push(''); item.bullets_en.push('')" class="text-xs text-foreground/70 hover:text-foreground">+ {{ __('modules/portal/setting.actions.add') }}</button>
                </div>
                <template x-for="(b, bi) in (item.bullets_ms || [])" :key="bi">
                    <div class="flex items-start gap-2">
                        <span class="mt-2 text-xs text-muted-foreground" x-text="bi + 1"></span>
                        <div class="grid flex-1 gap-2 sm:grid-cols-2">
                            <x-input type="text" x-model="item.bullets_ms[bi]" placeholder="MY" />
                            <x-input type="text" x-model="item.bullets_en[bi]" placeholder="EN" />
                        </div>
                        <button type="button" @click="item.bullets_ms.splice(bi, 1); item.bullets_en.splice(bi, 1)" class="mt-1.5 text-destructive"><svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg></button>
                    </div>
                </template>
            </div>
        </div>
    </template>
</div>
