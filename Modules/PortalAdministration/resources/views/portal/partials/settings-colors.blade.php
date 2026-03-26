{{-- Colors (Light Mode) --}}
<div>
    <h3 class="mb-3 text-sm font-semibold uppercase tracking-wide text-muted-foreground">{{ __('modules/portal-administration/portal-setting.sections.colors') }}</h3>
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @php
            $colorFields = [
                ['id' => 'color_header_bg', 'label' => 'Header Background', 'default' => '#0f172a'],
                ['id' => 'color_hero_bg_from', 'label' => 'Hero Gradient From', 'default' => '#0f172a'],
                ['id' => 'color_hero_bg_to', 'label' => 'Hero Gradient To', 'default' => '#1e293b'],
                ['id' => 'color_accent', 'label' => 'Accent / Highlight', 'default' => '#f43f5e'],
                ['id' => 'color_footer_bg', 'label' => 'Footer Background', 'default' => '#0f172a'],
                ['id' => 'color_body_bg', 'label' => 'Body Background', 'default' => '#f8fafc'],
                ['id' => 'color_lang_active', 'label' => 'MY/EN Active', 'default' => '#f43f5e'],
                ['id' => 'color_nav_bg', 'label' => 'Nav Button Background', 'default' => '#f43f5e'],
                ['id' => 'color_card_bg', 'label' => 'Card Background', 'default' => '#ffffff'],
                ['id' => 'color_text', 'label' => 'Text Color', 'default' => '#1f2937'],
            ];
        @endphp
        @foreach ($colorFields as $cf)
            <x-field for="{{ $cf['id'] }}" class="gap-1.5">
                <x-slot:labelText>{{ $cf['label'] }}</x-slot:labelText>
                <div class="flex items-center gap-2">
                    <input id="{{ $cf['id'] }}" name="{{ $cf['id'] }}" type="color"
                        value="{{ $settings[$cf['id']] ?? $cf['default'] }}"
                        class="h-9 w-14 cursor-pointer rounded-md border border-input" />
                    <x-input name="{{ $cf['id'] }}_text" type="text" class="w-28 font-mono text-xs"
                        :value="$settings[$cf['id']] ?? $cf['default']"
                        oninput="document.getElementById('{{ $cf['id'] }}').value = this.value" />
                </div>
            </x-field>
        @endforeach
    </div>
</div>

<hr />

{{-- Dark Mode Colors --}}
<div>
    <h3 class="mb-3 text-sm font-semibold uppercase tracking-wide text-muted-foreground">{{ __('modules/portal-administration/portal-setting.sections.dark_colors') }}</h3>
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @php
            $darkFields = [
                ['id' => 'dark_header_bg', 'label' => 'Header Background', 'default' => '#020617'],
                ['id' => 'dark_hero_bg_from', 'label' => 'Hero Gradient From', 'default' => '#020617'],
                ['id' => 'dark_hero_bg_to', 'label' => 'Hero Gradient To', 'default' => '#0f172a'],
                ['id' => 'dark_body_bg', 'label' => 'Body Background', 'default' => '#0f172a'],
                ['id' => 'dark_nav_bg', 'label' => 'Nav Button Background', 'default' => '#fb7185'],
                ['id' => 'dark_card_bg', 'label' => 'Card Background', 'default' => '#1e293b'],
                ['id' => 'dark_text', 'label' => 'Text Color', 'default' => '#e2e8f0'],
                ['id' => 'dark_footer_bg', 'label' => 'Footer Background', 'default' => '#020617'],
                ['id' => 'dark_accent', 'label' => 'Accent / Highlight', 'default' => '#fb7185'],
            ];
        @endphp
        @foreach ($darkFields as $df)
            <x-field for="{{ $df['id'] }}" class="gap-1.5">
                <x-slot:labelText>{{ $df['label'] }}</x-slot:labelText>
                <div class="flex items-center gap-2">
                    <input id="{{ $df['id'] }}" name="{{ $df['id'] }}" type="color"
                        value="{{ $settings[$df['id']] ?? $df['default'] }}"
                        class="h-9 w-14 cursor-pointer rounded-md border border-input" />
                    <x-input name="{{ $df['id'] }}_text" type="text" class="w-28 font-mono text-xs"
                        :value="$settings[$df['id']] ?? $df['default']"
                        oninput="document.getElementById('{{ $df['id'] }}').value = this.value" />
                </div>
            </x-field>
        @endforeach
    </div>
</div>
