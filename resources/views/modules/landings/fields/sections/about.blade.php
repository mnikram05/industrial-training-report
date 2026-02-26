<x-form-section>
    <x-slot:labelText>{{ __('About Section') }}</x-slot:labelText>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <x-field for="landing_about_title_en" :error="$errors->first('content.about.title.en')" class="gap-1.5">
            <x-slot:labelText>{{ __('Title (English)') }}</x-slot:labelText>
            <x-input id="landing_about_title_en" name="content[about][title][en]" type="text" class="w-full"
                :value="old(
                    'content.about.title.en',
                    data_get($content, 'about.title.en', data_get($content, 'about.title', '')),
                )" />
        </x-field>

        <x-field for="landing_about_title_ms" :error="$errors->first('content.about.title.ms')" class="gap-1.5">
            <x-slot:labelText>{{ __('Title (Malay)') }}</x-slot:labelText>
            <x-input id="landing_about_title_ms" name="content[about][title][ms]" type="text" class="w-full"
                :value="old(
                    'content.about.title.ms',
                    data_get($content, 'about.title.ms', data_get($content, 'about.title', '')),
                )" />
        </x-field>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <x-field for="landing_about_body_en" :error="$errors->first('content.about.body.en')" class="gap-1.5">
            <x-slot:labelText>{{ __('Body (English)') }}</x-slot:labelText>
            <x-textarea id="landing_about_body_en" name="content[about][body][en]"
                class="min-h-24 w-full">{{ old('content.about.body.en', data_get($content, 'about.body.en', data_get($content, 'about.body', ''))) }}</x-textarea>
        </x-field>

        <x-field for="landing_about_body_ms" :error="$errors->first('content.about.body.ms')" class="gap-1.5">
            <x-slot:labelText>{{ __('Body (Malay)') }}</x-slot:labelText>
            <x-textarea id="landing_about_body_ms" name="content[about][body][ms]"
                class="min-h-24 w-full">{{ old('content.about.body.ms', data_get($content, 'about.body.ms', data_get($content, 'about.body', ''))) }}</x-textarea>
        </x-field>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <x-media-upload-field id="landing_about_image" name="content[about][image]" :label="__('About Image')" :path="data_get($content, 'about.image')"
            error-key="content.about.image" />

        <div class="grid grid-cols-1 gap-4">
            <x-field for="landing_about_alt_en" :error="$errors->first('content.about.alt.en')" class="gap-1.5">
                <x-slot:labelText>{{ __('Image Alt Text (English)') }}</x-slot:labelText>
                <x-input id="landing_about_alt_en" name="content[about][alt][en]" type="text" class="w-full"
                    :value="old(
                        'content.about.alt.en',
                        data_get($content, 'about.alt.en', data_get($content, 'about.alt', '')),
                    )" />
            </x-field>

            <x-field for="landing_about_alt_ms" :error="$errors->first('content.about.alt.ms')" class="gap-1.5">
                <x-slot:labelText>{{ __('Image Alt Text (Malay)') }}</x-slot:labelText>
                <x-input id="landing_about_alt_ms" name="content[about][alt][ms]" type="text" class="w-full"
                    :value="old(
                        'content.about.alt.ms',
                        data_get($content, 'about.alt.ms', data_get($content, 'about.alt', '')),
                    )" />
            </x-field>
        </div>
    </div>
</x-form-section>
