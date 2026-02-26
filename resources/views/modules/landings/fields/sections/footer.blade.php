<x-form-section>
    <x-slot:labelText>{{ __('Footer') }}</x-slot:labelText>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <x-field for="landing_footer_text_en" :error="$errors->first('content.footer.text.en')" class="gap-1.5">
            <x-slot:labelText>{{ __('Footer Text (English)') }}</x-slot:labelText>
            <x-input id="landing_footer_text_en" name="content[footer][text][en]" type="text" class="w-full"
                :value="old(
                    'content.footer.text.en',
                    data_get($content, 'footer.text.en', data_get($content, 'footer.text', '')),
                )" />
        </x-field>

        <x-field for="landing_footer_text_ms" :error="$errors->first('content.footer.text.ms')" class="gap-1.5">
            <x-slot:labelText>{{ __('Footer Text (Malay)') }}</x-slot:labelText>
            <x-input id="landing_footer_text_ms" name="content[footer][text][ms]" type="text" class="w-full"
                :value="old(
                    'content.footer.text.ms',
                    data_get($content, 'footer.text.ms', data_get($content, 'footer.text', '')),
                )" />
        </x-field>
    </div>
</x-form-section>
