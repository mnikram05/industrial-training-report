<x-app-layout>

    <x-card module>
        <x-card-header flush>
            <x-card-title>{{ $media->name }}</x-card-title>
        </x-card-header>

        <x-card-content flush stacked>
            <div class="space-y-6">
                @if ($media->isImage())
                    <div class="flex justify-center rounded-md border bg-muted/30 p-4">
                        <img src="{{ $media->url }}" alt="{{ $media->alt ?? $media->name }}" class="max-h-96 rounded" />
                    </div>
                @endif

                {{ html()->form('PUT', route('media.update', $media))->id('edit-media-form')->open() }}

                <div class="space-y-4 pb-6">
                    <x-field for="media_name" :error="$errors->first('name')" class="gap-1.5">
                        <x-slot:labelText>{{ __('modules/portal-administration/media.fields.name') }} <span class="text-destructive">*</span></x-slot:labelText>
                        <x-input id="media_name" name="name" type="text" class="sm:w-1/2"
                            :value="old('name', $media->name)" maxlength="255" />
                    </x-field>

                    <x-field for="media_alt" :error="$errors->first('alt')" class="gap-1.5">
                        <x-slot:labelText>{{ __('modules/portal-administration/media.fields.alt') }}</x-slot:labelText>
                        <x-input id="media_alt" name="alt" type="text" class="sm:w-1/2"
                            :value="old('alt', $media->alt ?? '')" />
                    </x-field>

                    <x-field for="media_collection" :error="$errors->first('collection')" class="gap-1.5">
                        <x-slot:labelText>{{ __('modules/portal-administration/media.fields.collection') }}</x-slot:labelText>
                        <x-input id="media_collection" name="collection" type="text" class="sm:w-1/2"
                            placeholder="{{ __('modules/portal-administration/media.placeholders.collection') }}"
                            :value="old('collection', $media->collection ?? '')" maxlength="255" />
                    </x-field>
                </div>

                {{ html()->form()->close() }}

                <x-detail-grid>
                    <x-detail-field :value="$media->file_name">
                        <x-slot:labelText>{{ __('modules/portal-administration/media.fields.file_name') }}</x-slot:labelText>
                    </x-detail-field>
                    <x-detail-field :value="$media->mime_type">
                        <x-slot:labelText>{{ __('modules/portal-administration/media.fields.mime_type') }}</x-slot:labelText>
                    </x-detail-field>
                    <x-detail-field :value="$media->human_size">
                        <x-slot:labelText>{{ __('modules/portal-administration/media.fields.size') }}</x-slot:labelText>
                    </x-detail-field>
                    <x-detail-field :value="$media->created_at?->format('d/m/Y H:i')">
                        <x-slot:labelText>{{ __('modules/portal-administration/media.fields.created_at') }}</x-slot:labelText>
                    </x-detail-field>
                </x-detail-grid>
            </div>

            <x-button-group plain end spaced>
                <x-button as="a" variant="outline" href="{{ route('media.index') }}">{{ __('crud.back') }}</x-button>
                <x-button type="submit" form="edit-media-form">{{ __('crud.update') }}</x-button>
            </x-button-group>
        </x-card-content>
    </x-card>
</x-app-layout>
