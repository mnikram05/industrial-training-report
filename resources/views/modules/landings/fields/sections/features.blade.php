<x-form-section>
    <x-slot:labelText>{{ __('ui.features_section') }}</x-slot:labelText>

    @for ($index = 0; $index < 3; $index++)
        <div class="min-w-0 space-y-4 rounded-lg border border-border p-3">
            <p class="text-xs font-medium uppercase tracking-wide text-muted-foreground">
                {{ __('Feature :number', ['number' => $index + 1]) }}
            </p>

            <x-field for="landing_feature_icon_{{ $index }}" :error="$errors->first('content.features.' . $index . '.icon')" class="gap-1.5">
                <x-slot:labelText>{{ __('ui.icon') }}</x-slot:labelText>
                <x-combobox id="landing_feature_icon_{{ $index }}"
                    name="content[features][{{ $index }}][icon]" class="w-full min-w-0" :options="$featureIconOptions"
                    :value="old(
                        'content.features.' . $index . '.icon',
                        data_get($content, 'features.' . $index . '.icon', 'sparkles'),
                    )" search-placeholder="{{ __('ui.search_icons') }}" />
            </x-field>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-field for="landing_feature_title_en_{{ $index }}" :error="$errors->first('content.features.' . $index . '.title.en')" class="gap-1.5">
                    <x-slot:labelText>{{ __('ui.title_english') }}</x-slot:labelText>
                    <x-input id="landing_feature_title_en_{{ $index }}"
                        name="content[features][{{ $index }}][title][en]" type="text" class="w-full"
                        :value="old(
                            'content.features.' . $index . '.title.en',
                            data_get(
                                $content,
                                'features.' . $index . '.title.en',
                                data_get($content, 'features.' . $index . '.title', ''),
                            ),
                        )" />
                </x-field>

                <x-field for="landing_feature_title_ms_{{ $index }}" :error="$errors->first('content.features.' . $index . '.title.ms')" class="gap-1.5">
                    <x-slot:labelText>{{ __('ui.title_malay') }}</x-slot:labelText>
                    <x-input id="landing_feature_title_ms_{{ $index }}"
                        name="content[features][{{ $index }}][title][ms]" type="text" class="w-full"
                        :value="old(
                            'content.features.' . $index . '.title.ms',
                            data_get(
                                $content,
                                'features.' . $index . '.title.ms',
                                data_get($content, 'features.' . $index . '.title', ''),
                            ),
                        )" />
                </x-field>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-field for="landing_feature_description_en_{{ $index }}" :error="$errors->first('content.features.' . $index . '.description.en')" class="gap-1.5">
                    <x-slot:labelText>{{ __('ui.description_english') }}</x-slot:labelText>
                    <x-input id="landing_feature_description_en_{{ $index }}"
                        name="content[features][{{ $index }}][description][en]" type="text" class="w-full"
                        :value="old(
                            'content.features.' . $index . '.description.en',
                            data_get(
                                $content,
                                'features.' . $index . '.description.en',
                                data_get($content, 'features.' . $index . '.description', ''),
                            ),
                        )" />
                </x-field>

                <x-field for="landing_feature_description_ms_{{ $index }}" :error="$errors->first('content.features.' . $index . '.description.ms')" class="gap-1.5">
                    <x-slot:labelText>{{ __('ui.description_malay') }}</x-slot:labelText>
                    <x-input id="landing_feature_description_ms_{{ $index }}"
                        name="content[features][{{ $index }}][description][ms]" type="text" class="w-full"
                        :value="old(
                            'content.features.' . $index . '.description.ms',
                            data_get(
                                $content,
                                'features.' . $index . '.description.ms',
                                data_get($content, 'features.' . $index . '.description', ''),
                            ),
                        )" />
                </x-field>
            </div>
        </div>
    @endfor
</x-form-section>
