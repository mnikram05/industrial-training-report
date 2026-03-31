@php
    $colorGroups = [
        [
            'label' => __('modules/portal-administration/portal-setting.sections.colors_background'),
            'fields' => [
                ['key' => 'header_bg',    'label' => __('modules/portal-administration/portal-setting.color_fields.header_bg')],
                ['key' => 'hero_bg_from', 'label' => __('modules/portal-administration/portal-setting.color_fields.hero_bg_from')],
                ['key' => 'hero_bg_to',   'label' => __('modules/portal-administration/portal-setting.color_fields.hero_bg_to')],
                ['key' => 'footer_bg',    'label' => __('modules/portal-administration/portal-setting.color_fields.footer_bg')],
                ['key' => 'body_bg',      'label' => __('modules/portal-administration/portal-setting.color_fields.body_bg')],
            ],
        ],
        [
            'label' => __('modules/portal-administration/portal-setting.sections.colors_accent'),
            'fields' => [
                ['key' => 'accent',      'label' => __('modules/portal-administration/portal-setting.color_fields.accent')],
                ['key' => 'text',        'label' => __('modules/portal-administration/portal-setting.color_fields.text')],
                ['key' => 'lang_active', 'label' => __('modules/portal-administration/portal-setting.color_fields.lang_active')],
                ['key' => 'nav_bg',      'label' => __('modules/portal-administration/portal-setting.color_fields.nav_bg')],
            ],
        ],
        [
            'label' => __('modules/portal-administration/portal-setting.sections.colors_card'),
            'fields' => [
                ['key' => 'card_bg', 'label' => __('modules/portal-administration/portal-setting.color_fields.card_bg')],
            ],
        ],
    ];

    $lightDefaults = [
        'header_bg'    => '#0f172a',
        'hero_bg_from' => '#0f172a',
        'hero_bg_to'   => '#1e293b',
        'footer_bg'    => '#0f172a',
        'body_bg'      => '#f8fafc',
        'accent'       => '#f43f5e',
        'text'         => '#1f2937',
        'lang_active'  => '#f43f5e',
        'nav_bg'       => '#f43f5e',
        'card_bg'      => '#ffffff',
    ];

    $darkDefaults = [
        'header_bg'    => '#020617',
        'hero_bg_from' => '#020617',
        'hero_bg_to'   => '#0f172a',
        'footer_bg'    => '#020617',
        'body_bg'      => '#0f172a',
        'accent'       => '#fb7185',
        'text'         => '#e2e8f0',
        'lang_active'  => '#fb7185',
        'nav_bg'       => '#fb7185',
        'card_bg'      => '#1e293b',
    ];
@endphp

<div x-data="{ mode: 'light' }">

    {{-- Mode Toggle --}}
    <div class="mb-5 flex items-center gap-2">
        <button type="button"
            @click="mode = 'light'"
            :class="mode === 'light' ? 'bg-amber-100 text-amber-700 border-amber-300 font-bold' : 'bg-background text-muted-foreground border-input hover:bg-accent'"
            class="inline-flex items-center gap-1.5 rounded-md border px-4 py-1.5 text-sm transition-colors">
            ☀️ Light Mode
        </button>
        <button type="button"
            @click="mode = 'dark'"
            :class="mode === 'dark' ? 'bg-indigo-100 text-indigo-700 border-indigo-300 font-bold' : 'bg-background text-muted-foreground border-input hover:bg-accent'"
            class="inline-flex items-center gap-1.5 rounded-md border px-4 py-1.5 text-sm transition-colors">
            🌙 Dark Mode
        </button>
    </div>

    {{-- Color Groups --}}
    <div class="space-y-4">
        @foreach ($colorGroups as $group)
            <div class="rounded-lg border border-gray-100 bg-gray-50/50 p-4">
                <h4 class="mb-3 text-xs font-bold uppercase tracking-widest text-muted-foreground/70">{{ $group['label'] }}</h4>
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($group['fields'] as $f)
                        @php
                            $lightId = 'color_' . $f['key'];
                            $darkId  = 'dark_' . $f['key'];
                        @endphp

                        {{-- Light --}}
                        <x-field x-show="mode === 'light'" for="{{ $lightId }}" class="gap-1.5">
                            <x-slot:labelText>{{ $f['label'] }}</x-slot:labelText>
                            <div class="flex items-center gap-2">
                                <input id="{{ $lightId }}" name="{{ $lightId }}" type="color"
                                    value="{{ $settings[$lightId] ?? $lightDefaults[$f['key']] }}"
                                    class="h-9 w-12 cursor-pointer rounded border border-input p-1" />
                                <x-input name="{{ $lightId }}_text" type="text" class="font-mono text-xs"
                                    :value="$settings[$lightId] ?? $lightDefaults[$f['key']]"
                                    oninput="document.getElementById('{{ $lightId }}').value = this.value" />
                            </div>
                        </x-field>

                        {{-- Dark --}}
                        <x-field x-show="mode === 'dark'" for="{{ $darkId }}" class="gap-1.5">
                            <x-slot:labelText>{{ $f['label'] }}</x-slot:labelText>
                            <div class="flex items-center gap-2">
                                <input id="{{ $darkId }}" name="{{ $darkId }}" type="color"
                                    value="{{ $settings[$darkId] ?? $darkDefaults[$f['key']] }}"
                                    class="h-9 w-12 cursor-pointer rounded border border-input p-1" />
                                <x-input name="{{ $darkId }}_text" type="text" class="font-mono text-xs"
                                    :value="$settings[$darkId] ?? $darkDefaults[$f['key']]"
                                    oninput="document.getElementById('{{ $darkId }}').value = this.value" />
                            </div>
                        </x-field>

                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

</div>
