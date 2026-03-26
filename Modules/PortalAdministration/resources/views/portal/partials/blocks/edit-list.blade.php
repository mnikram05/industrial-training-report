<div class="space-y-4">
    <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.icon_emoji') }}</x-slot:labelText>
        <select x-model="block.data.icon" class="h-9 w-40 rounded-md border border-input bg-background px-3 text-sm">
            <option value="">--</option>
            @foreach (['👤' => 'Person','🏢' => 'Building','📅' => 'Calendar','🎓' => 'Graduation','📄' => 'Document','📋' => 'Clipboard','📈' => 'Chart','⭐' => 'Star','🏆' => 'Trophy','🚀' => 'Rocket','💡' => 'Idea','👥' => 'Group','👁️' => 'Eye','⚙️' => 'Gear','📱' => 'Mobile','🖥️' => 'Desktop','🚩' => 'Flag','⬆️' => 'Up','📌' => 'Pin','🔗' => 'Link','✅' => 'Check','❤️' => 'Heart','📝' => 'Note','🔍' => 'Search'] as $emoji => $label)
                <option value="{{ $emoji }}">{{ $emoji }} {{ $label }}</option>
            @endforeach
        </select></x-field>
    <div class="grid gap-4 sm:grid-cols-2">
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.title_my') }}</x-slot:labelText>
            <x-input type="text" x-model="block.data.heading_ms" /></x-field>
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.title_en') }}</x-slot:labelText>
            <x-input type="text" x-model="block.data.heading_en" /></x-field>
    </div>
    <div class="flex items-center justify-end">
        <button type="button" @click="block.data.items_ms.push(''); block.data.items_en.push('')"
            class="inline-flex items-center gap-1.5 rounded-md border border-input bg-background px-3 py-1.5 text-xs font-medium transition-colors hover:bg-accent hover:text-accent-foreground">
            <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            {{ __('modules/portal/setting.actions.add') }}
        </button>
    </div>
    <template x-for="(item, i) in block.data.items_ms" :key="i">
        <div class="flex items-start gap-3 rounded-md border p-3">
            <span class="mt-2 text-xs font-semibold text-muted-foreground" x-text="i + 1"></span>
            <div class="grid flex-1 gap-3 sm:grid-cols-2">
                <x-input type="text" x-model="block.data.items_ms[i]" placeholder="MY" />
                <x-input type="text" x-model="block.data.items_en[i]" placeholder="EN" />
            </div>
            <button type="button" @click="block.data.items_ms.splice(i, 1); block.data.items_en.splice(i, 1)" class="mt-1.5 text-destructive hover:text-destructive/80">
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </template>
</div>
