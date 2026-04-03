<x-form-section>
    <x-slot:labelText>{{ __('ui.articles_section') }}</x-slot:labelText>

    @for ($index = 0; $index < 3; $index++)
        <div class="min-w-0 space-y-4 rounded-lg border border-border p-3">
            <p class="text-xs font-medium uppercase tracking-wide text-muted-foreground">
                {{ __('Article :number', ['number' => $index + 1]) }}
            </p>

            <x-field for="landing_article_slug_{{ $index }}" :error="$errors->first('content.articles.' . $index . '.article_slug')" class="gap-1.5">
                <x-slot:labelText>{{ __('ui.link_to_article') }}</x-slot:labelText>
                <x-combobox id="landing_article_slug_{{ $index }}"
                    name="content[articles][{{ $index }}][article_slug]" class="w-full min-w-0" :options="$articleOptions ?? []"
                    :value="old(
                        'content.articles.' . $index . '.article_slug',
                        data_get($content, 'articles.' . $index . '.article_slug', ''),
                    )" placeholder="{{ __('ui.select_a_published_article_optional') }}"
                    search-placeholder="{{ __('ui.search_articles') }}" />
                <x-slot:descriptionText>
                    @if ($articleOptionLimit ?? null)
                        {{ __('Showing latest :count published articles.', ['count' => $articleOptionLimit]) }}
                    @else
                        {{ __('ui.showing_published_articles') }}
                    @endif
                </x-slot:descriptionText>
            </x-field>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-field for="landing_article_title_en_{{ $index }}" :error="$errors->first('content.articles.' . $index . '.title.en')" class="gap-1.5">
                    <x-slot:labelText>{{ __('ui.title_english') }}</x-slot:labelText>
                    <x-input id="landing_article_title_en_{{ $index }}"
                        name="content[articles][{{ $index }}][title][en]" type="text" class="w-full"
                        :value="old(
                            'content.articles.' . $index . '.title.en',
                            data_get(
                                $content,
                                'articles.' . $index . '.title.en',
                                data_get($content, 'articles.' . $index . '.title', ''),
                            ),
                        )" />
                </x-field>

                <x-field for="landing_article_title_ms_{{ $index }}" :error="$errors->first('content.articles.' . $index . '.title.ms')" class="gap-1.5">
                    <x-slot:labelText>{{ __('ui.title_malay') }}</x-slot:labelText>
                    <x-input id="landing_article_title_ms_{{ $index }}"
                        name="content[articles][{{ $index }}][title][ms]" type="text" class="w-full"
                        :value="old(
                            'content.articles.' . $index . '.title.ms',
                            data_get(
                                $content,
                                'articles.' . $index . '.title.ms',
                                data_get($content, 'articles.' . $index . '.title', ''),
                            ),
                        )" />
                </x-field>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-field for="landing_article_excerpt_en_{{ $index }}" :error="$errors->first('content.articles.' . $index . '.excerpt.en')" class="gap-1.5">
                    <x-slot:labelText>{{ __('ui.excerpt_english') }}</x-slot:labelText>
                    <x-textarea id="landing_article_excerpt_en_{{ $index }}"
                        name="content[articles][{{ $index }}][excerpt][en]"
                        class="min-h-20 w-full">{{ old('content.articles.' . $index . '.excerpt.en', data_get($content, 'articles.' . $index . '.excerpt.en', data_get($content, 'articles.' . $index . '.excerpt', ''))) }}</x-textarea>
                </x-field>

                <x-field for="landing_article_excerpt_ms_{{ $index }}" :error="$errors->first('content.articles.' . $index . '.excerpt.ms')" class="gap-1.5">
                    <x-slot:labelText>{{ __('ui.excerpt_malay') }}</x-slot:labelText>
                    <x-textarea id="landing_article_excerpt_ms_{{ $index }}"
                        name="content[articles][{{ $index }}][excerpt][ms]"
                        class="min-h-20 w-full">{{ old('content.articles.' . $index . '.excerpt.ms', data_get($content, 'articles.' . $index . '.excerpt.ms', data_get($content, 'articles.' . $index . '.excerpt', ''))) }}</x-textarea>
                </x-field>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-media-upload-field id="landing_article_image_{{ $index }}"
                    name="content[articles][{{ $index }}][image]" :label="__('ui.article_image')" :path="data_get($content, 'articles.' . $index . '.image')"
                    error-key="{{ 'content.articles.' . $index . '.image' }}"
                    upload-class="w-full flex-col items-stretch sm:flex-row sm:items-center" />

                <div class="grid grid-cols-1 gap-4">
                    <x-field for="landing_article_alt_en_{{ $index }}" :error="$errors->first('content.articles.' . $index . '.alt.en')" class="gap-1.5">
                        <x-slot:labelText>{{ __('ui.image_alt_text_english') }}</x-slot:labelText>
                        <x-input id="landing_article_alt_en_{{ $index }}"
                            name="content[articles][{{ $index }}][alt][en]" type="text" class="w-full"
                            :value="old(
                                'content.articles.' . $index . '.alt.en',
                                data_get(
                                    $content,
                                    'articles.' . $index . '.alt.en',
                                    data_get($content, 'articles.' . $index . '.alt', ''),
                                ),
                            )" />
                    </x-field>

                    <x-field for="landing_article_alt_ms_{{ $index }}" :error="$errors->first('content.articles.' . $index . '.alt.ms')" class="gap-1.5">
                        <x-slot:labelText>{{ __('ui.image_alt_text_malay') }}</x-slot:labelText>
                        <x-input id="landing_article_alt_ms_{{ $index }}"
                            name="content[articles][{{ $index }}][alt][ms]" type="text" class="w-full"
                            :value="old(
                                'content.articles.' . $index . '.alt.ms',
                                data_get(
                                    $content,
                                    'articles.' . $index . '.alt.ms',
                                    data_get($content, 'articles.' . $index . '.alt', ''),
                                ),
                            )" />
                    </x-field>
                </div>
            </div>
        </div>
    @endfor
</x-form-section>
