<x-app-layout>

    <x-card module>
        <x-card-header flush>
            <x-card-title>{{ __('modules/portal-administration/media.new') }}</x-card-title>
        </x-card-header>

        <x-card-content flush>
            {{ html()->form('POST', route('media.store'))->id('upload-media-form')->acceptsFiles()->open() }}

            <div class="space-y-4 pb-6">
                <x-field for="media_files" :error="$errors->first('files')" class="gap-1.5">
                    <x-slot:labelText>{{ __('modules/portal-administration/media.fields.file_name') }} <span class="text-destructive">*</span></x-slot:labelText>
                    <input id="media_files" name="files[]" type="file" multiple
                        class="sm:w-1/2 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-primary file:text-primary-foreground hover:file:bg-primary/90" />
                    <p class="text-xs text-muted-foreground">{{ __('Max 10MB per file. Multiple files allowed.') }}</p>
                </x-field>

                <x-field for="media_collection" :error="$errors->first('collection')" class="gap-1.5">
                    <x-slot:labelText>{{ __('modules/portal-administration/media.fields.collection') }}</x-slot:labelText>
                    <x-input id="media_collection" name="collection" type="text" class="sm:w-1/2"
                        placeholder="{{ __('modules/portal-administration/media.placeholders.collection') }}"
                        :value="old('collection', '')" maxlength="255" />
                </x-field>
            </div>

            {{ html()->form()->close() }}

            <x-button-group plain end>
                <x-button as="a" variant="outline" href="{{ route('media.index') }}">{{ __('crud.cancel') }}</x-button>
                <x-button type="submit" form="upload-media-form">{{ __('modules/portal-administration/media.new') }}</x-button>
            </x-button-group>
        </x-card-content>
    </x-card>
</x-app-layout>
