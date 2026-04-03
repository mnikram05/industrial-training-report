<x-form-section>
    <x-slot:labelText>{{ __('ui.banner_section') }}</x-slot:labelText>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <x-field for="landing_banner_title_en" :error="$errors->first('content.banner.title.en')" class="gap-1.5">
            <x-slot:labelText>{{ __('ui.title_english') }}</x-slot:labelText>
            <x-input id="landing_banner_title_en" name="content[banner][title][en]" type="text" class="w-full"
                :value="old(
                    'content.banner.title.en',
                    data_get($content, 'banner.title.en', data_get($content, 'banner.title', '')),
                )" />
        </x-field>

        <x-field for="landing_banner_title_ms" :error="$errors->first('content.banner.title.ms')" class="gap-1.5">
            <x-slot:labelText>{{ __('ui.title_malay') }}</x-slot:labelText>
            <x-input id="landing_banner_title_ms" name="content[banner][title][ms]" type="text" class="w-full"
                :value="old(
                    'content.banner.title.ms',
                    data_get($content, 'banner.title.ms', data_get($content, 'banner.title', '')),
                )" />
        </x-field>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <x-field for="landing_banner_subtitle_en" :error="$errors->first('content.banner.subtitle.en')" class="gap-1.5">
            <x-slot:labelText>{{ __('ui.subtitle_english') }}</x-slot:labelText>
            <x-textarea id="landing_banner_subtitle_en" name="content[banner][subtitle][en]"
                class="min-h-24 w-full">{{ old('content.banner.subtitle.en', data_get($content, 'banner.subtitle.en', data_get($content, 'banner.subtitle', ''))) }}</x-textarea>
        </x-field>

        <x-field for="landing_banner_subtitle_ms" :error="$errors->first('content.banner.subtitle.ms')" class="gap-1.5">
            <x-slot:labelText>{{ __('ui.subtitle_malay') }}</x-slot:labelText>
            <x-textarea id="landing_banner_subtitle_ms" name="content[banner][subtitle][ms]"
                class="min-h-24 w-full">{{ old('content.banner.subtitle.ms', data_get($content, 'banner.subtitle.ms', data_get($content, 'banner.subtitle', ''))) }}</x-textarea>
        </x-field>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <x-media-upload-field id="landing_banner_image" name="content[banner][image]" :label="__('ui.banner_image')"
            :path="data_get($content, 'banner.image')" error-key="content.banner.image" />

        <div class="grid grid-cols-1 gap-4">
            <x-field for="landing_banner_alt_en" :error="$errors->first('content.banner.alt.en')" class="gap-1.5">
                <x-slot:labelText>{{ __('ui.image_alt_text_english') }}</x-slot:labelText>
                <x-input id="landing_banner_alt_en" name="content[banner][alt][en]" type="text" class="w-full"
                    :value="old(
                        'content.banner.alt.en',
                        data_get($content, 'banner.alt.en', data_get($content, 'banner.alt', '')),
                    )" />
            </x-field>

            <x-field for="landing_banner_alt_ms" :error="$errors->first('content.banner.alt.ms')" class="gap-1.5">
                <x-slot:labelText>{{ __('ui.image_alt_text_malay') }}</x-slot:labelText>
                <x-input id="landing_banner_alt_ms" name="content[banner][alt][ms]" type="text" class="w-full"
                    :value="old(
                        'content.banner.alt.ms',
                        data_get($content, 'banner.alt.ms', data_get($content, 'banner.alt', '')),
                    )" />
            </x-field>
        </div>
    </div>
</x-form-section>
