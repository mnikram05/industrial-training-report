<x-form-section>
    <x-slot:labelText>{{ __('Security Section') }}</x-slot:labelText>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <x-field for="landing_security_title_en" :error="$errors->first('content.security.title.en')" class="gap-1.5">
            <x-slot:labelText>{{ __('Title (English)') }}</x-slot:labelText>
            <x-input id="landing_security_title_en" name="content[security][title][en]" type="text" class="w-full"
                :value="old(
                    'content.security.title.en',
                    data_get($content, 'security.title.en', data_get($content, 'security.title', '')),
                )" />
        </x-field>

        <x-field for="landing_security_title_ms" :error="$errors->first('content.security.title.ms')" class="gap-1.5">
            <x-slot:labelText>{{ __('Title (Malay)') }}</x-slot:labelText>
            <x-input id="landing_security_title_ms" name="content[security][title][ms]" type="text" class="w-full"
                :value="old(
                    'content.security.title.ms',
                    data_get($content, 'security.title.ms', data_get($content, 'security.title', '')),
                )" />
        </x-field>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <x-field for="landing_security_body_en" :error="$errors->first('content.security.body.en')" class="gap-1.5">
            <x-slot:labelText>{{ __('Body (English)') }}</x-slot:labelText>
            <x-textarea id="landing_security_body_en" name="content[security][body][en]"
                class="min-h-24 w-full">{{ old('content.security.body.en', data_get($content, 'security.body.en', data_get($content, 'security.body', ''))) }}</x-textarea>
        </x-field>

        <x-field for="landing_security_body_ms" :error="$errors->first('content.security.body.ms')" class="gap-1.5">
            <x-slot:labelText>{{ __('Body (Malay)') }}</x-slot:labelText>
            <x-textarea id="landing_security_body_ms" name="content[security][body][ms]"
                class="min-h-24 w-full">{{ old('content.security.body.ms', data_get($content, 'security.body.ms', data_get($content, 'security.body', ''))) }}</x-textarea>
        </x-field>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <x-media-upload-field id="landing_security_image" name="content[security][image]" :label="__('Security Image')"
            :path="data_get($content, 'security.image')" error-key="content.security.image" />

        <div class="grid grid-cols-1 gap-4">
            <x-field for="landing_security_alt_en" :error="$errors->first('content.security.alt.en')" class="gap-1.5">
                <x-slot:labelText>{{ __('Image Alt Text (English)') }}</x-slot:labelText>
                <x-input id="landing_security_alt_en" name="content[security][alt][en]" type="text" class="w-full"
                    :value="old(
                        'content.security.alt.en',
                        data_get($content, 'security.alt.en', data_get($content, 'security.alt', '')),
                    )" />
            </x-field>

            <x-field for="landing_security_alt_ms" :error="$errors->first('content.security.alt.ms')" class="gap-1.5">
                <x-slot:labelText>{{ __('Image Alt Text (Malay)') }}</x-slot:labelText>
                <x-input id="landing_security_alt_ms" name="content[security][alt][ms]" type="text" class="w-full"
                    :value="old(
                        'content.security.alt.ms',
                        data_get($content, 'security.alt.ms', data_get($content, 'security.alt', '')),
                    )" />
            </x-field>
        </div>
    </div>
</x-form-section>
