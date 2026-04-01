<div class="space-y-3">
    <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.card_layout') }}</x-slot:labelText>
        <select x-model="block.data.layout" class="h-9 rounded-md border border-input bg-background px-3 text-sm sm:w-1/2">
            <option value="centered">{{ __('modules/portal/setting.layouts.centered') }}</option>
            <option value="horizontal">{{ __('modules/portal/setting.layouts.horizontal') }}</option>
            <option value="compact">{{ __('modules/portal/setting.layouts.compact') }}</option>
            <option value="featured">{{ __('modules/portal/setting.layouts.featured') }}</option>
            <option value="gallery">{{ __('modules/portal/setting.layouts.gallery') }}</option>
        </select>
    </x-field>
    <div class="flex items-center justify-end">
        <button type="button" @click="block.data.items.push({ display: 'emoji', icon: '', image: '', label_ms: '', label_en: '', value_ms: '', value_en: '' })"
            class="inline-flex items-center gap-1.5 rounded-md border border-input bg-background px-3 py-1.5 text-xs font-medium transition-colors hover:bg-accent hover:text-accent-foreground">
            <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            {{ __('modules/portal/setting.actions.add') }}
        </button>
    </div>
    <template x-for="(card, ci) in block.data.items" :key="ci">
        <div class="rounded-md border p-3 space-y-3" x-data="{ cardDisplay: card.display || (card.image ? 'image' : (card.icon ? 'emoji' : 'none')) }" x-init="card.display = cardDisplay">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-muted-foreground" x-text="'{{ __('modules/portal/setting.actions.item_label') }} ' + (ci + 1)"></span>
                <button type="button" @click="block.data.items.splice(ci, 1)" class="text-destructive hover:text-destructive/80"><svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg></button>
            </div>

            {{-- Display type selector --}}
            <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.display_type') }}</x-slot:labelText>
                <select x-model="cardDisplay" @change="card.display = cardDisplay" class="h-9 w-48 rounded-md border border-input bg-background px-3 text-sm">
                    <option value="emoji">{{ __('modules/portal/setting.display_types.emoji') }}</option>
                    <option value="image">{{ __('modules/portal/setting.display_types.image') }}</option>
                    <option value="both">{{ __('modules/portal/setting.display_types.both') }}</option>
                    <option value="none">{{ __('modules/portal/setting.display_types.none') }}</option>
                </select>
            </x-field>

            {{-- Emoji field --}}
            <div x-show="cardDisplay === 'emoji' || cardDisplay === 'both'">
                <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.icon_emoji') }}</x-slot:labelText>
                    <select x-model="card.icon" class="h-9 w-32 rounded-md border border-input bg-background px-3 text-sm">
                        <option value="">--</option>
                        @foreach (['👤' => 'Person','🏢' => 'Building','📅' => 'Calendar','🎓' => 'Graduation','📄' => 'Document','📋' => 'Clipboard','📈' => 'Chart','⭐' => 'Star','🏆' => 'Trophy','🚀' => 'Rocket','💡' => 'Idea','👥' => 'Group','👁️' => 'Eye','⚙️' => 'Gear','📱' => 'Mobile','🖥️' => 'Desktop','🚩' => 'Flag','⬆️' => 'Up','📌' => 'Pin','🔗' => 'Link','✅' => 'Check','❤️' => 'Heart','📝' => 'Note','🔍' => 'Search'] as $emoji => $label)
                            <option value="{{ $emoji }}">{{ $emoji }} {{ $label }}</option>
                        @endforeach
                    </select></x-field>
            </div>

            {{-- Image field --}}
            <div x-show="cardDisplay === 'image' || cardDisplay === 'both'">
                <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.image') }}</x-slot:labelText>
                    <select x-model="card.image" class="w-full h-9 rounded-md border border-input bg-background px-3 text-sm sm:w-1/2">
                        <option value="">-- {{ __('modules/portal/setting.messages.none') }} --</option>
                        <template x-for="[path, label] in Object.entries(mediaOptions)" :key="path"><option :value="path" x-text="label" :selected="card.image === path"></option></template>
                    </select>
                    <p class="text-xs text-muted-foreground">{{ __('modules/portal/setting.hints.upload_media_first') }}</p>
                </x-field>
            </div>

            <div class="grid gap-3 sm:grid-cols-2">
                <x-input type="text" x-model="card.label_ms" placeholder="{{ __('modules/portal/setting.fields.label_my') }}" />
                <x-input type="text" x-model="card.label_en" placeholder="{{ __('modules/portal/setting.fields.label_en') }}" />
            </div>
            <div class="grid gap-3 sm:grid-cols-2">
                <x-input type="text" x-model="card.value_ms" placeholder="{{ __('modules/portal/setting.fields.value_my') }}" />
                <x-input type="text" x-model="card.value_en" placeholder="{{ __('modules/portal/setting.fields.value_en') }}" />
            </div>
        </div>
    </template>
</div>
