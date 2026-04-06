@php $cmsLocale = app()->getLocale(); $titleField = 'title_' . $cmsLocale; @endphp
<div class="space-y-4" x-data="{ editingWeek: null }">
    <div class="grid gap-4 sm:grid-cols-2">
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.title_ms') }}</x-slot:labelText>
            <x-input type="text" x-model="block.data.heading_ms" /></x-field>
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.title_en') }}</x-slot:labelText>
            <x-input type="text" x-model="block.data.heading_en" /></x-field>
    </div>
    <div x-data="{ colorMode: 'light' }" class="rounded-lg border border-gray-100 bg-gray-50/50 p-4 space-y-3">
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold uppercase tracking-widest text-muted-foreground/70">{{ __('modules/portal/setting.fields.text_colors') }}</span>
            <div class="flex items-center gap-1">
                <button type="button" @click="colorMode = 'light'"
                    :class="colorMode === 'light' ? 'bg-amber-100 text-amber-700 border-amber-300 font-bold' : 'bg-background text-muted-foreground border-input'"
                    class="rounded border px-2.5 py-1 text-xs transition-colors">☀️ Light</button>
                <button type="button" @click="colorMode = 'dark'"
                    :class="colorMode === 'dark' ? 'bg-indigo-100 text-indigo-700 border-indigo-300 font-bold' : 'bg-background text-muted-foreground border-input'"
                    class="rounded border px-2.5 py-1 text-xs transition-colors">🌙 Dark</button>
            </div>
        </div>
        @php
            $wcFields = [
                ['key' => 'title_color',          'label' => __('modules/portal/setting.fields.week_title_color'),    'placeholder' => 'var(--portal-text)'],
                ['key' => 'topic_color',           'label' => __('modules/portal/setting.fields.topic_color'),         'placeholder' => 'var(--portal-accent)'],
                ['key' => 'report_heading_color',  'label' => __('modules/portal/setting.fields.report_heading_color'),'placeholder' => 'var(--portal-text)'],
                ['key' => 'day_color',             'label' => __('modules/portal/setting.fields.day_color'),           'placeholder' => 'var(--portal-text)'],
                ['key' => 'activity_color',        'label' => __('modules/portal/setting.fields.activity_color'),      'placeholder' => 'var(--portal-text)'],
            ];
        @endphp
        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($wcFields as $wc)
                <x-field class="gap-1.5">
                    <x-slot:labelText>{{ $wc['label'] }}</x-slot:labelText>
                    <div class="flex items-center gap-2" x-show="colorMode === 'light'">
                        <input type="color" x-model="block.data.{{ $wc['key'] }}" class="h-9 w-12 cursor-pointer rounded border border-input bg-background p-1" />
                        <x-input type="text" x-model="block.data.{{ $wc['key'] }}" placeholder="{{ $wc['placeholder'] }}" class="flex-1 font-mono text-xs" />
                    </div>
                    <div class="flex items-center gap-2" x-show="colorMode === 'dark'">
                        <input type="color" x-model="block.data.{{ $wc['key'] }}_dark" class="h-9 w-12 cursor-pointer rounded border border-input bg-background p-1" />
                        <x-input type="text" x-model="block.data.{{ $wc['key'] }}_dark" placeholder="{{ $wc['placeholder'] }}" class="flex-1 font-mono text-xs" />
                    </div>
                </x-field>
            @endforeach
        </div>
    </div>

    <div class="flex items-center justify-end">
        <button type="button" @click="block.data.items.push({ title_ms: '', title_en: '', start_date: '', end_date: '', title_color: '', topic_ms: '', topic_en: '', topic_color: '', days: [], reflection_ms: '', reflection_en: '' })"
            class="inline-flex items-center gap-1.5 rounded-md border border-input bg-background px-3 py-1.5 text-xs font-medium transition-colors hover:bg-accent hover:text-accent-foreground">
            <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            {{ __('modules/portal/setting.actions.add') }}
        </button>
    </div>

    {{-- Calendar Grid --}}
    <div class="grid grid-cols-2 gap-2 sm:grid-cols-3 lg:grid-cols-4">
        <template x-for="(item, wi) in block.data.items" :key="wi">
            <button type="button" @click="editingWeek = editingWeek === wi ? null : wi"
                class="rounded-lg border-2 p-3 text-center transition-all duration-200 hover:shadow-md"
                :class="editingWeek === wi ? 'border-primary bg-primary/5 shadow-md' : 'border-gray-200 hover:border-primary/40'">
                <p class="text-sm font-bold" :class="editingWeek === wi ? 'text-primary' : 'text-foreground'" x-text="(item['{{ $titleField }}'] || item.title_ms) || ('{{ __('modules/portal/setting.actions.item_label') }} ' + (wi + 1))"></p>
                <p class="mt-0.5 text-[10px] text-muted-foreground" x-show="item.start_date && item.end_date"
                    x-text="new Date(item.start_date).toLocaleDateString('ms-MY', {day:'numeric',month:'short'}).toUpperCase() + ' - ' + new Date(item.end_date).toLocaleDateString('ms-MY', {day:'numeric',month:'short',year:'numeric'}).toUpperCase()">
                </p>
                <p class="mt-0.5 text-[10px] italic text-muted-foreground/50" x-show="!item.start_date || !item.end_date">{{ __('modules/portal/setting.hints.no_date') }}</p>
            </button>
        </template>
    </div>

    {{-- Edit Panel --}}
    <template x-if="editingWeek !== null && block.data.items[editingWeek]">
        <div class="rounded-lg border-2 border-primary/20 bg-primary/5 p-4 space-y-4">
            {{-- Header --}}
            <div class="flex items-center justify-between">
                <span class="text-sm font-bold text-primary" x-text="(block.data.items[editingWeek]['{{ $titleField }}'] || block.data.items[editingWeek].title_ms) || ('{{ __('modules/portal/setting.actions.item_label') }} ' + (editingWeek + 1))"></span>
                <div class="flex items-center gap-2">
                    <button type="button" @click="if(confirm('{{ __('modules/portal/setting.actions.confirm_remove') }}')) { block.data.items.splice(editingWeek, 1); editingWeek = null; }"
                        class="rounded p-1 text-destructive hover:bg-destructive/10">
                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                    </button>
                    <button type="button" @click="editingWeek = null"
                        class="rounded p-1 text-muted-foreground hover:bg-accent">
                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>

            {{-- Metadata --}}
            <div class="grid gap-3 sm:grid-cols-2">
                <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.title_ms') }}</x-slot:labelText>
                    <x-input type="text" x-model="block.data.items[editingWeek].title_ms" /></x-field>
                <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.title_en') }}</x-slot:labelText>
                    <x-input type="text" x-model="block.data.items[editingWeek].title_en" /></x-field>
            </div>
            <div class="grid gap-3 sm:grid-cols-2">
                <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.start_date') }}</x-slot:labelText>
                    <x-input type="date" x-model="block.data.items[editingWeek].start_date" /></x-field>
                <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.end_date') }}</x-slot:labelText>
                    <x-input type="date" x-model="block.data.items[editingWeek].end_date" /></x-field>
            </div>
            <div class="grid gap-3 sm:grid-cols-2">
                <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.topic_ms') }}</x-slot:labelText>
                    <x-input type="text" x-model="block.data.items[editingWeek].topic_ms" :placeholder="__('modules/portal/setting.hints.topic_placeholder_ms')" /></x-field>
                <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.topic_en') }}</x-slot:labelText>
                    <x-input type="text" x-model="block.data.items[editingWeek].topic_en" :placeholder="__('modules/portal/setting.hints.topic_placeholder_en')" /></x-field>
            </div>

            <hr />

            {{-- Daily Log --}}
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <h4 class="text-xs font-bold uppercase tracking-wide text-muted-foreground">📅 {{ __('modules/portal/setting.block_types.daily_log') }}</h4>
                    <button type="button" @click="if(!block.data.items[editingWeek].days) block.data.items[editingWeek].days = []; block.data.items[editingWeek].days.push({ day_ms: '', day_en: '', activities_ms: [''], activities_en: [''] })"
                        class="text-xs text-foreground/70 hover:text-foreground">+ {{ __('modules/portal/setting.actions.add') }}</button>
                </div>

                <template x-for="(day, di) in (block.data.items[editingWeek].days || [])" :key="di">
                    <div class="rounded-md border bg-background p-3 space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold text-muted-foreground" x-text="(day['day_{{ $cmsLocale }}'] || day.day_ms) || ('{{ __('modules/portal/setting.fields.day') }} ' + (di + 1))"></span>
                            <button type="button" @click="block.data.items[editingWeek].days.splice(di, 1)" class="text-destructive hover:text-destructive/80"><svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg></button>
                        </div>
                        <div class="grid gap-2 sm:grid-cols-2">
                            <x-input type="text" x-model="day.day_ms" placeholder="Isnin" class="text-xs" />
                            <x-input type="text" x-model="day.day_en" placeholder="Monday" class="text-xs" />
                        </div>
                        <div class="space-y-1">
                            <div class="flex items-center justify-between">
                                <p class="text-[10px] font-semibold text-muted-foreground">{{ __('modules/portal/setting.fields.activities') }}</p>
                                <button type="button" @click="day.activities_ms.push(''); day.activities_en.push('')" class="text-[10px] text-foreground/70 hover:text-foreground">+</button>
                            </div>
                            <template x-for="(act, ai) in day.activities_ms" :key="ai">
                                <div class="flex items-start gap-1">
                                    <span class="mt-1.5 text-[10px] text-muted-foreground" x-text="ai + 1"></span>
                                    <div class="grid flex-1 gap-1 sm:grid-cols-2">
                                        <input type="text" x-model="day.activities_ms[ai]" placeholder="MY" class="h-7 w-full rounded border border-input bg-background px-2 text-xs" />
                                        <input type="text" x-model="day.activities_en[ai]" placeholder="EN" class="h-7 w-full rounded border border-input bg-background px-2 text-xs" />
                                    </div>
                                    <button type="button" @click="day.activities_ms.splice(ai, 1); day.activities_en.splice(ai, 1)" class="mt-0.5 text-destructive"><svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg></button>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>

            <hr />

            {{-- Reflection --}}
            <div class="space-y-2">
                <h4 class="text-xs font-bold uppercase tracking-wide text-muted-foreground">💭 {{ __('modules/portal/setting.fields.reflection') }}</h4>
                <div class="grid gap-3 sm:grid-cols-2">
                    <textarea x-model="block.data.items[editingWeek].reflection_ms" rows="4" class="w-full rounded-md border border-input bg-background px-3 py-2 text-sm" placeholder="{{ __('modules/portal/setting.hints.reflection_ms') }}"></textarea>
                    <textarea x-model="block.data.items[editingWeek].reflection_en" rows="4" class="w-full rounded-md border border-input bg-background px-3 py-2 text-sm" placeholder="{{ __('modules/portal/setting.hints.reflection_en') }}"></textarea>
                </div>
            </div>
        </div>
    </template>
</div>
