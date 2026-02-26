<x-form-section>
    <x-slot:labelText>{{ __('Hero Section') }}</x-slot:labelText>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <x-field for="landing_hero_title_en" :error="$errors->first('content.hero.title.en')" class="gap-1.5">
            <x-slot:labelText>{{ __('Title (English)') }}</x-slot:labelText>
            <x-input id="landing_hero_title_en" name="content[hero][title][en]" type="text" class="w-full"
                :value="old(
                    'content.hero.title.en',
                    data_get($content, 'hero.title.en', data_get($content, 'hero.title', '')),
                )" />
        </x-field>

        <x-field for="landing_hero_title_ms" :error="$errors->first('content.hero.title.ms')" class="gap-1.5">
            <x-slot:labelText>{{ __('Title (Malay)') }}</x-slot:labelText>
            <x-input id="landing_hero_title_ms" name="content[hero][title][ms]" type="text" class="w-full"
                :value="old(
                    'content.hero.title.ms',
                    data_get($content, 'hero.title.ms', data_get($content, 'hero.title', '')),
                )" />
        </x-field>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <x-field for="landing_hero_subtitle_en" :error="$errors->first('content.hero.subtitle.en')" class="gap-1.5">
            <x-slot:labelText>{{ __('Subtitle (English)') }}</x-slot:labelText>
            <x-textarea id="landing_hero_subtitle_en" name="content[hero][subtitle][en]"
                class="min-h-24 w-full">{{ old('content.hero.subtitle.en', data_get($content, 'hero.subtitle.en', data_get($content, 'hero.subtitle', ''))) }}</x-textarea>
        </x-field>

        <x-field for="landing_hero_subtitle_ms" :error="$errors->first('content.hero.subtitle.ms')" class="gap-1.5">
            <x-slot:labelText>{{ __('Subtitle (Malay)') }}</x-slot:labelText>
            <x-textarea id="landing_hero_subtitle_ms" name="content[hero][subtitle][ms]"
                class="min-h-24 w-full">{{ old('content.hero.subtitle.ms', data_get($content, 'hero.subtitle.ms', data_get($content, 'hero.subtitle', ''))) }}</x-textarea>
        </x-field>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <div class="min-w-0 space-y-4 rounded-lg border border-border p-3">
            <p class="text-xs font-medium uppercase tracking-wide text-muted-foreground">{{ __('Primary Button') }}</p>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-field for="landing_hero_primary_text_en" :error="$errors->first('content.hero.primary_button.text.en')" class="gap-1.5">
                    <x-slot:labelText>{{ __('Text (English)') }}</x-slot:labelText>
                    <x-input id="landing_hero_primary_text_en" name="content[hero][primary_button][text][en]"
                        type="text" class="w-full" :value="old(
                            'content.hero.primary_button.text.en',
                            data_get(
                                $content,
                                'hero.primary_button.text.en',
                                data_get($content, 'hero.primary_button.text', ''),
                            ),
                        )" />
                </x-field>

                <x-field for="landing_hero_primary_text_ms" :error="$errors->first('content.hero.primary_button.text.ms')" class="gap-1.5">
                    <x-slot:labelText>{{ __('Text (Malay)') }}</x-slot:labelText>
                    <x-input id="landing_hero_primary_text_ms" name="content[hero][primary_button][text][ms]"
                        type="text" class="w-full" :value="old(
                            'content.hero.primary_button.text.ms',
                            data_get(
                                $content,
                                'hero.primary_button.text.ms',
                                data_get($content, 'hero.primary_button.text', ''),
                            ),
                        )" />
                </x-field>
            </div>

            <x-field for="landing_hero_primary_url" class="gap-1.5">
                <x-slot:labelText>{{ __('URL') }}</x-slot:labelText>
                <x-input id="landing_hero_primary_url" name="content[hero][primary_button][url]" type="text"
                    class="w-full" :value="old(
                        'content.hero.primary_button.url',
                        data_get($content, 'hero.primary_button.url', ''),
                    )" />
            </x-field>
        </div>

        <div class="min-w-0 space-y-4 rounded-lg border border-border p-3">
            <p class="text-xs font-medium uppercase tracking-wide text-muted-foreground">{{ __('Secondary Button') }}
            </p>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-field for="landing_hero_secondary_text_en" :error="$errors->first('content.hero.secondary_button.text.en')" class="gap-1.5">
                    <x-slot:labelText>{{ __('Text (English)') }}</x-slot:labelText>
                    <x-input id="landing_hero_secondary_text_en" name="content[hero][secondary_button][text][en]"
                        type="text" class="w-full" :value="old(
                            'content.hero.secondary_button.text.en',
                            data_get(
                                $content,
                                'hero.secondary_button.text.en',
                                data_get($content, 'hero.secondary_button.text', ''),
                            ),
                        )" />
                </x-field>

                <x-field for="landing_hero_secondary_text_ms" :error="$errors->first('content.hero.secondary_button.text.ms')" class="gap-1.5">
                    <x-slot:labelText>{{ __('Text (Malay)') }}</x-slot:labelText>
                    <x-input id="landing_hero_secondary_text_ms" name="content[hero][secondary_button][text][ms]"
                        type="text" class="w-full" :value="old(
                            'content.hero.secondary_button.text.ms',
                            data_get(
                                $content,
                                'hero.secondary_button.text.ms',
                                data_get($content, 'hero.secondary_button.text', ''),
                            ),
                        )" />
                </x-field>
            </div>

            <x-field for="landing_hero_secondary_url" class="gap-1.5">
                <x-slot:labelText>{{ __('URL') }}</x-slot:labelText>
                <x-input id="landing_hero_secondary_url" name="content[hero][secondary_button][url]" type="text"
                    class="w-full" :value="old(
                        'content.hero.secondary_button.url',
                        data_get($content, 'hero.secondary_button.url', ''),
                    )" />
            </x-field>
        </div>
    </div>
</x-form-section>
